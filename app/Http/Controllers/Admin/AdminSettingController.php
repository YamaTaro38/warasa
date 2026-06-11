<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminSetting;
use Illuminate\Http\Request;

class AdminSettingController extends Controller
{
    /*
     * Display admin settings page
     */
    public function index()
    {
        $settings = AdminSetting::orderBy('group')->orderBy('key')->get();
        $groups = $settings->groupBy('group');

        $groupLabels = [
            'general' => 'General Settings',
            'features' => 'Feature Toggles',
        ];

        return view('admin.settings.index', compact('settings', 'groups', 'groupLabels'));
    }

    /*
     * Update settings
     */
    public function update(Request $request)
    {
        $request->validate([
            'settings' => 'required|array',
            'settings.*.key' => 'required|string|exists:admin_settings,key',
            'settings.*.value' => 'required',
        ]);

        foreach ($request->settings as $settingData) {
            $setting = AdminSetting::where('key', $settingData['key'])->first();
            if ($setting) {
                $value = $settingData['value'];
                if ($setting->type === 'boolean') {
                    $value = $value === 'true' ? 'true' : 'false';
                }
                $setting->update(['value' => $value]);
            }
        }

        return back()->with('success', 'Settings updated successfully!');
    }
}