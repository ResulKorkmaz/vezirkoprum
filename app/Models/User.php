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
        'unique_user_id',
        'profession_id',
        'retirement_detail',
        'current_city',
        'current_district',
        'phone',
        'show_phone',
        'birth_year',
        'bio',
        'profile_photo_path',
        'profile_photo_visibility',
        'kvkk_consent',
        'kvkk_consent_date',
        'is_admin',
        'is_suspended',
        'suspended_until',
        'suspension_reason',
        'suspended_by',
        'suspended_at',
        'admin_notes',
        'last_login_at',
        'last_login_ip',
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
            'is_suspended' => 'boolean',
            'suspended_until' => 'datetime',
            'suspended_at' => 'datetime',
            'last_login_at' => 'datetime',
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

    /**
     * Meslek gösterimi (emekli detayı ile birlikte)
     */
    public function getDisplayProfessionAttribute()
    {
        if (!$this->profession) {
            return null;
        }

        $professionName = $this->profession->name;
        
        // Eğer meslek "Emekli" ise ve retirement_detail varsa
        if ($professionName === 'Emekli' && $this->retirement_detail) {
            return "Emekli ({$this->retirement_detail})";
        }
        
        return $professionName;
    }

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Kullanıcının beğenileri
     */
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    /**
     * Kullanıcının yorumları
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Kullanıcının bildirimleri
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    /**
     * Kullanıcının gönderdiği bildiriler
     */
    public function sentNotifications()
    {
        return $this->hasMany(Notification::class, 'from_user_id');
    }

    /**
     * Okunmamış bildirim sayısı
     */
    public function getUnreadNotificationsCountAttribute()
    {
        return $this->notifications()->unread()->count();
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
        if ($this->profile_photo_path) {
            return asset('storage/' . $this->profile_photo_path);
        }
        return 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgdmlld0JveD0iMCAwIDEwMCAxMDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSIxMDAiIGhlaWdodD0iMTAwIiBmaWxsPSIjRTVFN0VCIi8+CjxjaXJjbGUgY3g9IjUwIiBjeT0iMzUiIHI9IjE1IiBmaWxsPSIjOUNBM0FGIi8+CjxwYXRoIGQ9Ik0yNSA4NUMyNSA3MCAzNSA2MCA1MCA2MEM2NSA2MCA3NSA3MCA3NSA4NSIgc3Ryb2tlPSIjOUNBM0FGIiBzdHJva2Utd2lkdGg9IjMiIGZpbGw9Im5vbmUiLz4KPC9zdmc+';
    }

    /**
     * Profil resminin kullanıcı için görünür olup olmadığını kontrol et
     */
    public function canSeeProfilePhoto($viewer = null)
    {
        if (!$this->profile_photo_path) {
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

    /**
     * Model events
     */
    protected static function boot()
    {
        parent::boot();

        // Yeni kullanıcı oluşturulduğunda benzersiz ID ata
        static::creating(function ($user) {
            if (!$user->unique_user_id) {
                $user->unique_user_id = self::generateUniqueUserId();
            }
        });

        // Kullanıcı silinmeden önce arşivle
        static::deleting(function ($user) {
            $user->archiveUserData();
        });
    }

    /**
     * Benzersiz kullanıcı ID oluştur
     */
    public static function generateUniqueUserId()
    {
        $startId = 55900;
        
        // Son kullanılan ID'yi bul
        $lastUser = self::orderBy('unique_user_id', 'desc')->first();
        if ($lastUser && $lastUser->unique_user_id) {
            $startId = max($startId, (int)$lastUser->unique_user_id + 1);
        }
        
        // Benzersiz ID bul
        do {
            $uniqueId = (string) $startId;
            $exists = self::where('unique_user_id', $uniqueId)->exists() || 
                     \App\Models\DeletedUserArchive::where('unique_user_id', $uniqueId)->exists();
            $startId++;
        } while ($exists);
        
        return $uniqueId;
    }

    /**
     * Kullanıcı verilerini arşivle
     */
    public function archiveUserData($reason = 'Kullanıcı silindi')
    {
        // Bu metod gelecekte kullanıcı verilerini arşivlemek için kullanılabilir
        // Şimdilik sadece admin notlarına ekliyoruz
        $this->update([
            'admin_notes' => ($this->admin_notes ? $this->admin_notes . "\n\n" : '') . 
                           '[' . now()->format('d.m.Y H:i') . '] Arşivlendi: ' . $reason
        ]);
    }

    /**
     * Kullanıcı ID ile görüntüleme adı
     */
    public function getDisplayNameWithIdAttribute()
    {
        return $this->name . ' (#' . $this->unique_user_id . ')';
    }

    /**
     * Kısa görüntüleme adı (sadece ID)
     */
    public function getShortDisplayNameAttribute()
    {
        return '#' . $this->unique_user_id;
    }

    /**
     * Admin kullanıcı mı kontrol et
     */
    public function isAdmin()
    {
        return $this->is_admin ?? false;
    }

    /**
     * Kullanıcı ID'sini admin kontrolü ile göster
     */
    public function getDisplayNameWithIdForUser($viewer = null)
    {
        $name = $this->name;
        
        if ($viewer && $viewer->isAdmin()) {
            $name .= ' (#' . $this->unique_user_id . ')';
        }
        
        return $name;
    }

    /**
     * Askıya alan admin ile ilişki
     */
    public function suspendedBy()
    {
        return $this->belongsTo(User::class, 'suspended_by');
    }

    /**
     * Bu admin tarafından askıya alınan kullanıcılar
     */
    public function suspendedUsers()
    {
        return $this->hasMany(User::class, 'suspended_by');
    }

    /**
     * Kullanıcı askıda mı kontrol et
     */
    public function isSuspended()
    {
        if (!$this->is_suspended) {
            return false;
        }

        // Süresiz askı
        if (!$this->suspended_until) {
            return true;
        }

        // Süreli askı - süre dolmuş mu kontrol et
        if ($this->suspended_until->isPast()) {
            // Askıyı otomatik kaldır
            $this->update([
                'is_suspended' => false,
                'suspended_until' => null,
                'suspension_reason' => null,
                'suspended_by' => null,
                'suspended_at' => null,
            ]);
            return false;
        }

        return true;
    }

    /**
     * Kullanıcıyı askıya al
     */
    public function suspend($reason, $adminId, $until = null)
    {
        $this->update([
            'is_suspended' => true,
            'suspended_until' => $until,
            'suspension_reason' => $reason,
            'suspended_by' => $adminId,
            'suspended_at' => now(),
        ]);
    }

    /**
     * Kullanıcının askısını kaldır
     */
    public function unsuspend()
    {
        $this->update([
            'is_suspended' => false,
            'suspended_until' => null,
            'suspension_reason' => null,
            'suspended_by' => null,
            'suspended_at' => null,
        ]);
    }

    /**
     * Askı durumu bilgisi
     */
    public function getSuspensionStatusAttribute()
    {
        if (!$this->is_suspended) {
            return 'Aktif';
        }

        if (!$this->suspended_until) {
            return 'Süresiz Askıda';
        }

        if ($this->suspended_until->isFuture()) {
            return 'Askıda (' . $this->suspended_until->diffForHumans() . ' kadar)';
        }

        return 'Askı Süresi Dolmuş';
    }

    /**
     * Son giriş bilgisini güncelle
     */
    public function updateLastLogin($ip = null)
    {
        $this->update([
            'last_login_at' => now(),
            'last_login_ip' => $ip ?: request()->ip(),
        ]);
    }

    /**
     * Kullanıcı yasaklı mı kontrol et (kayıt sırasında)
     */
    public static function isUserBanned($email, $phone = null)
    {
        // E-posta kontrolü
        if (\App\Models\BannedUser::isEmailBanned($email)) {
            return true;
        }

        // Telefon kontrolü
        if ($phone && \App\Models\BannedUser::isPhoneBanned($phone)) {
            return true;
        }

        return false;
    }

    /**
     * Şifre sıfırlama
     */
    public function resetPassword($newPassword)
    {
        $this->update([
            'password' => bcrypt($newPassword),
        ]);
    }
}
