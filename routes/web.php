<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\WhatsappController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

// Ana sayfa - herkese açık
Route::get('/', [HomeController::class, 'index'])->name('home');

// Gizlilik Politikası - herkese açık
Route::get('/privacy', function () {
    return view('privacy');
})->name('privacy');

// Kullanım Şartları - herkese açık
Route::get('/terms', function () {
    return view('terms');
})->name('terms');

// KVKK sayfası - herkese açık
Route::get('/kvkk', function () {
    return view('kvkk');
})->name('kvkk');

// İletişim formu - herkese açık
Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');

// Profil görüntüleme - herkese açık
Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show');

// Dashboard'ı ana sayfaya yönlendir
Route::get('/dashboard', function () {
    return redirect()->route('home');
})->middleware(['auth', 'verified'])->name('dashboard');

// Admin giriş sayfaları - giriş yapmamış kullanıcılar için
Route::middleware('guest')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminController::class, 'login']);
});

Route::middleware('auth')->group(function () {
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
        Route::delete('/', [MessageController::class, 'bulkDelete'])->name('bulk-delete');
    });
    
    // WhatsApp grupları - sadece görüntüleme
    Route::get('/whatsapp', [WhatsappController::class, 'index'])->name('whatsapp.index');
});

// Admin routes - admin middleware ile korumalı
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [AdminController::class, 'logout'])->name('logout');
    Route::resource('whatsapp', WhatsappController::class);
    
    // Kullanıcı yönetimi
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\UserManagementController::class, 'index'])->name('index');
        
        // Toplu silme - parametre alan route'lardan önce olmalı
        Route::get('/bulk/delete', [\App\Http\Controllers\Admin\UserManagementController::class, 'showBulkDeleteForm'])->name('bulk-delete');
        Route::post('/bulk/delete', [\App\Http\Controllers\Admin\UserManagementController::class, 'bulkDestroy'])->name('bulk-delete.store');
        
        // Yasaklı kullanıcılar - parametre alan route'lardan önce olmalı
        Route::get('/banned/list', [\App\Http\Controllers\Admin\UserManagementController::class, 'bannedUsers'])->name('banned');
        Route::get('/banned/{bannedUser}', [\App\Http\Controllers\Admin\UserManagementController::class, 'showBannedUser'])->name('banned.show');
        Route::delete('/banned/{bannedUser}', [\App\Http\Controllers\Admin\UserManagementController::class, 'unban'])->name('banned.unban');
        
        // Kullanıcı spesifik route'lar
        Route::get('/{user}', [\App\Http\Controllers\Admin\UserManagementController::class, 'show'])->name('show');
        Route::get('/{user}/edit', [\App\Http\Controllers\Admin\UserManagementController::class, 'edit'])->name('edit');
        Route::put('/{user}', [\App\Http\Controllers\Admin\UserManagementController::class, 'update'])->name('update');
        
        // Şifre sıfırlama
        Route::get('/{user}/reset-password', [\App\Http\Controllers\Admin\UserManagementController::class, 'showResetPasswordForm'])->name('reset-password');
        Route::post('/{user}/reset-password', [\App\Http\Controllers\Admin\UserManagementController::class, 'resetPassword'])->name('reset-password.store');
        
        // Askıya alma
        Route::get('/{user}/suspend', [\App\Http\Controllers\Admin\UserManagementController::class, 'showSuspendForm'])->name('suspend');
        Route::post('/{user}/suspend', [\App\Http\Controllers\Admin\UserManagementController::class, 'suspend'])->name('suspend.store');
        Route::post('/{user}/unsuspend', [\App\Http\Controllers\Admin\UserManagementController::class, 'unsuspend'])->name('unsuspend');
        
        // Kalıcı yasaklama
        Route::get('/{user}/ban', [\App\Http\Controllers\Admin\UserManagementController::class, 'showBanForm'])->name('ban');
        Route::post('/{user}/ban', [\App\Http\Controllers\Admin\UserManagementController::class, 'ban'])->name('ban.store');
        
        // Kullanıcı silme
        Route::get('/{user}/delete', [\App\Http\Controllers\Admin\UserManagementController::class, 'showDeleteForm'])->name('delete');
        Route::delete('/{user}', [\App\Http\Controllers\Admin\UserManagementController::class, 'destroy'])->name('destroy');
    });
});

require __DIR__.'/auth.php';
