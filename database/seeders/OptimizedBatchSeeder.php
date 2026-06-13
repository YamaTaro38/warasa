<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OptimizedBatchSeeder extends Seeder
{
    /**
     * Run the optimized batch seed using bulk INSERT operations.
     * This is MUCH faster than individual updateOrInsert calls,
     * especially over remote MySQL connections.
     */
    public function run(): void
    {
        // ==================== MENU VISIBILITIES (bulk insert) ====================
        $menus = [
            ['menu_key' => 'dashboard', 'label' => 'Dashboard', 'icon' => 'fas fa-chart-pie', 'group' => 'main', 'is_visible' => true, 'is_sub_feature' => false, 'parent_menu' => null, 'route_name' => 'dashboard', 'sort_order' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['menu_key' => 'products', 'label' => 'Products', 'icon' => 'fas fa-cubes', 'group' => 'main', 'is_visible' => true, 'is_sub_feature' => false, 'parent_menu' => null, 'route_name' => 'products.index', 'sort_order' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['menu_key' => 'projects', 'label' => 'Projects', 'icon' => 'fas fa-folder', 'group' => 'main', 'is_visible' => true, 'is_sub_feature' => false, 'parent_menu' => null, 'route_name' => 'projects.index', 'sort_order' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['menu_key' => 'generator_quick', 'label' => 'Quick Generate', 'icon' => 'fas fa-bolt', 'group' => 'generator', 'is_visible' => true, 'is_sub_feature' => false, 'parent_menu' => null, 'route_name' => 'generator.quick', 'sort_order' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['menu_key' => 'generator_smart', 'label' => 'Smart Generate', 'icon' => 'fas fa-brain', 'group' => 'generator', 'is_visible' => true, 'is_sub_feature' => false, 'parent_menu' => null, 'route_name' => 'generator.smart', 'sort_order' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['menu_key' => 'roas_calculator', 'label' => 'ROAS Calculator', 'icon' => 'fas fa-file-excel', 'group' => 'generator', 'is_visible' => true, 'is_sub_feature' => false, 'parent_menu' => null, 'route_name' => 'roas.calculator', 'sort_order' => 6, 'created_at' => now(), 'updated_at' => now()],
            ['menu_key' => 'shopee_fee_calculator', 'label' => 'Shopee Fee Calc.', 'icon' => 'fas fa-calculator', 'group' => 'generator', 'is_visible' => true, 'is_sub_feature' => false, 'parent_menu' => null, 'route_name' => 'shopee.fee.calculator', 'sort_order' => 7, 'created_at' => now(), 'updated_at' => now()],
            ['menu_key' => 'ai_image_generate', 'label' => 'AI Image Generate', 'icon' => 'fas fa-image', 'group' => 'generator', 'is_visible' => true, 'is_sub_feature' => true, 'parent_menu' => 'generator_quick', 'route_name' => null, 'sort_order' => 8, 'created_at' => now(), 'updated_at' => now()],
            ['menu_key' => 'competitor_analyze', 'label' => 'Competitor Analyze', 'icon' => 'fas fa-search', 'group' => 'generator', 'is_visible' => true, 'is_sub_feature' => true, 'parent_menu' => 'generator_smart', 'route_name' => null, 'sort_order' => 9, 'created_at' => now(), 'updated_at' => now()],
            ['menu_key' => 'seo_score', 'label' => 'SEO Score', 'icon' => 'fas fa-chart-line', 'group' => 'generator', 'is_visible' => true, 'is_sub_feature' => true, 'parent_menu' => 'generator_smart', 'route_name' => null, 'sort_order' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['menu_key' => 'watermark', 'label' => 'Watermark', 'icon' => 'fas fa-stamp', 'group' => 'generator', 'is_visible' => true, 'is_sub_feature' => true, 'parent_menu' => 'generator_quick', 'route_name' => null, 'sort_order' => 11, 'created_at' => now(), 'updated_at' => now()],
            ['menu_key' => 'chatbot', 'label' => 'Chatbot', 'icon' => 'fas fa-robot', 'group' => 'workspace', 'is_visible' => true, 'is_sub_feature' => false, 'parent_menu' => null, 'route_name' => 'chatbot', 'sort_order' => 12, 'created_at' => now(), 'updated_at' => now()],
            ['menu_key' => 'settings', 'label' => 'Settings', 'icon' => 'fas fa-user-cog', 'group' => 'workspace', 'is_visible' => true, 'is_sub_feature' => false, 'parent_menu' => null, 'route_name' => 'profile.edit', 'sort_order' => 13, 'created_at' => now(), 'updated_at' => now()],
        ];

        // Truncate and bulk insert for maximum speed
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('menu_visibilities')->truncate();
        DB::table('menu_visibilities')->insert($menus);
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // ==================== ADMIN SETTINGS (bulk insert) ====================
        $settings = [
            ['key' => 'app_name', 'value' => 'Warasa', 'type' => 'string', 'group' => 'general', 'description' => 'Application name', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'maintenance_mode', 'value' => 'false', 'type' => 'boolean', 'group' => 'general', 'description' => 'Enable maintenance mode', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'registration_enabled', 'value' => 'true', 'type' => 'boolean', 'group' => 'general', 'description' => 'Enable user registration', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'ai_image_enabled', 'value' => 'true', 'type' => 'boolean', 'group' => 'features', 'description' => 'Enable AI image generation feature', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'chatbot_enabled', 'value' => 'true', 'type' => 'boolean', 'group' => 'features', 'description' => 'Enable chatbot feature', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'export_enabled', 'value' => 'true', 'type' => 'boolean', 'group' => 'features', 'description' => 'Enable product export feature', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('admin_settings')->truncate();
        DB::table('admin_settings')->insert($settings);

        // ==================== SHOPEE FEE CONFIGS (bulk insert) ====================
        $feeConfigs = [
            // Star admin fees
            ['key' => 'star_default', 'value' => '2.50', 'type' => 'float', 'group' => 'admin_fee_star', 'description' => 'Star/Star+ default admin fee rate (%)'],
            ['key' => 'star_elektronik', 'value' => '1.50', 'type' => 'float', 'group' => 'admin_fee_star', 'description' => 'Star admin fee - Elektronik (%)'],
            ['key' => 'star_handphone', 'value' => '1.50', 'type' => 'float', 'group' => 'admin_fee_star', 'description' => 'Star admin fee - Handphone (%)'],
            ['key' => 'star_komputer', 'value' => '1.50', 'type' => 'float', 'group' => 'admin_fee_star', 'description' => 'Star admin fee - Komputer (%)'],
            ['key' => 'star_kamera', 'value' => '1.50', 'type' => 'float', 'group' => 'admin_fee_star', 'description' => 'Star admin fee - Kamera (%)'],
            ['key' => 'star_fashion', 'value' => '3.00', 'type' => 'float', 'group' => 'admin_fee_star', 'description' => 'Star admin fee - Fashion (%)'],
            ['key' => 'star_kecantikan', 'value' => '2.50', 'type' => 'float', 'group' => 'admin_fee_star', 'description' => 'Star admin fee - Kecantikan (%)'],
            ['key' => 'star_ibu_anak', 'value' => '2.50', 'type' => 'float', 'group' => 'admin_fee_star', 'description' => 'Star admin fee - Ibu & Anak (%)'],
            ['key' => 'star_makanan', 'value' => '3.00', 'type' => 'float', 'group' => 'admin_fee_star', 'description' => 'Star admin fee - Makanan (%)'],
            ['key' => 'star_rumah_tangga', 'value' => '2.50', 'type' => 'float', 'group' => 'admin_fee_star', 'description' => 'Star admin fee - Rumah Tangga (%)'],
            ['key' => 'star_otomotif', 'value' => '8.25', 'type' => 'float', 'group' => 'admin_fee_star', 'description' => 'Star admin fee - Otomotif (%)'],
            ['key' => 'star_olahraga', 'value' => '2.50', 'type' => 'float', 'group' => 'admin_fee_star', 'description' => 'Star admin fee - Olahraga (%)'],
            ['key' => 'star_buku', 'value' => '2.50', 'type' => 'float', 'group' => 'admin_fee_star', 'description' => 'Star admin fee - Buku (%)'],

            // Non-Star admin fees
            ['key' => 'non_star_default', 'value' => '4.50', 'type' => 'float', 'group' => 'admin_fee_non_star', 'description' => 'Non-Star default admin fee rate (%)'],
            ['key' => 'non_star_elektronik', 'value' => '3.50', 'type' => 'float', 'group' => 'admin_fee_non_star', 'description' => 'Non-Star admin fee - Elektronik (%)'],
            ['key' => 'non_star_handphone', 'value' => '3.50', 'type' => 'float', 'group' => 'admin_fee_non_star', 'description' => 'Non-Star admin fee - Handphone (%)'],
            ['key' => 'non_star_komputer', 'value' => '3.50', 'type' => 'float', 'group' => 'admin_fee_non_star', 'description' => 'Non-Star admin fee - Komputer (%)'],
            ['key' => 'non_star_kamera', 'value' => '3.50', 'type' => 'float', 'group' => 'admin_fee_non_star', 'description' => 'Non-Star admin fee - Kamera (%)'],
            ['key' => 'non_star_fashion', 'value' => '5.50', 'type' => 'float', 'group' => 'admin_fee_non_star', 'description' => 'Non-Star admin fee - Fashion (%)'],
            ['key' => 'non_star_kecantikan', 'value' => '4.50', 'type' => 'float', 'group' => 'admin_fee_non_star', 'description' => 'Non-Star admin fee - Kecantikan (%)'],
            ['key' => 'non_star_ibu_anak', 'value' => '4.50', 'type' => 'float', 'group' => 'admin_fee_non_star', 'description' => 'Non-Star admin fee - Ibu & Anak (%)'],
            ['key' => 'non_star_makanan', 'value' => '5.50', 'type' => 'float', 'group' => 'admin_fee_non_star', 'description' => 'Non-Star admin fee - Makanan (%)'],
            ['key' => 'non_star_rumah_tangga', 'value' => '4.50', 'type' => 'float', 'group' => 'admin_fee_non_star', 'description' => 'Non-Star admin fee - Rumah Tangga (%)'],
            ['key' => 'non_star_otomotif', 'value' => '3.50', 'type' => 'float', 'group' => 'admin_fee_non_star', 'description' => 'Non-Star admin fee - Otomotif (%)'],
            ['key' => 'non_star_olahraga', 'value' => '4.50', 'type' => 'float', 'group' => 'admin_fee_non_star', 'description' => 'Non-Star admin fee - Olahraga (%)'],
            ['key' => 'non_star_buku', 'value' => '4.50', 'type' => 'float', 'group' => 'admin_fee_non_star', 'description' => 'Non-Star admin fee - Buku (%)'],

            // Other fees
            ['key' => 'fixed_fee', 'value' => '1000', 'type' => 'integer', 'group' => 'other_fees', 'description' => 'Fixed fee per transaction (Rp)'],
            ['key' => 'service_fee_rate', 'value' => '1.00', 'type' => 'float', 'group' => 'other_fees', 'description' => 'Service fee rate (%)'],
            ['key' => 'promo_xtra_rate', 'value' => '4.50', 'type' => 'float', 'group' => 'promo', 'description' => 'Promo XTRA rate (%)'],
            ['key' => 'promo_xtra_max', 'value' => '60000', 'type' => 'integer', 'group' => 'promo', 'description' => 'Promo XTRA max fee (Rp)'],
            ['key' => 'live_xtra_rate', 'value' => '3.00', 'type' => 'float', 'group' => 'promo', 'description' => 'Live XTRA rate (%)'],
            ['key' => 'live_xtra_max', 'value' => '20000', 'type' => 'integer', 'group' => 'promo', 'description' => 'Live XTRA max fee (Rp)'],
            ['key' => 'preorder_fee_rate', 'value' => '3.00', 'type' => 'float', 'group' => 'other_fees', 'description' => 'Pre-Order fee rate (%)'],
            ['key' => 'free_shipping_default', 'value' => '2.50', 'type' => 'float', 'group' => 'free_shipping', 'description' => 'Free Shipping XTRA default rate (%)'],
            ['key' => 'free_shipping_max', 'value' => '30000', 'type' => 'integer', 'group' => 'free_shipping', 'description' => 'Free Shipping XTRA max subsidy (Rp)'],
            ['key' => 'fs_elektronik', 'value' => '1.80', 'type' => 'float', 'group' => 'free_shipping', 'description' => 'Free Shipping - Elektronik (%)'],
            ['key' => 'fs_handphone', 'value' => '1.80', 'type' => 'float', 'group' => 'free_shipping', 'description' => 'Free Shipping - Handphone (%)'],
            ['key' => 'fs_komputer', 'value' => '1.80', 'type' => 'float', 'group' => 'free_shipping', 'description' => 'Free Shipping - Komputer (%)'],
            ['key' => 'fs_kamera', 'value' => '1.80', 'type' => 'float', 'group' => 'free_shipping', 'description' => 'Free Shipping - Kamera (%)'],
            ['key' => 'fs_fashion', 'value' => '3.00', 'type' => 'float', 'group' => 'free_shipping', 'description' => 'Free Shipping - Fashion (%)'],
            ['key' => 'fs_makanan', 'value' => '3.50', 'type' => 'float', 'group' => 'free_shipping', 'description' => 'Free Shipping - Makanan (%)'],
            ['key' => 'fs_rumah_tangga', 'value' => '2.50', 'type' => 'float', 'group' => 'free_shipping', 'description' => 'Free Shipping - Rumah Tangga (%)'],
        ];

        // Add timestamps
        $now = now();
        foreach ($feeConfigs as &$config) {
            $config['created_at'] = $now;
            $config['updated_at'] = $now;
        }
        unset($config);

        DB::table('shopee_fee_configs')->truncate();
        DB::table('shopee_fee_configs')->insert($feeConfigs);

        $this->command->info('✅ OptimizedBatchSeeder completed successfully!');
    }
}