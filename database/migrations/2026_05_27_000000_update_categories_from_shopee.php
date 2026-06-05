<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Hapus foreign key constraint temporarily
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

        // Insert kategori baru sesuai standar Shopee Indonesia
        DB::table('product_categories')->insert([
            // Fashion
            ['name' => 'Atasan Pria', 'slug' => 'atasan-pria', 'sort_order' => 1, 'spec_template' => json_encode(['Bahan', 'Ukuran', 'Warna', 'Lengan']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Bawahan Pria', 'slug' => 'bawahan-pria', 'sort_order' => 2, 'spec_template' => json_encode(['Bahan', 'Ukuran', 'Warna', 'Model']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Jaket & Outer Pria', 'slug' => 'jaket-outer-pria', 'sort_order' => 3, 'spec_template' => json_encode(['Bahan', 'Ukuran', 'Warna', 'Tipe']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Atasan Wanita', 'slug' => 'atasan-wanita', 'sort_order' => 4, 'spec_template' => json_encode(['Bahan', 'Ukuran', 'Warna', 'Lengan']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Bawahan Wanita', 'slug' => 'bawahan-wanita', 'sort_order' => 5, 'spec_template' => json_encode(['Bahan', 'Ukuran', 'Warna', 'Model']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Jaket & Outer Wanita', 'slug' => 'jaket-outer-wanita', 'sort_order' => 6, 'spec_template' => json_encode(['Bahan', 'Ukuran', 'Warna', 'Tipe']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Dress & Rok', 'slug' => 'dress-rok', 'sort_order' => 7, 'spec_template' => json_encode(['Bahan', 'Ukuran', 'Warna', 'Panjang']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Hijab & Perlengkapan', 'slug' => 'hijab-perlengkapan', 'sort_order' => 8, 'spec_template' => json_encode(['Bahan', 'Ukuran', 'Warna', 'Jenis']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Baju Muslim', 'slug' => 'baju-muslim', 'sort_order' => 9, 'spec_template' => json_encode(['Bahan', 'Ukuran', 'Warna', 'Model']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Muslim Wanita', 'slug' => 'muslim-wanita', 'sort_order' => 10, 'spec_template' => json_encode(['Bahan', 'Ukuran', 'Warna', 'Model']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Pakaian Dalam', 'slug' => 'pakaian-dalam', 'sort_order' => 11, 'spec_template' => json_encode(['Bahan', 'Ukuran', 'Warna', 'Tipe']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Batik & Kain Tradisional', 'slug' => 'batik-kain-tradisional', 'sort_order' => 12, 'spec_template' => json_encode(['Bahan', 'Ukuran', 'Motif', 'Jenis']), 'is_active' => true, 'created_at' => now()],

            // Tas
            ['name' => 'Tas Wanita', 'slug' => 'tas-wanita', 'sort_order' => 13, 'spec_template' => json_encode(['Bahan', 'Ukuran', 'Warna', 'Model']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Tas Pria', 'slug' => 'tas-pria', 'sort_order' => 14, 'spec_template' => json_encode(['Bahan', 'Ukuran', 'Warna', 'Tipe']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Ransel & Backpack', 'slug' => 'ransel-backpack', 'sort_order' => 15, 'spec_template' => json_encode(['Bahan', 'Kapasitas', 'Fitur', 'Warna']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Dompet & Kartu', 'slug' => 'dompet-kartu', 'sort_order' => 16, 'spec_template' => json_encode(['Bahan', 'Ukuran', 'Warna', 'Jumlah Slot']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Koper & Travel', 'slug' => 'koper-travel', 'sort_order' => 17, 'spec_template' => json_encode(['Bahan', 'Ukuran', 'Berat', 'Roda']), 'is_active' => true, 'created_at' => now()],

            // Sepatu
            ['name' => 'Sepatu Pria', 'slug' => 'sepatu-pria', 'sort_order' => 18, 'spec_template' => json_encode(['Bahan', 'Ukuran', 'Warna', 'Tipe']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Sepatu Wanita', 'slug' => 'sepatu-wanita', 'sort_order' => 19, 'spec_template' => json_encode(['Bahan', 'Ukuran', 'Warna', 'Tinggi Hak']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Sneakers', 'slug' => 'sneakers', 'sort_order' => 20, 'spec_template' => json_encode(['Bahan', 'Ukuran', 'Warna', 'Sol']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Sandal & Flip Flop', 'slug' => 'sandal-flipflop', 'sort_order' => 21, 'spec_template' => json_encode(['Bahan', 'Ukuran', 'Warna', 'Tipe']), 'is_active' => true, 'created_at' => now()],

            // Jam Tangan & Aksesoris
            ['name' => 'Jam Tangan Pria', 'slug' => 'jam-tangan-pria', 'sort_order' => 22, 'spec_template' => json_encode(['Merek', 'Material', 'Gerak', 'Ketahanan Air']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Jam Tangan Wanita', 'slug' => 'jam-tangan-wanita', 'sort_order' => 23, 'spec_template' => json_encode(['Merek', 'Material', 'Gerak', 'Ketahanan Air']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Smartwatch', 'slug' => 'smartwatch', 'sort_order' => 24, 'spec_template' => json_encode(['Merek', 'Fitur', 'Layar', 'Baterai']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Aksesoris Fashion', 'slug' => 'aksesoris-fashion', 'sort_order' => 25, 'spec_template' => json_encode(['Bahan', 'Warna', 'Tipe']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Perhiasan', 'slug' => 'perhiasan', 'sort_order' => 26, 'spec_template' => json_encode(['Bahan', 'Berat', 'Warna', 'Sertifikasi']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Kacamata', 'slug' => 'kacamata', 'sort_order' => 27, 'spec_template' => json_encode(['Bahan', 'Warna', 'Lensa', 'Model']), 'is_active' => true, 'created_at' => now()],

            // Handphone & Tablet
            ['name' => 'Handphone', 'slug' => 'handphone', 'sort_order' => 28, 'spec_template' => json_encode(['Merek', 'RAM', 'ROM', 'Ukuran Layar', 'Baterai']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Tablet', 'slug' => 'tablet', 'sort_order' => 29, 'spec_template' => json_encode(['Merek', 'RAM', 'ROM', 'Ukuran Layar']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Casing & Pelindung HP', 'slug' => 'casing-pelindung-hp', 'sort_order' => 30, 'spec_template' => json_encode(['Bahan', 'Model HP', 'Warna', 'Fitur']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Charger & Kabel', 'slug' => 'charger-kabel', 'sort_order' => 31, 'spec_template' => json_encode(['Tipe', 'Panjang', 'Daya', 'Merek']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Powerbank', 'slug' => 'powerbank', 'sort_order' => 32, 'spec_template' => json_encode(['Kapasitas', 'Port', 'Fitur', 'Merek']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Headset & Earphone', 'slug' => 'headset-earphone', 'sort_order' => 33, 'spec_template' => json_encode(['Tipe', 'Koneksi', 'Fitur', 'Merek']), 'is_active' => true, 'created_at' => now()],

            // Elektronik
            ['name' => 'TV & Audio', 'slug' => 'tv-audio', 'sort_order' => 34, 'spec_template' => json_encode(['Merek', 'Ukuran', 'Fitur', 'Daya']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Kamera', 'slug' => 'kamera', 'sort_order' => 35, 'spec_template' => json_encode(['Merek', 'Resolusi', 'Tipe', 'Fitur']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Speaker & Soundbar', 'slug' => 'speaker-soundbar', 'sort_order' => 36, 'spec_template' => json_encode(['Merek', 'Daya', 'Koneksi', 'Fitur']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Game Console', 'slug' => 'game-console', 'sort_order' => 37, 'spec_template' => json_encode(['Merek', 'Model', 'Kapasitas', 'Kelengkapan']), 'is_active' => true, 'created_at' => now()],

            // Komputer & Laptop
            ['name' => 'Laptop', 'slug' => 'laptop', 'sort_order' => 38, 'spec_template' => json_encode(['Merek', 'Prosesor', 'RAM', 'Penyimpanan', 'Ukuran Layar']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'PC Desktop', 'slug' => 'pc-desktop', 'sort_order' => 39, 'spec_template' => json_encode(['Prosesor', 'RAM', 'Penyimpanan', 'GPU']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Monitor', 'slug' => 'monitor', 'sort_order' => 40, 'spec_template' => json_encode(['Merek', 'Ukuran', 'Resolusi', 'Refresh Rate']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Keyboard & Mouse', 'slug' => 'keyboard-mouse', 'sort_order' => 41, 'spec_template' => json_encode(['Merek', 'Koneksi', 'Tipe', 'Fitur']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Komponen Komputer', 'slug' => 'komponen-komputer', 'sort_order' => 42, 'spec_template' => json_encode(['Merek', 'Tipe', 'Spesifikasi']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Printer & Scanner', 'slug' => 'printer-scanner', 'sort_order' => 43, 'spec_template' => json_encode(['Merek', 'Tipe', 'Fitur', 'Koneksi']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Aksesoris Komputer', 'slug' => 'aksesoris-komputer', 'sort_order' => 44, 'spec_template' => json_encode(['Merek', 'Tipe', 'Fitur']), 'is_active' => true, 'created_at' => now()],

            // Kecantikan
            ['name' => 'Skincare & Wajah', 'slug' => 'skincare-wajah', 'sort_order' => 45, 'spec_template' => json_encode(['Kandungan', 'Volume', 'Jenis Kulit', 'Cara Pakai']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Makeup', 'slug' => 'makeup', 'sort_order' => 46, 'spec_template' => json_encode(['Merek', 'Warna', 'Volume', 'Tipe']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Perawatan Rambut', 'slug' => 'perawatan-rambut', 'sort_order' => 47, 'spec_template' => json_encode(['Kandungan', 'Volume', 'Tipe Rambut', 'Cara Pakai']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Perawatan Tubuh', 'slug' => 'perawatan-tubuh', 'sort_order' => 48, 'spec_template' => json_encode(['Kandungan', 'Volume', 'Tipe', 'Cara Pakai']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Parfum & Fragrance', 'slug' => 'parfum-fragrance', 'sort_order' => 49, 'spec_template' => json_encode(['Merek', 'Volume', 'Aroma', 'Tipe']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Alat Kecantikan', 'slug' => 'alat-kecantikan', 'sort_order' => 50, 'spec_template' => json_encode(['Merek', 'Tipe', 'Daya', 'Fitur']), 'is_active' => true, 'created_at' => now()],

            // Kesehatan
            ['name' => 'Suplemen & Vitamin', 'slug' => 'suplemen-vitamin', 'sort_order' => 51, 'spec_template' => json_encode(['Kandungan', 'Jumlah', 'Aturan Pakai', 'Sertifikasi']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Alat Kesehatan', 'slug' => 'alat-kesehatan', 'sort_order' => 52, 'spec_template' => json_encode(['Merek', 'Tipe', 'Fitur', 'Sertifikasi']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Obat-obatan', 'slug' => 'obat-obatan', 'sort_order' => 53, 'spec_template' => json_encode(['Kandungan', 'Jumlah', 'Aturan Pakai', 'Sertifikasi']), 'is_active' => true, 'created_at' => now()],

            // Makanan & Minuman
            ['name' => 'Makanan Ringan', 'slug' => 'makanan-ringan', 'sort_order' => 54, 'spec_template' => json_encode(['Komposisi', 'Berat', 'Kadaluarsa', 'Sertifikasi']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Makanan Berat', 'slug' => 'makanan-berat', 'sort_order' => 55, 'spec_template' => json_encode(['Komposisi', 'Berat', 'Kadaluarsa', 'Cara Saji']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Minuman', 'slug' => 'minuman', 'sort_order' => 56, 'spec_template' => json_encode(['Komposisi', 'Volume', 'Kadaluarsa', 'Rasa']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Bahan Masak & Bumbu', 'slug' => 'bahan-masak-bumbu', 'sort_order' => 57, 'spec_template' => json_encode(['Komposisi', 'Berat', 'Kadaluarsa', 'Sertifikasi']), 'is_active' => true, 'created_at' => now()],

            // Ibu & Bayi
            ['name' => 'Perlengkapan Bayi', 'slug' => 'perlengkapan-bayi', 'sort_order' => 58, 'spec_template' => json_encode(['Bahan', 'Ukuran', 'Umur', 'Merek']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Pakaian Bayi & Anak', 'slug' => 'pakaian-bayi-anak', 'sort_order' => 59, 'spec_template' => json_encode(['Bahan', 'Ukuran', 'Umur', 'Warna']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Mainan Bayi', 'slug' => 'mainan-bayi', 'sort_order' => 60, 'spec_template' => json_encode(['Bahan', 'Umur', 'Sertifikasi']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Makanan Bayi', 'slug' => 'makanan-bayi', 'sort_order' => 61, 'spec_template' => json_encode(['Komposisi', 'Umur', 'Berat', 'Kadaluarsa']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Perlengkapan Ibu Hamil', 'slug' => 'perlengkapan-ibu-hamil', 'sort_order' => 62, 'spec_template' => json_encode(['Bahan', 'Ukuran', 'Tipe', 'Merek']), 'is_active' => true, 'created_at' => now()],

            // Olahraga & Outdoor
            ['name' => 'Pakaian Olahraga', 'slug' => 'pakaian-olahraga', 'sort_order' => 63, 'spec_template' => json_encode(['Bahan', 'Ukuran', 'Warna', 'Tipe']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Sepatu Olahraga', 'slug' => 'sepatu-olahraga', 'sort_order' => 64, 'spec_template' => json_encode(['Bahan', 'Ukuran', 'Warna', 'Tipe']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Alat Fitness & Gym', 'slug' => 'alat-fitness-gym', 'sort_order' => 65, 'spec_template' => json_encode(['Bahan', 'Berat', 'Fitur', 'Merek']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Alat Olahraga', 'slug' => 'alat-olahraga', 'sort_order' => 66, 'spec_template' => json_encode(['Bahan', 'Ukuran', 'Tipe', 'Merek']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Camping & Hiking', 'slug' => 'camping-hiking', 'sort_order' => 67, 'spec_template' => json_encode(['Bahan', 'Ukuran', 'Berat', 'Fitur']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Sepeda & Aksesoris', 'slug' => 'sepeda-aksesoris', 'sort_order' => 68, 'spec_template' => json_encode(['Merek', 'Ukuran', 'Tipe', 'Fitur']), 'is_active' => true, 'created_at' => now()],

            // Otomotif
            ['name' => 'Aksesoris Mobil', 'slug' => 'aksesoris-mobil', 'sort_order' => 69, 'spec_template' => json_encode(['Bahan', 'Tipe', 'Warna', 'Merek']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Aksesoris Motor', 'slug' => 'aksesoris-motor', 'sort_order' => 70, 'spec_template' => json_encode(['Bahan', 'Tipe', 'Warna', 'Merek']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Helm', 'slug' => 'helm', 'sort_order' => 71, 'spec_template' => json_encode(['Bahan', 'Ukuran', 'Warna', 'Sertifikasi']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Oli & Cairan Kendaraan', 'slug' => 'oli-cairan-kendaraan', 'sort_order' => 72, 'spec_template' => json_encode(['Merek', 'Volume', 'Tipe', 'Spesifikasi']), 'is_active' => true, 'created_at' => now()],

            // Rumah Tangga
            ['name' => 'Peralatan Dapur', 'slug' => 'peralatan-dapur', 'sort_order' => 73, 'spec_template' => json_encode(['Bahan', 'Ukuran', 'Merek', 'Fitur']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Peralatan Makan & Minum', 'slug' => 'peralatan-makan-minum', 'sort_order' => 74, 'spec_template' => json_encode(['Bahan', 'Ukuran', 'Warna', 'Isi']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Dekorasi Rumah', 'slug' => 'dekorasi-rumah', 'sort_order' => 75, 'spec_template' => json_encode(['Bahan', 'Ukuran', 'Warna', 'Tipe']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Peralatan Kebersihan', 'slug' => 'peralatan-kebersihan', 'sort_order' => 76, 'spec_template' => json_encode(['Bahan', 'Ukuran', 'Tipe', 'Merek']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Penyimpanan & Organizer', 'slug' => 'penyimpanan-organizer', 'sort_order' => 77, 'spec_template' => json_encode(['Bahan', 'Ukuran', 'Warna', 'Fitur']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Elektronik Rumah Tangga', 'slug' => 'elektronik-rumah-tangga', 'sort_order' => 78, 'spec_template' => json_encode(['Merek', 'Daya', 'Fitur', 'Garansi']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Lampu & Pencahayaan', 'slug' => 'lampu-pencahayaan', 'sort_order' => 79, 'spec_template' => json_encode(['Merek', 'Daya', 'Warna', 'Tipe']), 'is_active' => true, 'created_at' => now()],

            // Mainan & Hobi
            ['name' => 'Mainan Anak', 'slug' => 'mainan-anak', 'sort_order' => 80, 'spec_template' => json_encode(['Bahan', 'Umur', 'Ukuran', 'Sertifikasi']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Action Figure & Koleksi', 'slug' => 'action-figure-koleksi', 'sort_order' => 81, 'spec_template' => json_encode(['Bahan', 'Ukuran', 'Merek', 'Tahun Rilis']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Puzzle & Board Game', 'slug' => 'puzzle-board-game', 'sort_order' => 82, 'spec_template' => json_encode(['Bahan', 'Jumlah', 'Umur', 'Merek']), 'is_active' => true, 'created_at' => now()],

            // Buku & Alat Tulis
            ['name' => 'Buku', 'slug' => 'buku', 'sort_order' => 83, 'spec_template' => json_encode(['Format', 'Bahasa', 'Halaman', 'Penerbit']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Alat Tulis & Stationery', 'slug' => 'alat-tulis-stationery', 'sort_order' => 84, 'spec_template' => json_encode(['Bahan', 'Warna', 'Tipe', 'Merek']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Peralatan Seni & Lukis', 'slug' => 'peralatan-seni-lukis', 'sort_order' => 85, 'spec_template' => json_encode(['Bahan', 'Ukuran', 'Tipe', 'Merek']), 'is_active' => true, 'created_at' => now()],

            // Petshop
            ['name' => 'Makanan Hewan', 'slug' => 'makanan-hewan', 'sort_order' => 86, 'spec_template' => json_encode(['Komposisi', 'Berat', 'Jenis Hewan', 'Umur']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Perlengkapan Hewan', 'slug' => 'perlengkapan-hewan', 'sort_order' => 87, 'spec_template' => json_encode(['Bahan', 'Ukuran', 'Jenis Hewan', 'Warna']), 'is_active' => true, 'created_at' => now()],
            ['name' => 'Kandang & Akuarium', 'slug' => 'kandang-akuarium', 'sort_order' => 88, 'spec_template' => json_encode(['Bahan', 'Ukuran', 'Jenis Hewan', 'Fitur']), 'is_active' => true, 'created_at' => now()],

            // Lainnya
            ['name' => 'Lainnya', 'slug' => 'lainnya', 'sort_order' => 99, 'spec_template' => null, 'is_active' => true, 'created_at' => now()],
        ]);
    }

    public function down()
    {
        // Kembalikan ke data awal jika rollback
        DB::table('product_categories')->truncate();
        DB::table('product_categories')->insert([
            ['name' => 'Fashion Wanita', 'slug' => 'fashion-wanita', 'sort_order' => 1, 'spec_template' => json_encode(['Bahan', 'Ukuran', 'Warna', 'Perawatan']), 'created_at' => now()],
            ['name' => 'Fashion Pria', 'slug' => 'fashion-pria', 'sort_order' => 2, 'spec_template' => json_encode(['Bahan', 'Ukuran', 'Warna', 'Tipe']), 'created_at' => now()],
            ['name' => 'Fashion Muslim', 'slug' => 'fashion-muslim', 'sort_order' => 3, 'spec_template' => json_encode(['Bahan', 'Ukuran', 'Warna', 'Motif']), 'created_at' => now()],
        ]);
    }
};