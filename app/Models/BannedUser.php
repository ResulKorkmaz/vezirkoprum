<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class BannedUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'phone_hash',
        'ban_type',
        'ban_reason',
        'banned_by',
        'banned_at',
        'ban_expires_at',
        'original_user_data',
    ];

    protected $casts = [
        'banned_at' => 'datetime',
        'ban_expires_at' => 'datetime',
        'original_user_data' => 'array',
    ];

    /**
     * İlişkiler
     */
    public function bannedBy()
    {
        return $this->belongsTo(User::class, 'banned_by');
    }

    /**
     * E-posta yasaklı mı kontrol et
     */
    public static function isEmailBanned($email)
    {
        return self::where('email', $email)
            ->where(function ($query) {
                $query->where('ban_type', 'permanent')
                    ->orWhere(function ($q) {
                        $q->where('ban_type', 'temporary')
                          ->where('ban_expires_at', '>', now());
                    });
            })
            ->exists();
    }

    /**
     * Telefon numarası yasaklı mı kontrol et
     */
    public static function isPhoneBanned($phone)
    {
        if (!$phone) return false;
        
        $phoneHash = hash('sha256', $phone);
        
        return self::where('phone_hash', $phoneHash)
            ->where(function ($query) {
                $query->where('ban_type', 'permanent')
                    ->orWhere(function ($q) {
                        $q->where('ban_type', 'temporary')
                          ->where('ban_expires_at', '>', now());
                    });
            })
            ->exists();
    }

    /**
     * Kullanıcıyı yasakla
     */
    public static function banUser(User $user, $reason, $bannedBy, $banType = 'permanent', $expiresAt = null)
    {
        // Telefon numarasının hash'ini al
        $phoneHash = null;
        if ($user->getRawPhoneAttribute()) {
            try {
                $decryptedPhone = Crypt::decryptString($user->getRawPhoneAttribute());
                $phoneHash = hash('sha256', $decryptedPhone);
            } catch (\Exception $e) {
                // Decrypt hatası durumunda devam et
            }
        }

        return self::create([
            'email' => $user->email,
            'phone_hash' => $phoneHash,
            'ban_type' => $banType,
            'ban_reason' => $reason,
            'banned_by' => $bannedBy,
            'banned_at' => now(),
            'ban_expires_at' => $expiresAt,
            'original_user_data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'unique_user_id' => $user->unique_user_id,
                'current_city' => $user->current_city,
                'current_district' => $user->current_district,
                'profession_id' => $user->profession_id,
                'created_at' => $user->created_at,
            ],
        ]);
    }

    /**
     * Yasağın aktif olup olmadığını kontrol et
     */
    public function isActive()
    {
        if ($this->ban_type === 'permanent') {
            return true;
        }
        
        if ($this->ban_type === 'temporary' && $this->ban_expires_at) {
            return $this->ban_expires_at->isFuture();
        }
        
        return false;
    }

    /**
     * Yasağın kalan süresini al
     */
    public function getRemainingTime()
    {
        if ($this->ban_type === 'permanent') {
            return 'Süresiz';
        }
        
        if ($this->ban_type === 'temporary' && $this->ban_expires_at) {
            if ($this->ban_expires_at->isFuture()) {
                return $this->ban_expires_at->diffForHumans();
            }
            return 'Süresi dolmuş';
        }
        
        return 'Bilinmiyor';
    }
}
