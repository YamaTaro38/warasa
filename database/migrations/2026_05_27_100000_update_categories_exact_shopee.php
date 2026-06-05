<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Hapus foreign key constraint temporarily, then delete all categories
        if (DB::getDriverName() === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = OFF');
        } else {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
        }
        
        DB::table('product_categories')->truncate();
        
        if (DB::getDriverName() === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = ON');
        } else {
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        }

        // ====================================================
        // KATEGORI UTAMA LEVEL 1 — PERSIS SHOPEE INDONESIA
        // ====================================================
        $parents = [];
        
        $parents['Pakaian Pria'] = DB::table('product_categories')->insertGetId([
            'name' => 'Pakaian Pria', 'slug' => 'pakaian-pria', 'sort_order' => 1,
            'spec_template' => null, 'parent_id' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $parents['Pakaian Wanita'] = DB::table('product_categories')->insertGetId([
            'name' => 'Pakaian Wanita', 'slug' => 'pakaian-wanita', 'sort_order' => 2,
            'spec_template' => null, 'parent_id' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $parents['Fashion Muslim'] = DB::table('product_categories')->insertGetId([
            'name' => 'Fashion Muslim', 'slug' => 'fashion-muslim', 'sort_order' => 3,
            'spec_template' => null, 'parent_id' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $parents['Tas'] = DB::table('product_categories')->insertGetId([
            'name' => 'Tas', 'slug' => 'tas', 'sort_order' => 4,
            'spec_template' => null, 'parent_id' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $parents['Sepatu'] = DB::table('product_categories')->insertGetId([
            'name' => 'Sepatu', 'slug' => 'sepatu', 'sort_order' => 5,
            'spec_template' => null, 'parent_id' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $parents['Jam Tangan'] = DB::table('product_categories')->insertGetId([
            'name' => 'Jam Tangan', 'slug' => 'jam-tangan', 'sort_order' => 6,
            'spec_template' => null, 'parent_id' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $parents['Aksesoris Fashion'] = DB::table('product_categories')->insertGetId([
            'name' => 'Aksesoris Fashion', 'slug' => 'aksesoris-fashion', 'sort_order' => 7,
            'spec_template' => null, 'parent_id' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $parents['Handphone & Aksesoris'] = DB::table('product_categories')->insertGetId([
            'name' => 'Handphone & Aksesoris', 'slug' => 'handphone-aksesoris', 'sort_order' => 8,
            'spec_template' => null, 'parent_id' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $parents['Elektronik'] = DB::table('product_categories')->insertGetId([
            'name' => 'Elektronik', 'slug' => 'elektronik', 'sort_order' => 9,
            'spec_template' => null, 'parent_id' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $parents['Komputer & Laptop'] = DB::table('product_categories')->insertGetId([
            'name' => 'Komputer & Laptop', 'slug' => 'komputer-laptop', 'sort_order' => 10,
            'spec_template' => null, 'parent_id' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $parents['Kecantikan'] = DB::table('product_categories')->insertGetId([
            'name' => 'Kecantikan', 'slug' => 'kecantikan', 'sort_order' => 11,
            'spec_template' => null, 'parent_id' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $parents['Kesehatan'] = DB::table('product_categories')->insertGetId([
            'name' => 'Kesehatan', 'slug' => 'kesehatan', 'sort_order' => 12,
            'spec_template' => null, 'parent_id' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $parents['Makanan & Minuman'] = DB::table('product_categories')->insertGetId([
            'name' => 'Makanan & Minuman', 'slug' => 'makanan-minuman', 'sort_order' => 13,
            'spec_template' => null, 'parent_id' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $parents['Ibu & Bayi'] = DB::table('product_categories')->insertGetId([
            'name' => 'Ibu & Bayi', 'slug' => 'ibu-bayi', 'sort_order' => 14,
            'spec_template' => null, 'parent_id' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $parents['Olahraga & Outdoor'] = DB::table('product_categories')->insertGetId([
            'name' => 'Olahraga & Outdoor', 'slug' => 'olahraga-outdoor', 'sort_order' => 15,
            'spec_template' => null, 'parent_id' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $parents['Otomotif'] = DB::table('product_categories')->insertGetId([
            'name' => 'Otomotif', 'slug' => 'otomotif', 'sort_order' => 16,
            'spec_template' => null, 'parent_id' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $parents['Perlengkapan Rumah'] = DB::table('product_categories')->insertGetId([
            'name' => 'Perlengkapan Rumah', 'slug' => 'perlengkapan-rumah', 'sort_order' => 17,
            'spec_template' => null, 'parent_id' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $parents['Mainan & Hobi'] = DB::table('product_categories')->insertGetId([
            'name' => 'Mainan & Hobi', 'slug' => 'mainan-hobi', 'sort_order' => 18,
            'spec_template' => null, 'parent_id' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $parents['Buku & Alat Tulis'] = DB::table('product_categories')->insertGetId([
            'name' => 'Buku & Alat Tulis', 'slug' => 'buku-alat-tulis', 'sort_order' => 19,
            'spec_template' => null, 'parent_id' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $parents['Perawatan Hewan'] = DB::table('product_categories')->insertGetId([
            'name' => 'Perawatan Hewan', 'slug' => 'perawatan-hewan', 'sort_order' => 20,
            'spec_template' => null, 'parent_id' => null, 'is_active' => true, 'created_at' => now()
        ]);

        // ====================================================
        // SUB-KATEGORI LEVEL 2 (Parent: Level 1)
        // TIDAK punya spec_template (spesifikasi hanya di Level 3/Leaf)
        // ====================================================
        $level2 = [];

        // --- Pakaian Pria ---
        $level2['Pakaian Pria']['Atasan'] = DB::table('product_categories')->insertGetId([
            'name' => 'Atasan', 'slug' => 'atasan-pria', 'parent_id' => $parents['Pakaian Pria'], 'sort_order' => 1,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $level2['Pakaian Pria']['Bawahan'] = DB::table('product_categories')->insertGetId([
            'name' => 'Bawahan', 'slug' => 'bawahan-pria', 'parent_id' => $parents['Pakaian Pria'], 'sort_order' => 2,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $level2['Pakaian Pria']['Jaket & Outerwear'] = DB::table('product_categories')->insertGetId([
            'name' => 'Jaket & Outerwear', 'slug' => 'jaket-outerwear-pria', 'parent_id' => $parents['Pakaian Pria'], 'sort_order' => 3,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $level2['Pakaian Pria']['Pakaian Dalam'] = DB::table('product_categories')->insertGetId([
            'name' => 'Pakaian Dalam', 'slug' => 'pakaian-dalam-pria', 'parent_id' => $parents['Pakaian Pria'], 'sort_order' => 4,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);

        // --- Pakaian Wanita ---
        $level2['Pakaian Wanita']['Atasan'] = DB::table('product_categories')->insertGetId([
            'name' => 'Atasan', 'slug' => 'atasan-wanita', 'parent_id' => $parents['Pakaian Wanita'], 'sort_order' => 1,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $level2['Pakaian Wanita']['Bawahan'] = DB::table('product_categories')->insertGetId([
            'name' => 'Bawahan', 'slug' => 'bawahan-wanita', 'parent_id' => $parents['Pakaian Wanita'], 'sort_order' => 2,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $level2['Pakaian Wanita']['Dress & Rok'] = DB::table('product_categories')->insertGetId([
            'name' => 'Dress & Rok', 'slug' => 'dress-rok', 'parent_id' => $parents['Pakaian Wanita'], 'sort_order' => 3,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $level2['Pakaian Wanita']['Jaket & Outerwear'] = DB::table('product_categories')->insertGetId([
            'name' => 'Jaket & Outerwear', 'slug' => 'jaket-outerwear-wanita', 'parent_id' => $parents['Pakaian Wanita'], 'sort_order' => 4,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $level2['Pakaian Wanita']['Pakaian Dalam'] = DB::table('product_categories')->insertGetId([
            'name' => 'Pakaian Dalam', 'slug' => 'pakaian-dalam-wanita', 'parent_id' => $parents['Pakaian Wanita'], 'sort_order' => 5,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);

        // --- Fashion Muslim ---
        $level2['Fashion Muslim']['Hijab'] = DB::table('product_categories')->insertGetId([
            'name' => 'Hijab', 'slug' => 'hijab', 'parent_id' => $parents['Fashion Muslim'], 'sort_order' => 1,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $level2['Fashion Muslim']['Baju Muslim Pria'] = DB::table('product_categories')->insertGetId([
            'name' => 'Baju Muslim Pria', 'slug' => 'baju-muslim-pria', 'parent_id' => $parents['Fashion Muslim'], 'sort_order' => 2,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $level2['Fashion Muslim']['Baju Muslim Wanita'] = DB::table('product_categories')->insertGetId([
            'name' => 'Baju Muslim Wanita', 'slug' => 'baju-muslim-wanita', 'parent_id' => $parents['Fashion Muslim'], 'sort_order' => 3,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $level2['Fashion Muslim']['Perlengkapan Sholat'] = DB::table('product_categories')->insertGetId([
            'name' => 'Perlengkapan Sholat', 'slug' => 'perlengkapan-sholat', 'parent_id' => $parents['Fashion Muslim'], 'sort_order' => 4,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);

        // --- Tas ---
        $level2['Tas']['Tas Wanita'] = DB::table('product_categories')->insertGetId([
            'name' => 'Tas Wanita', 'slug' => 'tas-wanita-sub', 'parent_id' => $parents['Tas'], 'sort_order' => 1,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $level2['Tas']['Tas Pria'] = DB::table('product_categories')->insertGetId([
            'name' => 'Tas Pria', 'slug' => 'tas-pria-sub', 'parent_id' => $parents['Tas'], 'sort_order' => 2,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $level2['Tas']['Ransel'] = DB::table('product_categories')->insertGetId([
            'name' => 'Ransel', 'slug' => 'ransel', 'parent_id' => $parents['Tas'], 'sort_order' => 3,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $level2['Tas']['Dompet'] = DB::table('product_categories')->insertGetId([
            'name' => 'Dompet', 'slug' => 'dompet', 'parent_id' => $parents['Tas'], 'sort_order' => 4,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $level2['Tas']['Koper & Travel'] = DB::table('product_categories')->insertGetId([
            'name' => 'Koper & Travel', 'slug' => 'koper-travel', 'parent_id' => $parents['Tas'], 'sort_order' => 5,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);

        // --- Sepatu ---
        $level2['Sepatu']['Sepatu Pria'] = DB::table('product_categories')->insertGetId([
            'name' => 'Sepatu Pria', 'slug' => 'sepatu-pria-sub', 'parent_id' => $parents['Sepatu'], 'sort_order' => 1,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $level2['Sepatu']['Sepatu Wanita'] = DB::table('product_categories')->insertGetId([
            'name' => 'Sepatu Wanita', 'slug' => 'sepatu-wanita-sub', 'parent_id' => $parents['Sepatu'], 'sort_order' => 2,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $level2['Sepatu']['Sneakers'] = DB::table('product_categories')->insertGetId([
            'name' => 'Sneakers', 'slug' => 'sneakers', 'parent_id' => $parents['Sepatu'], 'sort_order' => 3,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $level2['Sepatu']['Sandal & Flip Flop'] = DB::table('product_categories')->insertGetId([
            'name' => 'Sandal & Flip Flop', 'slug' => 'sandal-flipflop', 'parent_id' => $parents['Sepatu'], 'sort_order' => 4,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);

        // --- Jam Tangan ---
        $level2['Jam Tangan']['Jam Tangan Pria'] = DB::table('product_categories')->insertGetId([
            'name' => 'Jam Tangan Pria', 'slug' => 'jam-tangan-pria-sub', 'parent_id' => $parents['Jam Tangan'], 'sort_order' => 1,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $level2['Jam Tangan']['Jam Tangan Wanita'] = DB::table('product_categories')->insertGetId([
            'name' => 'Jam Tangan Wanita', 'slug' => 'jam-tangan-wanita-sub', 'parent_id' => $parents['Jam Tangan'], 'sort_order' => 2,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $level2['Jam Tangan']['Smartwatch'] = DB::table('product_categories')->insertGetId([
            'name' => 'Smartwatch', 'slug' => 'smartwatch', 'parent_id' => $parents['Jam Tangan'], 'sort_order' => 3,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);

        // --- Aksesoris Fashion ---
        $level2['Aksesoris Fashion']['Perhiasan'] = DB::table('product_categories')->insertGetId([
            'name' => 'Perhiasan', 'slug' => 'perhiasan', 'parent_id' => $parents['Aksesoris Fashion'], 'sort_order' => 1,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $level2['Aksesoris Fashion']['Kacamata'] = DB::table('product_categories')->insertGetId([
            'name' => 'Kacamata', 'slug' => 'kacamata', 'parent_id' => $parents['Aksesoris Fashion'], 'sort_order' => 2,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $level2['Aksesoris Fashion']['Aksesoris Rambut'] = DB::table('product_categories')->insertGetId([
            'name' => 'Aksesoris Rambut', 'slug' => 'aksesoris-rambut', 'parent_id' => $parents['Aksesoris Fashion'], 'sort_order' => 3,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $level2['Aksesoris Fashion']['Ikat Pinggang'] = DB::table('product_categories')->insertGetId([
            'name' => 'Ikat Pinggang', 'slug' => 'ikat-pinggang', 'parent_id' => $parents['Aksesoris Fashion'], 'sort_order' => 4,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);

        // --- Handphone & Aksesoris ---
        $level2['Handphone & Aksesoris']['Handphone'] = DB::table('product_categories')->insertGetId([
            'name' => 'Handphone', 'slug' => 'handphone', 'parent_id' => $parents['Handphone & Aksesoris'], 'sort_order' => 1,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $level2['Handphone & Aksesoris']['Tablet'] = DB::table('product_categories')->insertGetId([
            'name' => 'Tablet', 'slug' => 'tablet', 'parent_id' => $parents['Handphone & Aksesoris'], 'sort_order' => 2,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $level2['Handphone & Aksesoris']['Casing & Pelindung'] = DB::table('product_categories')->insertGetId([
            'name' => 'Casing & Pelindung', 'slug' => 'casing-pelindung', 'parent_id' => $parents['Handphone & Aksesoris'], 'sort_order' => 3,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $level2['Handphone & Aksesoris']['Charger & Kabel'] = DB::table('product_categories')->insertGetId([
            'name' => 'Charger & Kabel', 'slug' => 'charger-kabel', 'parent_id' => $parents['Handphone & Aksesoris'], 'sort_order' => 4,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $level2['Handphone & Aksesoris']['Powerbank'] = DB::table('product_categories')->insertGetId([
            'name' => 'Powerbank', 'slug' => 'powerbank', 'parent_id' => $parents['Handphone & Aksesoris'], 'sort_order' => 5,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $level2['Handphone & Aksesoris']['Headset & Earphone'] = DB::table('product_categories')->insertGetId([
            'name' => 'Headset & Earphone', 'slug' => 'headset-earphone', 'parent_id' => $parents['Handphone & Aksesoris'], 'sort_order' => 6,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);

        // --- Elektronik ---
        $level2['Elektronik']['TV & Audio'] = DB::table('product_categories')->insertGetId([
            'name' => 'TV & Audio', 'slug' => 'tv-audio', 'parent_id' => $parents['Elektronik'], 'sort_order' => 1,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $level2['Elektronik']['Kamera'] = DB::table('product_categories')->insertGetId([
            'name' => 'Kamera', 'slug' => 'kamera', 'parent_id' => $parents['Elektronik'], 'sort_order' => 2,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $level2['Elektronik']['Speaker & Soundbar'] = DB::table('product_categories')->insertGetId([
            'name' => 'Speaker & Soundbar', 'slug' => 'speaker-soundbar', 'parent_id' => $parents['Elektronik'], 'sort_order' => 3,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $level2['Elektronik']['Game Console'] = DB::table('product_categories')->insertGetId([
            'name' => 'Game Console', 'slug' => 'game-console', 'parent_id' => $parents['Elektronik'], 'sort_order' => 4,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);

        // --- Komputer & Laptop ---
        $level2['Komputer & Laptop']['Laptop'] = DB::table('product_categories')->insertGetId([
            'name' => 'Laptop', 'slug' => 'laptop', 'parent_id' => $parents['Komputer & Laptop'], 'sort_order' => 1,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $level2['Komputer & Laptop']['PC Desktop'] = DB::table('product_categories')->insertGetId([
            'name' => 'PC Desktop', 'slug' => 'pc-desktop', 'parent_id' => $parents['Komputer & Laptop'], 'sort_order' => 2,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $level2['Komputer & Laptop']['Monitor'] = DB::table('product_categories')->insertGetId([
            'name' => 'Monitor', 'slug' => 'monitor', 'parent_id' => $parents['Komputer & Laptop'], 'sort_order' => 3,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $level2['Komputer & Laptop']['Keyboard & Mouse'] = DB::table('product_categories')->insertGetId([
            'name' => 'Keyboard & Mouse', 'slug' => 'keyboard-mouse', 'parent_id' => $parents['Komputer & Laptop'], 'sort_order' => 4,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $level2['Komputer & Laptop']['Komponen PC'] = DB::table('product_categories')->insertGetId([
            'name' => 'Komponen PC', 'slug' => 'komponen-pc', 'parent_id' => $parents['Komputer & Laptop'], 'sort_order' => 5,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $level2['Komputer & Laptop']['Printer & Scanner'] = DB::table('product_categories')->insertGetId([
            'name' => 'Printer & Scanner', 'slug' => 'printer-scanner', 'parent_id' => $parents['Komputer & Laptop'], 'sort_order' => 6,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);

        // --- Kecantikan ---
        $level2['Kecantikan']['Perawatan Wajah'] = DB::table('product_categories')->insertGetId([
            'name' => 'Perawatan Wajah', 'slug' => 'perawatan-wajah', 'parent_id' => $parents['Kecantikan'], 'sort_order' => 1,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $level2['Kecantikan']['Makeup'] = DB::table('product_categories')->insertGetId([
            'name' => 'Makeup', 'slug' => 'makeup', 'parent_id' => $parents['Kecantikan'], 'sort_order' => 2,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $level2['Kecantikan']['Perawatan Rambut'] = DB::table('product_categories')->insertGetId([
            'name' => 'Perawatan Rambut', 'slug' => 'perawatan-rambut', 'parent_id' => $parents['Kecantikan'], 'sort_order' => 3,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $level2['Kecantikan']['Perawatan Tubuh'] = DB::table('product_categories')->insertGetId([
            'name' => 'Perawatan Tubuh', 'slug' => 'perawatan-tubuh', 'parent_id' => $parents['Kecantikan'], 'sort_order' => 4,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $level2['Kecantikan']['Parfum'] = DB::table('product_categories')->insertGetId([
            'name' => 'Parfum', 'slug' => 'parfum', 'parent_id' => $parents['Kecantikan'], 'sort_order' => 5,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $level2['Kecantikan']['Alat Kecantikan'] = DB::table('product_categories')->insertGetId([
            'name' => 'Alat Kecantikan', 'slug' => 'alat-kecantikan', 'parent_id' => $parents['Kecantikan'], 'sort_order' => 6,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);

        // --- Kesehatan ---
        $level2['Kesehatan']['Suplemen & Vitamin'] = DB::table('product_categories')->insertGetId([
            'name' => 'Suplemen & Vitamin', 'slug' => 'suplemen-vitamin', 'parent_id' => $parents['Kesehatan'], 'sort_order' => 1,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $level2['Kesehatan']['Alat Kesehatan'] = DB::table('product_categories')->insertGetId([
            'name' => 'Alat Kesehatan', 'slug' => 'alat-kesehatan', 'parent_id' => $parents['Kesehatan'], 'sort_order' => 2,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $level2['Kesehatan']['Obat-obatan'] = DB::table('product_categories')->insertGetId([
            'name' => 'Obat-obatan', 'slug' => 'obat-obatan', 'parent_id' => $parents['Kesehatan'], 'sort_order' => 3,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);

        // --- Makanan & Minuman ---
        $level2['Makanan & Minuman']['Makanan Ringan'] = DB::table('product_categories')->insertGetId([
            'name' => 'Makanan Ringan', 'slug' => 'makanan-ringan', 'parent_id' => $parents['Makanan & Minuman'], 'sort_order' => 1,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $level2['Makanan & Minuman']['Makanan Berat'] = DB::table('product_categories')->insertGetId([
            'name' => 'Makanan Berat', 'slug' => 'makanan-berat', 'parent_id' => $parents['Makanan & Minuman'], 'sort_order' => 2,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $level2['Makanan & Minuman']['Minuman'] = DB::table('product_categories')->insertGetId([
            'name' => 'Minuman', 'slug' => 'minuman', 'parent_id' => $parents['Makanan & Minuman'], 'sort_order' => 3,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $level2['Makanan & Minuman']['Bahan Masak & Bumbu'] = DB::table('product_categories')->insertGetId([
            'name' => 'Bahan Masak & Bumbu', 'slug' => 'bahan-masak-bumbu', 'parent_id' => $parents['Makanan & Minuman'], 'sort_order' => 4,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);

        // --- Ibu & Bayi ---
        $level2['Ibu & Bayi']['Perlengkapan Bayi'] = DB::table('product_categories')->insertGetId([
            'name' => 'Perlengkapan Bayi', 'slug' => 'perlengkapan-bayi', 'parent_id' => $parents['Ibu & Bayi'], 'sort_order' => 1,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $level2['Ibu & Bayi']['Pakaian Bayi & Anak'] = DB::table('product_categories')->insertGetId([
            'name' => 'Pakaian Bayi & Anak', 'slug' => 'pakaian-bayi-anak', 'parent_id' => $parents['Ibu & Bayi'], 'sort_order' => 2,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $level2['Ibu & Bayi']['Mainan Bayi'] = DB::table('product_categories')->insertGetId([
            'name' => 'Mainan Bayi', 'slug' => 'mainan-bayi', 'parent_id' => $parents['Ibu & Bayi'], 'sort_order' => 3,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $level2['Ibu & Bayi']['Makanan & Susu Bayi'] = DB::table('product_categories')->insertGetId([
            'name' => 'Makanan & Susu Bayi', 'slug' => 'makanan-susu-bayi', 'parent_id' => $parents['Ibu & Bayi'], 'sort_order' => 4,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $level2['Ibu & Bayi']['Perlengkapan Ibu'] = DB::table('product_categories')->insertGetId([
            'name' => 'Perlengkapan Ibu', 'slug' => 'perlengkapan-ibu', 'parent_id' => $parents['Ibu & Bayi'], 'sort_order' => 5,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);

        // --- Olahraga & Outdoor ---
        $level2['Olahraga & Outdoor']['Pakaian Olahraga'] = DB::table('product_categories')->insertGetId([
            'name' => 'Pakaian Olahraga', 'slug' => 'pakaian-olahraga', 'parent_id' => $parents['Olahraga & Outdoor'], 'sort_order' => 1,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $level2['Olahraga & Outdoor']['Sepatu Olahraga'] = DB::table('product_categories')->insertGetId([
            'name' => 'Sepatu Olahraga', 'slug' => 'sepatu-olahraga', 'parent_id' => $parents['Olahraga & Outdoor'], 'sort_order' => 2,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $level2['Olahraga & Outdoor']['Alat Fitness'] = DB::table('product_categories')->insertGetId([
            'name' => 'Alat Fitness', 'slug' => 'alat-fitness', 'parent_id' => $parents['Olahraga & Outdoor'], 'sort_order' => 3,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $level2['Olahraga & Outdoor']['Alat Olahraga'] = DB::table('product_categories')->insertGetId([
            'name' => 'Alat Olahraga', 'slug' => 'alat-olahraga', 'parent_id' => $parents['Olahraga & Outdoor'], 'sort_order' => 4,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $level2['Olahraga & Outdoor']['Camping & Hiking'] = DB::table('product_categories')->insertGetId([
            'name' => 'Camping & Hiking', 'slug' => 'camping-hiking', 'parent_id' => $parents['Olahraga & Outdoor'], 'sort_order' => 5,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $level2['Olahraga & Outdoor']['Sepeda'] = DB::table('product_categories')->insertGetId([
            'name' => 'Sepeda', 'slug' => 'sepeda', 'parent_id' => $parents['Olahraga & Outdoor'], 'sort_order' => 6,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);

        // --- Otomotif ---
        $level2['Otomotif']['Aksesoris Mobil'] = DB::table('product_categories')->insertGetId([
            'name' => 'Aksesoris Mobil', 'slug' => 'aksesoris-mobil', 'parent_id' => $parents['Otomotif'], 'sort_order' => 1,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $level2['Otomotif']['Aksesoris Motor'] = DB::table('product_categories')->insertGetId([
            'name' => 'Aksesoris Motor', 'slug' => 'aksesoris-motor', 'parent_id' => $parents['Otomotif'], 'sort_order' => 2,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $level2['Otomotif']['Helm'] = DB::table('product_categories')->insertGetId([
            'name' => 'Helm', 'slug' => 'helm', 'parent_id' => $parents['Otomotif'], 'sort_order' => 3,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $level2['Otomotif']['Oli & Cairan'] = DB::table('product_categories')->insertGetId([
            'name' => 'Oli & Cairan', 'slug' => 'oli-cairan', 'parent_id' => $parents['Otomotif'], 'sort_order' => 4,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);

        // --- Perlengkapan Rumah ---
        $level2['Perlengkapan Rumah']['Peralatan Dapur'] = DB::table('product_categories')->insertGetId([
            'name' => 'Peralatan Dapur', 'slug' => 'peralatan-dapur', 'parent_id' => $parents['Perlengkapan Rumah'], 'sort_order' => 1,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $level2['Perlengkapan Rumah']['Peralatan Makan'] = DB::table('product_categories')->insertGetId([
            'name' => 'Peralatan Makan', 'slug' => 'peralatan-makan', 'parent_id' => $parents['Perlengkapan Rumah'], 'sort_order' => 2,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $level2['Perlengkapan Rumah']['Dekorasi Rumah'] = DB::table('product_categories')->insertGetId([
            'name' => 'Dekorasi Rumah', 'slug' => 'dekorasi-rumah', 'parent_id' => $parents['Perlengkapan Rumah'], 'sort_order' => 3,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $level2['Perlengkapan Rumah']['Peralatan Kebersihan'] = DB::table('product_categories')->insertGetId([
            'name' => 'Peralatan Kebersihan', 'slug' => 'peralatan-kebersihan', 'parent_id' => $parents['Perlengkapan Rumah'], 'sort_order' => 4,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $level2['Perlengkapan Rumah']['Penyimpanan & Organizer'] = DB::table('product_categories')->insertGetId([
            'name' => 'Penyimpanan & Organizer', 'slug' => 'penyimpanan-organizer', 'parent_id' => $parents['Perlengkapan Rumah'], 'sort_order' => 5,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $level2['Perlengkapan Rumah']['Elektronik Rumah Tangga'] = DB::table('product_categories')->insertGetId([
            'name' => 'Elektronik Rumah Tangga', 'slug' => 'elektronik-rumah-tangga', 'parent_id' => $parents['Perlengkapan Rumah'], 'sort_order' => 6,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $level2['Perlengkapan Rumah']['Lampu & Pencahayaan'] = DB::table('product_categories')->insertGetId([
            'name' => 'Lampu & Pencahayaan', 'slug' => 'lampu-pencahayaan', 'parent_id' => $parents['Perlengkapan Rumah'], 'sort_order' => 7,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);

        // --- Mainan & Hobi ---
        $level2['Mainan & Hobi']['Mainan Anak'] = DB::table('product_categories')->insertGetId([
            'name' => 'Mainan Anak', 'slug' => 'mainan-anak', 'parent_id' => $parents['Mainan & Hobi'], 'sort_order' => 1,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $level2['Mainan & Hobi']['Action Figure & Koleksi'] = DB::table('product_categories')->insertGetId([
            'name' => 'Action Figure & Koleksi', 'slug' => 'action-figure-koleksi', 'parent_id' => $parents['Mainan & Hobi'], 'sort_order' => 2,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $level2['Mainan & Hobi']['Puzzle & Board Game'] = DB::table('product_categories')->insertGetId([
            'name' => 'Puzzle & Board Game', 'slug' => 'puzzle-board-game', 'parent_id' => $parents['Mainan & Hobi'], 'sort_order' => 3,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);

        // --- Buku & Alat Tulis ---
        $level2['Buku & Alat Tulis']['Buku'] = DB::table('product_categories')->insertGetId([
            'name' => 'Buku', 'slug' => 'buku', 'parent_id' => $parents['Buku & Alat Tulis'], 'sort_order' => 1,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $level2['Buku & Alat Tulis']['Alat Tulis'] = DB::table('product_categories')->insertGetId([
            'name' => 'Alat Tulis', 'slug' => 'alat-tulis', 'parent_id' => $parents['Buku & Alat Tulis'], 'sort_order' => 2,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $level2['Buku & Alat Tulis']['Peralatan Seni'] = DB::table('product_categories')->insertGetId([
            'name' => 'Peralatan Seni', 'slug' => 'peralatan-seni', 'parent_id' => $parents['Buku & Alat Tulis'], 'sort_order' => 3,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);

        // --- Perawatan Hewan ---
        $level2['Perawatan Hewan']['Makanan Hewan'] = DB::table('product_categories')->insertGetId([
            'name' => 'Makanan Hewan', 'slug' => 'makanan-hewan', 'parent_id' => $parents['Perawatan Hewan'], 'sort_order' => 1,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $level2['Perawatan Hewan']['Perlengkapan Hewan'] = DB::table('product_categories')->insertGetId([
            'name' => 'Perlengkapan Hewan', 'slug' => 'perlengkapan-hewan', 'parent_id' => $parents['Perawatan Hewan'], 'sort_order' => 2,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);
        $level2['Perawatan Hewan']['Kandang & Akuarium'] = DB::table('product_categories')->insertGetId([
            'name' => 'Kandang & Akuarium', 'slug' => 'kandang-akuarium', 'parent_id' => $parents['Perawatan Hewan'], 'sort_order' => 3,
            'spec_template' => null, 'is_active' => true, 'created_at' => now()
        ]);

        // ====================================================
        // KATEGORI LEVEL 3 (LEAF) — TEMPAT PRODUK BERADA
        // Setiap leaf memiliki spec_template sendiri
        // ====================================================

        // ========== PAKAIAN PRIA ==========

        // Atasan Pria
        DB::table('product_categories')->insert([
            ['name' => 'Kaos', 'slug' => 'kaos-pria', 'parent_id' => $level2['Pakaian Pria']['Atasan'], 'sort_order' => 1,
             'spec_template' => json_encode(['Bahan', 'Motif', 'Lengan', 'Karakteristik']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Kemeja Kasual', 'slug' => 'kemeja-kasual-pria', 'parent_id' => $level2['Pakaian Pria']['Atasan'], 'sort_order' => 2,
             'spec_template' => json_encode(['Bahan', 'Kerah', 'Motif', 'Lengan']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Polo', 'slug' => 'polo-pria', 'parent_id' => $level2['Pakaian Pria']['Atasan'], 'sort_order' => 3,
             'spec_template' => json_encode(['Bahan', 'Kerah', 'Motif', 'Lengan']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Kemeja Formal', 'slug' => 'kemeja-formal-pria', 'parent_id' => $level2['Pakaian Pria']['Atasan'], 'sort_order' => 4,
             'spec_template' => json_encode(['Bahan', 'Kerah', 'Motif', 'Panjang Lengan', 'Ukuran Kerah']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Sweater & Hoodie', 'slug' => 'sweater-hoodie-pria', 'parent_id' => $level2['Pakaian Pria']['Atasan'], 'sort_order' => 5,
             'spec_template' => json_encode(['Bahan', 'Ketebalan', 'Motif', 'Fitur']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Rompi', 'slug' => 'rompi-pria', 'parent_id' => $level2['Pakaian Pria']['Atasan'], 'sort_order' => 6,
             'spec_template' => json_encode(['Bahan', 'Motif', 'Fitur', 'Jenis']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Koko/Pakaian Muslim', 'slug' => 'koko-muslim-pria', 'parent_id' => $level2['Pakaian Pria']['Atasan'], 'sort_order' => 7,
             'spec_template' => json_encode(['Bahan', 'Kerah', 'Motif', 'Lengan']), 'is_active' => true, 'created_at' => now()],
        ]);

        // Bawahan Pria
        DB::table('product_categories')->insert([
            ['name' => 'Celana Chino', 'slug' => 'celana-chino-pria', 'parent_id' => $level2['Pakaian Pria']['Bawahan'], 'sort_order' => 1,
             'spec_template' => json_encode(['Bahan', 'Model', 'Panjang', 'Motif']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Celana Jeans', 'slug' => 'celana-jeans-pria', 'parent_id' => $level2['Pakaian Pria']['Bawahan'], 'sort_order' => 2,
             'spec_template' => json_encode(['Bahan', 'Model', 'Panjang', 'Warna Denim']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Celana Pendek', 'slug' => 'celana-pendek-pria', 'parent_id' => $level2['Pakaian Pria']['Bawahan'], 'sort_order' => 3,
             'spec_template' => json_encode(['Bahan', 'Model', 'Panjang', 'Motif']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Celana Formal', 'slug' => 'celana-formal-pria', 'parent_id' => $level2['Pakaian Pria']['Bawahan'], 'sort_order' => 4,
             'spec_template' => json_encode(['Bahan', 'Model', 'Panjang', 'Motif']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Celana Cargo', 'slug' => 'celana-cargo-pria', 'parent_id' => $level2['Pakaian Pria']['Bawahan'], 'sort_order' => 5,
             'spec_template' => json_encode(['Bahan', 'Model', 'Panjang', 'Fitur', 'Jumlah Kantong']), 'is_active' => true, 'created_at' => now()],
        ]);

        // Jaket & Outerwear Pria
        DB::table('product_categories')->insert([
            ['name' => 'Jaket Denim', 'slug' => 'jaket-denim-pria', 'parent_id' => $level2['Pakaian Pria']['Jaket & Outerwear'], 'sort_order' => 1,
             'spec_template' => json_encode(['Bahan', 'Tipe Jaket', 'Ketebalan', 'Fitur', 'Warna Denim']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Jaket Bomber', 'slug' => 'jaket-bomber-pria', 'parent_id' => $level2['Pakaian Pria']['Jaket & Outerwear'], 'sort_order' => 2,
             'spec_template' => json_encode(['Bahan', 'Tipe Jaket', 'Ketebalan', 'Fitur']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Jaket Hoodie', 'slug' => 'jaket-hoodie-pria', 'parent_id' => $level2['Pakaian Pria']['Jaket & Outerwear'], 'sort_order' => 3,
             'spec_template' => json_encode(['Bahan', 'Tipe Jaket', 'Ketebalan', 'Fitur']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Jaket Parka', 'slug' => 'jaket-parka-pria', 'parent_id' => $level2['Pakaian Pria']['Jaket & Outerwear'], 'sort_order' => 4,
             'spec_template' => json_encode(['Bahan', 'Tipe Jaket', 'Ketebalan', 'Fitur', 'Tahan Air']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Jas & Blazer', 'slug' => 'jas-blazer-pria', 'parent_id' => $level2['Pakaian Pria']['Jaket & Outerwear'], 'sort_order' => 5,
             'spec_template' => json_encode(['Bahan', 'Tipe Jaket', 'Ketebalan', 'Fitur', 'Model']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Rompi', 'slug' => 'rompi-outerwear-pria', 'parent_id' => $level2['Pakaian Pria']['Jaket & Outerwear'], 'sort_order' => 6,
             'spec_template' => json_encode(['Bahan', 'Tipe Jaket', 'Ketebalan', 'Fitur']), 'is_active' => true, 'created_at' => now()],
        ]);

        // Pakaian Dalam Pria
        DB::table('product_categories')->insert([
            ['name' => 'Boxer', 'slug' => 'boxer-pria', 'parent_id' => $level2['Pakaian Pria']['Pakaian Dalam'], 'sort_order' => 1,
             'spec_template' => json_encode(['Bahan', 'Jenis', 'Set/Pcs']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Singlet', 'slug' => 'singlet-pria', 'parent_id' => $level2['Pakaian Pria']['Pakaian Dalam'], 'sort_order' => 2,
             'spec_template' => json_encode(['Bahan', 'Jenis', 'Set/Pcs']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Kaus Kaki', 'slug' => 'kaus-kaki-pria', 'parent_id' => $level2['Pakaian Pria']['Pakaian Dalam'], 'sort_order' => 3,
             'spec_template' => json_encode(['Bahan', 'Jenis', 'Set/Pcs', 'Tinggi']), 'is_active' => true, 'created_at' => now()],
        ]);

        // ========== PAKAIAN WANITA ==========

        // Atasan Wanita
        DB::table('product_categories')->insert([
            ['name' => 'Kaos', 'slug' => 'kaos-wanita', 'parent_id' => $level2['Pakaian Wanita']['Atasan'], 'sort_order' => 1,
             'spec_template' => json_encode(['Bahan', 'Motif', 'Lengan', 'Karakteristik']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Kemeja Wanita', 'slug' => 'kemeja-wanita', 'parent_id' => $level2['Pakaian Wanita']['Atasan'], 'sort_order' => 2,
             'spec_template' => json_encode(['Bahan', 'Kerah', 'Motif', 'Lengan']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Blouse', 'slug' => 'blouse-wanita', 'parent_id' => $level2['Pakaian Wanita']['Atasan'], 'sort_order' => 3,
             'spec_template' => json_encode(['Bahan', 'Kerah', 'Motif', 'Lengan', 'Detail']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Kardigan', 'slug' => 'kardigan-wanita', 'parent_id' => $level2['Pakaian Wanita']['Atasan'], 'sort_order' => 4,
             'spec_template' => json_encode(['Bahan', 'Ketebalan', 'Motif', 'Panjang']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Sweater & Hoodie', 'slug' => 'sweater-hoodie-wanita', 'parent_id' => $level2['Pakaian Wanita']['Atasan'], 'sort_order' => 5,
             'spec_template' => json_encode(['Bahan', 'Ketebalan', 'Motif', 'Fitur']), 'is_active' => true, 'created_at' => now()],
        ]);

        // Bawahan Wanita
        DB::table('product_categories')->insert([
            ['name' => 'Celana Panjang', 'slug' => 'celana-panjang-wanita', 'parent_id' => $level2['Pakaian Wanita']['Bawahan'], 'sort_order' => 1,
             'spec_template' => json_encode(['Bahan', 'Model', 'Panjang', 'Motif']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Celana Pendek', 'slug' => 'celana-pendek-wanita', 'parent_id' => $level2['Pakaian Wanita']['Bawahan'], 'sort_order' => 2,
             'spec_template' => json_encode(['Bahan', 'Model', 'Panjang', 'Motif']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Legging', 'slug' => 'legging-wanita', 'parent_id' => $level2['Pakaian Wanita']['Bawahan'], 'sort_order' => 3,
             'spec_template' => json_encode(['Bahan', 'Model', 'Panjang', 'Ketebalan']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Rok', 'slug' => 'rok-bawahan-wanita', 'parent_id' => $level2['Pakaian Wanita']['Bawahan'], 'sort_order' => 4,
             'spec_template' => json_encode(['Bahan', 'Model', 'Panjang', 'Motif']), 'is_active' => true, 'created_at' => now()],
        ]);

        // Dress & Rok
        DB::table('product_categories')->insert([
            ['name' => 'Dress Kasual', 'slug' => 'dress-kasual', 'parent_id' => $level2['Pakaian Wanita']['Dress & Rok'], 'sort_order' => 1,
             'spec_template' => json_encode(['Bahan', 'Panjang', 'Gaya', 'Motif', 'Lengan']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Dress Formal', 'slug' => 'dress-formal', 'parent_id' => $level2['Pakaian Wanita']['Dress & Rok'], 'sort_order' => 2,
             'spec_template' => json_encode(['Bahan', 'Panjang', 'Gaya', 'Motif', 'Detail']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Rok Panjang', 'slug' => 'rok-panjang', 'parent_id' => $level2['Pakaian Wanita']['Dress & Rok'], 'sort_order' => 3,
             'spec_template' => json_encode(['Bahan', 'Panjang', 'Gaya', 'Motif']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Rok Pendek', 'slug' => 'rok-pendek', 'parent_id' => $level2['Pakaian Wanita']['Dress & Rok'], 'sort_order' => 4,
             'spec_template' => json_encode(['Bahan', 'Panjang', 'Gaya', 'Motif']), 'is_active' => true, 'created_at' => now()],
        ]);

        // Jaket & Outerwear Wanita
        DB::table('product_categories')->insert([
            ['name' => 'Jaket Denim', 'slug' => 'jaket-denim-wanita', 'parent_id' => $level2['Pakaian Wanita']['Jaket & Outerwear'], 'sort_order' => 1,
             'spec_template' => json_encode(['Bahan', 'Tipe Jaket', 'Ketebalan', 'Fitur']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Jaket Bomber', 'slug' => 'jaket-bomber-wanita', 'parent_id' => $level2['Pakaian Wanita']['Jaket & Outerwear'], 'sort_order' => 2,
             'spec_template' => json_encode(['Bahan', 'Tipe Jaket', 'Ketebalan', 'Fitur']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Jaket Hoodie', 'slug' => 'jaket-hoodie-wanita', 'parent_id' => $level2['Pakaian Wanita']['Jaket & Outerwear'], 'sort_order' => 3,
             'spec_template' => json_encode(['Bahan', 'Tipe Jaket', 'Ketebalan', 'Fitur']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Jas & Blazer', 'slug' => 'jas-blazer-wanita', 'parent_id' => $level2['Pakaian Wanita']['Jaket & Outerwear'], 'sort_order' => 4,
             'spec_template' => json_encode(['Bahan', 'Tipe Jaket', 'Ketebalan', 'Fitur', 'Model']), 'is_active' => true, 'created_at' => now()],
        ]);

        // Pakaian Dalam Wanita
        DB::table('product_categories')->insert([
            ['name' => 'Bra', 'slug' => 'bra-wanita', 'parent_id' => $level2['Pakaian Wanita']['Pakaian Dalam'], 'sort_order' => 1,
             'spec_template' => json_encode(['Bahan', 'Jenis', 'Set/Pcs', 'Fitur']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Panties', 'slug' => 'panties-wanita', 'parent_id' => $level2['Pakaian Wanita']['Pakaian Dalam'], 'sort_order' => 2,
             'spec_template' => json_encode(['Bahan', 'Jenis', 'Set/Pcs']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Set Innerwear', 'slug' => 'set-innerwear-wanita', 'parent_id' => $level2['Pakaian Wanita']['Pakaian Dalam'], 'sort_order' => 3,
             'spec_template' => json_encode(['Bahan', 'Jenis', 'Set/Pcs', 'Fitur']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Kaus Kaki', 'slug' => 'kaus-kaki-wanita', 'parent_id' => $level2['Pakaian Wanita']['Pakaian Dalam'], 'sort_order' => 4,
             'spec_template' => json_encode(['Bahan', 'Jenis', 'Set/Pcs', 'Tinggi']), 'is_active' => true, 'created_at' => now()],
        ]);

        // ========== FASHION MUSLIM ==========

        // Hijab
        DB::table('product_categories')->insert([
            ['name' => 'Hijab Segi Empat', 'slug' => 'hijab-segi-empat', 'parent_id' => $level2['Fashion Muslim']['Hijab'], 'sort_order' => 1,
             'spec_template' => json_encode(['Bahan', 'Jenis Hijab', 'Motif', 'Ukuran']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Pashmina', 'slug' => 'pashmina', 'parent_id' => $level2['Fashion Muslim']['Hijab'], 'sort_order' => 2,
             'spec_template' => json_encode(['Bahan', 'Jenis Hijab', 'Motif', 'Cara Pakai']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Bergo & Instan', 'slug' => 'bergo-instan', 'parent_id' => $level2['Fashion Muslim']['Hijab'], 'sort_order' => 3,
             'spec_template' => json_encode(['Bahan', 'Jenis Hijab', 'Motif', 'Cara Pakai']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Ciput & Ninja', 'slug' => 'ciput-ninja', 'parent_id' => $level2['Fashion Muslim']['Hijab'], 'sort_order' => 3,
             'spec_template' => json_encode(['Bahan', 'Jenis Hijab', 'Motif', 'Cara Pakai']), 'is_active' => true, 'created_at' => now()],
        ]);

        // Baju Muslim Pria
        DB::table('product_categories')->insert([
            ['name' => 'Koko Pria', 'slug' => 'koko-pria', 'parent_id' => $level2['Fashion Muslim']['Baju Muslim Pria'], 'sort_order' => 1,
             'spec_template' => json_encode(['Bahan', 'Jenis', 'Gaya', 'Motif', 'Kerah']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Sarung', 'slug' => 'sarung', 'parent_id' => $level2['Fashion Muslim']['Baju Muslim Pria'], 'sort_order' => 2,
             'spec_template' => json_encode(['Bahan', 'Jenis', 'Motif', 'Ukuran']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Peci & Kopiah', 'slug' => 'peci-kopiah', 'parent_id' => $level2['Fashion Muslim']['Baju Muslim Pria'], 'sort_order' => 3,
             'spec_template' => json_encode(['Bahan', 'Jenis', 'Gaya', 'Motif']), 'is_active' => true, 'created_at' => now()],
        ]);

        // Baju Muslim Wanita
        DB::table('product_categories')->insert([
            ['name' => 'Gamis', 'slug' => 'gamis', 'parent_id' => $level2['Fashion Muslim']['Baju Muslim Wanita'], 'sort_order' => 1,
             'spec_template' => json_encode(['Bahan', 'Jenis', 'Gaya', 'Motif']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Mukena', 'slug' => 'mukena', 'parent_id' => $level2['Fashion Muslim']['Baju Muslim Wanita'], 'sort_order' => 2,
             'spec_template' => json_encode(['Bahan', 'Jenis', 'Gaya', 'Motif', 'Set']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Tunik', 'slug' => 'tunik-muslim', 'parent_id' => $level2['Fashion Muslim']['Baju Muslim Wanita'], 'sort_order' => 3,
             'spec_template' => json_encode(['Bahan', 'Jenis', 'Gaya', 'Motif']), 'is_active' => true, 'created_at' => now()],
        ]);

        // Perlengkapan Sholat
        DB::table('product_categories')->insert([
            ['name' => 'Sajadah', 'slug' => 'sajadah', 'parent_id' => $level2['Fashion Muslim']['Perlengkapan Sholat'], 'sort_order' => 1,
             'spec_template' => json_encode(['Bahan', 'Jenis', 'Set', 'Ukuran']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Tasbih', 'slug' => 'tasbih', 'parent_id' => $level2['Fashion Muslim']['Perlengkapan Sholat'], 'sort_order' => 2,
             'spec_template' => json_encode(['Bahan', 'Jenis', 'Set']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Al-Quran', 'slug' => 'al-quran', 'parent_id' => $level2['Fashion Muslim']['Perlengkapan Sholat'], 'sort_order' => 3,
             'spec_template' => json_encode(['Jenis', 'Set', 'Ukuran', 'Bahasa']), 'is_active' => true, 'created_at' => now()],
        ]);

        // ========== TAS ==========

        // Tas Wanita
        DB::table('product_categories')->insert([
            ['name' => 'Tas Selempang', 'slug' => 'tas-selempang-wanita', 'parent_id' => $level2['Tas']['Tas Wanita'], 'sort_order' => 1,
             'spec_template' => json_encode(['Bahan', 'Model', 'Kapasitas', 'Warna']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Tas Tangan', 'slug' => 'tas-tangan-wanita', 'parent_id' => $level2['Tas']['Tas Wanita'], 'sort_order' => 2,
             'spec_template' => json_encode(['Bahan', 'Model', 'Kapasitas', 'Warna']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Tas Punggung Wanita', 'slug' => 'tas-punggung-wanita', 'parent_id' => $level2['Tas']['Tas Wanita'], 'sort_order' => 3,
             'spec_template' => json_encode(['Bahan', 'Model', 'Kapasitas', 'Fitur']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Clutch', 'slug' => 'clutch-wanita', 'parent_id' => $level2['Tas']['Tas Wanita'], 'sort_order' => 4,
             'spec_template' => json_encode(['Bahan', 'Model', 'Kapasitas', 'Warna']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Tas Pinggang', 'slug' => 'tas-pinggang-wanita', 'parent_id' => $level2['Tas']['Tas Wanita'], 'sort_order' => 5,
             'spec_template' => json_encode(['Bahan', 'Model', 'Kapasitas', 'Fitur']), 'is_active' => true, 'created_at' => now()],
        ]);

        // Tas Pria
        DB::table('product_categories')->insert([
            ['name' => 'Tas Selempang Pria', 'slug' => 'tas-selempang-pria', 'parent_id' => $level2['Tas']['Tas Pria'], 'sort_order' => 1,
             'spec_template' => json_encode(['Bahan', 'Model', 'Kapasitas', 'Warna']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Tas Punggung Pria', 'slug' => 'tas-punggung-pria', 'parent_id' => $level2['Tas']['Tas Pria'], 'sort_order' => 2,
             'spec_template' => json_encode(['Bahan', 'Model', 'Kapasitas', 'Fitur']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Tas Pinggang Pria', 'slug' => 'tas-pinggang-pria', 'parent_id' => $level2['Tas']['Tas Pria'], 'sort_order' => 3,
             'spec_template' => json_encode(['Bahan', 'Model', 'Kapasitas', 'Fitur']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Tas Kerja', 'slug' => 'tas-kerja-pria', 'parent_id' => $level2['Tas']['Tas Pria'], 'sort_order' => 4,
             'spec_template' => json_encode(['Bahan', 'Model', 'Kapasitas', 'Fitur', 'Kompartemen Laptop']), 'is_active' => true, 'created_at' => now()],
        ]);

        // Ransel
        DB::table('product_categories')->insert([
            ['name' => 'Ransel Sekolah', 'slug' => 'ransel-sekolah', 'parent_id' => $level2['Tas']['Ransel'], 'sort_order' => 1,
             'spec_template' => json_encode(['Bahan', 'Kapasitas', 'Fitur', 'Berat']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Ransel Laptop', 'slug' => 'ransel-laptop', 'parent_id' => $level2['Tas']['Ransel'], 'sort_order' => 2,
             'spec_template' => json_encode(['Bahan', 'Kapasitas', 'Fitur', 'Berat', 'Ukuran Laptop']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Ransel Travel', 'slug' => 'ransel-travel', 'parent_id' => $level2['Tas']['Ransel'], 'sort_order' => 3,
             'spec_template' => json_encode(['Bahan', 'Kapasitas', 'Fitur', 'Berat']), 'is_active' => true, 'created_at' => now()],
        ]);

        // Dompet
        DB::table('product_categories')->insert([
            ['name' => 'Dompet Pria', 'slug' => 'dompet-pria', 'parent_id' => $level2['Tas']['Dompet'], 'sort_order' => 1,
             'spec_template' => json_encode(['Bahan', 'Model', 'Jumlah Slot']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Dompet Wanita', 'slug' => 'dompet-wanita', 'parent_id' => $level2['Tas']['Dompet'], 'sort_order' => 2,
             'spec_template' => json_encode(['Bahan', 'Model', 'Jumlah Slot']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Card Holder', 'slug' => 'card-holder', 'parent_id' => $level2['Tas']['Dompet'], 'sort_order' => 3,
             'spec_template' => json_encode(['Bahan', 'Model', 'Jumlah Slot']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Money Belt', 'slug' => 'money-belt', 'parent_id' => $level2['Tas']['Dompet'], 'sort_order' => 4,
             'spec_template' => json_encode(['Bahan', 'Model', 'Fitur']), 'is_active' => true, 'created_at' => now()],
        ]);

        // Koper & Travel
        DB::table('product_categories')->insert([
            ['name' => 'Koper Kabin', 'slug' => 'koper-kabin', 'parent_id' => $level2['Tas']['Koper & Travel'], 'sort_order' => 1,
             'spec_template' => json_encode(['Bahan', 'Ukuran (cm/Liter)', 'Jumlah Roda', 'Fitur']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Koper Besar', 'slug' => 'koper-besar', 'parent_id' => $level2['Tas']['Koper & Travel'], 'sort_order' => 2,
             'spec_template' => json_encode(['Bahan', 'Ukuran (cm/Liter)', 'Jumlah Roda', 'Fitur']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Travel Bag', 'slug' => 'travel-bag', 'parent_id' => $level2['Tas']['Koper & Travel'], 'sort_order' => 3,
             'spec_template' => json_encode(['Bahan', 'Ukuran (cm/Liter)', 'Jumlah Roda', 'Fitur']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Tas Rias', 'slug' => 'tas-rias', 'parent_id' => $level2['Tas']['Koper & Travel'], 'sort_order' => 4,
             'spec_template' => json_encode(['Bahan', 'Ukuran (cm/Liter)', 'Fitur', 'Jumlah Kompartemen']), 'is_active' => true, 'created_at' => now()],
        ]);

        // ========== SEPATU ==========

        // Sepatu Pria
        DB::table('product_categories')->insert([
            ['name' => 'Sepatu Formal Pria', 'slug' => 'sepatu-formal-pria', 'parent_id' => $level2['Sepatu']['Sepatu Pria'], 'sort_order' => 1,
             'spec_template' => json_encode(['Bahan', 'Tipe Sepatu', 'Sol', 'Tinggi']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Sepatu Kasual Pria', 'slug' => 'sepatu-kasual-pria', 'parent_id' => $level2['Sepatu']['Sepatu Pria'], 'sort_order' => 2,
             'spec_template' => json_encode(['Bahan', 'Tipe Sepatu', 'Sol', 'Tinggi']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Boots Pria', 'slug' => 'boots-pria', 'parent_id' => $level2['Sepatu']['Sepatu Pria'], 'sort_order' => 3,
             'spec_template' => json_encode(['Bahan', 'Tipe Sepatu', 'Sol', 'Tinggi']), 'is_active' => true, 'created_at' => now()],
        ]);

        // Sepatu Wanita
        DB::table('product_categories')->insert([
            ['name' => 'Sepatu Hak Tinggi', 'slug' => 'sepatu-hak-tinggi', 'parent_id' => $level2['Sepatu']['Sepatu Wanita'], 'sort_order' => 1,
             'spec_template' => json_encode(['Bahan', 'Tipe Sepatu', 'Tinggi Hak', 'Sol']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Sepatu Datar Wanita', 'slug' => 'sepatu-datar-wanita', 'parent_id' => $level2['Sepatu']['Sepatu Wanita'], 'sort_order' => 2,
             'spec_template' => json_encode(['Bahan', 'Tipe Sepatu', 'Tinggi Hak', 'Sol']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Boots Wanita', 'slug' => 'boots-wanita', 'parent_id' => $level2['Sepatu']['Sepatu Wanita'], 'sort_order' => 3,
             'spec_template' => json_encode(['Bahan', 'Tipe Sepatu', 'Tinggi Hak', 'Sol']), 'is_active' => true, 'created_at' => now()],
        ]);

        // Sneakers
        DB::table('product_categories')->insert([
            ['name' => 'Sneakers Pria', 'slug' => 'sneakers-pria', 'parent_id' => $level2['Sepatu']['Sneakers'], 'sort_order' => 1,
             'spec_template' => json_encode(['Bahan', 'Tipe', 'Sol', 'Fitur']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Sneakers Wanita', 'slug' => 'sneakers-wanita', 'parent_id' => $level2['Sepatu']['Sneakers'], 'sort_order' => 2,
             'spec_template' => json_encode(['Bahan', 'Tipe', 'Sol', 'Fitur']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Sneakers Unisex', 'slug' => 'sneakers-unisex', 'parent_id' => $level2['Sepatu']['Sneakers'], 'sort_order' => 3,
             'spec_template' => json_encode(['Bahan', 'Tipe', 'Sol', 'Fitur']), 'is_active' => true, 'created_at' => now()],
        ]);

        // Sandal & Flip Flop
        DB::table('product_categories')->insert([
            ['name' => 'Sandal Pria', 'slug' => 'sandal-pria', 'parent_id' => $level2['Sepatu']['Sandal & Flip Flop'], 'sort_order' => 1,
             'spec_template' => json_encode(['Bahan', 'Tipe', 'Sol']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Sandal Wanita', 'slug' => 'sandal-wanita', 'parent_id' => $level2['Sepatu']['Sandal & Flip Flop'], 'sort_order' => 2,
             'spec_template' => json_encode(['Bahan', 'Tipe', 'Sol']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Flip Flop', 'slug' => 'flip-flop', 'parent_id' => $level2['Sepatu']['Sandal & Flip Flop'], 'sort_order' => 3,
             'spec_template' => json_encode(['Bahan', 'Tipe', 'Sol']), 'is_active' => true, 'created_at' => now()],
        ]);

        // ========== JAM TANGAN ==========

        // Jam Tangan Pria
        DB::table('product_categories')->insert([
            ['name' => 'Jam Tangan Kasual Pria', 'slug' => 'jam-kasual-pria', 'parent_id' => $level2['Jam Tangan']['Jam Tangan Pria'], 'sort_order' => 1,
             'spec_template' => json_encode(['Merk', 'Tipe Pergerakan', 'Bahan Tali', 'Ketahanan Air']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Jam Tangan Formal Pria', 'slug' => 'jam-formal-pria', 'parent_id' => $level2['Jam Tangan']['Jam Tangan Pria'], 'sort_order' => 2,
             'spec_template' => json_encode(['Merk', 'Tipe Pergerakan', 'Bahan Tali', 'Ketahanan Air', 'Bahan Gelang']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Jam Tangan Olahraga Pria', 'slug' => 'jam-olahraga-pria', 'parent_id' => $level2['Jam Tangan']['Jam Tangan Pria'], 'sort_order' => 3,
             'spec_template' => json_encode(['Merk', 'Tipe Pergerakan', 'Bahan Tali', 'Ketahanan Air', 'Fitur']), 'is_active' => true, 'created_at' => now()],
        ]);

        // Jam Tangan Wanita
        DB::table('product_categories')->insert([
            ['name' => 'Jam Tangan Kasual Wanita', 'slug' => 'jam-kasual-wanita', 'parent_id' => $level2['Jam Tangan']['Jam Tangan Wanita'], 'sort_order' => 1,
             'spec_template' => json_encode(['Merk', 'Tipe Pergerakan', 'Bahan Tali', 'Ketahanan Air']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Jam Tangan Formal Wanita', 'slug' => 'jam-formal-wanita', 'parent_id' => $level2['Jam Tangan']['Jam Tangan Wanita'], 'sort_order' => 2,
             'spec_template' => json_encode(['Merk', 'Tipe Pergerakan', 'Bahan Tali', 'Ketahanan Air']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Jam Tangan Fashion Wanita', 'slug' => 'jam-fashion-wanita', 'parent_id' => $level2['Jam Tangan']['Jam Tangan Wanita'], 'sort_order' => 3,
             'spec_template' => json_encode(['Merk', 'Tipe Pergerakan', 'Bahan Tali', 'Ketahanan Air']), 'is_active' => true, 'created_at' => now()],
        ]);

        // Smartwatch
        DB::table('product_categories')->insert([
            ['name' => 'Smartwatch Pria', 'slug' => 'smartwatch-pria', 'parent_id' => $level2['Jam Tangan']['Smartwatch'], 'sort_order' => 1,
             'spec_template' => json_encode(['Merk', 'Fitur', 'Ukuran Layar', 'Kompatibilitas', 'Baterai']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Smartwatch Wanita', 'slug' => 'smartwatch-wanita', 'parent_id' => $level2['Jam Tangan']['Smartwatch'], 'sort_order' => 2,
             'spec_template' => json_encode(['Merk', 'Fitur', 'Ukuran Layar', 'Kompatibilitas', 'Baterai']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Smartband', 'slug' => 'smartband', 'parent_id' => $level2['Jam Tangan']['Smartwatch'], 'sort_order' => 3,
             'spec_template' => json_encode(['Merk', 'Fitur', 'Kompatibilitas', 'Baterai']), 'is_active' => true, 'created_at' => now()],
        ]);

        // ========== AKSESORIS FASHION ==========

        // Perhiasan
        DB::table('product_categories')->insert([
            ['name' => 'Kalung', 'slug' => 'kalung', 'parent_id' => $level2['Aksesoris Fashion']['Perhiasan'], 'sort_order' => 1,
             'spec_template' => json_encode(['Bahan', 'Tipe', 'Panjang', 'Sertifikasi']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Gelang', 'slug' => 'gelang', 'parent_id' => $level2['Aksesoris Fashion']['Perhiasan'], 'sort_order' => 2,
             'spec_template' => json_encode(['Bahan', 'Tipe', 'Panjang', 'Sertifikasi']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Cincin', 'slug' => 'cincin', 'parent_id' => $level2['Aksesoris Fashion']['Perhiasan'], 'sort_order' => 3,
             'spec_template' => json_encode(['Bahan', 'Tipe', 'Ukuran', 'Sertifikasi']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Anting', 'slug' => 'anting', 'parent_id' => $level2['Aksesoris Fashion']['Perhiasan'], 'sort_order' => 4,
             'spec_template' => json_encode(['Bahan', 'Tipe', 'Sertifikasi']), 'is_active' => true, 'created_at' => now()],
        ]);

        // Kacamata
        DB::table('product_categories')->insert([
            ['name' => 'Kacamata Hitam', 'slug' => 'kacamata-hitam', 'parent_id' => $level2['Aksesoris Fashion']['Kacamata'], 'sort_order' => 1,
             'spec_template' => json_encode(['Bahan Frame', 'Jenis Lensa', 'Model', 'Fitur']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Kacamata Baca', 'slug' => 'kacamata-baca', 'parent_id' => $level2['Aksesoris Fashion']['Kacamata'], 'sort_order' => 2,
             'spec_template' => json_encode(['Bahan Frame', 'Jenis Lensa', 'Model', 'Kekuatan Lensa']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Kacamata Olahraga', 'slug' => 'kacamata-olahraga', 'parent_id' => $level2['Aksesoris Fashion']['Kacamata'], 'sort_order' => 3,
             'spec_template' => json_encode(['Bahan Frame', 'Jenis Lensa', 'Model', 'Fitur']), 'is_active' => true, 'created_at' => now()],
        ]);

        // Aksesoris Rambut
        DB::table('product_categories')->insert([
            ['name' => 'Jepit Rambut', 'slug' => 'jepit-rambut', 'parent_id' => $level2['Aksesoris Fashion']['Aksesoris Rambut'], 'sort_order' => 1,
             'spec_template' => json_encode(['Bahan', 'Tipe', 'Isi']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Ikat Rambut', 'slug' => 'ikat-rambut', 'parent_id' => $level2['Aksesoris Fashion']['Aksesoris Rambut'], 'sort_order' => 2,
             'spec_template' => json_encode(['Bahan', 'Tipe', 'Isi']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Bando', 'slug' => 'bando', 'parent_id' => $level2['Aksesoris Fashion']['Aksesoris Rambut'], 'sort_order' => 3,
             'spec_template' => json_encode(['Bahan', 'Tipe']), 'is_active' => true, 'created_at' => now()],
        ]);

        // Ikat Pinggang
        DB::table('product_categories')->insert([
            ['name' => 'Ikat Pinggang Pria', 'slug' => 'ikat-pinggang-pria', 'parent_id' => $level2['Aksesoris Fashion']['Ikat Pinggang'], 'sort_order' => 1,
             'spec_template' => json_encode(['Bahan', 'Panjang', 'Model', 'Warna']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Ikat Pinggang Wanita', 'slug' => 'ikat-pinggang-wanita', 'parent_id' => $level2['Aksesoris Fashion']['Ikat Pinggang'], 'sort_order' => 2,
             'spec_template' => json_encode(['Bahan', 'Panjang', 'Model', 'Warna']), 'is_active' => true, 'created_at' => now()],
        ]);

        // ========== HANDPHONE & AKSESORIS ==========

        // Handphone
        DB::table('product_categories')->insert([
            ['name' => 'Smartphone', 'slug' => 'smartphone', 'parent_id' => $level2['Handphone & Aksesoris']['Handphone'], 'sort_order' => 1,
             'spec_template' => json_encode(['Merk', 'Model', 'Masa Garansi', 'Jumlah Kamera Utama', 'Kapasitas Baterai', 'RAM', 'ROM']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Feature Phone', 'slug' => 'feature-phone', 'parent_id' => $level2['Handphone & Aksesoris']['Handphone'], 'sort_order' => 2,
             'spec_template' => json_encode(['Merk', 'Model', 'Masa Garansi', 'Fitur']), 'is_active' => true, 'created_at' => now()],
        ]);

        // Tablet
        DB::table('product_categories')->insert([
            ['name' => 'Tablet Android', 'slug' => 'tablet-android', 'parent_id' => $level2['Handphone & Aksesoris']['Tablet'], 'sort_order' => 1,
             'spec_template' => json_encode(['Merk', 'Model', 'Masa Garansi', 'Fitur', 'RAM', 'ROM']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'iPad', 'slug' => 'ipad', 'parent_id' => $level2['Handphone & Aksesoris']['Tablet'], 'sort_order' => 2,
             'spec_template' => json_encode(['Merk', 'Model', 'Masa Garansi', 'Fitur', 'RAM', 'ROM']), 'is_active' => true, 'created_at' => now()],
        ]);

        // Casing & Pelindung
        DB::table('product_categories')->insert([
            ['name' => 'Casing HP', 'slug' => 'casing-hp', 'parent_id' => $level2['Handphone & Aksesoris']['Casing & Pelindung'], 'sort_order' => 1,
             'spec_template' => json_encode(['Bahan', 'Model HP yang Cocok', 'Jenis', 'Fitur']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Tempered Glass', 'slug' => 'tempered-glass', 'parent_id' => $level2['Handphone & Aksesoris']['Casing & Pelindung'], 'sort_order' => 2,
             'spec_template' => json_encode(['Bahan', 'Model HP yang Cocok', 'Jenis', 'Fitur']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Casing Tablet', 'slug' => 'casing-tablet', 'parent_id' => $level2['Handphone & Aksesoris']['Casing & Pelindung'], 'sort_order' => 3,
             'spec_template' => json_encode(['Bahan', 'Model HP yang Cocok', 'Jenis', 'Fitur']), 'is_active' => true, 'created_at' => now()],
        ]);

        // Charger & Kabel
        DB::table('product_categories')->insert([
            ['name' => 'Charger Kepala', 'slug' => 'charger-kepala', 'parent_id' => $level2['Handphone & Aksesoris']['Charger & Kabel'], 'sort_order' => 1,
             'spec_template' => json_encode(['Tipe Konektor', 'Daya Output', 'Merk', 'Fitur']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Kabel Data', 'slug' => 'kabel-data', 'parent_id' => $level2['Handphone & Aksesoris']['Charger & Kabel'], 'sort_order' => 2,
             'spec_template' => json_encode(['Tipe Konektor', 'Panjang Kabel', 'Merk', 'Fitur']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Wireless Charger', 'slug' => 'wireless-charger', 'parent_id' => $level2['Handphone & Aksesoris']['Charger & Kabel'], 'sort_order' => 3,
             'spec_template' => json_encode(['Daya Output', 'Merk', 'Fitur', 'Kompatibilitas']), 'is_active' => true, 'created_at' => now()],
        ]);

        // Powerbank
        DB::table('product_categories')->insert([
            ['name' => 'Powerbank Standar', 'slug' => 'powerbank-standar', 'parent_id' => $level2['Handphone & Aksesoris']['Powerbank'], 'sort_order' => 1,
             'spec_template' => json_encode(['Kapasitas', 'Jumlah Port', 'Fitur', 'Merk']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Powerbank Fast Charging', 'slug' => 'powerbank-fast-charging', 'parent_id' => $level2['Handphone & Aksesoris']['Powerbank'], 'sort_order' => 2,
             'spec_template' => json_encode(['Kapasitas', 'Jumlah Port', 'Fitur', 'Merk', 'Daya Output']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Powerbank Solar', 'slug' => 'powerbank-solar', 'parent_id' => $level2['Handphone & Aksesoris']['Powerbank'], 'sort_order' => 3,
             'spec_template' => json_encode(['Kapasitas', 'Jumlah Port', 'Fitur', 'Merk']), 'is_active' => true, 'created_at' => now()],
        ]);

        // Headset & Earphone
        DB::table('product_categories')->insert([
            ['name' => 'Earphone Kabel', 'slug' => 'earphone-kabel', 'parent_id' => $level2['Handphone & Aksesoris']['Headset & Earphone'], 'sort_order' => 1,
             'spec_template' => json_encode(['Tipe', 'Koneksi', 'Fitur', 'Merk']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'TWS (True Wireless)', 'slug' => 'tws-earphone', 'parent_id' => $level2['Handphone & Aksesoris']['Headset & Earphone'], 'sort_order' => 2,
             'spec_template' => json_encode(['Tipe', 'Koneksi', 'Fitur', 'Merk', 'Baterai']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Headphone', 'slug' => 'headphone', 'parent_id' => $level2['Handphone & Aksesoris']['Headset & Earphone'], 'sort_order' => 3,
             'spec_template' => json_encode(['Tipe', 'Koneksi', 'Fitur', 'Merk']), 'is_active' => true, 'created_at' => now()],
        ]);

        // ========== ELEKTRONIK ==========

        // TV & Audio
        DB::table('product_categories')->insert([
            ['name' => 'Smart TV', 'slug' => 'smart-tv', 'parent_id' => $level2['Elektronik']['TV & Audio'], 'sort_order' => 1,
             'spec_template' => json_encode(['Merk', 'Ukuran Layar', 'Fitur', 'Daya', 'Resolusi']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'TV Biasa', 'slug' => 'tv-biasa', 'parent_id' => $level2['Elektronik']['TV & Audio'], 'sort_order' => 2,
             'spec_template' => json_encode(['Merk', 'Ukuran Layar', 'Fitur', 'Daya']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Home Theater', 'slug' => 'home-theater', 'parent_id' => $level2['Elektronik']['TV & Audio'], 'sort_order' => 3,
             'spec_template' => json_encode(['Merk', 'Daya', 'Fitur', 'Koneksi', 'Jumlah Speaker']), 'is_active' => true, 'created_at' => now()],
        ]);

        // Kamera
        DB::table('product_categories')->insert([
            ['name' => 'DSLR', 'slug' => 'dslr', 'parent_id' => $level2['Elektronik']['Kamera'], 'sort_order' => 1,
             'spec_template' => json_encode(['Merk', 'Tipe', 'Resolusi', 'Fitur', 'Sensor']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Mirrorless', 'slug' => 'mirrorless', 'parent_id' => $level2['Elektronik']['Kamera'], 'sort_order' => 2,
             'spec_template' => json_encode(['Merk', 'Tipe', 'Resolusi', 'Fitur']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Kamera Saku', 'slug' => 'kamera-saku', 'parent_id' => $level2['Elektronik']['Kamera'], 'sort_order' => 3,
             'spec_template' => json_encode(['Merk', 'Tipe', 'Resolusi', 'Fitur']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Action Camera', 'slug' => 'action-camera', 'parent_id' => $level2['Elektronik']['Kamera'], 'sort_order' => 4,
             'spec_template' => json_encode(['Merk', 'Tipe', 'Resolusi', 'Fitur', 'Tahan Air']), 'is_active' => true, 'created_at' => now()],
        ]);

        // Speaker & Soundbar
        DB::table('product_categories')->insert([
            ['name' => 'Speaker Portable', 'slug' => 'speaker-portable', 'parent_id' => $level2['Elektronik']['Speaker & Soundbar'], 'sort_order' => 1,
             'spec_template' => json_encode(['Merk', 'Daya Output', 'Koneksi', 'Fitur', 'Baterai']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Soundbar', 'slug' => 'soundbar', 'parent_id' => $level2['Elektronik']['Speaker & Soundbar'], 'sort_order' => 2,
             'spec_template' => json_encode(['Merk', 'Daya Output', 'Koneksi', 'Fitur']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Speaker Bluetooth', 'slug' => 'speaker-bluetooth', 'parent_id' => $level2['Elektronik']['Speaker & Soundbar'], 'sort_order' => 3,
             'spec_template' => json_encode(['Merk', 'Daya Output', 'Koneksi', 'Fitur', 'Baterai', 'Tahan Air']), 'is_active' => true, 'created_at' => now()],
        ]);

        // Game Console
        DB::table('product_categories')->insert([
            ['name' => 'PlayStation', 'slug' => 'playstation', 'parent_id' => $level2['Elektronik']['Game Console'], 'sort_order' => 1,
             'spec_template' => json_encode(['Merk', 'Model', 'Kapasitas', 'Kelengkapan', 'Kondisi']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Xbox', 'slug' => 'xbox', 'parent_id' => $level2['Elektronik']['Game Console'], 'sort_order' => 2,
             'spec_template' => json_encode(['Merk', 'Model', 'Kapasitas', 'Kelengkapan']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Nintendo', 'slug' => 'nintendo', 'parent_id' => $level2['Elektronik']['Game Console'], 'sort_order' => 3,
             'spec_template' => json_encode(['Merk', 'Model', 'Kapasitas', 'Kelengkapan']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Game Controller', 'slug' => 'game-controller', 'parent_id' => $level2['Elektronik']['Game Console'], 'sort_order' => 4,
             'spec_template' => json_encode(['Merk', 'Tipe', 'Koneksi', 'Kompatibilitas']), 'is_active' => true, 'created_at' => now()],
        ]);

        // ========== KOMPUTER & LAPTOP ==========

        // Laptop
        DB::table('product_categories')->insert([
            ['name' => 'Laptop Gaming', 'slug' => 'laptop-gaming', 'parent_id' => $level2['Komputer & Laptop']['Laptop'], 'sort_order' => 1,
             'spec_template' => json_encode(['Jenis Laptop', 'Kapasitas Penyimpanan', 'Tipe Prosesor', 'Sistem Operasi', 'Ukuran Layar', 'RAM']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Laptop Kantor', 'slug' => 'laptop-kantor', 'parent_id' => $level2['Komputer & Laptop']['Laptop'], 'sort_order' => 2,
             'spec_template' => json_encode(['Jenis Laptop', 'Kapasitas Penyimpanan', 'Tipe Prosesor', 'Sistem Operasi', 'Ukuran Layar', 'RAM']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'MacBook', 'slug' => 'macbook', 'parent_id' => $level2['Komputer & Laptop']['Laptop'], 'sort_order' => 3,
             'spec_template' => json_encode(['Jenis Laptop', 'Kapasitas Penyimpanan', 'Tipe Prosesor', 'Sistem Operasi', 'Ukuran Layar', 'RAM']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Chromebook', 'slug' => 'chromebook', 'parent_id' => $level2['Komputer & Laptop']['Laptop'], 'sort_order' => 4,
             'spec_template' => json_encode(['Jenis Laptop', 'Kapasitas Penyimpanan', 'Tipe Prosesor', 'Sistem Operasi', 'Ukuran Layar', 'RAM']), 'is_active' => true, 'created_at' => now()],
        ]);

        // PC Desktop
        DB::table('product_categories')->insert([
            ['name' => 'PC Gaming', 'slug' => 'pc-gaming', 'parent_id' => $level2['Komputer & Laptop']['PC Desktop'], 'sort_order' => 1,
             'spec_template' => json_encode(['Tipe Prosesor', 'Kapasitas RAM', 'Kapasitas Penyimpanan', 'GPU']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'PC Kantor', 'slug' => 'pc-kantor', 'parent_id' => $level2['Komputer & Laptop']['PC Desktop'], 'sort_order' => 2,
             'spec_template' => json_encode(['Tipe Prosesor', 'Kapasitas RAM', 'Kapasitas Penyimpanan', 'GPU']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'All-in-One PC', 'slug' => 'all-in-one-pc', 'parent_id' => $level2['Komputer & Laptop']['PC Desktop'], 'sort_order' => 3,
             'spec_template' => json_encode(['Tipe Prosesor', 'Kapasitas RAM', 'Kapasitas Penyimpanan', 'Ukuran Layar']), 'is_active' => true, 'created_at' => now()],
        ]);

        // Monitor
        DB::table('product_categories')->insert([
            ['name' => 'Monitor Gaming', 'slug' => 'monitor-gaming', 'parent_id' => $level2['Komputer & Laptop']['Monitor'], 'sort_order' => 1,
             'spec_template' => json_encode(['Merk', 'Ukuran Layar', 'Resolusi', 'Refresh Rate']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Monitor Kantor', 'slug' => 'monitor-kantor', 'parent_id' => $level2['Komputer & Laptop']['Monitor'], 'sort_order' => 2,
             'spec_template' => json_encode(['Merk', 'Ukuran Layar', 'Resolusi', 'Refresh Rate']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Monitor IPS', 'slug' => 'monitor-ips', 'parent_id' => $level2['Komputer & Laptop']['Monitor'], 'sort_order' => 3,
             'spec_template' => json_encode(['Merk', 'Ukuran Layar', 'Resolusi', 'Refresh Rate']), 'is_active' => true, 'created_at' => now()],
        ]);

        // Keyboard & Mouse
        DB::table('product_categories')->insert([
            ['name' => 'Keyboard Mekanik', 'slug' => 'keyboard-mekanik', 'parent_id' => $level2['Komputer & Laptop']['Keyboard & Mouse'], 'sort_order' => 1,
             'spec_template' => json_encode(['Merk', 'Koneksi', 'Tipe', 'Fitur', 'Switch']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Keyboard Biasa', 'slug' => 'keyboard-biasa', 'parent_id' => $level2['Komputer & Laptop']['Keyboard & Mouse'], 'sort_order' => 2,
             'spec_template' => json_encode(['Merk', 'Koneksi', 'Tipe', 'Fitur']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Mouse', 'slug' => 'mouse', 'parent_id' => $level2['Komputer & Laptop']['Keyboard & Mouse'], 'sort_order' => 3,
             'spec_template' => json_encode(['Merk', 'Koneksi', 'Tipe', 'Fitur', 'DPI']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Mouse Pad', 'slug' => 'mouse-pad', 'parent_id' => $level2['Komputer & Laptop']['Keyboard & Mouse'], 'sort_order' => 4,
             'spec_template' => json_encode(['Bahan', 'Ukuran', 'Ketebalan']), 'is_active' => true, 'created_at' => now()],
        ]);

        // Komponen PC
        DB::table('product_categories')->insert([
            ['name' => 'Processor', 'slug' => 'processor', 'parent_id' => $level2['Komputer & Laptop']['Komponen PC'], 'sort_order' => 1,
             'spec_template' => json_encode(['Merk', 'Tipe', 'Spesifikasi', 'Socket']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'RAM', 'slug' => 'ram', 'parent_id' => $level2['Komputer & Laptop']['Komponen PC'], 'sort_order' => 2,
             'spec_template' => json_encode(['Merk', 'Tipe', 'Spesifikasi', 'Kapasitas']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'VGA Card', 'slug' => 'vga-card', 'parent_id' => $level2['Komputer & Laptop']['Komponen PC'], 'sort_order' => 3,
             'spec_template' => json_encode(['Merk', 'Tipe', 'Spesifikasi', 'VRAM']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Motherboard', 'slug' => 'motherboard', 'parent_id' => $level2['Komputer & Laptop']['Komponen PC'], 'sort_order' => 4,
             'spec_template' => json_encode(['Merk', 'Tipe', 'Spesifikasi', 'Socket']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Storage (SSD/HDD)', 'slug' => 'storage-ssd-hdd', 'parent_id' => $level2['Komputer & Laptop']['Komponen PC'], 'sort_order' => 5,
             'spec_template' => json_encode(['Merk', 'Tipe', 'Spesifikasi', 'Kapasitas']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'PSU (Power Supply)', 'slug' => 'psu-power-supply', 'parent_id' => $level2['Komputer & Laptop']['Komponen PC'], 'sort_order' => 6,
             'spec_template' => json_encode(['Merk', 'Tipe', 'Spesifikasi', 'Daya Watt']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Casing Komputer', 'slug' => 'casing-komputer', 'parent_id' => $level2['Komputer & Laptop']['Komponen PC'], 'sort_order' => 7,
             'spec_template' => json_encode(['Merk', 'Tipe', 'Spesifikasi', 'Form Factor']), 'is_active' => true, 'created_at' => now()],
        ]);

        // Printer & Scanner
        DB::table('product_categories')->insert([
            ['name' => 'Printer Inkjet', 'slug' => 'printer-inkjet', 'parent_id' => $level2['Komputer & Laptop']['Printer & Scanner'], 'sort_order' => 1,
             'spec_template' => json_encode(['Merk', 'Tipe', 'Fitur', 'Koneksi']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Printer Laser', 'slug' => 'printer-laser', 'parent_id' => $level2['Komputer & Laptop']['Printer & Scanner'], 'sort_order' => 2,
             'spec_template' => json_encode(['Merk', 'Tipe', 'Fitur', 'Koneksi']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Printer Multifungsi', 'slug' => 'printer-multifungsi', 'parent_id' => $level2['Komputer & Laptop']['Printer & Scanner'], 'sort_order' => 3,
             'spec_template' => json_encode(['Merk', 'Tipe', 'Fitur', 'Koneksi']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Scanner', 'slug' => 'scanner', 'parent_id' => $level2['Komputer & Laptop']['Printer & Scanner'], 'sort_order' => 4,
             'spec_template' => json_encode(['Merk', 'Tipe', 'Fitur', 'Resolusi']), 'is_active' => true, 'created_at' => now()],
        ]);

        // ========== KECANTIKAN ==========

        // Perawatan Wajah
        DB::table('product_categories')->insert([
            ['name' => 'Facial Wash', 'slug' => 'facial-wash', 'parent_id' => $level2['Kecantikan']['Perawatan Wajah'], 'sort_order' => 1,
             'spec_template' => json_encode(['Formulasi', 'Manfaat Perawatan Kulit', 'Masa Penyimpanan', 'Ukuran Per Produk', 'Jenis Kulit']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Serum', 'slug' => 'serum-wajah', 'parent_id' => $level2['Kecantikan']['Perawatan Wajah'], 'sort_order' => 2,
             'spec_template' => json_encode(['Formulasi', 'Manfaat Perawatan Kulit', 'Masa Penyimpanan', 'Ukuran Per Produk', 'Kandungan Aktif']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Moisturizer', 'slug' => 'moisturizer', 'parent_id' => $level2['Kecantikan']['Perawatan Wajah'], 'sort_order' => 3,
             'spec_template' => json_encode(['Formulasi', 'Manfaat Perawatan Kulit', 'Masa Penyimpanan', 'Ukuran Per Produk', 'Jenis Kulit']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Sunscreen', 'slug' => 'sunscreen', 'parent_id' => $level2['Kecantikan']['Perawatan Wajah'], 'sort_order' => 4,
             'spec_template' => json_encode(['Formulasi', 'Manfaat Perawatan Kulit', 'Masa Penyimpanan', 'Ukuran Per Produk', 'SPF']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Masker Wajah', 'slug' => 'masker-wajah', 'parent_id' => $level2['Kecantikan']['Perawatan Wajah'], 'sort_order' => 5,
             'spec_template' => json_encode(['Formulasi', 'Manfaat Perawatan Kulit', 'Masa Penyimpanan', 'Ukuran Per Produk', 'Jumlah Masker']), 'is_active' => true, 'created_at' => now()],
        ]);

        // Makeup
        DB::table('product_categories')->insert([
            ['name' => 'Foundation', 'slug' => 'foundation', 'parent_id' => $level2['Kecantikan']['Makeup'], 'sort_order' => 1,
             'spec_template' => json_encode(['Merk', 'Jenis', 'Volume', 'Finishing', 'Shade']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Lipstik', 'slug' => 'lipstik', 'parent_id' => $level2['Kecantikan']['Makeup'], 'sort_order' => 2,
             'spec_template' => json_encode(['Merk', 'Jenis', 'Volume', 'Finishing', 'Warna']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Eyeshadow', 'slug' => 'eyeshadow', 'parent_id' => $level2['Kecantikan']['Makeup'], 'sort_order' => 3,
             'spec_template' => json_encode(['Merk', 'Jenis', 'Volume', 'Finishing', 'Jumlah Warna']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Bedak', 'slug' => 'bedak', 'parent_id' => $level2['Kecantikan']['Makeup'], 'sort_order' => 4,
             'spec_template' => json_encode(['Merk', 'Jenis', 'Volume', 'Finishing', 'Shade']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Concealer', 'slug' => 'concealer', 'parent_id' => $level2['Kecantikan']['Makeup'], 'sort_order' => 5,
             'spec_template' => json_encode(['Merk', 'Jenis', 'Volume', 'Finishing', 'Shade']), 'is_active' => true, 'created_at' => now()],
        ]);

        // Perawatan Rambut
        DB::table('product_categories')->insert([
            ['name' => 'Shampoo', 'slug' => 'shampoo', 'parent_id' => $level2['Kecantikan']['Perawatan Rambut'], 'sort_order' => 1,
             'spec_template' => json_encode(['Formulasi', 'Tipe Rambut', 'Manfaat', 'Volume']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Conditioner', 'slug' => 'conditioner', 'parent_id' => $level2['Kecantikan']['Perawatan Rambut'], 'sort_order' => 2,
             'spec_template' => json_encode(['Formulasi', 'Tipe Rambut', 'Manfaat', 'Volume']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Hair Serum', 'slug' => 'hair-serum', 'parent_id' => $level2['Kecantikan']['Perawatan Rambut'], 'sort_order' => 3,
             'spec_template' => json_encode(['Formulasi', 'Tipe Rambut', 'Manfaat', 'Volume']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Hair Styling', 'slug' => 'hair-styling', 'parent_id' => $level2['Kecantikan']['Perawatan Rambut'], 'sort_order' => 4,
             'spec_template' => json_encode(['Formulasi', 'Tipe Rambut', 'Manfaat', 'Volume', 'Level Tahan']), 'is_active' => true, 'created_at' => now()],
        ]);

        // Perawatan Tubuh
        DB::table('product_categories')->insert([
            ['name' => 'Body Wash', 'slug' => 'body-wash', 'parent_id' => $level2['Kecantikan']['Perawatan Tubuh'], 'sort_order' => 1,
             'spec_template' => json_encode(['Formulasi', 'Manfaat', 'Tipe', 'Volume']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Body Lotion', 'slug' => 'body-lotion', 'parent_id' => $level2['Kecantikan']['Perawatan Tubuh'], 'sort_order' => 2,
             'spec_template' => json_encode(['Formulasi', 'Manfaat', 'Tipe', 'Volume']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Hand & Body Cream', 'slug' => 'hand-body-cream', 'parent_id' => $level2['Kecantikan']['Perawatan Tubuh'], 'sort_order' => 3,
             'spec_template' => json_encode(['Formulasi', 'Manfaat', 'Tipe', 'Volume']), 'is_active' => true, 'created_at' => now()],
        ]);

        // Parfum
        DB::table('product_categories')->insert([
            ['name' => 'Parfum Pria', 'slug' => 'parfum-pria', 'parent_id' => $level2['Kecantikan']['Parfum'], 'sort_order' => 1,
             'spec_template' => json_encode(['Merk', 'Volume', 'Keluarga Aroma', 'Tipe', 'Ketahanan']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Parfum Wanita', 'slug' => 'parfum-wanita', 'parent_id' => $level2['Kecantikan']['Parfum'], 'sort_order' => 2,
             'spec_template' => json_encode(['Merk', 'Volume', 'Keluarga Aroma', 'Tipe', 'Ketahanan']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Parfum Unisex', 'slug' => 'parfum-unisex', 'parent_id' => $level2['Kecantikan']['Parfum'], 'sort_order' => 3,
             'spec_template' => json_encode(['Merk', 'Volume', 'Keluarga Aroma', 'Tipe', 'Ketahanan']), 'is_active' => true, 'created_at' => now()],
        ]);

        // Alat Kecantikan
        DB::table('product_categories')->insert([
            ['name' => 'Hair Dryer', 'slug' => 'hair-dryer', 'parent_id' => $level2['Kecantikan']['Alat Kecantikan'], 'sort_order' => 1,
             'spec_template' => json_encode(['Merk', 'Tipe', 'Daya', 'Fitur']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Straightener & Curler', 'slug' => 'straightener-curler', 'parent_id' => $level2['Kecantikan']['Alat Kecantikan'], 'sort_order' => 2,
             'spec_template' => json_encode(['Merk', 'Tipe', 'Daya', 'Fitur']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Facial Device', 'slug' => 'facial-device', 'parent_id' => $level2['Kecantikan']['Alat Kecantikan'], 'sort_order' => 3,
             'spec_template' => json_encode(['Merk', 'Tipe', 'Daya', 'Fitur']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Alat Cukur & Trimmer', 'slug' => 'alat-cukur-trimmer', 'parent_id' => $level2['Kecantikan']['Alat Kecantikan'], 'sort_order' => 4,
             'spec_template' => json_encode(['Merk', 'Tipe', 'Daya', 'Fitur']), 'is_active' => true, 'created_at' => now()],
        ]);

        // ========== KESEHATAN ==========

        // Suplemen & Vitamin
        DB::table('product_categories')->insert([
            ['name' => 'Vitamin', 'slug' => 'vitamin', 'parent_id' => $level2['Kesehatan']['Suplemen & Vitamin'], 'sort_order' => 1,
             'spec_template' => json_encode(['Kandungan', 'Jumlah Per Kemasan', 'Aturan Pakai', 'Sertifikasi']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Suplemen Herbal', 'slug' => 'suplemen-herbal', 'parent_id' => $level2['Kesehatan']['Suplemen & Vitamin'], 'sort_order' => 2,
             'spec_template' => json_encode(['Kandungan', 'Jumlah Per Kemasan', 'Aturan Pakai', 'Sertifikasi']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Suplemen Fitness', 'slug' => 'suplemen-fitness', 'parent_id' => $level2['Kesehatan']['Suplemen & Vitamin'], 'sort_order' => 3,
             'spec_template' => json_encode(['Kandungan', 'Jumlah Per Kemasan', 'Aturan Pakai', 'Sertifikasi', 'Rasa']), 'is_active' => true, 'created_at' => now()],
        ]);

        // Alat Kesehatan
        DB::table('product_categories')->insert([
            ['name' => 'Termometer', 'slug' => 'termometer', 'parent_id' => $level2['Kesehatan']['Alat Kesehatan'], 'sort_order' => 1,
             'spec_template' => json_encode(['Merk', 'Tipe', 'Fitur', 'Sertifikasi']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Tensi Darah', 'slug' => 'tensi-darah', 'parent_id' => $level2['Kesehatan']['Alat Kesehatan'], 'sort_order' => 2,
             'spec_template' => json_encode(['Merk', 'Tipe', 'Fitur', 'Sertifikasi']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Masker Medis', 'slug' => 'masker-medis', 'parent_id' => $level2['Kesehatan']['Alat Kesehatan'], 'sort_order' => 3,
             'spec_template' => json_encode(['Merk', 'Tipe', 'Fitur', 'Sertifikasi', 'Jumlah Per Kemasan']), 'is_active' => true, 'created_at' => now()],
        ]);

        // Obat-obatan
        DB::table('product_categories')->insert([
            ['name' => 'Obat Umum', 'slug' => 'obat-umum', 'parent_id' => $level2['Kesehatan']['Obat-obatan'], 'sort_order' => 1,
             'spec_template' => json_encode(['Kandungan Aktif', 'Jumlah', 'Aturan Pakai', 'Sertifikasi']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Obat Herbal', 'slug' => 'obat-herbal', 'parent_id' => $level2['Kesehatan']['Obat-obatan'], 'sort_order' => 2,
             'spec_template' => json_encode(['Kandungan Aktif', 'Jumlah', 'Aturan Pakai', 'Sertifikasi']), 'is_active' => true, 'created_at' => now()],
        ]);

        // ========== MAKANAN & MINUMAN ==========

        // Makanan Ringan
        DB::table('product_categories')->insert([
            ['name' => 'Camilan Asin', 'slug' => 'camilan-asin', 'parent_id' => $level2['Makanan & Minuman']['Makanan Ringan'], 'sort_order' => 1,
             'spec_template' => json_encode(['Komposisi', 'Berat Bersih', 'Kadaluarsa', 'Sertifikasi']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Camilan Manis', 'slug' => 'camilan-manis', 'parent_id' => $level2['Makanan & Minuman']['Makanan Ringan'], 'sort_order' => 2,
             'spec_template' => json_encode(['Komposisi', 'Berat Bersih', 'Kadaluarsa', 'Sertifikasi']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Coklat & Permen', 'slug' => 'coklat-permen', 'parent_id' => $level2['Makanan & Minuman']['Makanan Ringan'], 'sort_order' => 3,
             'spec_template' => json_encode(['Komposisi', 'Berat Bersih', 'Kadaluarsa', 'Sertifikasi']), 'is_active' => true, 'created_at' => now()],
        ]);

        // Makanan Berat
        DB::table('product_categories')->insert([
            ['name' => 'Makanan Instan', 'slug' => 'makanan-instan', 'parent_id' => $level2['Makanan & Minuman']['Makanan Berat'], 'sort_order' => 1,
             'spec_template' => json_encode(['Komposisi', 'Berat Bersih', 'Kadaluarsa', 'Cara Penyajian', 'Rasa']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Makanan Kaleng', 'slug' => 'makanan-kaleng', 'parent_id' => $level2['Makanan & Minuman']['Makanan Berat'], 'sort_order' => 2,
             'spec_template' => json_encode(['Komposisi', 'Berat Bersih', 'Kadaluarsa', 'Cara Penyajian']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Makanan Beku', 'slug' => 'makanan-beku', 'parent_id' => $level2['Makanan & Minuman']['Makanan Berat'], 'sort_order' => 3,
             'spec_template' => json_encode(['Komposisi', 'Berat Bersih', 'Kadaluarsa', 'Cara Penyajian']), 'is_active' => true, 'created_at' => now()],
        ]);

        // Minuman
        DB::table('product_categories')->insert([
            ['name' => 'Minuman Ringan', 'slug' => 'minuman-ringan', 'parent_id' => $level2['Makanan & Minuman']['Minuman'], 'sort_order' => 1,
             'spec_template' => json_encode(['Komposisi', 'Volume', 'Kadaluarsa', 'Rasa']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Kopi & Teh', 'slug' => 'kopi-teh', 'parent_id' => $level2['Makanan & Minuman']['Minuman'], 'sort_order' => 2,
             'spec_template' => json_encode(['Komposisi', 'Volume', 'Kadaluarsa', 'Rasa', 'Jenis']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Susu', 'slug' => 'susu-minuman', 'parent_id' => $level2['Makanan & Minuman']['Minuman'], 'sort_order' => 3,
             'spec_template' => json_encode(['Komposisi', 'Volume', 'Kadaluarsa', 'Rasa', 'Kandungan']), 'is_active' => true, 'created_at' => now()],
        ]);

        // Bahan Masak & Bumbu
        DB::table('product_categories')->insert([
            ['name' => 'Bumbu Dapur', 'slug' => 'bumbu-dapur', 'parent_id' => $level2['Makanan & Minuman']['Bahan Masak & Bumbu'], 'sort_order' => 1,
             'spec_template' => json_encode(['Komposisi', 'Berat Bersih', 'Kadaluarsa', 'Sertifikasi']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Beras & Sembako', 'slug' => 'beras-sembako', 'parent_id' => $level2['Makanan & Minuman']['Bahan Masak & Bumbu'], 'sort_order' => 2,
             'spec_template' => json_encode(['Komposisi', 'Berat Bersih', 'Kadaluarsa', 'Sertifikasi']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Minyak & Saus', 'slug' => 'minyak-saus', 'parent_id' => $level2['Makanan & Minuman']['Bahan Masak & Bumbu'], 'sort_order' => 3,
             'spec_template' => json_encode(['Komposisi', 'Volume', 'Kadaluarsa', 'Sertifikasi']), 'is_active' => true, 'created_at' => now()],
        ]);

        // ========== IBU & BAYI ==========

        // Perlengkapan Bayi
        DB::table('product_categories')->insert([
            ['name' => 'Popok & Diaper', 'slug' => 'popok-diaper', 'parent_id' => $level2['Ibu & Bayi']['Perlengkapan Bayi'], 'sort_order' => 1,
             'spec_template' => json_encode(['Bahan', 'Umur', 'Fitur', 'Merk', 'Ukuran']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Tisu & Lap Bayi', 'slug' => 'tisu-lap-bayi', 'parent_id' => $level2['Ibu & Bayi']['Perlengkapan Bayi'], 'sort_order' => 2,
             'spec_template' => json_encode(['Bahan', 'Umur', 'Fitur', 'Merk']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Botol & Dot', 'slug' => 'botol-dot', 'parent_id' => $level2['Ibu & Bayi']['Perlengkapan Bayi'], 'sort_order' => 3,
             'spec_template' => json_encode(['Bahan', 'Umur', 'Fitur', 'Merk']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Stroller', 'slug' => 'stroller', 'parent_id' => $level2['Ibu & Bayi']['Perlengkapan Bayi'], 'sort_order' => 4,
             'spec_template' => json_encode(['Bahan', 'Umur', 'Fitur', 'Merk', 'Berat Maksimal']), 'is_active' => true, 'created_at' => now()],
        ]);

        // Pakaian Bayi & Anak
        DB::table('product_categories')->insert([
            ['name' => 'Baju Bayi', 'slug' => 'baju-bayi', 'parent_id' => $level2['Ibu & Bayi']['Pakaian Bayi & Anak'], 'sort_order' => 1,
             'spec_template' => json_encode(['Bahan', 'Umur', 'Jenis', 'Perawatan', 'Ukuran']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Baju Anak', 'slug' => 'baju-anak', 'parent_id' => $level2['Ibu & Bayi']['Pakaian Bayi & Anak'], 'sort_order' => 2,
             'spec_template' => json_encode(['Bahan', 'Umur', 'Jenis', 'Perawatan', 'Ukuran']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Aksesoris Bayi', 'slug' => 'aksesoris-bayi', 'parent_id' => $level2['Ibu & Bayi']['Pakaian Bayi & Anak'], 'sort_order' => 3,
             'spec_template' => json_encode(['Bahan', 'Umur', 'Jenis', 'Perawatan']), 'is_active' => true, 'created_at' => now()],
        ]);

        // Mainan Bayi
        DB::table('product_categories')->insert([
            ['name' => 'Mainan Edukasi', 'slug' => 'mainan-edukasi-bayi', 'parent_id' => $level2['Ibu & Bayi']['Mainan Bayi'], 'sort_order' => 1,
             'spec_template' => json_encode(['Bahan', 'Umur', 'Sertifikasi']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Mainan Sensorik', 'slug' => 'mainan-sensorik-bayi', 'parent_id' => $level2['Ibu & Bayi']['Mainan Bayi'], 'sort_order' => 2,
             'spec_template' => json_encode(['Bahan', 'Umur', 'Sertifikasi']), 'is_active' => true, 'created_at' => now()],
        ]);

        // Makanan & Susu Bayi
        DB::table('product_categories')->insert([
            ['name' => 'Susu Formula', 'slug' => 'susu-formula', 'parent_id' => $level2['Ibu & Bayi']['Makanan & Susu Bayi'], 'sort_order' => 1,
             'spec_template' => json_encode(['Komposisi', 'Umur', 'Berat', 'Kadaluarsa', 'Rasa']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'MPASI', 'slug' => 'mpasi', 'parent_id' => $level2['Ibu & Bayi']['Makanan & Susu Bayi'], 'sort_order' => 2,
             'spec_template' => json_encode(['Komposisi', 'Umur', 'Berat', 'Kadaluarsa', 'Rasa']), 'is_active' => true, 'created_at' => now()],
        ]);

        // Perlengkapan Ibu
        DB::table('product_categories')->insert([
            ['name' => 'Baju Hamil', 'slug' => 'baju-hamil', 'parent_id' => $level2['Ibu & Bayi']['Perlengkapan Ibu'], 'sort_order' => 1,
             'spec_template' => json_encode(['Bahan', 'Tipe', 'Fitur', 'Merk', 'Ukuran']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Perawatan Ibu', 'slug' => 'perawatan-ibu', 'parent_id' => $level2['Ibu & Bayi']['Perlengkapan Ibu'], 'sort_order' => 2,
             'spec_template' => json_encode(['Bahan', 'Tipe', 'Fitur', 'Merk']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Pompa ASI', 'slug' => 'pompa-asi', 'parent_id' => $level2['Ibu & Bayi']['Perlengkapan Ibu'], 'sort_order' => 3,
             'spec_template' => json_encode(['Bahan', 'Tipe', 'Fitur', 'Merk', 'Daya']), 'is_active' => true, 'created_at' => now()],
        ]);

        // ========== OLAHRAGA & OUTDOOR ==========

        // Pakaian Olahraga
        DB::table('product_categories')->insert([
            ['name' => 'Baju Olahraga', 'slug' => 'baju-olahraga', 'parent_id' => $level2['Olahraga & Outdoor']['Pakaian Olahraga'], 'sort_order' => 1,
             'spec_template' => json_encode(['Bahan', 'Tipe', 'Fitur', 'Jenis Olahraga']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Celana Olahraga', 'slug' => 'celana-olahraga', 'parent_id' => $level2['Olahraga & Outdoor']['Pakaian Olahraga'], 'sort_order' => 2,
             'spec_template' => json_encode(['Bahan', 'Tipe', 'Fitur', 'Jenis Olahraga']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Jaket Olahraga', 'slug' => 'jaket-olahraga', 'parent_id' => $level2['Olahraga & Outdoor']['Pakaian Olahraga'], 'sort_order' => 3,
             'spec_template' => json_encode(['Bahan', 'Tipe', 'Fitur', 'Jenis Olahraga', 'Ketebalan']), 'is_active' => true, 'created_at' => now()],
        ]);

        // Sepatu Olahraga
        DB::table('product_categories')->insert([
            ['name' => 'Sepatu Lari', 'slug' => 'sepatu-lari', 'parent_id' => $level2['Olahraga & Outdoor']['Sepatu Olahraga'], 'sort_order' => 1,
             'spec_template' => json_encode(['Bahan', 'Tipe', 'Sol', 'Jenis Olahraga']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Sepatu Basket', 'slug' => 'sepatu-basket', 'parent_id' => $level2['Olahraga & Outdoor']['Sepatu Olahraga'], 'sort_order' => 2,
             'spec_template' => json_encode(['Bahan', 'Tipe', 'Sol', 'Jenis Olahraga']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Sepatu Futsal', 'slug' => 'sepatu-futsal', 'parent_id' => $level2['Olahraga & Outdoor']['Sepatu Olahraga'], 'sort_order' => 3,
             'spec_template' => json_encode(['Bahan', 'Tipe', 'Sol', 'Jenis Olahraga']), 'is_active' => true, 'created_at' => now()],
        ]);

        // Alat Fitness
        DB::table('product_categories')->insert([
            ['name' => 'Dumbbell & Barbel', 'slug' => 'dumbbell-barbel', 'parent_id' => $level2['Olahraga & Outdoor']['Alat Fitness'], 'sort_order' => 1,
             'spec_template' => json_encode(['Bahan', 'Berat Maksimal', 'Fitur', 'Merk']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Matras Yoga', 'slug' => 'matras-yoga', 'parent_id' => $level2['Olahraga & Outdoor']['Alat Fitness'], 'sort_order' => 2,
             'spec_template' => json_encode(['Bahan', 'Berat Maksimal', 'Fitur', 'Merk', 'Ukuran']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Resistance Band', 'slug' => 'resistance-band', 'parent_id' => $level2['Olahraga & Outdoor']['Alat Fitness'], 'sort_order' => 3,
             'spec_template' => json_encode(['Bahan', 'Berat Maksimal', 'Fitur', 'Merk', 'Level']), 'is_active' => true, 'created_at' => now()],
        ]);

        // Alat Olahraga
        DB::table('product_categories')->insert([
            ['name' => 'Bola Olahraga', 'slug' => 'bola-olahraga', 'parent_id' => $level2['Olahraga & Outdoor']['Alat Olahraga'], 'sort_order' => 1,
             'spec_template' => json_encode(['Bahan', 'Tipe', 'Jenis Olahraga', 'Merk', 'Ukuran']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Raket', 'slug' => 'raket', 'parent_id' => $level2['Olahraga & Outdoor']['Alat Olahraga'], 'sort_order' => 2,
             'spec_template' => json_encode(['Bahan', 'Tipe', 'Jenis Olahraga', 'Merk', 'Berat']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Perlengkapan Renang', 'slug' => 'perlengkapan-renang', 'parent_id' => $level2['Olahraga & Outdoor']['Alat Olahraga'], 'sort_order' => 3,
             'spec_template' => json_encode(['Bahan', 'Tipe', 'Jenis Olahraga', 'Merk']), 'is_active' => true, 'created_at' => now()],
        ]);

        // Camping & Hiking
        DB::table('product_categories')->insert([
            ['name' => 'Tenda', 'slug' => 'tenda', 'parent_id' => $level2['Olahraga & Outdoor']['Camping & Hiking'], 'sort_order' => 1,
             'spec_template' => json_encode(['Bahan', 'Kapasitas', 'Berat', 'Fitur', 'Tahan Air']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Sleeping Bag', 'slug' => 'sleeping-bag', 'parent_id' => $level2['Olahraga & Outdoor']['Camping & Hiking'], 'sort_order' => 2,
             'spec_template' => json_encode(['Bahan', 'Kapasitas', 'Berat', 'Fitur']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Perlengkapan Hiking', 'slug' => 'perlengkapan-hiking', 'parent_id' => $level2['Olahraga & Outdoor']['Camping & Hiking'], 'sort_order' => 3,
             'spec_template' => json_encode(['Bahan', 'Kapasitas', 'Berat', 'Fitur']), 'is_active' => true, 'created_at' => now()],
        ]);

        // Sepeda
        DB::table('product_categories')->insert([
            ['name' => 'Sepeda Gunung', 'slug' => 'sepeda-gunung', 'parent_id' => $level2['Olahraga & Outdoor']['Sepeda'], 'sort_order' => 1,
             'spec_template' => json_encode(['Merk', 'Tipe', 'Ukuran Roda', 'Fitur', 'Jumlah Gigi']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Sepeda Lipat', 'slug' => 'sepeda-lipat', 'parent_id' => $level2['Olahraga & Outdoor']['Sepeda'], 'sort_order' => 2,
             'spec_template' => json_encode(['Merk', 'Tipe', 'Ukuran Roda', 'Fitur', 'Jumlah Gigi']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Sepeda Balap', 'slug' => 'sepeda-balap', 'parent_id' => $level2['Olahraga & Outdoor']['Sepeda'], 'sort_order' => 3,
             'spec_template' => json_encode(['Merk', 'Tipe', 'Ukuran Roda', 'Fitur', 'Jumlah Gigi']), 'is_active' => true, 'created_at' => now()],
        ]);

        // ========== OTOMOTIF ==========

        // Aksesoris Mobil
        DB::table('product_categories')->insert([
            ['name' => 'Sarung Jok', 'slug' => 'sarung-jok-mobil', 'parent_id' => $level2['Otomotif']['Aksesoris Mobil'], 'sort_order' => 1,
             'spec_template' => json_encode(['Bahan', 'Tipe', 'Merk Mobil']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Karpet Mobil', 'slug' => 'karpet-mobil', 'parent_id' => $level2['Otomotif']['Aksesoris Mobil'], 'sort_order' => 2,
             'spec_template' => json_encode(['Bahan', 'Tipe', 'Merk Mobil']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Pengharum Mobil', 'slug' => 'pengharum-mobil', 'parent_id' => $level2['Otomotif']['Aksesoris Mobil'], 'sort_order' => 3,
             'spec_template' => json_encode(['Bahan', 'Tipe', 'Merk Mobil', 'Aroma']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Dekorasi Mobil', 'slug' => 'dekorasi-mobil', 'parent_id' => $level2['Otomotif']['Aksesoris Mobil'], 'sort_order' => 4,
             'spec_template' => json_encode(['Bahan', 'Tipe', 'Merk Mobil']), 'is_active' => true, 'created_at' => now()],
        ]);

        // Aksesoris Motor
        DB::table('product_categories')->insert([
            ['name' => 'Helm', 'slug' => 'helm-motor', 'parent_id' => $level2['Otomotif']['Aksesoris Motor'], 'sort_order' => 1,
             'spec_template' => json_encode(['Bahan', 'Tipe', 'Sertifikasi', 'Fitur']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Sarung Tangan', 'slug' => 'sarung-tangan-motor', 'parent_id' => $level2['Otomotif']['Aksesoris Motor'], 'sort_order' => 2,
             'spec_template' => json_encode(['Bahan', 'Tipe', 'Merk Motor']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Cover Motor', 'slug' => 'cover-motor', 'parent_id' => $level2['Otomotif']['Aksesoris Motor'], 'sort_order' => 3,
             'spec_template' => json_encode(['Bahan', 'Tipe', 'Merk Motor']), 'is_active' => true, 'created_at' => now()],
        ]);

        // Helm (Level 2 -> Leaf sudah ada di atas, jadi ini helm di bawah aksesoris motor)
        // Oli & Cairan
        DB::table('product_categories')->insert([
            ['name' => 'Oli Mesin', 'slug' => 'oli-mesin', 'parent_id' => $level2['Otomotif']['Oli & Cairan'], 'sort_order' => 1,
             'spec_template' => json_encode(['Merk', 'Volume', 'Tipe', 'Spesifikasi']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Cairan Pendingin', 'slug' => 'cairan-pendingin', 'parent_id' => $level2['Otomotif']['Oli & Cairan'], 'sort_order' => 2,
             'spec_template' => json_encode(['Merk', 'Volume', 'Tipe', 'Spesifikasi']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Cairan Rem', 'slug' => 'cairan-rem', 'parent_id' => $level2['Otomotif']['Oli & Cairan'], 'sort_order' => 3,
             'spec_template' => json_encode(['Merk', 'Volume', 'Tipe', 'Spesifikasi']), 'is_active' => true, 'created_at' => now()],
        ]);

        // ========== PERLENGKAPAN RUMAH ==========

        // Peralatan Dapur
        DB::table('product_categories')->insert([
            ['name' => 'Panci & Wajan', 'slug' => 'panci-wajan', 'parent_id' => $level2['Perlengkapan Rumah']['Peralatan Dapur'], 'sort_order' => 1,
             'spec_template' => json_encode(['Bahan', 'Ukuran', 'Fitur', 'Merk']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Pisau Dapur', 'slug' => 'pisau-dapur', 'parent_id' => $level2['Perlengkapan Rumah']['Peralatan Dapur'], 'sort_order' => 2,
             'spec_template' => json_encode(['Bahan', 'Ukuran', 'Fitur', 'Merk', 'Jumlah Set']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Alat Masak Kecil', 'slug' => 'alat-masak-kecil', 'parent_id' => $level2['Perlengkapan Rumah']['Peralatan Dapur'], 'sort_order' => 3,
             'spec_template' => json_encode(['Bahan', 'Ukuran', 'Fitur', 'Merk']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Tempat Penyimpanan Makanan', 'slug' => 'tempat-penyimpanan-makanan', 'parent_id' => $level2['Perlengkapan Rumah']['Peralatan Dapur'], 'sort_order' => 4,
             'spec_template' => json_encode(['Bahan', 'Ukuran', 'Fitur', 'Merk']), 'is_active' => true, 'created_at' => now()],
        ]);

        // Peralatan Makan
        DB::table('product_categories')->insert([
            ['name' => 'Piring & Mangkuk', 'slug' => 'piring-mangkuk', 'parent_id' => $level2['Perlengkapan Rumah']['Peralatan Makan'], 'sort_order' => 1,
             'spec_template' => json_encode(['Bahan', 'Jumlah Isi', 'Fitur', 'Warna']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Gelas & Cangkir', 'slug' => 'gelas-cangkir', 'parent_id' => $level2['Perlengkapan Rumah']['Peralatan Makan'], 'sort_order' => 2,
             'spec_template' => json_encode(['Bahan', 'Jumlah Isi', 'Fitur', 'Volume']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Cutlery (Sendok/Garpu/Pisau)', 'slug' => 'cutlery-set', 'parent_id' => $level2['Perlengkapan Rumah']['Peralatan Makan'], 'sort_order' => 3,
             'spec_template' => json_encode(['Bahan', 'Jumlah Isi', 'Fitur']), 'is_active' => true, 'created_at' => now()],
        ]);

        // Dekorasi Rumah
        DB::table('product_categories')->insert([
            ['name' => 'Vas & Pot Bunga', 'slug' => 'vas-pot-bunga', 'parent_id' => $level2['Perlengkapan Rumah']['Dekorasi Rumah'], 'sort_order' => 1,
             'spec_template' => json_encode(['Bahan', 'Ukuran', 'Tipe', 'Gaya']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Hiasan Dinding', 'slug' => 'hiasan-dinding', 'parent_id' => $level2['Perlengkapan Rumah']['Dekorasi Rumah'], 'sort_order' => 2,
             'spec_template' => json_encode(['Bahan', 'Ukuran', 'Tipe', 'Gaya']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Jam Dinding', 'slug' => 'jam-dinding', 'parent_id' => $level2['Perlengkapan Rumah']['Dekorasi Rumah'], 'sort_order' => 3,
             'spec_template' => json_encode(['Bahan', 'Ukuran', 'Tipe', 'Gaya']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Bantal & Karpet', 'slug' => 'bantal-karpet', 'parent_id' => $level2['Perlengkapan Rumah']['Dekorasi Rumah'], 'sort_order' => 4,
             'spec_template' => json_encode(['Bahan', 'Ukuran', 'Tipe', 'Gaya']), 'is_active' => true, 'created_at' => now()],
        ]);

        // Peralatan Kebersihan
        DB::table('product_categories')->insert([
            ['name' => 'Alat Pel & Sapu', 'slug' => 'alat-pel-sapu', 'parent_id' => $level2['Perlengkapan Rumah']['Peralatan Kebersihan'], 'sort_order' => 1,
             'spec_template' => json_encode(['Bahan', 'Tipe', 'Fitur', 'Merk']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Kain Lap & Spons', 'slug' => 'kain-lap-spons', 'parent_id' => $level2['Perlengkapan Rumah']['Peralatan Kebersihan'], 'sort_order' => 2,
             'spec_template' => json_encode(['Bahan', 'Tipe', 'Fitur', 'Merk']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Pembersih Lantai', 'slug' => 'pembersih-lantai', 'parent_id' => $level2['Perlengkapan Rumah']['Peralatan Kebersihan'], 'sort_order' => 3,
             'spec_template' => json_encode(['Bahan', 'Tipe', 'Fitur', 'Merk', 'Volume']), 'is_active' => true, 'created_at' => now()],
        ]);

        // Penyimpanan & Organizer
        DB::table('product_categories')->insert([
            ['name' => 'Rak & Lemari', 'slug' => 'rak-lemari', 'parent_id' => $level2['Perlengkapan Rumah']['Penyimpanan & Organizer'], 'sort_order' => 1,
             'spec_template' => json_encode(['Bahan', 'Ukuran', 'Fitur']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Box & Kotak Penyimpanan', 'slug' => 'box-kotak-penyimpanan', 'parent_id' => $level2['Perlengkapan Rumah']['Penyimpanan & Organizer'], 'sort_order' => 2,
             'spec_template' => json_encode(['Bahan', 'Ukuran', 'Fitur']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Hanger & Gantungan', 'slug' => 'hanger-gantungan', 'parent_id' => $level2['Perlengkapan Rumah']['Penyimpanan & Organizer'], 'sort_order' => 3,
             'spec_template' => json_encode(['Bahan', 'Ukuran', 'Fitur', 'Jumlah']), 'is_active' => true, 'created_at' => now()],
        ]);

        // Elektronik Rumah Tangga
        DB::table('product_categories')->insert([
            ['name' => 'Kipas Angin', 'slug' => 'kipas-angin', 'parent_id' => $level2['Perlengkapan Rumah']['Elektronik Rumah Tangga'], 'sort_order' => 1,
             'spec_template' => json_encode(['Merk', 'Daya', 'Fitur', 'Garansi']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'AC (Pendingin Ruangan)', 'slug' => 'ac-pendingin-ruangan', 'parent_id' => $level2['Perlengkapan Rumah']['Elektronik Rumah Tangga'], 'sort_order' => 2,
             'spec_template' => json_encode(['Merk', 'Daya (PK)', 'Fitur', 'Garansi']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Kulkas', 'slug' => 'kulkas', 'parent_id' => $level2['Perlengkapan Rumah']['Elektronik Rumah Tangga'], 'sort_order' => 3,
             'spec_template' => json_encode(['Merk', 'Daya', 'Fitur', 'Garansi', 'Kapasitas']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Mesin Cuci', 'slug' => 'mesin-cuci', 'parent_id' => $level2['Perlengkapan Rumah']['Elektronik Rumah Tangga'], 'sort_order' => 4,
             'spec_template' => json_encode(['Merk', 'Daya', 'Fitur', 'Garansi', 'Kapasitas']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Microwave & Oven', 'slug' => 'microwave-oven', 'parent_id' => $level2['Perlengkapan Rumah']['Elektronik Rumah Tangga'], 'sort_order' => 5,
             'spec_template' => json_encode(['Merk', 'Daya', 'Fitur', 'Garansi']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Rice Cooker', 'slug' => 'rice-cooker', 'parent_id' => $level2['Perlengkapan Rumah']['Elektronik Rumah Tangga'], 'sort_order' => 6,
             'spec_template' => json_encode(['Merk', 'Daya', 'Fitur', 'Garansi', 'Kapasitas']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Vacuum Cleaner', 'slug' => 'vacuum-cleaner', 'parent_id' => $level2['Perlengkapan Rumah']['Elektronik Rumah Tangga'], 'sort_order' => 7,
             'spec_template' => json_encode(['Merk', 'Daya', 'Fitur', 'Garansi', 'Daya Hisap']), 'is_active' => true, 'created_at' => now()],
        ]);

        // Lampu & Pencahayaan
        DB::table('product_categories')->insert([
            ['name' => 'Lampu LED', 'slug' => 'lampu-led', 'parent_id' => $level2['Perlengkapan Rumah']['Lampu & Pencahayaan'], 'sort_order' => 1,
             'spec_template' => json_encode(['Merk', 'Daya', 'Tipe', 'Warna Cahaya', 'Ukuran']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Lampu Hias', 'slug' => 'lampu-hias', 'parent_id' => $level2['Perlengkapan Rumah']['Lampu & Pencahayaan'], 'sort_order' => 2,
             'spec_template' => json_encode(['Merk', 'Daya', 'Tipe', 'Warna Cahaya', 'Gaya']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Lampu Darurat', 'slug' => 'lampu-darurat', 'parent_id' => $level2['Perlengkapan Rumah']['Lampu & Pencahayaan'], 'sort_order' => 3,
             'spec_template' => json_encode(['Merk', 'Daya', 'Tipe', 'Fitur', 'Baterai']), 'is_active' => true, 'created_at' => now()],
        ]);

        // ========== MAINAN & HOBI ==========

        // Mainan Anak
        DB::table('product_categories')->insert([
            ['name' => 'Mainan Mobil-mobilan', 'slug' => 'mainan-mobil', 'parent_id' => $level2['Mainan & Hobi']['Mainan Anak'], 'sort_order' => 1,
             'spec_template' => json_encode(['Bahan', 'Umur', 'Sertifikasi']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Boneka', 'slug' => 'boneka', 'parent_id' => $level2['Mainan & Hobi']['Mainan Anak'], 'sort_order' => 2,
             'spec_template' => json_encode(['Bahan', 'Umur', 'Sertifikasi', 'Tinggi']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Mainan STEM', 'slug' => 'mainan-stem', 'parent_id' => $level2['Mainan & Hobi']['Mainan Anak'], 'sort_order' => 3,
             'spec_template' => json_encode(['Bahan', 'Umur', 'Sertifikasi']), 'is_active' => true, 'created_at' => now()],
        ]);

        // Action Figure & Koleksi
        DB::table('product_categories')->insert([
            ['name' => 'Action Figure', 'slug' => 'action-figure', 'parent_id' => $level2['Mainan & Hobi']['Action Figure & Koleksi'], 'sort_order' => 1,
             'spec_template' => json_encode(['Bahan', 'Tinggi', 'Merk', 'Tahun Rilis']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Model Kit', 'slug' => 'model-kit', 'parent_id' => $level2['Mainan & Hobi']['Action Figure & Koleksi'], 'sort_order' => 2,
             'spec_template' => json_encode(['Bahan', 'Tinggi', 'Merk', 'Tahun Rilis', 'Level Kesulitan']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Miniatur', 'slug' => 'miniatur', 'parent_id' => $level2['Mainan & Hobi']['Action Figure & Koleksi'], 'sort_order' => 3,
             'spec_template' => json_encode(['Bahan', 'Tinggi', 'Merk', 'Tahun Rilis']), 'is_active' => true, 'created_at' => now()],
        ]);

        // Puzzle & Board Game
        DB::table('product_categories')->insert([
            ['name' => 'Puzzle', 'slug' => 'puzzle', 'parent_id' => $level2['Mainan & Hobi']['Puzzle & Board Game'], 'sort_order' => 1,
             'spec_template' => json_encode(['Bahan', 'Jumlah Pcs', 'Umur', 'Merk']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Board Game', 'slug' => 'board-game', 'parent_id' => $level2['Mainan & Hobi']['Puzzle & Board Game'], 'sort_order' => 2,
             'spec_template' => json_encode(['Bahan', 'Jumlah Pcs', 'Umur', 'Merk', 'Jumlah Pemain']), 'is_active' => true, 'created_at' => now()],
        ]);

        // ========== BUKU & ALAT TULIS ==========

        // Buku
        DB::table('product_categories')->insert([
            ['name' => 'Novel & Fiksi', 'slug' => 'novel-fiksi', 'parent_id' => $level2['Buku & Alat Tulis']['Buku'], 'sort_order' => 1,
             'spec_template' => json_encode(['Format', 'Bahasa', 'Jumlah Halaman', 'Penerbit', 'Genre']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Buku Pendidikan', 'slug' => 'buku-pendidikan', 'parent_id' => $level2['Buku & Alat Tulis']['Buku'], 'sort_order' => 2,
             'spec_template' => json_encode(['Format', 'Bahasa', 'Jumlah Halaman', 'Penerbit']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Komik & Manga', 'slug' => 'komik-manga', 'parent_id' => $level2['Buku & Alat Tulis']['Buku'], 'sort_order' => 3,
             'spec_template' => json_encode(['Format', 'Bahasa', 'Jumlah Halaman', 'Penerbit', 'Volume']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Buku Agama', 'slug' => 'buku-agama', 'parent_id' => $level2['Buku & Alat Tulis']['Buku'], 'sort_order' => 4,
             'spec_template' => json_encode(['Format', 'Bahasa', 'Jumlah Halaman', 'Penerbit']), 'is_active' => true, 'created_at' => now()],
        ]);

        // Alat Tulis
        DB::table('product_categories')->insert([
            ['name' => 'Pulpen & Pensil', 'slug' => 'pulpen-pensil', 'parent_id' => $level2['Buku & Alat Tulis']['Alat Tulis'], 'sort_order' => 1,
             'spec_template' => json_encode(['Bahan', 'Tipe', 'Merk', 'Warna Tinta']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Buku Tulis & Buku Catatan', 'slug' => 'buku-tulis-catatan', 'parent_id' => $level2['Buku & Alat Tulis']['Alat Tulis'], 'sort_order' => 2,
             'spec_template' => json_encode(['Bahan', 'Tipe', 'Merk', 'Jumlah Halaman', 'Ukuran']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Stabilo & Spidol', 'slug' => 'stabilo-spidol', 'parent_id' => $level2['Buku & Alat Tulis']['Alat Tulis'], 'sort_order' => 3,
             'spec_template' => json_encode(['Bahan', 'Tipe', 'Merk', 'Jumlah Warna']), 'is_active' => true, 'created_at' => now()],
        ]);

        // Peralatan Seni
        DB::table('product_categories')->insert([
            ['name' => 'Cat & Kuas', 'slug' => 'cat-kuas', 'parent_id' => $level2['Buku & Alat Tulis']['Peralatan Seni'], 'sort_order' => 1,
             'spec_template' => json_encode(['Bahan', 'Tipe', 'Merk', 'Jumlah Warna']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Kanvas & Kertas Seni', 'slug' => 'kanvas-kertas-seni', 'parent_id' => $level2['Buku & Alat Tulis']['Peralatan Seni'], 'sort_order' => 2,
             'spec_template' => json_encode(['Bahan', 'Tipe', 'Merk', 'Ukuran']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Alat Mewarnai', 'slug' => 'alat-mewarnai', 'parent_id' => $level2['Buku & Alat Tulis']['Peralatan Seni'], 'sort_order' => 3,
             'spec_template' => json_encode(['Bahan', 'Tipe', 'Merk', 'Jumlah Warna']), 'is_active' => true, 'created_at' => now()],
        ]);

        // ========== PERAWATAN HEWAN ==========

        // Makanan Hewan
        DB::table('product_categories')->insert([
            ['name' => 'Makanan Anjing', 'slug' => 'makanan-anjing', 'parent_id' => $level2['Perawatan Hewan']['Makanan Hewan'], 'sort_order' => 1,
             'spec_template' => json_encode(['Komposisi', 'Berat', 'Jenis Hewan', 'Usia Hewan', 'Rasa']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Makanan Kucing', 'slug' => 'makanan-kucing', 'parent_id' => $level2['Perawatan Hewan']['Makanan Hewan'], 'sort_order' => 2,
             'spec_template' => json_encode(['Komposisi', 'Berat', 'Jenis Hewan', 'Usia Hewan', 'Rasa']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Makanan Ikan', 'slug' => 'makanan-ikan', 'parent_id' => $level2['Perawatan Hewan']['Makanan Hewan'], 'sort_order' => 3,
             'spec_template' => json_encode(['Komposisi', 'Berat', 'Jenis Hewan', 'Usia Hewan']), 'is_active' => true, 'created_at' => now()],
        ]);

        // Perlengkapan Hewan
        DB::table('product_categories')->insert([
            ['name' => 'Kandang & Tempat Tidur', 'slug' => 'kandang-tempat-tidur-hewan', 'parent_id' => $level2['Perawatan Hewan']['Perlengkapan Hewan'], 'sort_order' => 1,
             'spec_template' => json_encode(['Bahan', 'Ukuran', 'Jenis Hewan']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Mainan Hewan', 'slug' => 'mainan-hewan', 'parent_id' => $level2['Perawatan Hewan']['Perlengkapan Hewan'], 'sort_order' => 2,
             'spec_template' => json_encode(['Bahan', 'Ukuran', 'Jenis Hewan']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Peralatan Mandi & Grooming', 'slug' => 'peralatan-mandi-grooming', 'parent_id' => $level2['Perawatan Hewan']['Perlengkapan Hewan'], 'sort_order' => 3,
             'spec_template' => json_encode(['Bahan', 'Ukuran', 'Jenis Hewan']), 'is_active' => true, 'created_at' => now()],
        ]);

        // Kandang & Akuarium
        DB::table('product_categories')->insert([
            ['name' => 'Kandang Hewan', 'slug' => 'kandang-hewan', 'parent_id' => $level2['Perawatan Hewan']['Kandang & Akuarium'], 'sort_order' => 1,
             'spec_template' => json_encode(['Bahan', 'Ukuran', 'Jenis Hewan', 'Fitur']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Akuarium', 'slug' => 'akuarium', 'parent_id' => $level2['Perawatan Hewan']['Kandang & Akuarium'], 'sort_order' => 2,
             'spec_template' => json_encode(['Bahan', 'Ukuran', 'Jenis Hewan', 'Fitur', 'Volume']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Terrarium', 'slug' => 'terrarium', 'parent_id' => $level2['Perawatan Hewan']['Kandang & Akuarium'], 'sort_order' => 3,
             'spec_template' => json_encode(['Bahan', 'Ukuran', 'Jenis Hewan', 'Fitur']), 'is_active' => true, 'created_at' => now()],
        ]);

        // Lainnya (tanpa parent)
        DB::table('product_categories')->insert([
            'name' => 'Lainnya', 'slug' => 'lainnya', 'sort_order' => 99,
            'spec_template' => null, 'parent_id' => null, 'is_active' => true, 'created_at' => now()
        ]);
    }

    public function down()
    {
        DB::table('product_categories')->truncate();
    }
};
