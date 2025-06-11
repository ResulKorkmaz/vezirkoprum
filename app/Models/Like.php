<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Like extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'post_id'
    ];

    /**
     * Beğeniyi yapan kullanıcı
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Beğenilen post
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Kullanıcının belirli bir postu beğenip beğenmediğini kontrol et
     */
    public static function isLikedByUser($postId, $userId)
    {
        return self::where('post_id', $postId)
            ->where('user_id', $userId)
            ->exists();
    }

    /**
     * Bir postun toplam beğeni sayısını getir
     */
    public static function getLikeCount($postId)
    {
        return self::where('post_id', $postId)->count();
    }

    /**
     * Kullanıcının toplam aldığı beğeni sayısı
     */
    public static function getUserTotalLikes($userId)
    {
        return self::whereHas('post', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->count();
    }
}
