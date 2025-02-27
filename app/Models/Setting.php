<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
    ];

    /**
     * Get setting value by key
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function getValue(string $key, $default = null)
    {
        $setting = self::where('key', $key)->first();

        if (!$setting) {
            return $default;
        }

        if ($setting->type === 'boolean') {
            return (bool) $setting->value;
        }

        if ($setting->type === 'json') {
            return json_decode($setting->value, true);
        }

        return $setting->value;
    }

    /**
     * Set setting value by key
     *
     * @param string $key
     * @param mixed $value
     * @param string|null $type
     * @param string|null $group
     * @return void
     */
    public static function setValue(string $key, $value, ?string $type = null, ?string $group = null)
    {
        $setting = self::firstOrNew(['key' => $key]);

        if ($type) {
            $setting->type = $type;
        }

        if ($group) {
            $setting->group = $group;
        }

        if ($setting->type === 'json' && !is_string($value)) {
            $value = json_encode($value);
        }

        $setting->value = $value;
        $setting->save();
    }

    /**
     * Get all settings as key-value pairs
     *
     * @param string|null $group
     * @return array
     */
    public static function getAllSettings(?string $group = null): array
    {
        $query = self::query();

        if ($group) {
            $query->where('group', $group);
        }

        $settings = $query->get();
        $result = [];

        foreach ($settings as $setting) {
            $value = $setting->value;

            if ($setting->type === 'boolean') {
                $value = (bool) $value;
            } elseif ($setting->type === 'json') {
                $value = json_decode($value, true);
            }

            $result[$setting->key] = $value;
        }

        return $result;
    }
}
