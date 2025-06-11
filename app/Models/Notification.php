<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'from_user_id',
        'type',
        'title',
        'message',
        'notifiable_type',
        'notifiable_id',
        'data',
        'is_read',
        'read_at',
        'is_email_sent',
        'email_sent_at',
        'action_url',
    ];

    protected $casts = [
        'data' => 'array',
        'is_read' => 'boolean',
        'is_email_sent' => 'boolean',
        'read_at' => 'datetime',
        'email_sent_at' => 'datetime',
    ];

    /**
     * Bildirim alan kullanıcı
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Bildirimi gönderen kullanıcı
     */
    public function fromUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    /**
     * Polymorphic ilişki - bildirimin bağlı olduğu obje
     */
    public function notifiable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Okunmamış bildiriler
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /**
     * Okunmuş bildiriler
     */
    public function scopeRead($query)
    {
        return $query->where('is_read', true);
    }

    /**
     * Belirli tipteki bildiriler
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Son bildiriler
     */
    public function scopeRecent($query, $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    /**
     * Bildirimi okundu olarak işaretle
     */
    public function markAsRead()
    {
        if (!$this->is_read) {
            $this->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
        }
    }

    /**
     * Bildirimi okunmadı olarak işaretle
     */
    public function markAsUnread()
    {
        $this->update([
            'is_read' => false,
            'read_at' => null,
        ]);
    }

    /**
     * E-posta gönderildi olarak işaretle
     */
    public function markEmailAsSent()
    {
        $this->update([
            'is_email_sent' => true,
            'email_sent_at' => now(),
        ]);
    }

    /**
     * Bildirim türleri
     */
    public static function getTypes(): array
    {
        return [
            'message' => 'Yeni Mesaj',
            'like' => 'Beğeni',
            'comment' => 'Yorum',
            'follow' => 'Takip',
            'post' => 'Yeni Paylaşım',
            'mention' => 'Bahsetme',
            'system' => 'Sistem Bildirimi',
        ];
    }

    /**
     * Bildirim oluştur - ana helper method
     */
    public static function createNotification(array $data): self
    {
        return self::create([
            'user_id' => $data['user_id'],
            'from_user_id' => $data['from_user_id'] ?? null,
            'type' => $data['type'],
            'title' => $data['title'],
            'message' => $data['message'],
            'notifiable_type' => $data['notifiable_type'] ?? null,
            'notifiable_id' => $data['notifiable_id'] ?? null,
            'data' => $data['data'] ?? [],
            'action_url' => $data['action_url'] ?? null,
        ]);
    }

    /**
     * Beğeni bildirimi oluştur
     */
    public static function createLikeNotification(Post $post, User $fromUser): ?self
    {
        // Kendi postunu beğeniyorsa bildirim gönderme
        if ($post->user_id === $fromUser->id) {
            return null;
        }

        return self::createNotification([
            'user_id' => $post->user_id,
            'from_user_id' => $fromUser->id,
            'type' => 'like',
            'title' => 'Paylaşımınız beğenildi!',
            'message' => $fromUser->name . ' paylaşımınızı beğendi.',
            'notifiable_type' => Post::class,
            'notifiable_id' => $post->id,
            'action_url' => route('posts.index') . '#post-' . $post->id,
            'data' => [
                'from_user_avatar' => $fromUser->profile_photo_url,
                'post_excerpt' => \Str::limit($post->content, 50),
            ],
        ]);
    }

    /**
     * Yorum bildirimi oluştur
     */
    public static function createCommentNotification(Comment $comment): ?self
    {
        $post = $comment->post;
        $fromUser = $comment->user;

        // Kendi postuna yorum yapıyorsa bildirim gönderme
        if ($post->user_id === $fromUser->id) {
            return null;
        }

        return self::createNotification([
            'user_id' => $post->user_id,
            'from_user_id' => $fromUser->id,
            'type' => 'comment',
            'title' => 'Paylaşımınıza yorum yapıldı!',
            'message' => $fromUser->name . ' paylaşımınıza yorum yaptı: "' . \Str::limit($comment->content, 50) . '"',
            'notifiable_type' => Comment::class,
            'notifiable_id' => $comment->id,
            'action_url' => route('posts.index') . '#post-' . $post->id,
            'data' => [
                'from_user_avatar' => $fromUser->profile_photo_url,
                'post_excerpt' => \Str::limit($post->content, 50),
                'comment_excerpt' => \Str::limit($comment->content, 50),
            ],
        ]);
    }

    /**
     * Mesaj bildirimi oluştur
     */
    public static function createMessageNotification(Message $message): self
    {
        return self::createNotification([
            'user_id' => $message->recipient_id,
            'from_user_id' => $message->sender_id,
            'type' => 'message',
            'title' => 'Yeni mesajınız var!',
            'message' => $message->sender->name . ' size yeni bir mesaj gönderdi.',
            'notifiable_type' => Message::class,
            'notifiable_id' => $message->id,
            'action_url' => route('messages.index'),
            'data' => [
                'from_user_avatar' => $message->sender->profile_photo_url,
                'message_excerpt' => \Str::limit($message->content, 50),
            ],
        ]);
    }

    /**
     * Kullanıcının okunmamış bildirim sayısı
     */
    public static function getUnreadCount($userId): int
    {
        return self::where('user_id', $userId)->unread()->count();
    }

    /**
     * Kullanıcının tüm bildirimlerini okundu olarak işaretle
     */
    public static function markAllAsReadForUser($userId): int
    {
        return self::where('user_id', $userId)
            ->unread()
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
    }
}
