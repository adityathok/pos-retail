<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingService
{
    /**
     * Get setting value by key
     */
    public function get(string $key, $default = null)
    {
        return Setting::get($key, $default);
    }

    /**
     * Set setting value by key
     */
    public function set(string $key, $value, string $type = 'string', string $description = null)
    {
        return Setting::set($key, $value, $type, $description);
    }

    /**
     * Get multiple settings
     */
    public function getMultiple(array $keys)
    {
        return Setting::getMultiple($keys);
    }

    /**
     * Get all company settings
     */
    public function getCompanySettings()
    {
        return $this->getMultiple([
            'company_name',
            'company_address',
            'company_leader',
            'company_phone',
            'company_email'
        ]);
    }

    /**
     * Update company settings
     */
    public function updateCompanySettings(array $settings)
    {
        $allowedKeys = [
            'company_name',
            'company_address',
            'company_leader',
            'company_phone',
            'company_email'
        ];

        $updated = [];
        foreach ($settings as $key => $value) {
            if (in_array($key, $allowedKeys) && $value !== null) {
                $this->set($key, $value);
                $updated[$key] = $value;
            }
        }

        return $updated;
    }

    /**
     * Get setting with type casting
     */
    public function getTyped(string $key, string $type = 'string', $default = null)
    {
        $value = $this->get($key, $default);
        
        return $this->castValue($value, $type);
    }

    /**
     * Set boolean setting
     */
    public function setBoolean(string $key, bool $value, string $description = null)
    {
        return $this->set($key, $value, 'boolean', $description);
    }

    /**
     * Get boolean setting
     */
    public function getBoolean(string $key, bool $default = false)
    {
        return $this->getTyped($key, 'boolean', $default);
    }

    /**
     * Set integer setting
     */
    public function setInteger(string $key, int $value, string $description = null)
    {
        return $this->set($key, $value, 'integer', $description);
    }

    /**
     * Get integer setting
     */
    public function getInteger(string $key, int $default = 0)
    {
        return $this->getTyped($key, 'integer', $default);
    }

    /**
     * Set JSON setting
     */
    public function setJson(string $key, array $value, string $description = null)
    {
        return $this->set($key, $value, 'json', $description);
    }

    /**
     * Get JSON setting
     */
    public function getJson(string $key, array $default = [])
    {
        return $this->getTyped($key, 'json', $default);
    }

    /**
     * Check if setting exists
     */
    public function exists(string $key)
    {
        return Setting::where('key', $key)->exists();
    }

    /**
     * Delete setting
     */
    public function delete(string $key)
    {
        Cache::forget("setting_{$key}");
        return Setting::where('key', $key)->delete();
    }

    /**
     * Get all settings as key-value pairs
     */
    public function all()
    {
        return Setting::all()->pluck('value', 'key')->toArray();
    }

    /**
     * Clear settings cache
     */
    public function clearCache(string $key = null)
    {
        if ($key) {
            Cache::forget("setting_{$key}");
        } else {
            // Clear all setting cache keys
            $keys = Setting::pluck('key');
            foreach ($keys as $settingKey) {
                Cache::forget("setting_{$settingKey}");
            }
        }
    }

    /**
     * Cast value based on type
     */
    protected function castValue($value, string $type)
    {
        switch ($type) {
            case 'boolean':
                return (bool) $value;
            case 'integer':
                return (int) $value;
            case 'json':
                return is_array($value) ? $value : json_decode($value, true);
            default:
                return $value;
        }
    }

    /**
     * Get company name for display
     */
    public function getCompanyName()
    {
        return $this->get('company_name', 'PT. Retail Indonesia');
    }

    /**
     * Get company address for display
     */
    public function getCompanyAddress()
    {
        return $this->get('company_address', '');
    }

    /**
     * Get company leader for display
     */
    public function getCompanyLeader()
    {
        return $this->get('company_leader', '');
    }
}