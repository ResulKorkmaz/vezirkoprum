<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\SpamWord;
use App\Services\SpamDetectionService;
use Illuminate\Http\Request;

class SpamController extends Controller
{
    protected $spamDetection;

    public function __construct(SpamDetectionService $spamDetection)
    {
        $this->spamDetection = $spamDetection;
    }

    /**
     * Spam yönetimi ana sayfası
     */
    public function index()
    {
        $stats = [
            'total_spam' => Post::where('is_spam', true)->count(),
            'quarantined' => Post::where('spam_status', 'quarantined')->count(),
            'suspicious' => Post::where('spam_status', 'suspicious')->count(),
            'clean' => Post::where('spam_status', 'clean')->count(),
        ];

        $recentSpamPosts = Post::with('user')
            ->where('is_spam', true)
            ->latest()
            ->take(10)
            ->get();

        $suspiciousPosts = Post::with('user')
            ->where('spam_status', 'suspicious')
            ->latest()
            ->take(10)
            ->get();

        $quarantinedPosts = Post::with('user')
            ->where('spam_status', 'quarantined')
            ->latest()
            ->take(10)
            ->get();

        return view('admin.spam.index', compact('stats', 'recentSpamPosts', 'suspiciousPosts', 'quarantinedPosts'));
    }

    /**
     * Spam postları listele
     */
    public function posts(Request $request)
    {
        $query = Post::with('user');

        // Filtreleme
        if ($request->has('status') && $request->status !== 'all') {
            if ($request->status === 'spam') {
                $query->where('is_spam', true);
            } else {
                $query->where('spam_status', $request->status);
            }
        }

        // Arama
        if ($request->has('search') && $request->search) {
            $query->where('content', 'like', '%' . $request->search . '%');
        }

        $posts = $query->latest()->paginate(20);
        
        // Stats için ayrı hesaplama
        $stats = [
            'spam' => Post::where('is_spam', true)->count(),
            'suspicious' => Post::where('spam_status', 'suspicious')->count(),
            'quarantined' => Post::where('spam_status', 'quarantined')->count(),
            'clean' => Post::where('spam_status', 'clean')->count(),
        ];

        return view('admin.spam.posts', compact('posts', 'stats'));
    }

    /**
     * Spam kelimeleri yönetimi
     */
    public function words()
    {
        $words = SpamWord::orderBy('category')
            ->orderBy('weight', 'desc')
            ->paginate(50);

        $categories = SpamWord::distinct('category')->pluck('category');
        
        // Stats için kategori bazında sayıları hesapla
        $categoryStats = [
            'profanity' => SpamWord::where('category', 'profanity')->count(),
            'scam' => SpamWord::where('category', 'scam')->count(),
            'commercial' => SpamWord::where('category', 'commercial')->count(),
            'inappropriate' => SpamWord::where('category', 'inappropriate')->count(),
        ];

        return view('admin.spam.words', compact('words', 'categories', 'categoryStats'));
    }

    /**
     * Postu temizle (spam değil olarak işaretle)
     */
    public function approvePost(Post $post)
    {
        $post->markAsClean();

        return response()->json([
            'success' => true,
            'message' => 'Post temizlendi ve yayına alındı.'
        ]);
    }

    /**
     * Postu spam olarak onayla
     */
    public function confirmSpam(Post $post)
    {
        $post->markAsSpam(['Admin tarafından onaylandı']);

        return response()->json([
            'success' => true,
            'message' => 'Post spam olarak onaylandı.'
        ]);
    }

    /**
     * Postu karantinaya al
     */
    public function quarantinePost(Post $post)
    {
        $post->quarantine(['Admin tarafından karantinaya alındı']);

        return response()->json([
            'success' => true,
            'message' => 'Post karantinaya alındı.'
        ]);
    }

    /**
     * Postu sil (Admin yetkisi ile)
     */
    public function deletePost(Post $post)
    {
        $post->delete();

        return response()->json([
            'success' => true,
            'message' => 'Post başarıyla silindi.'
        ]);
    }

    /**
     * Toplu işlem
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:approve,spam,quarantine,delete',
            'post_ids' => 'required|array',
            'post_ids.*' => 'exists:posts,id'
        ]);

        $posts = Post::whereIn('id', $request->post_ids)->get();
        $count = 0;

        foreach ($posts as $post) {
            switch ($request->action) {
                case 'approve':
                    $post->markAsClean();
                    $count++;
                    break;
                case 'spam':
                    $post->markAsSpam(['Admin tarafından toplu işlemle spam olarak işaretlendi']);
                    $count++;
                    break;
                case 'quarantine':
                    $post->quarantine(['Admin tarafından toplu işlemle karantinaya alındı']);
                    $count++;
                    break;
                case 'delete':
                    $post->delete();
                    $count++;
                    break;
            }
        }

        return response()->json([
            'success' => true,
            'message' => "{$count} post başarıyla işlendi."
        ]);
    }

    /**
     * Spam kelimesi ekle
     */
    public function addWord(Request $request)
    {
        $request->validate([
            'word' => 'required|string|max:255|unique:spam_words,word',
            'weight' => 'required|integer|min:1|max:10',
            'category' => 'required|in:profanity,scam,commercial,inappropriate'
        ]);

        SpamWord::create([
            'word' => $request->word,
            'weight' => $request->weight,
            'category' => $request->category,
            'is_active' => true
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Spam kelimesi başarıyla eklendi.'
        ]);
    }

    /**
     * Spam kelimesini güncelle
     */
    public function updateWord(SpamWord $word, Request $request)
    {
        $request->validate([
            'weight' => 'required|integer|min:1|max:10',
            'category' => 'required|in:profanity,scam,commercial,inappropriate',
            'is_active' => 'required|boolean'
        ]);

        $word->update([
            'weight' => $request->weight,
            'category' => $request->category,
            'is_active' => $request->is_active
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Spam kelimesi başarıyla güncellendi.'
        ]);
    }

    /**
     * Spam kelimesini sil
     */
    public function deleteWord(SpamWord $word)
    {
        $word->delete();

        return response()->json([
            'success' => true,
            'message' => 'Spam kelimesi başarıyla silindi.'
        ]);
    }

    /**
     * İçeriği manuel olarak analiz et
     */
    public function analyzeContent(Request $request)
    {
        $request->validate([
            'content' => 'required|string'
        ]);

        $analysis = $this->spamDetection->analyzeContent($request->content);

        return response()->json([
            'success' => true,
            'analysis' => $analysis
        ]);
    }

    /**
     * Tüm postları yeniden analiz et (arka plan job olarak çalıştırılmalı)
     */
    public function reanalyzeAll()
    {
        $posts = Post::where('spam_checked_at', null)
            ->orWhere('spam_checked_at', '<', now()->subDays(30))
            ->take(100)
            ->get();

        $processed = 0;
        foreach ($posts as $post) {
            $this->spamDetection->processPost($post);
            $processed++;
        }

        return response()->json([
            'success' => true,
            'message' => "{$processed} post yeniden analiz edildi."
        ]);
    }
}
