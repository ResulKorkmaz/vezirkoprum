<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WhatsappGroup extends Model
{
    protected $fillable = [
        'name',
        'city',
        'district',
        'description',
        'invite_link',
        'is_active',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    /**
     * Grubu oluşturan kullanıcı
     */
    public function creator()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }
}
