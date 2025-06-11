<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Notification;
use App\Services\SpamDetectionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CommentController extends Controller
{
    protected $spamDetection;

    public function __construct(SpamDetectionService $spamDetection)
    {
        $this->spamDetection = $spamDetection;
    }

    /**
     * Yorum ekleme
     */
    public function store(Request $request, Post $post)
    {
        try {
            $user = Auth::user();
            
            // Validasyon
            $request->validate([
                'content' => 'required|string|min:2|max:500'
            ], [
                'content.required' => 'Yorum içeriği gereklidir.',
                'content.min' => 'Yorum en az 2 karakter olmalıdır.',
                'content.max' => 'Yorum en fazla 500 karakter olabilir.'
            ]);
            
            // Rate limiting kontrolü
            if (!$this->checkRateLimit($user->id)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Çok hızlı yorum yazıyorsunuz. Lütfen bir dakika bekleyin.'
                ], 429);
            }
            
            // Spam analizi
            $analysis = $this->spamDetection->analyzeContent($request->content, $user->id);
            
            DB::beginTransaction();
            
            // Yorum oluştur
            $comment = Comment::create([
                'user_id' => $user->id,
                'post_id' => $post->id,
                'content' => $request->content,
                'is_active' => true,
                'spam_score' => $analysis['score'],
                'spam_checked_at' => now()
            ]);
            
            // Spam kontrolü sonucuna göre işle
            if ($analysis['score'] >= 70) {
                $comment->markAsSpam($analysis['reasons']);
                $status = 'spam';
                $message = 'Yorumunuz spam olarak algılandı ve yayınlanmadı.';
            } elseif ($analysis['score'] >= 40) {
                $comment->update(['spam_reasons' => $analysis['reasons']]);
                $status = 'suspicious';
                $message = 'Yorumunuz eklendi ancak moderasyon bekliyor.';
            } else {
                $status = 'approved';
                $message = 'Yorumunuz başarıyla eklendi.';
            }
            
            // Sadece onaylanmış yorumlar için sayacı güncelle
            if ($status === 'approved') {
                $post->updateCommentCount();
            }
            
            DB::commit();
            
            // Response data hazırla
            $responseData = [
                'success' => true,
                'message' => $message,
                'status' => $status,
                'spam_score' => $analysis['score']
            ];
            
            // Eğer yorum onaylandıysa, comment data'sını da gönder
            if ($status === 'approved') {
                $responseData['comment'] = [
                    'id' => $comment->id,
                    'content' => $comment->content,
                    'user_name' => $user->name,
                    'user_photo' => $user->profile_photo_url,
                    'created_at' => $comment->created_at->diffForHumans(),
                    'is_owner' => true
                ];
                $responseData['comment_count'] = $post->fresh()->comment_count;
                
                // Yorum bildirimi gönder
                try {
                    Notification::createCommentNotification($comment);
                } catch (\Exception $e) {
                    Log::error('Comment notification failed: ' . $e->getMessage());
                    // Bildirim hatası ana işlemi etkilemesin
                }
            }
            
            return response()->json($responseData);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->validator->errors()->first()
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Comment store error: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'post_id' => $post->id,
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Bir hata oluştu. Lütfen tekrar deneyin.'
            ], 500);
        }
    }
    
    /**
     * Yorumları listele - herkese açık
     */
    public function index(Post $post)
    {
        $comments = Comment::with('user:id,name,profile_photo_path')
            ->where('post_id', $post->id)
            ->active()
            ->latest()
            ->paginate(10);
            
        $currentUserId = Auth::id(); // Giriş yapmamış kullanıcılar için null olacak
            
        $commentsData = $comments->map(function ($comment) use ($currentUserId) {
            return [
                'id' => $comment->id,
                'content' => $comment->content,
                'user_name' => $comment->user->name,
                'user_photo' => $comment->user->profile_photo_url,
                'created_at' => $comment->created_at->diffForHumans(),
                'is_owner' => $currentUserId && $comment->user_id === $currentUserId
            ];
        });
        
        return response()->json([
            'success' => true,
            'comments' => $commentsData,
            'pagination' => [
                'current_page' => $comments->currentPage(),
                'last_page' => $comments->lastPage(),
                'per_page' => $comments->perPage(),
                'total' => $comments->total()
            ]
        ]);
    }
    
    /**
     * Yorum güncelleme
     */
    public function update(Request $request, Comment $comment)
    {
        try {
            // Yetki kontrolü
            if ($comment->user_id !== Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bu yorumu düzenleme yetkiniz yok.'
                ], 403);
            }
            
            // Validasyon
            $request->validate([
                'content' => 'required|string|min:2|max:500'
            ]);
            
            // Spam analizi
            $analysis = $this->spamDetection->analyzeContent($request->content, $comment->user_id);
            
            DB::beginTransaction();
            
            // Yorumu güncelle
            $comment->update([
                'content' => $request->content,
                'spam_score' => $analysis['score'],
                'spam_checked_at' => now()
            ]);
            
            // Spam kontrol sonucu
            if ($analysis['score'] >= 70) {
                $comment->markAsSpam($analysis['reasons']);
                $message = 'Yorumunuz güncellendi ancak spam içerik nedeniyle deaktif edildi.';
            } else {
                $comment->markAsClean();
                $message = 'Yorumunuz başarıyla güncellendi.';
            }
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => $message,
                'comment' => [
                    'id' => $comment->id,
                    'content' => $comment->content,
                    'spam_score' => $analysis['score']
                ]
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Comment update error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Bir hata oluştu. Lütfen tekrar deneyin.'
            ], 500);
        }
    }
    
    /**
     * Yorum silme
     */
    public function destroy(Comment $comment)
    {
        try {
            // Yetki kontrolü
            if ($comment->user_id !== Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bu yorumu silme yetkiniz yok.'
                ], 403);
            }
            
            DB::beginTransaction();
            
            $post = $comment->post;
            $comment->delete();
            
            // Post yorum sayısını güncelle
            $post->updateCommentCount();
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Yorumunuz başarıyla silindi.',
                'comment_count' => $post->fresh()->comment_count
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Comment delete error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Bir hata oluştu. Lütfen tekrar deneyin.'
            ], 500);
        }
    }
    
    /**
     * Rate limiting kontrolü
     */
    private function checkRateLimit($userId)
    {
        // Son 1 dakikada kaç yorum yapmış kontrol et
        $recentComments = Comment::where('user_id', $userId)
            ->where('created_at', '>', now()->subMinute())
            ->count();
            
        return $recentComments < 10; // Dakikada maksimum 10 yorum
    }
}
