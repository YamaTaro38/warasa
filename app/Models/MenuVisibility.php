<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuVisibility extends Model
{
    protected $fillable = [
        'menu_key',
        'label',
        'icon',
        'group',
        'is_visible',
        'is_sub_feature',
        'parent_menu',
        'route_name',
        'sort_order',
    ];

    protected $casts = [
        'is_visible' => 'boolean',
        'is_sub_feature' => 'boolean',
    ];

    /*
     * Get all visible menus
     */
    public static function getVisibleMenus(): \Illuminate\Support\Collection
    {
        return static::where('is_visible', true)
            ->orderBy('sort_order')
            ->get();
    }

    /*
     * Get menus by group
     */
    public static function getByGroup(string $group): \Illuminate\Support\Collection
    {
        return static::where('group', $group)
            ->orderBy('sort_order')
            ->get();
    }

    /*
     * Get main menus (not sub-features)
     */
    public static function getMainMenus(): \Illuminate\Support\Collection
    {
        return static::where('is_sub_feature', false)
            ->where('is_visible', true)
            ->orderBy('sort_order')
            ->get();
    }

    /*
     * Get sub-features for a parent menu
     */
    public static function getSubFeatures(string $parentMenu): \Illuminate\Support\Collection
    {
        return static::where('parent_menu', $parentMenu)
            ->where('is_sub_feature', true)
            ->where('is_visible', true)
            ->orderBy('sort_order')
            ->get();
    }

    /*
     * Check if a menu is visible
     */
    public static function isVisible(string $menuKey): bool
    {
        $menu = static::where('menu_key', $menuKey)->first();
        return $menu ? $menu->is_visible : false;
    }
}