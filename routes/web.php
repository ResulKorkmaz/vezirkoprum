<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\WhatsappController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\SiteSettingsController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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

// Yorum okuma - herkese açık
Route::get('/posts/{post}/comments', [\App\Http\Controllers\CommentController::class, 'index'])->name('posts.comments.index');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Hemşehriler sayfası - sadece üyeler görebilir
    Route::get('/hemsehriler', [HomeController::class, 'hemsehriler'])->name('hemsehriler.index');
    
    // Paylaşımlar
    Route::prefix('posts')->name('posts.')->group(function () {
        Route::get('/', [PostController::class, 'index'])->name('index');
        Route::get('/create', [PostController::class, 'create'])->name('create');
        Route::post('/', [PostController::class, 'store'])->name('store');
        Route::get('/remaining', [PostController::class, 'getRemainingPosts'])->name('remaining');
        Route::get('/{post}/edit', [PostController::class, 'edit'])->name('edit');
        Route::put('/{post}', [PostController::class, 'update'])->name('update');
        Route::delete('/{post}', [PostController::class, 'destroy'])->name('destroy');
        
        // Beğeni işlemleri
        Route::post('/{post}/like', [\App\Http\Controllers\LikeController::class, 'toggle'])->name('like');
        Route::get('/{post}/like-status', [\App\Http\Controllers\LikeController::class, 'status'])->name('like.status');
        Route::get('/{post}/likers', [\App\Http\Controllers\LikeController::class, 'users'])->name('likers');
        
        // Yorum yazma - sadece giriş yapmış kullanıcılar
        Route::post('/{post}/comments', [\App\Http\Controllers\CommentController::class, 'store'])->name('comments.store');
    });
    
    // Yorum yönetimi
    Route::prefix('comments')->name('comments.')->group(function () {
        Route::put('/{comment}', [\App\Http\Controllers\CommentController::class, 'update'])->name('update');
        Route::delete('/{comment}', [\App\Http\Controllers\CommentController::class, 'destroy'])->name('destroy');
    });
    
    // Mesajlaşma
    Route::prefix('messages')->name('messages.')->group(function () {
        Route::get('/', [MessageController::class, 'index'])->name('index');
        Route::get('/create/{user}', [MessageController::class, 'create'])->name('create');
        Route::post('/', [MessageController::class, 'store'])->name('store');
        Route::get('/{message}', [MessageController::class, 'show'])->name('show');
        Route::delete('/{message}', [MessageController::class, 'destroy'])->name('destroy');
        Route::delete('/', [MessageController::class, 'bulkDelete'])->name('bulk-delete');
    });
    
    // Bildiriler
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/create', [\App\Http\Controllers\ReportController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\ReportController::class, 'store'])->name('store');
    });
    
    // Bildirimler (Notifications)
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', [\App\Http\Controllers\NotificationController::class, 'index'])->name('index');
        Route::get('/api', [\App\Http\Controllers\NotificationController::class, 'getNotifications'])->name('api');
        Route::get('/count', [\App\Http\Controllers\NotificationController::class, 'getUnreadCount'])->name('count');
        Route::patch('/{notification}/read', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('mark-read');
        Route::patch('/{notification}/unread', [\App\Http\Controllers\NotificationController::class, 'markAsUnread'])->name('mark-unread');
        Route::patch('/mark-all-read', [\App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('mark-all-read');
        Route::delete('/{notification}', [\App\Http\Controllers\NotificationController::class, 'destroy'])->name('destroy');
        Route::get('/{notification}/redirect', [\App\Http\Controllers\NotificationController::class, 'readAndRedirect'])->name('redirect');
        Route::get('/settings', [\App\Http\Controllers\NotificationController::class, 'settings'])->name('settings');
        Route::patch('/settings', [\App\Http\Controllers\NotificationController::class, 'updateSettings'])->name('update-settings');
    });
    
    // WhatsApp grupları - sadece görüntüleme
    Route::get('/whatsapp', [WhatsappController::class, 'index'])->name('whatsapp.index');
});

// Admin routes - admin middleware ile korumalı
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [AdminController::class, 'logout'])->name('logout');
    Route::resource('whatsapp', WhatsappController::class);
    
    // Spam yönetimi
    Route::prefix('spam')->name('spam.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\SpamController::class, 'index'])->name('index');
        Route::get('/posts', [\App\Http\Controllers\Admin\SpamController::class, 'posts'])->name('posts');
        Route::get('/words', [\App\Http\Controllers\Admin\SpamController::class, 'words'])->name('words');
        
        // Post işlemleri
        Route::patch('/posts/{post}/approve', [\App\Http\Controllers\Admin\SpamController::class, 'approvePost'])->name('posts.approve');
        Route::patch('/posts/{post}/spam', [\App\Http\Controllers\Admin\SpamController::class, 'confirmSpam'])->name('posts.spam');
        Route::patch('/posts/{post}/quarantine', [\App\Http\Controllers\Admin\SpamController::class, 'quarantinePost'])->name('posts.quarantine');
        Route::delete('/posts/{post}', [\App\Http\Controllers\Admin\SpamController::class, 'deletePost'])->name('posts.delete');
        Route::post('/posts/bulk', [\App\Http\Controllers\Admin\SpamController::class, 'bulkAction'])->name('posts.bulk');
        
        // Kelime işlemleri
        Route::post('/words', [\App\Http\Controllers\Admin\SpamController::class, 'addWord'])->name('words.add');
        Route::patch('/words/{word}', [\App\Http\Controllers\Admin\SpamController::class, 'updateWord'])->name('words.update');
        Route::delete('/words/{word}', [\App\Http\Controllers\Admin\SpamController::class, 'deleteWord'])->name('words.delete');
        
        // Analiz işlemleri
        Route::post('/analyze', [\App\Http\Controllers\Admin\SpamController::class, 'analyzeContent'])->name('analyze');
        Route::post('/reanalyze', [\App\Http\Controllers\Admin\SpamController::class, 'reanalyzeAll'])->name('reanalyze');
    });
    
    // Bildiri yönetimi
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\ReportManagementController::class, 'index'])->name('index');
        Route::get('/{report}', [\App\Http\Controllers\Admin\ReportManagementController::class, 'show'])->name('show');
        Route::patch('/{report}/status', [\App\Http\Controllers\Admin\ReportManagementController::class, 'updateStatus'])->name('update-status');
        Route::patch('/{report}/toggle-content', [\App\Http\Controllers\Admin\ReportManagementController::class, 'toggleContent'])->name('toggle-content');
        Route::delete('/{report}', [\App\Http\Controllers\Admin\ReportManagementController::class, 'destroy'])->name('destroy');
        Route::post('/bulk-action', [\App\Http\Controllers\Admin\ReportManagementController::class, 'bulkAction'])->name('bulk-action');
    });
    
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
    
    // Site Ayarları
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [SiteSettingsController::class, 'index'])->name('index');
        Route::put('/', [SiteSettingsController::class, 'update'])->name('update');
        Route::post('/initialize', [SiteSettingsController::class, 'initializeDefaults'])->name('initialize');
        Route::post('/', [SiteSettingsController::class, 'store'])->name('store');
        Route::delete('/{setting}', [SiteSettingsController::class, 'destroy'])->name('destroy');
    });
});

// Sitemap for SEO
Route::get('/sitemap.xml', function () {
    $sitemap = '<?xml version="1.0" encoding="UTF-8"?>';
    $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
    
    // Homepage
    $sitemap .= '<url>';
    $sitemap .= '<loc>https://vezirkoprum.com.tr/</loc>';
    $sitemap .= '<lastmod>' . now()->toISOString() . '</lastmod>';
    $sitemap .= '<changefreq>daily</changefreq>';
    $sitemap .= '<priority>1.0</priority>';
    $sitemap .= '</url>';
    
    // Register page
    $sitemap .= '<url>';
    $sitemap .= '<loc>https://vezirkoprum.com.tr/register</loc>';
    $sitemap .= '<lastmod>' . now()->toISOString() . '</lastmod>';
    $sitemap .= '<changefreq>monthly</changefreq>';
    $sitemap .= '<priority>0.8</priority>';
    $sitemap .= '</url>';
    
    // Login page
    $sitemap .= '<url>';
    $sitemap .= '<loc>https://vezirkoprum.com.tr/login</loc>';
    $sitemap .= '<lastmod>' . now()->toISOString() . '</lastmod>';
    $sitemap .= '<changefreq>monthly</changefreq>';
    $sitemap .= '<priority>0.7</priority>';
    $sitemap .= '</url>';
    
    // WhatsApp groups page
    $sitemap .= '<url>';
    $sitemap .= '<loc>https://vezirkoprum.com.tr/whatsapp</loc>';
    $sitemap .= '<lastmod>' . now()->toISOString() . '</lastmod>';
    $sitemap .= '<changefreq>weekly</changefreq>';
    $sitemap .= '<priority>0.9</priority>';
    $sitemap .= '</url>';
    
    $sitemap .= '</urlset>';
    
    return response($sitemap, 200, [
        'Content-Type' => 'application/xml'
    ]);
})->name('sitemap');

require __DIR__.'/auth.php';
