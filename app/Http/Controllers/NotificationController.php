<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Bildirimler sayfası
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Filtre seçenekleri
        $filter = $request->get('filter', 'all'); // all, unread, read
        $type = $request->get('type'); // message, like, comment, etc.
        
        $query = $user->notifications()->with(['fromUser:id,name,profile_photo_path']);
        
        // Filtre uygula
        if ($filter === 'unread') {
            $query->unread();
        } elseif ($filter === 'read') {
            $query->read();
        }
        
        if ($type) {
            $query->ofType($type);
        }
        
        $notifications = $query->latest()->paginate(20);
        
        // İstatistikler
        $stats = [
            'total' => $user->notifications()->count(),
            'unread' => $user->notifications()->unread()->count(),
            'read' => $user->notifications()->read()->count(),
        ];
        
        // Bildirim türleri sayısı
        $typeStats = [];
        foreach (Notification::getTypes() as $typeKey => $typeName) {
            $typeStats[$typeKey] = $user->notifications()->ofType($typeKey)->count();
        }
        
        return view('notifications.index', compact('notifications', 'stats', 'typeStats', 'filter', 'type'));
    }
    
    /**
     * AJAX ile bildirimler listesi
     */
    public function getNotifications(Request $request)
    {
        $user = Auth::user();
        $limit = $request->get('limit', 10);
        $offset = $request->get('offset', 0);
        
        $notifications = $user->notifications()
            ->with(['fromUser:id,name,profile_photo_path'])
            ->latest()
            ->limit($limit)
            ->offset($offset)
            ->get();
        
        $notificationData = $notifications->map(function ($notification) {
            return [
                'id' => $notification->id,
                'type' => $notification->type,
                'title' => $notification->title,
                'message' => $notification->message,
                'is_read' => $notification->is_read,
                'created_at' => $notification->created_at->diffForHumans(),
                'action_url' => $notification->action_url,
                'from_user' => $notification->fromUser ? [
                    'name' => $notification->fromUser->name,
                    'avatar' => $notification->fromUser->profile_photo_url,
                ] : null,
                'data' => $notification->data,
            ];
        });
        
        return response()->json([
            'success' => true,
            'notifications' => $notificationData,
            'unread_count' => $user->unread_notifications_count,
        ]);
    }
    
    /**
     * Bildirim sayısı (AJAX)
     */
    public function getUnreadCount()
    {
        $count = Auth::user()->unread_notifications_count;
        
        return response()->json([
            'success' => true,
            'count' => $count,
            'formatted_count' => $count > 99 ? '99+' : $count,
        ]);
    }
    
    /**
     * Bildirim okundu olarak işaretle
     */
    public function markAsRead(Notification $notification)
    {
        // Yetki kontrolü
        if ($notification->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Bu bildirimi okuma yetkiniz yok.'
            ], 403);
        }
        
        $notification->markAsRead();
        
        return response()->json([
            'success' => true,
            'message' => 'Bildirim okundu olarak işaretlendi.',
            'unread_count' => Auth::user()->unread_notifications_count,
        ]);
    }
    
    /**
     * Bildirim okunmadı olarak işaretle
     */
    public function markAsUnread(Notification $notification)
    {
        // Yetki kontrolü
        if ($notification->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Bu bildirimi düzenleme yetkiniz yok.'
            ], 403);
        }
        
        $notification->markAsUnread();
        
        return response()->json([
            'success' => true,
            'message' => 'Bildirim okunmadı olarak işaretlendi.',
            'unread_count' => Auth::user()->unread_notifications_count,
        ]);
    }
    
    /**
     * Tüm bildirimi okundu işaretle
     */
    public function markAllAsRead()
    {
        $count = Notification::markAllAsReadForUser(Auth::id());
        
        return response()->json([
            'success' => true,
            'message' => "{$count} bildirim okundu olarak işaretlendi.",
            'unread_count' => 0,
        ]);
    }
    
    /**
     * Bildirim sil
     */
    public function destroy(Notification $notification)
    {
        // Yetki kontrolü
        if ($notification->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Bu bildirimi silme yetkiniz yok.'
            ], 403);
        }
        
        $notification->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Bildirim silindi.',
            'unread_count' => Auth::user()->unread_notifications_count,
        ]);
    }
    
    /**
     * Bildirimi oku ve yönlendir
     */
    public function readAndRedirect(Notification $notification)
    {
        // Yetki kontrolü
        if ($notification->user_id !== Auth::id()) {
            abort(403, 'Bu bildirimi görme yetkiniz yok.');
        }
        
        // Okundu olarak işaretle
        $notification->markAsRead();
        
        // Eğer action_url varsa yönlendir
        if ($notification->action_url) {
            return redirect($notification->action_url);
        }
        
        // Yoksa bildirimler sayfasına yönlendir
        return redirect()->route('notifications.index');
    }
    
    /**
     * Bildirim ayarları sayfası
     */
    public function settings()
    {
        $user = Auth::user();
        
        // Kullanıcının bildirim tercihleri (ileride user_notification_settings tablosu eklenebilir)
        $settings = [
            'email_notifications' => true, // Varsayılan değerler
            'like_notifications' => true,
            'comment_notifications' => true,
            'message_notifications' => true,
            'follow_notifications' => true,
        ];
        
        return view('notifications.settings', compact('settings'));
    }
    
    /**
     * Bildirim ayarlarını güncelle
     */
    public function updateSettings(Request $request)
    {
        $request->validate([
            'email_notifications' => 'boolean',
            'like_notifications' => 'boolean',
            'comment_notifications' => 'boolean',
            'message_notifications' => 'boolean',
            'follow_notifications' => 'boolean',
        ]);
        
        // İleride user_notification_settings tablosuna kaydedilecek
        // Şimdilik sadece başarı mesajı döndür
        
        return redirect()->route('notifications.settings')
            ->with('success', 'Bildirim ayarlarınız güncellendi.');
    }
}
