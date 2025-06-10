<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Profession;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $professions = Profession::where('is_active', true)->orderBy('name')->get();
        $cities = config('turkiye.cities');
        
        return view('profile.edit', [
            'user' => $request->user(),
            'professions' => $professions,
            'cities' => $cities,
        ]);
    }

    /**
     * Display a user's profile.
     */
    public function show(Request $request, User $user): View
    {
        return view('profile.show', [
            'user' => $user,
            'currentUser' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        try {
        $user = $request->user();
            
            // Profil bilgilerini güncelle
            $user->fill($request->validated());

            if ($user->isDirty('email')) {
                $user->email_verified_at = null;
            }

            // Profil fotoğrafı yükleme
        if ($request->hasFile('profile_photo')) {
            $file = $request->file('profile_photo');
                
                // Eski profil fotoğrafını sil
                if ($user->profile_photo_path) {
                    Storage::disk('public')->delete($user->profile_photo_path);
                }
                
                // Yeni dosya adı oluştur
                $filename = time() . '_' . $user->id . '.jpg';
                $path = 'profile-photos/' . $filename;
            
                // Resmi işle ve kaydet
            $manager = new ImageManager(new Driver());
            $image = $manager->read($file->getPathname());
            
                // Resmi 400x400 boyutuna getir ve optimize et
                $image->cover(400, 400);
            
                // Kaliteyi ayarla (dosya boyutunu küçültmek için)
                $processedImage = $image->toJpeg(80);
                
                // Storage'a kaydet
                Storage::disk('public')->put($path, $processedImage);
            
                // Veritabanında path'i güncelle
                $user->profile_photo_path = $path;
            }

            $user->save();

            return Redirect::route('profile.edit')->with('status', 'Profil başarıyla güncellendi!');
            
        } catch (\Exception $e) {
            Log::error('Profile update error: ' . $e->getMessage());
            return Redirect::route('profile.edit')->with('error', 'Profil güncellenirken bir hata oluştu: ' . $e->getMessage());
        }
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // Profil fotoğrafını sil
        if ($user->profile_photo_path) {
            Storage::disk('public')->delete($user->profile_photo_path);
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
