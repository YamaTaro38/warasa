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
            // Single command: migrate:fresh builds all tables, runs all seeders
            // Setting PHP timeout for this specific request
            $output .= "⏳ Running migrate:fresh --seed (this may take up to 60s)...<br>";
            Artisan::call('migrate:fresh', [
                "--force" => true,
                "--seed" => true,
                "--seeder" => "Database\\Seeders\\DatabaseSeeder",
                "--no-interaction" => true,
            ]);
            $output .= nl2br(Artisan::output());
            $output .= "<br>";

            // No need for separate ShopeeCategoryCodesSeeder - it's already in DatabaseSeeder
            
            $output .= "<span style='color:green;font-weight:bold;'>✅ SUKSES!</span>";
        } catch (\Exception $e) {
            $success = false;
            $output .= "<span style='color:red;font-weight:bold;'>❌ Gagal: " . $e->getMessage() . "</span>";
        }

        $status = $success ? "✅ SUKSES" : "❌ GAGAL";
        return "<html><body style='font-family:monospace;padding:20px;'><h2>{$status}</h2>{$output}</body></html>";
    }
}