<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\WhatsappController;
use Illuminate\Support\Facades\Route;

// Ana sayfa - herkese açık
Route::get('/', [HomeController::class, 'index'])->name('home');

// Authentication routes - Breeze kurulduktan sonra eklenecek
// require __DIR__.'/auth.php';

// Giriş yapmış kullanıcılar için
Route::middleware('auth')->group(function () {
    // Profil yönetimi
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Mesajlaşma
    Route::prefix('messages')->name('messages.')->group(function () {
        Route::get('/', [MessageController::class, 'index'])->name('index');
        Route::get('/create/{user}', [MessageController::class, 'create'])->name('create');
        Route::post('/', [MessageController::class, 'store'])->name('store');
        Route::get('/{message}', [MessageController::class, 'show'])->name('show');
        Route::delete('/{message}', [MessageController::class, 'destroy'])->name('destroy');
    });
    
    // WhatsApp grupları - sadece görüntüleme
    Route::get('/whatsapp', [WhatsappController::class, 'index'])->name('whatsapp.index');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('whatsapp', WhatsappController::class)->except(['index']);
});
