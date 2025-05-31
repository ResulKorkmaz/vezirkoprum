<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profession;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('profession')
            ->where('is_admin', false); // Admin kullanıcıları hariç tut
        
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
                User::where('is_admin', false)->count(), // Admin hariç toplam sayı
                8,
                1,
                ['path' => request()->url()]
            );
        } else {
            $users = $query->paginate(12);
        }
        
        $professions = Profession::where('is_active', true)->orderBy('name')->get();
        $cities = config('turkiye.cities');
        
        return view('home', compact('users', 'professions', 'cities', 'hasFilters'));
    }
}
