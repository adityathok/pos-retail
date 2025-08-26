<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'type',
        'description'
    ];

    protected $casts = [
        'value' => 'string'
    ];

    /**
     * Get setting value by key
     */
    public static function get(string $key, $default = null)
    {
        $cacheKey = "setting_{$key}";
        
        return Cache::remember($cacheKey, 3600, function () use ($key, $default) {
            $setting = static::where('key', $key)->first();
            
            if (!$setting) {
                return $default;
            }
            
            return static::castValue($setting->value, $setting->type);
        });
    }

    /**
     * Set setting value by key
     */
    public static function set(string $key, $value, string $type = 'string', string $description = null)
    {
        $setting = static::updateOrCreate(
            ['key' => $key],
            [
                'value' => static::prepareValue($value, $type),
                'type' => $type,
                'description' => $description
            ]
        );

        // Clear cache
        Cache::forget("setting_{$key}");
        
        return $setting;
    }

    /**
     * Cast value based on type
     */
    protected static function castValue($value, string $type)
    {
        switch ($type) {
            case 'boolean':
                return (bool) $value;
            case 'integer':
                return (int) $value;
            case 'json':
                return json_decode($value, true);
            default:
                return $value;
        }
    }

    /**
     * Prepare value for storage
     */
    protected static function prepareValue($value, string $type)
    {
        switch ($type) {
            case 'boolean':
                return $value ? '1' : '0';
            case 'json':
                return json_encode($value);
            default:
                return (string) $value;
        }
    }

    /**
     * Get multiple settings
     */
    public static function getMultiple(array $keys)
    {
        $result = [];
        foreach ($keys as $key) {
            $result[$key] = static::get($key);
        }
        return $result;
    }
}
