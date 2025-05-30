<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminController extends Controller
{
    /**
     * Admin giriş formunu göster
     */
    public function showLoginForm()
    {
        // Zaten giriş yapmış admin ise admin panele yönlendir
        if (auth()->check() && auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.login');
    }

    /**
     * Admin girişi işle
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ], [
            'username.required' => 'Kullanıcı adı gereklidir.',
            'password.required' => 'Şifre gereklidir.',
        ]);

        // Sabit admin bilgileri
        $adminUsername = 'rslkrkmz';
        $adminPassword = 'Rr123456';

        if ($request->username === $adminUsername && $request->password === $adminPassword) {
            // Admin kullanıcısını bul veya oluştur
            $adminUser = User::where('email', 'admin@vezirkoprum.com.tr')->first();
            
            if (!$adminUser) {
                $adminUser = User::create([
                    'name' => 'Admin',
                    'email' => 'admin@vezirkoprum.com.tr',
                    'password' => Hash::make($adminPassword),
                    'email_verified_at' => now(),
                    'is_admin' => true,
                    'show_phone' => false,
                ]);
            } else {
                // Mevcut kullanıcıyı admin yap
                $adminUser->update(['is_admin' => true]);
            }

            // Kullanıcıyı giriş yap
            Auth::login($adminUser);

            return redirect()->route('admin.dashboard')->with('success', 'Admin paneline hoş geldiniz!');
        }

        return back()->withErrors([
            'username' => 'Kullanıcı adı veya şifre hatalı.',
        ])->withInput($request->only('username'));
    }

    /**
     * Admin dashboard
     */
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'admin_users' => User::where('is_admin', true)->count(),
            'recent_users' => User::where('created_at', '>=', now()->subDays(7))->count(),
            'verified_users' => User::whereNotNull('email_verified_at')->count(),
        ];

        $recentUsers = User::latest()->limit(10)->get();

        return view('admin.dashboard', compact('stats', 'recentUsers'));
    }

    /**
     * Admin çıkış
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->route('admin.login')->with('success', 'Başarıyla çıkış yaptınız.');
    }
}
