<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class ExportSqliteController extends Controller
{
    public function __invoke()
    {
        if (config('app.env') !== 'production') {
            return "Bukan di lingkungan produksi.";
        }
        if (config('database.default') !== 'sqlite') {
            return "Harus pakai SQLite. Jalankan /run-migrate-seed dulu.";
        }

        set_time_limit(30);
        
        $sql = "-- Warasa SQLite Export\n-- Generated: " . now() . "\n\n";
        
        $tables = ['admin_settings', 'menu_visibilities', 'shopee_fee_configs', 
                    'users', 'api_keys', 'product_categories', 'products',
                    'product_images', 'product_variations', 'projects',
                    'documentations', 'chat_sessions', 'chat_messages',
                    'activity_logs', 'export_histories', 'migrations'];
        
        foreach ($tables as $table) {
            try {
                $rows = DB::table($table)->get();
                if ($rows->isEmpty()) continue;
                
                $sql .= "-- Table: {$table} ({$rows->count()} rows)\n";
                
                foreach ($rows as $row) {
                    $data = (array) $row;
                    $cols = '`' . implode('`, `', array_keys($data)) . '`';
                    $vals = [];
                    foreach ($data as $val) {
                        if (is_null($val)) $vals[] = 'NULL';
                        else $vals[] = "'" . str_replace("'", "\\'", $val) . "'";
                    }
                    $sql .= "INSERT INTO `{$table}` ({$cols}) VALUES (" . implode(', ', $vals) . ");\n";
                }
                $sql .= "\n";
            } catch (\Exception $e) {
                $sql .= "-- Skipped {$table}: " . $e->getMessage() . "\n\n";
            }
        }
        
        return response($sql, 200, [
            'Content-Type' => 'text/plain',
            'Content-Disposition' => 'attachment; filename="warasa_export.sql"',
        ]);
    }
}