<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LikeController extends Controller
{
    /**
     * Beğeni durumunu toggle et (beğen/beğeniyi kaldır)
     */
    public function toggle(Request $request, Post $post)
    {
        try {
            $user = Auth::user();
            
            // Kullanıcının bu postu daha önce beğenip beğenmediğini kontrol et
            $existingLike = Like::where('user_id', $user->id)
                                ->where('post_id', $post->id)
                                ->first();
            
            DB::beginTransaction();
            
            if ($existingLike) {
                // Beğeniyi kaldır
                $existingLike->delete();
                $action = 'unliked';
                $message = 'Beğeni kaldırıldı';
            } else {
                // Beğeni ekle
                Like::create([
                    'user_id' => $user->id,
                    'post_id' => $post->id
                ]);
                $action = 'liked';
                $message = 'Post beğenildi';
                
                // Beğeni bildirimi gönder
                try {
                    Notification::createLikeNotification($post, $user);
                } catch (\Exception $e) {
                    Log::error('Like notification failed: ' . $e->getMessage());
                    // Bildirim hatası ana işlemi etkilemesin
                }
            }
            
            // Post'un beğeni sayısını güncelle
            $post->updateLikeCount();
            
            DB::commit();
            
            // Güncellenmiş sayıyı al
            $likeCount = $post->fresh()->like_count;
            $isLiked = !$existingLike; // Toggle durumu
            
            return response()->json([
                'success' => true,
                'action' => $action,
                'message' => $message,
                'like_count' => $likeCount,
                'is_liked' => $isLiked,
                'formatted_count' => $this->formatCount($likeCount)
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Like toggle error: ' . $e->getMessage(), [
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
     * Postun beğeni durumunu kontrol et
     */
    public function status(Post $post)
    {
        $user = Auth::user();
        
        $isLiked = Like::where('user_id', $user->id)
                      ->where('post_id', $post->id)
                      ->exists();
                      
        return response()->json([
            'success' => true,
            'is_liked' => $isLiked,
            'like_count' => $post->like_count,
            'formatted_count' => $this->formatCount($post->like_count)
        ]);
    }
    
    /**
     * Bir postun beğenen kullanıcılarını listele
     */
    public function users(Post $post)
    {
        $likes = Like::with('user:id,name,profile_photo_path')
                    ->where('post_id', $post->id)
                    ->latest()
                    ->take(20) // Son 20 beğenen
                    ->get();
                    
        $users = $likes->map(function ($like) {
            return [
                'id' => $like->user->id,
                'name' => $like->user->name,
                'profile_photo' => $like->user->profile_photo_url,
                'liked_at' => $like->created_at->diffForHumans()
            ];
        });
        
        return response()->json([
            'success' => true,
            'users' => $users,
            'total_count' => $post->like_count
        ]);
    }
    
    /**
     * Rate limiting kontrolü
     */
    public function checkRateLimit($userId)
    {
        // Son 1 dakikada kaç beğeni yapmış kontrol et
        $recentLikes = Like::where('user_id', $userId)
            ->where('created_at', '>', now()->subMinute())
            ->count();
            
        return $recentLikes < 30; // Dakikada maksimum 30 beğeni
    }
    
    /**
     * Sayıları formatla (1K, 1.2K gibi)
     */
    private function formatCount($count)
    {
        if ($count < 1000) {
            return (string) $count;
        } elseif ($count < 1000000) {
            return round($count / 1000, 1) . 'K';
        } else {
            return round($count / 1000000, 1) . 'M';
        }
    }
}
