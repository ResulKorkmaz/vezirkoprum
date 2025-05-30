<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'profession_id' => ['required', 'exists:professions,id'],
            'current_city' => ['required', 'string', 'max:255'],
            'current_district' => ['required', 'string', 'max:255'],
            'kvkk_consent' => ['required', 'accepted'],
        ], [
            'name.required' => 'Ad soyad alanı zorunludur.',
            'email.required' => 'E-posta alanı zorunludur.',
            'email.email' => 'Geçerli bir e-posta adresi giriniz.',
            'email.unique' => 'Bu e-posta adresi zaten kullanılmaktadır.',
            'password.required' => 'Şifre alanı zorunludur.',
            'password.confirmed' => 'Şifre onayı eşleşmiyor.',
            'profession_id.required' => 'Meslek seçimi zorunludur.',
            'profession_id.exists' => 'Seçilen meslek geçersizdir.',
            'current_city.required' => 'Şehir seçimi zorunludur.',
            'current_district.required' => 'İlçe seçimi zorunludur.',
            'kvkk_consent.required' => 'KVKK onayı zorunludur.',
            'kvkk_consent.accepted' => 'Kayıt olmak için KVKK onayını kabul etmelisiniz.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'profession_id' => $request->profession_id,
            'current_city' => $request->current_city,
            'current_district' => $request->current_district,
            'kvkk_consent' => true,
            'kvkk_consent_date' => now(),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
