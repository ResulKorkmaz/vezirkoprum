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
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }
}
