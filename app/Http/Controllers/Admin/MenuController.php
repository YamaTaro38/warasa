<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MenuVisibility;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /*
     * Display menu visibility management page
     */
    public function index()
    {
        $menus = MenuVisibility::orderBy('sort_order')->get();
        $groups = $menus->groupBy('group');

        return view('admin.menus.index', compact('menus', 'groups'));
    }

    /*
     * Toggle menu visibility
     */
    public function toggle(Request $request, MenuVisibility $menu)
    {
        $menu->update([
            'is_visible' => !$menu->is_visible,
        ]);

        $status = $menu->is_visible ? 'visible' : 'hidden';
        return back()->with('success', "Menu \"{$menu->label}\" is now {$status}.");
    }

    /*
     * Update multiple menus at once
     */
    public function updateBulk(Request $request)
    {
        $request->validate([
            'menus' => 'required|array',
            'menus.*.id' => 'required|exists:menu_visibilities,id',
            'menus.*.is_visible' => 'required',
        ]);

        foreach ($request->menus as $menuData) {
            MenuVisibility::where('id', $menuData['id'])->update([
                'is_visible' => $menuData['is_visible'] == '1',
            ]);
        }

        return back()->with('success', 'Menu visibility updated successfully!');
    }

    /*
     * Update sort order
     */
    public function updateSortOrder(Request $request)
    {
        $request->validate([
            'order' => 'required|array',
            'order.*' => 'required|integer|exists:menu_visibilities,id',
        ]);

        foreach ($request->order as $index => $id) {
            MenuVisibility::where('id', $id)->update(['sort_order' => $index + 1]);
        }

        return back()->with('success', 'Menu order updated successfully!');
    }
}