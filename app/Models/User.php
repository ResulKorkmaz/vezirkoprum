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
        }
    }

    public function getPhoneAttribute($value)
    {
        if ($value && $this->show_phone) {
            try {
                return Crypt::decryptString($value);
            } catch (\Exception $e) {
                return null;
            }
        }
        return null;
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
}
