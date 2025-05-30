<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse|JsonResponse
    {
        try {
            $validated = $request->validate([
                'current_password' => ['required', 'current_password'],
                'password' => ['required', Password::defaults(), 'confirmed'],
            ], [
                'current_password.required' => 'Mevcut şifre alanı zorunludur.',
                'current_password.current_password' => 'Mevcut şifre yanlış.',
                'password.required' => 'Yeni şifre alanı zorunludur.',
                'password.confirmed' => 'Şifre tekrarı uyuşmuyor.',
                'password.min' => 'Şifre en az 8 karakter olmalıdır.',
                'password.max' => 'Şifre en fazla 255 karakter olabilir.',
                'password.mixed' => 'Şifre en az bir büyük ve bir küçük harf içermelidir.',
                'password.letters' => 'Şifre en az bir harf içermelidir.',
                'password.numbers' => 'Şifre en az bir rakam içermelidir.',
                'password.symbols' => 'Şifre en az bir sembol içermelidir.',
                'password.uncompromised' => 'Bu şifre güvenlik ihlali nedeniyle kullanılamaz. Lütfen farklı bir şifre seçin.',
            ]);

            $request->user()->update([
                'password' => Hash::make($validated['password']),
            ]);

            // AJAX request için JSON response döndür
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'password-updated'
                ]);
            }

            // Normal form request için redirect
            return back()->with('status', 'password-updated');

        } catch (ValidationException $e) {
            // AJAX request için validation errors'ı JSON olarak döndür
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'errors' => $e->errors()
                ], 422);
            }
            
            // Normal form request için validation exception'ı fırlat
            throw $e;
        }
    }
}
