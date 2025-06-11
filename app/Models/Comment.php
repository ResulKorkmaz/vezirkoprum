<?php

namespace App\Models;

use App\Models\Concerns\Reportable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory, Reportable;

    protected $fillable = [
        'user_id',
        'post_id',
        'content',
        'is_active',
        'is_spam',
        'spam_score',
        'spam_checked_at',
        'spam_reasons'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_spam' => 'boolean',
        'spam_score' => 'integer',
        'spam_checked_at' => 'datetime',
        'spam_reasons' => 'array'
    ];

    /**
     * Yorumu yapan kullanıcı
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Yorum yapılan post
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Aktif yorumları getir
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->where('is_spam', false);
    }

    /**
     * Spam olmayan yorumları getir
     */
    public function scopeNotSpam($query)
    {
        return $query->where('is_spam', false);
    }

    /**
     * En yeni yorumları getir
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * Bir postun aktif yorum sayısını getir
     */
    public static function getActiveCommentCount($postId)
    {
        return self::where('post_id', $postId)
            ->active()
            ->count();
    }

    /**
     * Yorumu spam olarak işaretle
     */
    public function markAsSpam($reasons = [])
    {
        $this->update([
            'is_spam' => true,
            'spam_checked_at' => now(),
            'spam_reasons' => $reasons,
            'is_active' => false,
        ]);
    }

    /**
     * Yorumu temizle
     */
    public function markAsClean()
    {
        $this->update([
            'is_spam' => false,
            'spam_score' => 0,
            'spam_checked_at' => now(),
            'spam_reasons' => null,
            'is_active' => true,
        ]);
    }

    /**
     * İçeriği kısalt
     */
    public function getShortContentAttribute()
    {
        return \Str::limit($this->content, 100);
    }
}
