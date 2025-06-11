<?php

namespace App\Models;

use App\Models\Concerns\Reportable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Post extends Model
{
    use Reportable;

    protected $fillable = [
        'user_id',
        'content',
        'image',
        'is_active',
        'is_spam',
        'spam_score',
        'spam_status',
        'spam_checked_at',
        'spam_reasons',
        'like_count',
        'comment_count',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'is_spam' => 'boolean',
            'spam_score' => 'integer',
            'spam_checked_at' => 'datetime',
            'spam_reasons' => 'array',
            'like_count' => 'integer',
            'comment_count' => 'integer',
        ];
    }

    /**
     * Post sahibi kullanıcı
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Post beğenileri
     */
    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    /**
     * Post yorumları
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Aktif yorumlar
     */
    public function activeComments(): HasMany
    {
        return $this->hasMany(Comment::class)->active()->latest();
    }

    /**
     * Aktif postları getir
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Spam olmayan postları getir
     */
    public function scopeNotSpam($query)
    {
        return $query->where('is_spam', false);
    }

    /**
     * Temiz postları getir (spam değil ve karantinada değil)
     */
    public function scopeClean($query)
    {
        return $query->where('spam_status', 'clean');
    }

    /**
     * Şüpheli postları getir
     */
    public function scopeSuspicious($query)
    {
        return $query->where('spam_status', 'suspicious');
    }

    /**
     * Karantinada olan postları getir
     */
    public function scopeQuarantined($query)
    {
        return $query->where('spam_status', 'quarantined');
    }

    /**
     * En yeni postları getir
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * En popüler postları getir (beğeni + yorum sayısına göre)
     */
    public function scopePopular($query)
    {
        return $query->orderByRaw('(like_count + comment_count) DESC');
    }

    /**
     * İçeriği kısalt
     */
    public function getShortContentAttribute()
    {
        return \Str::limit($this->content, 100);
    }

    /**
     * Kullanıcının belirli bir postu beğenip beğenmediğini kontrol et
     */
    public function isLikedByUser($userId)
    {
        return $this->likes()->where('user_id', $userId)->exists();
    }

    /**
     * Beğeni sayısını güncelle
     */
    public function updateLikeCount()
    {
        $this->update(['like_count' => $this->likes()->count()]);
    }

    /**
     * Yorum sayısını güncelle
     */
    public function updateCommentCount()
    {
        $this->update(['comment_count' => $this->activeComments()->count()]);
    }

    /**
     * Kullanıcının günlük paylaşım sayısını kontrol et
     */
    public static function getUserDailyPostCount($userId)
    {
        return self::where('user_id', $userId)
            ->whereDate('created_at', Carbon::today())
            ->count();
    }

    /**
     * Kullanıcı günlük limite ulaştı mı?
     */
    public static function hasUserReachedDailyLimit($userId, $limit = 3)
    {
        return self::getUserDailyPostCount($userId) >= $limit;
    }

    /**
     * Kullanıcının kalan paylaşım hakkı
     */
    public static function getUserRemainingPosts($userId, $limit = 3)
    {
        $used = self::getUserDailyPostCount($userId);
        return max(0, $limit - $used);
    }

    /**
     * Postu spam olarak işaretle
     */
    public function markAsSpam($reasons = [])
    {
        $this->update([
            'is_spam' => true,
            'spam_status' => 'spam',
            'spam_checked_at' => now(),
            'spam_reasons' => $reasons,
            'is_active' => false, // Spam postlar otomatik olarak deaktif olur
        ]);
    }

    /**
     * Postu şüpheli olarak işaretle
     */
    public function markAsSuspicious($score, $reasons = [])
    {
        $this->update([
            'spam_score' => $score,
            'spam_status' => 'suspicious',
            'spam_checked_at' => now(),
            'spam_reasons' => $reasons,
        ]);
    }

    /**
     * Postu karantinaya al
     */
    public function quarantine($reasons = [])
    {
        $this->update([
            'spam_status' => 'quarantined',
            'spam_checked_at' => now(),
            'spam_reasons' => $reasons,
            'is_active' => false,
        ]);
    }

    /**
     * Postu temizle (spam değil olarak işaretle)
     */
    public function markAsClean()
    {
        $this->update([
            'is_spam' => false,
            'spam_score' => 0,
            'spam_status' => 'clean',
            'spam_checked_at' => now(),
            'spam_reasons' => null,
            'is_active' => true,
        ]);
    }
}
