<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'key',
        'label',
        'value',
        'group'
    ];

    /**
     * Helper to quickly get a setting value by key.
     * Usage: Setting::getValue('registration_fee', 5000)
     */
    public static function getValue($key, $default = null)
    {
        $setting = self::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }
}
