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
            // Step 0: Drop all tables manually first (handle FK constraints)
            $output .= "<strong>Step 0: Dropping all existing tables...</strong><br>";
            DB::statement('SET FOREIGN_KEY_CHECKS = 0');
            $tables = DB::select("SELECT TABLE_NAME FROM information_schema.tables WHERE table_schema IN ('defaultdb', (SELECT DATABASE()))");
            foreach ($tables as $table) {
                $tableName = $table->TABLE_NAME;
                DB::statement("DROP TABLE IF EXISTS `{$tableName}`");
                $output .= "Dropped: {$tableName}<br>";
            }
            DB::statement('SET FOREIGN_KEY_CHECKS = 1');
            $output .= "<br>";

            // Step 1: Run migrations
            $output .= "<strong>Step 1: Running migrations...</strong><br>";
            Artisan::call('migrate', [
                "--force" => true,
                "--no-interaction" => true,
                "--quiet" => true
            ]);
            $output .= nl2br(Artisan::output());
            $output .= "<br>";

            // Step 2: Run optimized batch seeder
            $output .= "<strong>Step 2: Running optimized seeder...</strong><br>";
            Artisan::call('db:seed', [
                "--class" => "Database\\Seeders\\OptimizedBatchSeeder",
                "--force" => true,
                "--no-interaction" => true,
                "--quiet" => true
            ]);
            $output .= nl2br(Artisan::output());
            $output .= "<br>";

            // Step 3: Run remaining seeders
            $output .= "<strong>Step 3: Running additional seeders...</strong><br>";
            Artisan::call('db:seed', [
                "--class" => "Database\\Seeders\\AdminUserSeeder",
                "--force" => true,
                "--no-interaction" => true,
                "--quiet" => true
            ]);
            $output .= nl2br(Artisan::output());
            $output .= "<br>";

            $output .= "<strong>Step 4: Running Shopee category codes seeder...</strong><br>";
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