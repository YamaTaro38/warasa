<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SyncToMysqlController extends Controller
{
    public function __invoke()
    {
        if (config('app.env') !== 'production') {
            return "Bukan di lingkungan produksi.";
        }

        // Pastikan pakai SQLite (sumber data)
        if (config('database.default') !== 'sqlite') {
            return "Harus pakai SQLite dulu. Jalankan /run-migrate-seed dulu.";
        }

        set_time_limit(120);
        $output = '';
        $success = true;

        try {
            // Ambil data dari SQLite
            $tables = ['users', 'cache', 'cache_locks', 'jobs', 'job_batches', 'failed_jobs',
                       'password_reset_tokens', 'sessions', 'projects', 'product_categories',
                       'products', 'product_images', 'product_variations', 'export_histories',
                       'chat_sessions', 'chat_messages', 'activity_logs', 'api_keys',
                       'admin_settings', 'menu_visibilities', 'shopee_fee_configs',
                       'documentations', 'migrations'];

            // Konfigurasi koneksi MySQL dari env Vercel
            Config::set('database.connections.mysql_sync', [
                'driver' => 'mysql',
                'host' => env('DB_HOST'),
                'port' => env('DB_PORT'),
                'database' => env('DB_DATABASE'),
                'username' => env('DB_USERNAME'),
                'password' => env('DB_PASSWORD'),
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
                'prefix' => '',
                'strict' => true,
                'options' => extension_loaded('pdo_mysql') ? [
                    \PDO::MYSQL_ATTR_SSL_CA => base_path('ca.pem'),
                ] : [],
            ]);

            DB::purge('mysql_sync');

            // Step 1: Run migrations di MySQL
            $output .= "<strong>Step 1: Migrate MySQL...</strong><br>";
            Artisan::call('migrate:fresh', [
                "--force" => true,
                "--database" => "mysql_sync",
                "--no-interaction" => true,
                "--quiet" => true,
            ]);
            $output .= nl2br(Artisan::output());
            $output .= "<br>";

            // Step 2: Copy data dari SQLite ke MySQL
            $output .= "<strong>Step 2: Copying data...</strong><br>";
            
            foreach ($tables as $table) {
                if (!Schema::connection('sqlite')->hasTable($table)) {
                    continue;
                }

                $rows = DB::connection('sqlite')->table($table)->get();
                $count = count($rows);
                
                if ($count > 0) {
                    $data = $rows->map(fn($row) => (array) $row)->toArray();
                    
                    // Batch insert to prevent timeout
                    foreach (array_chunk($data, 50) as $chunk) {
                        DB::connection('mysql_sync')->table($table)->insert($chunk);
                    }
                    $output .= "✅ {$table}: {$count} rows<br>";
                } else {
                    $output .= "⏭️ {$table}: 0 rows<br>";
                }
            }

            // Step 3: Seed admin user dan API keys di MySQL
            $output .= "<strong>Step 3: Seed admin user + API keys...</strong><br>";
            Artisan::call('db:seed', [
                "--class" => "Database\\Seeders\\AdminUserSeeder",
                "--force" => true,
                "--database" => "mysql_sync",
                "--no-interaction" => true,
                "--quiet" => true,
            ]);
            $output .= nl2br(Artisan::output());

            Artisan::call('db:seed', [
                "--class" => "Database\\Seeders\\ApiKeySeeder",
                "--force" => true,
                "--database" => "mysql_sync",
                "--no-interaction" => true,
                "--quiet" => true,
            ]);
            $output .= nl2br(Artisan::output());
            $output .= "<br>";

            $output .= "<span style='color:green;font-weight:bold;'>✅ Selesai! Data SQLite berhasil di-copy ke MySQL!</span>";
        } catch (\Exception $e) {
            $success = false;
            $output .= "<span style='color:red;font-weight:bold;'>❌ Gagal: " . $e->getMessage() . "</span>";
        }

        $status = $success ? "✅ SUKSES" : "❌ GAGAL";
        return "<html><body style='font-family:monospace;padding:20px;'><h2>{$status}</h2>{$output}</body></html>";
    }
}