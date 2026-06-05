<?php
// database/migrations/2025_01_01_000001_create_product_categories_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('product_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama kategori
            $table->string('slug')->unique(); // slug untuk URL
            $table->text('description')->nullable(); // deskripsi kategori
            $table->json('spec_template')->nullable(); // template spesifikasi
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->foreignId('parent_id')->nullable()->constrained('product_categories')->onDelete('cascade');
            $table->timestamps();
        });

        // Insert default categories (sudah direvisi)
        DB::table('product_categories')->insert([
            // Fashion
            ['name' => 'Fashion Wanita', 'slug' => 'fashion-wanita', 'sort_order' => 1, 'spec_template' => json_encode(['Bahan', 'Ukuran', 'Warna', 'Perawatan']), 'created_at' => now()],
            ['name' => 'Fashion Pria', 'slug' => 'fashion-pria', 'sort_order' => 2, 'spec_template' => json_encode(['Bahan', 'Ukuran', 'Warna', 'Tipe']), 'created_at' => now()],
            ['name' => 'Fashion Muslim', 'slug' => 'fashion-muslim', 'sort_order' => 3, 'spec_template' => json_encode(['Bahan', 'Ukuran', 'Warna', 'Motif']), 'created_at' => now()],
            // Tas & Sepatu
            ['name' => 'Tas Wanita', 'slug' => 'tas-wanita', 'sort_order' => 4, 'spec_template' => json_encode(['Bahan', 'Ukuran', 'Berat', 'Warna', 'Kompartemen']), 'created_at' => now()],
            ['name' => 'Tas Pria', 'slug' => 'tas-pria', 'sort_order' => 5, 'spec_template' => json_encode(['Bahan', 'Ukuran', 'Kompartemen', 'Fitur']), 'created_at' => now()],
            ['name' => 'Sepatu Wanita', 'slug' => 'sepatu-wanita', 'sort_order' => 6, 'spec_template' => json_encode(['Bahan', 'Ukuran', 'Warna', 'Sol']), 'created_at' => now()],
            ['name' => 'Sepatu Pria', 'slug' => 'sepatu-pria', 'sort_order' => 7, 'spec_template' => json_encode(['Bahan', 'Ukuran', 'Warna', 'Tipe']), 'created_at' => now()],
            ['name' => 'Jam Tangan', 'slug' => 'jam-tangan', 'sort_order' => 8, 'spec_template' => json_encode(['Tempat Produksi', 'Baterai', 'Ketahanan Air', 'Material']), 'created_at' => now()],
            ['name' => 'Aksesoris Fashion', 'slug' => 'aksesoris-fashion', 'sort_order' => 9, 'spec_template' => json_encode(['Bahan', 'Ukuran/Dimensi', 'Sertifikasi']), 'created_at' => now()],
            // Kecantikan & Kesehatan
            ['name' => 'Perawatan & Kecantikan', 'slug' => 'perawatan-kecantikan', 'sort_order' => 10, 'spec_template' => json_encode(['Kandungan', 'Volume', 'Cara Pakai', 'Sertifikasi']), 'created_at' => now()],
            ['name' => 'Ibu & Bayi', 'slug' => 'ibu-bayi', 'sort_order' => 11, 'spec_template' => json_encode(['Umur', 'Ukuran', 'Bahan']), 'created_at' => now()],
            ['name' => 'Kesehatan', 'slug' => 'kesehatan', 'sort_order' => 12, 'spec_template' => json_encode(['Kandungan', 'Volume', 'Cara Pakai', 'Sertifikasi']), 'created_at' => now()],
            // Makanan
            ['name' => 'Makanan & Minuman', 'slug' => 'makanan-minuman', 'sort_order' => 13, 'spec_template' => json_encode(['Komposisi', 'Berat Bersih', 'Kadaluarsa', 'Sertifikasi']), 'created_at' => now()],
            // Elektronik & Komputer
            ['name' => 'Handphone & Aksesoris', 'slug' => 'handphone-aksesoris', 'sort_order' => 14, 'spec_template' => json_encode(['Model', 'Garansi', 'Kemasan']), 'created_at' => now()],
            ['name' => 'Elektronik & Komputer', 'slug' => 'elektronik-komputer', 'sort_order' => 15, 'spec_template' => json_encode(['Model', 'Garansi', 'Kelengkapan']), 'created_at' => now()],
            // Rumah Tangga & Hobi
            ['name' => 'Peralatan Rumah', 'slug' => 'peralatan-rumah', 'sort_order' => 16, 'spec_template' => json_encode(['Bahan', 'Ukuran', 'Tata Cara']), 'created_at' => now()],
            ['name' => 'Olahraga & Outdoor', 'slug' => 'olahraga-outdoor', 'sort_order' => 17, 'spec_template' => json_encode(['Bahan', 'Ukuran', 'Garansi']), 'created_at' => now()],
            ['name' => 'Otomotif & Aksesoris', 'slug' => 'otomotif-aksesoris', 'sort_order' => 18, 'spec_template' => json_encode(['Spesifikasi', 'Garansi']), 'created_at' => now()],
            ['name' => 'Mainan & Hobi', 'slug' => 'mainan-hobi', 'sort_order' => 19, 'spec_template' => json_encode(['Bahan', 'Ukuran', 'Umur']), 'created_at' => now()],
            ['name' => 'Buku & Alat Tulis', 'slug' => 'buku-alat-tulis', 'sort_order' => 20, 'spec_template' => json_encode(['Format', 'Bahasa', 'Jumlah Halaman']), 'created_at' => now()],
            ['name' => 'Petshop', 'slug' => 'petshop', 'sort_order' => 21, 'spec_template' => json_encode(['Komposisi', 'Berat', 'Umur Hewan']), 'created_at' => now()],
            ['name' => 'Lainnya', 'slug' => 'lainnya', 'sort_order' => 99, 'spec_template' => null, 'created_at' => now()],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('product_categories');
    }
};