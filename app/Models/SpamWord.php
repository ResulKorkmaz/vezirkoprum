<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpamWord extends Model
{
    use HasFactory;

    protected $fillable = [
        'word',
        'weight',
        'category',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'weight' => 'integer'
    ];

    /**
     * Get active spam words
     */
    public static function getActiveWords()
    {
        return self::where('is_active', true)->get();
    }

    /**
     * Get words by category
     */
    public static function getWordsByCategory($category)
    {
        return self::where('category', $category)
                   ->where('is_active', true)
                   ->get();
    }

    /**
     * Check if a word exists in spam database
     */
    public static function isSpamWord($word)
    {
        return self::where('word', 'LIKE', "%{$word}%")
                   ->where('is_active', true)
                   ->exists();
    }
}
