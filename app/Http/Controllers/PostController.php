<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Rules\RecaptchaRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Tüm paylaşımları listele
     */
    public function index()
    {
        $posts = Post::with('user')
            ->active()
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

        $remainingPosts = Post::getUserRemainingPosts($user->id);

        return response()->json([
            'success' => true,
            'message' => 'Paylaşımınız başarıyla oluşturuldu!',
            'remaining_posts' => $remainingPosts,
            'post' => [
                'id' => $post->id,
                'content' => $post->short_content,
                'created_at' => $post->created_at->diffForHumans(),
                'user_name' => $user->getDisplayNameWithIdForUser(auth()->user()),
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

        // Paylaşımı güncelle
        $post->update([
            'content' => $request->content,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Paylaşımınız başarıyla güncellendi!',
            'post' => [
                'id' => $post->id,
                'content' => $post->short_content,
                'full_content' => $post->content,
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
