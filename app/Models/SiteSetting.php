<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'label',
        'description',
        'options',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'options' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Get all settings as key-value pairs
     */
    public static function getAllSettings()
    {
        return Cache::remember('site_settings', 3600, function () {
            return self::where('is_active', true)
                       ->pluck('value', 'key')
                       ->toArray();
        });
    }

    /**
     * Get a specific setting value
     */
    public static function get($key, $default = null)
    {
        $settings = self::getAllSettings();
        return $settings[$key] ?? $default;
    }

    /**
     * Set a setting value
     */
    public static function set($key, $value)
    {
        $setting = self::where('key', $key)->first();
        
        if ($setting) {
            $setting->update(['value' => $value]);
        } else {
            self::create([
                'key' => $key,
                'value' => $value,
                'label' => $key,
                'group' => 'general'
            ]);
        }

        // Clear cache
        Cache::forget('site_settings');
    }

    /**
     * Get settings grouped by category
     */
    public static function getGroupedSettings()
    {
        return self::where('is_active', true)
                   ->orderBy('group')
                   ->orderBy('sort_order')
                   ->get()
                   ->groupBy('group');
    }

    /**
     * Boot method to clear cache when model is saved
     */
    protected static function boot()
    {
        parent::boot();

        static::saved(function ($model) {
            Cache::forget('site_settings');
        });

        static::deleted(function ($model) {
            Cache::forget('site_settings');
        });
    }
}
