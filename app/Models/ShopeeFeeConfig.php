<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopeeFeeConfig extends Model
{
    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'description',
    ];

    /*
     * Get a config value by key
     */
    public static function getValue(string $key, mixed $default = null): mixed
    {
        $config = static::where('key', $key)->first();

        if (!$config) {
            return $default;
        }

        return $config->castValue();
    }

    /*
     * Set a config value by key
     */
    public static function setValue(string $key, mixed $value): static
    {
        return static::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }

    /*
     * Get all configs by group
     */
    public static function getByGroup(string $group): \Illuminate\Support\Collection
    {
        return static::where('group', $group)->get();
    }

    /*
     * Get all groups
     */
    public static function getGroups(): array
    {
        return static::select('group')->distinct()->pluck('group')->toArray();
    }

    /*
     * Cast value based on type
     */
    public function castValue(): mixed
    {
        return match ($this->type) {
            'boolean' => filter_var($this->value, FILTER_VALIDATE_BOOLEAN),
            'integer' => (int) $this->value,
            'float' => (float) $this->value,
            'json' => json_decode($this->value, true),
            default => $this->value,
        };
    }

    /*
     * Get all fee rates as nested array (for calculator)
     */
    public static function getFeeRates(): array
    {
        $starConfigs = static::where('group', 'admin_fee_star')->get()->pluck('value', 'key')->toArray();
        $nonStarConfigs = static::where('group', 'admin_fee_non_star')->get()->pluck('value', 'key')->toArray();

        $starRates = [];
        foreach ($starConfigs as $key => $value) {
            $category = str_replace('star_', '', $key);
            $starRates[$category] = (float) $value;
        }

        $nonStarRates = [];
        foreach ($nonStarConfigs as $key => $value) {
            $category = str_replace('non_star_', '', $key);
            $nonStarRates[$category] = (float) $value;
        }

        return [
            'star' => $starRates,
            'non_star' => $nonStarRates,
        ];
    }

    /*
     * Get free shipping rates as array
     */
    public static function getFreeShippingRates(): array
    {
        $configs = static::where('group', 'free_shipping')
            ->where('key', '!=', 'free_shipping_default')
            ->where('key', '!=', 'free_shipping_max')
            ->get()
            ->pluck('value', 'key')
            ->toArray();

        $rates = [];
        foreach ($configs as $key => $value) {
            $category = str_replace('fs_', '', $key);
            $rates[$category] = (float) $value;
        }

        return $rates;
    }
}