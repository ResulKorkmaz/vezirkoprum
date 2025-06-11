<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Rules\RecaptchaRule;
use App\Services\SpamDetectionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    protected $spamDetection;

    public function __construct(SpamDetectionService $spamDetection)
    {
        $this->spamDetection = $spamDetection;
    }

    /**
     * Tüm paylaşımları listele (sadece temiz postlar)
     */
    public function index()
    {
        $posts = Post::with('user')
            ->active()
            ->clean() // Sadece temiz postları göster
            ->latest()
            ->paginate(12);
            
        return view('posts.index', compact('posts'));
    }

    /**
     * Yeni paylaşım formu göster
     */
    public function create()
    {
        $user = Auth::user();
        $remainingPosts = Post::getUserRemainingPosts($user->id);
        
        return view('posts.create', compact('remainingPosts'));
    }

    /**
     * Paylaşım kaydet
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        
        // Günlük limit kontrolü
        if (Post::hasUserReachedDailyLimit($user->id)) {
            return response()->json([
                'success' => false,
                'message' => 'Günlük paylaşım limitinize ulaştınız. Günde en fazla 3 paylaşım yapabilirsiniz.'
            ], 429);
        }

        // Validasyon
        $request->validate([
            'content' => 'required|string|min:10|max:500',
            'recaptcha_token' => [new RecaptchaRule('post_create')],
        ], [
            'content.required' => 'Paylaşım içeriği gereklidir.',
            'content.min' => 'Paylaşım en az 10 karakter olmalıdır.',
            'content.max' => 'Paylaşım en fazla 500 karakter olabilir.',
        ]);

        // Paylaşım oluştur
        $post = Post::create([
            'user_id' => $user->id,
            'content' => $request->content,
            'is_active' => true,
        ]);

        // Spam analizi yap (middleware'den gelebilir veya burada)
        if ($request->has('spam_analysis')) {
            $analysis = $request->input('spam_analysis');
        } else {
            $analysis = $this->spamDetection->analyzeContent($request->content, $user->id);
        }

        // Spam skoruna göre postu işle
        if ($analysis['score'] >= SpamDetectionService::QUARANTINE_THRESHOLD) {
            $post->quarantine($analysis['reasons']);
            $message = 'Paylaşımınız inceleme için karantinaya alındı. Moderasyon sonrası yayınlanacaktır.';
        } elseif ($analysis['score'] >= SpamDetectionService::SPAM_THRESHOLD) {
            $post->markAsSpam($analysis['reasons']);
            $message = 'Paylaşımınız spam olarak işaretlendi ve yayınlanmadı. Lütfen içeriği gözden geçirin.';
        } elseif ($analysis['score'] >= SpamDetectionService::SUSPICIOUS_THRESHOLD) {
            $post->markAsSuspicious($analysis['score'], $analysis['reasons']);
            $message = 'Paylaşımınız oluşturuldu ancak şüpheli içerik nedeniyle inceleme bekliyor.';
        } else {
            $post->markAsClean();
            $message = 'Paylaşımınız başarıyla oluşturuldu!';
        }

        $remainingPosts = Post::getUserRemainingPosts($user->id);

        return response()->json([
            'success' => true,
            'message' => $message,
            'remaining_posts' => $remainingPosts,
            'spam_score' => $analysis['score'],
            'spam_status' => $analysis['status'],
            'post' => [
                'id' => $post->id,
                'content' => $post->short_content,
                'created_at' => $post->created_at->diffForHumans(),
                'user_name' => $user->getDisplayNameWithIdForUser(auth()->user()),
                'spam_status' => $post->spam_status,
            ]
        ]);
    }

    /**
     * Kullanıcının kalan paylaşım hakkını getir
     */
    public function getRemainingPosts()
    {
        $user = Auth::user();
        $remainingPosts = Post::getUserRemainingPosts($user->id);
        $dailyCount = Post::getUserDailyPostCount($user->id);
        
        return response()->json([
            'remaining_posts' => $remainingPosts,
            'daily_count' => $dailyCount,
            'daily_limit' => 3
        ]);
    }

    /**
     * Paylaşımı düzenle (AJAX)
     */
    public function edit(Post $post)
    {
        // Yetki kontrolü
        if ($post->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Bu paylaşımı düzenleme yetkiniz yok.'
            ], 403);
        }

        return response()->json([
            'success' => true,
            'post' => [
                'id' => $post->id,
                'content' => $post->content,
            ]
        ]);
    }

    /**
     * Paylaşımı güncelle
     */
    public function update(Request $request, Post $post)
    {
        // Yetki kontrolü
        if ($post->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Bu paylaşımı düzenleme yetkiniz yok.'
            ], 403);
        }

        // Validasyon
        $request->validate([
            'content' => 'required|string|min:10|max:500',
        ], [
            'content.required' => 'Paylaşım içeriği gereklidir.',
            'content.min' => 'Paylaşım en az 10 karakter olmalıdır.',
            'content.max' => 'Paylaşım en fazla 500 karakter olabilir.',
        ]);

        // Güncellenen içeriği spam için kontrol et
        $analysis = $this->spamDetection->analyzeContent($request->content, $post->user_id);
        
        // Paylaşımı güncelle
        $post->update([
            'content' => $request->content,
        ]);

        // Spam analizi sonucuna göre işle
        if ($analysis['score'] >= SpamDetectionService::SPAM_THRESHOLD) {
            $post->markAsSpam($analysis['reasons']);
            $message = 'Paylaşımınız güncellendi ancak spam içerik nedeniyle deaktif edildi.';
        } elseif ($analysis['score'] >= SpamDetectionService::SUSPICIOUS_THRESHOLD) {
            $post->markAsSuspicious($analysis['score'], $analysis['reasons']);
            $message = 'Paylaşımınız güncellendi ancak şüpheli içerik nedeniyle inceleme bekliyor.';
        } else {
            $post->markAsClean();
            $message = 'Paylaşımınız başarıyla güncellendi!';
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'spam_score' => $analysis['score'],
            'post' => [
                'id' => $post->id,
                'content' => $post->short_content,
                'full_content' => $post->content,
                'spam_status' => $post->spam_status,
            ]
        ]);
    }

    /**
     * Paylaşımı sil
     */
    public function destroy(Post $post)
    {
        // Yetki kontrolü
        if ($post->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Bu paylaşımı silme yetkiniz yok.'
            ], 403);
        }

        $post->delete();

        return response()->json([
            'success' => true,
            'message' => 'Paylaşımınız başarıyla silindi.'
        ]);
    }
}
