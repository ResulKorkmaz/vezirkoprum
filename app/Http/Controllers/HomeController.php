<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profession;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('profession');
        
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
        
        $users = $query->paginate(12);
        $professions = Profession::where('is_active', true)->orderBy('name')->get();
        $cities = config('turkiye.cities');
        
        return view('home', compact('users', 'professions', 'cities'));
    }
}
