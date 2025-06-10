<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class DeletedUserArchive extends Model
{
    protected $table = 'deleted_users_archive';

    protected $fillable = [
        'unique_user_id',
        'name',
        'email',
        'phone',
        'current_city',
        'current_district',
        'profession_id',
        'bio',
        'profile_photo',
        'show_phone',
        'email_verified_at',
        'original_created_at',
        'deleted_at',
        'deletion_reason',
        'deleted_by_ip',
        'compressed_data',
    ];

    protected function casts(): array
    {
        return [
            'show_phone' => 'boolean',
            'email_verified_at' => 'datetime',
            'original_created_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    /**
     * Şifreli telefon numarasını çöz
     */
    public function getDecryptedPhoneAttribute()
    {
        if ($this->phone) {
            try {
                return Crypt::decryptString($this->phone);
            } catch (\Exception $e) {
                return null;
            }
        }
        return null;
    }

    /**
     * Sıkıştırılmış veriyi çöz
     */
    public function getDecompressedDataAttribute()
    {
        if ($this->compressed_data) {
            try {
                $decompressed = gzuncompress(base64_decode($this->compressed_data));
                return json_decode($decompressed, true);
            } catch (\Exception $e) {
                return null;
            }
        }
        return null;
    }

    /**
     * Meslek ilişkisi (arşivlenmiş kullanıcı için)
     */
    public function profession()
    {
        return $this->belongsTo(Profession::class);
    }

    /**
     * Kolluk güçleri için arama
     */
    public static function searchForLawEnforcement($query)
    {
        return self::where(function($q) use ($query) {
            $q->where('unique_user_id', 'like', "%{$query}%")
              ->orWhere('name', 'like', "%{$query}%")
              ->orWhere('email', 'like', "%{$query}%");
        })->orderBy('deleted_at', 'desc');
    }

    /**
     * Güvenlik raporu oluştur
     */
    public function generateSecurityReport()
    {
        $decompressedData = $this->decompressed_data;
        
        return [
            'user_info' => [
                'unique_id' => $this->unique_user_id,
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->decrypted_phone,
                'city' => $this->current_city,
                'district' => $this->current_district,
            ],
            'account_info' => [
                'registration_date' => $this->original_created_at,
                'deletion_date' => $this->deleted_at,
                'deletion_reason' => $this->deletion_reason,
                'deletion_ip' => $this->deleted_by_ip,
            ],
            'activity_info' => $decompressedData['original_data'] ?? [],
            'messages_info' => [
                'sent_count' => $decompressedData['messages_sent'] ?? 0,
                'received_count' => $decompressedData['messages_received'] ?? 0,
            ],
            'technical_info' => [
                'last_login' => $decompressedData['last_login'] ?? null,
                'registration_ip' => $decompressedData['registration_ip'] ?? null,
                'user_agent' => $decompressedData['user_agent'] ?? null,
            ]
        ];
    }
}
