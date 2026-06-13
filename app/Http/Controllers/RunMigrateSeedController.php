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
            // Step 1: Run migrations with timeout
            $output .= "<strong>Step 1: Running migrations...</strong><br>";
            Artisan::call('migrate:fresh', [
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