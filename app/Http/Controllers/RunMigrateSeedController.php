<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class RunMigrateSeedController extends Controller
{
    public function __invoke()
    {
        if (config('app.env') !== 'production') {
            return "Bukan di lingkungan produksi.";
        }

        $output = '';
        $success = true;

        try {
            // Step 0: Drop all tables fast
            $output .= "<strong>Step 0: Dropping all tables...</strong><br>";
            DB::statement('SET FOREIGN_KEY_CHECKS = 0');
            DB::statement("SELECT GROUP_CONCAT(TABLE_NAME) INTO @tables FROM information_schema.tables WHERE table_schema = 'defaultdb' AND TABLE_TYPE = 'BASE TABLE'");
            DB::statement("SET @query = IF(@tables IS NOT NULL, CONCAT('DROP TABLE IF EXISTS ', @tables), 'SELECT 1')");
            DB::statement("PREPARE stmt FROM @query");
            DB::statement("EXECUTE stmt");
            DB::statement("DEALLOCATE PREPARE stmt");
            DB::statement('SET FOREIGN_KEY_CHECKS = 1');
            $output .= "All tables dropped in one query<br><br>";

            // Step 1: Run migrations + seed together (faster - 1 pass)
            $output .= "<strong>Step 1: Running migrations + seeders...</strong><br>";
            Artisan::call('migrate:fresh', [
                "--force" => true,
                "--seed" => true,
                "--seeder" => "Database\\Seeders\\DatabaseSeeder",
                "--no-interaction" => true,
                "--quiet" => true
            ]);
            $output .= nl2br(Artisan::output());
            $output .= "<br>";

            // Step 2: Run Shopee category codes seeder (must run after category seeder in DatabaseSeeder)
            $output .= "<strong>Step 2: Running Shopee category codes seeder...</strong><br>";
            Artisan::call('db:seed', [
                "--class" => "Database\\Seeders\\ShopeeCategoryCodesSeeder",
                "--force" => true,
                "--no-interaction" => true,
                "--quiet" => true
            ]);
            $output .= nl2br(Artisan::output());
            $output .= "<br>";

            $output .= "<span style='color:green;font-weight:bold;'>✅ Semua langkah berhasil!</span>";
        } catch (\Exception $e) {
            $success = false;
            $output .= "<span style='color:red;font-weight:bold;'>❌ Gagal: " . $e->getMessage() . "</span>";
        }

        $status = $success ? "✅ SUKSES" : "❌ GAGAL";
        return "<html><body style='font-family:monospace;padding:20px;'><h2>{$status}</h2>{$output}</body></html>";
    }
}