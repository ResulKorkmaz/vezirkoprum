<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profession;
use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('profession')
            ->where('is_admin', false) // Admin kullanıcıları hariç tut
            ->whereNotNull('email_verified_at') // Email doğrulaması yapılmış kullanıcılar
            ->where('is_suspended', false); // Suspended olmayan kullanıcılar
        
        // Filtre var mı kontrol et
        $hasFilters = $request->hasAny(['city', 'district', 'profession_id', 'show_all']);
        
        // Şehir filtresi
        if ($request->filled('city')) {
            $query->where('current_city', $request->city);
        }
        
        // İlçe filtresi
        if ($request->filled('district')) {
            $query->where('current_district', $request->district);
        }
        
        // Meslek filtresi
        if ($request->filled('profession_id')) {
            $query->where('profession_id', $request->profession_id);
        }
        
        // Filtre yoksa sadece ilk 8 üyeyi göster, varsa pagination kullan
        if (!$hasFilters) {
            $users = $query->orderBy('created_at', 'desc')->limit(8)->get();
            // Collection'ı paginator gibi göstermek için
            $users = new \Illuminate\Pagination\LengthAwarePaginator(
                $users,
                User::where('is_admin', false)
                    ->whereNotNull('email_verified_at')
                    ->where('is_suspended', false)
                    ->count(), // Aktif kullanıcı sayısı
                8,
                1,
                ['path' => request()->url()]
            );
        } else {
            $users = $query->paginate(12);
        }
        
        $professions = Profession::where('is_active', true)->orderBy('name')->get();
        $cities = config('turkiye.cities');
        
        // En yeni 6 paylaşımı getir
        $posts = Post::with('user')
            ->active()
            ->latest()
            ->limit(6)
            ->get();
        
        // Giriş yapmış kullanıcı için günlük paylaşım bilgisi
        $userPostInfo = null;
        if (auth()->check()) {
            $userPostInfo = [
                'daily_count' => Post::getUserDailyPostCount(auth()->id()),
                'remaining_posts' => Post::getUserRemainingPosts(auth()->id()),
                'daily_limit' => 3
            ];
        }
        
        return view('home', compact('users', 'professions', 'cities', 'hasFilters', 'posts', 'userPostInfo'));
    }
}
