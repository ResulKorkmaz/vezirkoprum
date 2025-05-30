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
        $user = $request->user();
        $validated = $request->validated();
        
        // Profil resmi upload ve optimizasyon işlemi
        if ($request->hasFile('profile_photo')) {
            // Eski resmi sil
            if ($user->profile_photo) {
                Storage::delete('public/profile-photos/' . $user->profile_photo);
            }
            
            $file = $request->file('profile_photo');
            $filename = time() . '_' . $user->id . '.jpg'; // Her zaman JPG olarak kaydet
            $filepath = storage_path('app/public/profile-photos/' . $filename);
            
            // Resmi optimize et (Intervention Image v3 syntax)
            $manager = new ImageManager(new Driver());
            $image = $manager->read($file->getPathname());
            
            // 400x400 boyutuna resize et
            $image->resize(400, 400);
            
            // JPEG olarak kaydet ve kaliteyi optimize et
            $quality = 85; // Başlangıç kalitesi
            $maxSize = 200 * 1024; // 200KB limit
            
            do {
                // Resmi encode et
                $encoded = $image->toJpeg($quality);
                
                // Eğer boyut çok büyükse kaliteyi düşür
                if (strlen($encoded) > $maxSize && $quality > 60) {
                    $quality -= 5;
                } else {
                    break;
                }
            } while ($quality >= 60);
            
            // Dosyayı kaydet
            file_put_contents($filepath, $encoded);
            
            $validated['profile_photo'] = $filename;
            
            // Log the final file size for debugging
            $finalSize = filesize($filepath);
            \Log::info("Profile photo optimized: {$filename}, Size: " . number_format($finalSize / 1024, 2) . " KB, Quality: {$quality}%");
    }

        // E-posta değişti mi kontrol et
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }
        
        // Kullanıcı bilgilerini güncelle
        $user->fill($validated);
        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
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

        // Profil resmini sil
        if ($user->profile_photo) {
            Storage::delete('public/profile-photos/' . $user->profile_photo);
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
