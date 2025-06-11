<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'reporter_id',
        'reportable_type',
        'reportable_id',
        'reason',
        'description',
        'status',
        'reviewed_by',
        'admin_notes',
        'reviewed_at',
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
    ];

    /**
     * Bildirimi yapan kullanıcı
     */
    public function reporter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    /**
     * Bildirimi inceleyen admin
     */
    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    /**
     * Bildirilen içerik (polymorphic)
     */
    public function reportable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Bildiri nedenleri
     */
    public static function getReasons(): array
    {
        return [
            'sexual_assault' => 'Cinsel Saldırı',
            'violence_and_profanity' => 'Şiddet ve Küfür',
            'other' => 'Diğer',
            'spam' => 'Spam/Reklam',
            'inappropriate' => 'Uygunsuz İçerik',
            'harassment' => 'Taciz/Zorbalık',
            'fake_news' => 'Yanlış Bilgi',
            'hate_speech' => 'Nefret Söylemi',
            'violence' => 'Şiddet İçeriği',
            'copyright' => 'Telif Hakkı İhlali',
        ];
    }

    /**
     * Durum renkleri
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending' => 'yellow',
            'reviewed' => 'blue',
            'resolved' => 'green',
            'dismissed' => 'gray',
            default => 'gray',
        };
    }

    /**
     * Durum metinleri
     */
    public function getStatusTextAttribute(): string
    {
        return match($this->status) {
            'pending' => 'Beklemede',
            'reviewed' => 'İnceleniyor',
            'resolved' => 'Çözüldü',
            'dismissed' => 'Reddedildi',
            default => 'Bilinmiyor',
        };
    }

    /**
     * Scope: Bekleyen bildiriler
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope: Belirli bir tür için bildiriler
     */
    public function scopeForType($query, string $type)
    {
        return $query->where('reportable_type', $type);
    }
}
