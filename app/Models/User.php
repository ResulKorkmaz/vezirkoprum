<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Crypt;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profession_id',
        'current_city',
        'current_district',
        'phone',
        'show_phone',
        'birth_year',
        'bio',
        'profile_photo',
        'profile_photo_visibility',
        'kvkk_consent',
        'kvkk_consent_date',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'phone', // Telefon her zaman şifreli saklanır
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'show_phone' => 'boolean',
            'is_admin' => 'boolean',
            'birth_year' => 'integer',
        ];
    }

    /**
     * İlişkiler
     */
    public function profession()
    {
        return $this->belongsTo(Profession::class);
    }

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    /**
     * Telefon şifreleme/deşifreleme
     */
    public function setPhoneAttribute($value)
    {
        if ($value) {
            $this->attributes['phone'] = Crypt::encryptString($value);
        } else {
            $this->attributes['phone'] = null;
        }
    }

    public function getPhoneAttribute($value)
    {
        if ($value) {
            try {
                return Crypt::decryptString($value);
            } catch (\Exception $e) {
                return null;
            }
        }
        return null;
    }

    /**
     * Ham telefon verisi (şifreli)
     */
    public function getRawPhoneAttribute()
    {
        return $this->attributes['phone'] ?? null;
    }

    /**
     * Gösterilecek telefon numarası
     */
    public function getDisplayPhoneAttribute()
    {
        if ($this->show_phone && $this->attributes['phone']) {
            try {
                return Crypt::decryptString($this->attributes['phone']);
            } catch (\Exception $e) {
                return null;
            }
        }
        return '*** *** ** **';
    }

    /**
     * Okunmamış mesaj sayısı
     */
    public function getUnreadMessagesCountAttribute()
    {
        return $this->receivedMessages()->where('is_read', false)->count();
    }

    /**
     * Profil resmi URL'si
     */
    public function getProfilePhotoUrlAttribute()
    {
        if ($this->profile_photo) {
            return asset('storage/profile-photos/' . $this->profile_photo);
        }
        return 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgdmlld0JveD0iMCAwIDEwMCAxMDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSIxMDAiIGhlaWdodD0iMTAwIiBmaWxsPSIjRTVFN0VCIi8+CjxjaXJjbGUgY3g9IjUwIiBjeT0iMzUiIHI9IjE1IiBmaWxsPSIjOUNBM0FGIi8+CjxwYXRoIGQ9Ik0yNSA4NUMyNSA3MCAzNSA2MCA1MCA2MEM2NSA2MCA3NSA3MCA3NSA4NSIgc3Ryb2tlPSIjOUNBM0FGIiBzdHJva2Utd2lkdGg9IjMiIGZpbGw9Im5vbmUiLz4KPC9zdmc+';
    }

    /**
     * Profil resminin kullanıcı için görünür olup olmadığını kontrol et
     */
    public function canSeeProfilePhoto($viewer = null)
    {
        if (!$this->profile_photo) {
            return false;
        }

        switch ($this->profile_photo_visibility) {
            case 'everyone':
                return true;
            case 'members_only':
                return $viewer && $viewer instanceof User;
            case 'private':
                return $viewer && $viewer->id === $this->id;
            default:
                return false;
        }
    }

    /**
     * Görünür profil resmi URL'si
     */
    public function getVisibleProfilePhotoUrl($viewer = null)
    {
        if ($this->canSeeProfilePhoto($viewer)) {
            return $this->profile_photo_url;
        }
        return 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgdmlld0JveD0iMCAwIDEwMCAxMDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSIxMDAiIGhlaWdodD0iMTAwIiBmaWxsPSIjRTVFN0VCIi8+CjxjaXJjbGUgY3g9IjUwIiBjeT0iMzUiIHI9IjE1IiBmaWxsPSIjOUNBM0FGIi8+CjxwYXRoIGQ9Ik0yNSA4NUMyNSA3MCAzNSA2MCA1MCA2MEM2NSA2MCA3NSA3MCA3NSA4NSIgc3Ryb2tlPSIjOUNBM0FGIiBzdHJva2Utd2lkdGg9IjMiIGZpbGw9Im5vbmUiLz4KPC9zdmc+';
    }

    /**
     * Telefon numarası ile kullanıcı bulma
     */
    public static function findByPhone($phone)
    {
        // Telefon numarasını temizle (boşluk, tire, parantez kaldır)
        $cleanPhone = preg_replace('/[\s\-\(\)]/', '', $phone);
        
        // Tüm kullanıcıları gez ve telefon numaralarını decrypt et
        $users = self::whereNotNull('phone')->get();
        
        foreach ($users as $user) {
            try {
                $decryptedPhone = Crypt::decryptString($user->attributes['phone']);
                $cleanDecryptedPhone = preg_replace('/[\s\-\(\)]/', '', $decryptedPhone);
                
                if ($cleanDecryptedPhone === $cleanPhone) {
                    return $user;
                }
            } catch (\Exception $e) {
                // Decrypt hatası durumunda devam et
                continue;
            }
        }
        
        return null;
    }

    /**
     * E-posta veya telefon ile kullanıcı bulma
     */
    public static function findByEmailOrPhone($identifier)
    {
        // E-posta formatında mı kontrol et
        if (filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
            return self::where('email', $identifier)->first();
        }
        
        // Telefon numarası olarak ara
        return self::findByPhone($identifier);
    }
}
