<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShopeeFeeConfig;
use Illuminate\Http\Request;

class ShopeeFeeConfigController extends Controller
{
    /*
     * Display shopee fee configuration page
     */
    public function index()
    {
        $configs = ShopeeFeeConfig::orderBy('group')->orderBy('key')->get();
        $groups = $configs->groupBy('group');

        $groupLabels = [
            'admin_fee_star' => 'Admin Fee - Star/Star+',
            'admin_fee_non_star' => 'Admin Fee - Non-Star',
            'other_fees' => 'Other Fees',
            'promo' => 'Promo & Live',
            'free_shipping' => 'Free Shipping XTRA',
        ];

        return view('admin.shopee-fees.index', compact('configs', 'groups', 'groupLabels'));
    }

    /*
     * Update all configs
     */
    public function update(Request $request)
    {
        $request->validate([
            'configs' => 'required|array',
            'configs.*.key' => 'required|string|exists:shopee_fee_configs,key',
            'configs.*.value' => 'required',
        ]);

        foreach ($request->configs as $configData) {
            $config = ShopeeFeeConfig::where('key', $configData['key'])->first();
            if ($config) {
                $value = $configData['value'];
                // Validate based on type
                if ($config->type === 'float' && !is_numeric($value)) {
                    continue;
                }
                if ($config->type === 'integer' && !ctype_digit((string) $value)) {
                    continue;
                }
                $config->update(['value' => $value]);
            }
        }

        return back()->with('success', 'Shopee fee configuration updated successfully!');
    }

    /*
     * Reset all configs to defaults
     */
    public function reset()
    {
        // Delete all existing configs
        ShopeeFeeConfig::truncate();

        // Re-seed with defaults
        $seeder = new \Database\Seeders\AdminDashboardSeeder();
        // Only run the shopee fee part
        $feeConfigs = $this->getDefaultFeeConfigs();
        foreach ($feeConfigs as $config) {
            \Illuminate\Support\Facades\DB::table('shopee_fee_configs')->insert($config);
        }

        return back()->with('success', 'Shopee fee configuration has been reset to defaults!');
    }

    private function getDefaultFeeConfigs(): array
    {
        return [
            ['key' => 'star_default', 'value' => '2.50', 'type' => 'float', 'group' => 'admin_fee_star', 'description' => 'Star/Star+ default admin fee rate (%)', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'star_elektronik', 'value' => '1.50', 'type' => 'float', 'group' => 'admin_fee_star', 'description' => 'Star admin fee - Elektronik (%)', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'star_handphone', 'value' => '1.50', 'type' => 'float', 'group' => 'admin_fee_star', 'description' => 'Star admin fee - Handphone (%)', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'star_komputer', 'value' => '1.50', 'type' => 'float', 'group' => 'admin_fee_star', 'description' => 'Star admin fee - Komputer (%)', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'star_kamera', 'value' => '1.50', 'type' => 'float', 'group' => 'admin_fee_star', 'description' => 'Star admin fee - Kamera (%)', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'star_fashion', 'value' => '3.00', 'type' => 'float', 'group' => 'admin_fee_star', 'description' => 'Star admin fee - Fashion (%)', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'star_kecantikan', 'value' => '2.50', 'type' => 'float', 'group' => 'admin_fee_star', 'description' => 'Star admin fee - Kecantikan (%)', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'star_ibu_anak', 'value' => '2.50', 'type' => 'float', 'group' => 'admin_fee_star', 'description' => 'Star admin fee - Ibu & Anak (%)', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'star_makanan', 'value' => '3.00', 'type' => 'float', 'group' => 'admin_fee_star', 'description' => 'Star admin fee - Makanan (%)', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'star_rumah_tangga', 'value' => '2.50', 'type' => 'float', 'group' => 'admin_fee_star', 'description' => 'Star admin fee - Rumah Tangga (%)', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'star_otomotif', 'value' => '8.25', 'type' => 'float', 'group' => 'admin_fee_star', 'description' => 'Star admin fee - Otomotif (%)', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'star_olahraga', 'value' => '2.50', 'type' => 'float', 'group' => 'admin_fee_star', 'description' => 'Star admin fee - Olahraga (%)', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'star_buku', 'value' => '2.50', 'type' => 'float', 'group' => 'admin_fee_star', 'description' => 'Star admin fee - Buku (%)', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'non_star_default', 'value' => '4.50', 'type' => 'float', 'group' => 'admin_fee_non_star', 'description' => 'Non-Star default admin fee rate (%)', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'non_star_elektronik', 'value' => '3.50', 'type' => 'float', 'group' => 'admin_fee_non_star', 'description' => 'Non-Star admin fee - Elektronik (%)', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'non_star_handphone', 'value' => '3.50', 'type' => 'float', 'group' => 'admin_fee_non_star', 'description' => 'Non-Star admin fee - Handphone (%)', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'non_star_komputer', 'value' => '3.50', 'type' => 'float', 'group' => 'admin_fee_non_star', 'description' => 'Non-Star admin fee - Komputer (%)', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'non_star_kamera', 'value' => '3.50', 'type' => 'float', 'group' => 'admin_fee_non_star', 'description' => 'Non-Star admin fee - Kamera (%)', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'non_star_fashion', 'value' => '5.50', 'type' => 'float', 'group' => 'admin_fee_non_star', 'description' => 'Non-Star admin fee - Fashion (%)', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'non_star_kecantikan', 'value' => '4.50', 'type' => 'float', 'group' => 'admin_fee_non_star', 'description' => 'Non-Star admin fee - Kecantikan (%)', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'non_star_ibu_anak', 'value' => '4.50', 'type' => 'float', 'group' => 'admin_fee_non_star', 'description' => 'Non-Star admin fee - Ibu & Anak (%)', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'non_star_makanan', 'value' => '5.50', 'type' => 'float', 'group' => 'admin_fee_non_star', 'description' => 'Non-Star admin fee - Makanan (%)', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'non_star_rumah_tangga', 'value' => '4.50', 'type' => 'float', 'group' => 'admin_fee_non_star', 'description' => 'Non-Star admin fee - Rumah Tangga (%)', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'non_star_otomotif', 'value' => '3.50', 'type' => 'float', 'group' => 'admin_fee_non_star', 'description' => 'Non-Star admin fee - Otomotif (%)', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'non_star_olahraga', 'value' => '4.50', 'type' => 'float', 'group' => 'admin_fee_non_star', 'description' => 'Non-Star admin fee - Olahraga (%)', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'non_star_buku', 'value' => '4.50', 'type' => 'float', 'group' => 'admin_fee_non_star', 'description' => 'Non-Star admin fee - Buku (%)', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'fixed_fee', 'value' => '1000', 'type' => 'integer', 'group' => 'other_fees', 'description' => 'Fixed fee per transaction (Rp)', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'service_fee_rate', 'value' => '1.00', 'type' => 'float', 'group' => 'other_fees', 'description' => 'Service fee rate (%)', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'promo_xtra_rate', 'value' => '4.50', 'type' => 'float', 'group' => 'promo', 'description' => 'Promo XTRA rate (%)', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'promo_xtra_max', 'value' => '60000', 'type' => 'integer', 'group' => 'promo', 'description' => 'Promo XTRA max fee (Rp)', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'live_xtra_rate', 'value' => '3.00', 'type' => 'float', 'group' => 'promo', 'description' => 'Live XTRA rate (%)', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'live_xtra_max', 'value' => '20000', 'type' => 'integer', 'group' => 'promo', 'description' => 'Live XTRA max fee (Rp)', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'preorder_fee_rate', 'value' => '3.00', 'type' => 'float', 'group' => 'other_fees', 'description' => 'Pre-Order fee rate (%)', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'free_shipping_default', 'value' => '2.50', 'type' => 'float', 'group' => 'free_shipping', 'description' => 'Free Shipping XTRA default rate (%)', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'free_shipping_max', 'value' => '30000', 'type' => 'integer', 'group' => 'free_shipping', 'description' => 'Free Shipping XTRA max subsidy (Rp)', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'fs_elektronik', 'value' => '1.80', 'type' => 'float', 'group' => 'free_shipping', 'description' => 'Free Shipping - Elektronik (%)', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'fs_handphone', 'value' => '1.80', 'type' => 'float', 'group' => 'free_shipping', 'description' => 'Free Shipping - Handphone (%)', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'fs_komputer', 'value' => '1.80', 'type' => 'float', 'group' => 'free_shipping', 'description' => 'Free Shipping - Komputer (%)', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'fs_kamera', 'value' => '1.80', 'type' => 'float', 'group' => 'free_shipping', 'description' => 'Free Shipping - Kamera (%)', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'fs_fashion', 'value' => '3.00', 'type' => 'float', 'group' => 'free_shipping', 'description' => 'Free Shipping - Fashion (%)', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'fs_makanan', 'value' => '3.50', 'type' => 'float', 'group' => 'free_shipping', 'description' => 'Free Shipping - Makanan (%)', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'fs_rumah_tangga', 'value' => '2.50', 'type' => 'float', 'group' => 'free_shipping', 'description' => 'Free Shipping - Rumah Tangga (%)', 'created_at' => now(), 'updated_at' => now()],
        ];
    }
}