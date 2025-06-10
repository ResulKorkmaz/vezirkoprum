<?php

namespace App\Models;

use App\Models\Concerns\Reportable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Post extends Model
{
    use Reportable;

    protected $fillable = [
        'user_id',
        'content',
        'image',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
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
     * Aktif postları getir
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * En yeni postları getir
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * İçeriği kısalt
     */
    public function getShortContentAttribute()
    {
        return \Str::limit($this->content, 100);
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
}
