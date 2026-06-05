<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShopeeCategoryCodesSeeder extends Seeder
{
    public function run()
    {
        // Mapping kategori leaf name -> shopee_code
        // Format: 'Category Name' => 'kode_kategori'
        $codes = [
            // ==================== PAKAIAN PRIA - ATASAN ====================
            'Kaos' => '100244',
            'Kemeja Kasual' => '100242',
            'Polo' => '100243',
            'Kemeja Formal' => '100242',
            'Sweater & Hoodie' => '100049',
            'Rompi' => '100231',
            'Koko/Pakaian Muslim' => '100306',
            
            // ==================== PAKAIAN PRIA - BAWAHAN ====================
            'Celana Chino' => '100240',
            'Celana Jeans' => '100047',
            'Celana Pendek' => '100053',
            'Celana Formal' => '100235',
            'Celana Cargo' => '100238',
            
            // ==================== PAKAIAN PRIA - JAKET & OUTERWEAR ====================
            'Jaket Denim' => '100230',
            'Jaket Bomber' => '100230',
            'Jaket Hoodie' => '100228',
            'Jaket Parka' => '100229',
            'Jas & Blazer' => '100234',
            'Rompi Outerwear' => '100231',
            
            // ==================== PAKAIAN PRIA - PAKAIAN DALAM ====================
            'Boxer' => '100247',
            'Singlet' => '100248',
            'Kaus Kaki' => '100062',
            
            // ==================== PAKAIAN WANITA - ATASAN ====================
            'Kaos Wanita' => '100352',
            'Kemeja Wanita' => '100353',
            'Blouse' => '100353',
            'Kardigan' => '100108',
            'Sweater & Hoodie Wanita' => '100374',
            
            // ==================== PAKAIAN WANITA - BAWAHAN ====================
            'Celana Panjang' => '100358',
            'Celana Pendek Wanita' => '100360',
            'Legging' => '100357',
            'Rok Bawahan' => '100102',
            
            // ==================== PAKAIAN WANITA - DRESS & ROK ====================
            'Dress Kasual' => '100104',
            'Dress Formal' => '100104',
            'Rok Panjang' => '100102',
            'Rok Pendek' => '100102',
            
            // ==================== PAKAIAN WANITA - JAKET & OUTERWEAR ====================
            'Jaket Denim Wanita' => '100370',
            'Jaket Bomber Wanita' => '100370',
            'Jaket Hoodie Wanita' => '100374',
            'Jas & Blazer Wanita' => '100369',
            
            // ==================== PAKAIAN WANITA - PAKAIAN DALAM ====================
            'Bra' => '100381',
            'Panties' => '100382',
            'Set Innerwear' => '100380',
            'Kaus Kaki Wanita' => '100417',
            
            // ==================== FASHION MUSLIM - HIJAB ====================
            'Hijab Segi Empat' => '100494',
            'Pashmina' => '100495',
            'Bergo & Instan' => '100493',
            'Ciput & Ninja' => '100527',
            
            // ==================== FASHION MUSLIM - BAJU MUSLIM PRIA ====================
            'Koko Pria' => '100306',
            'Sarung' => '100309',
            'Peci & Kopiah' => '100302',
            
            // ==================== FASHION MUSLIM - BAJU MUSLIM WANITA ====================
            'Gamis' => '100505',
            'Mukena' => '100303',
            'Tunik' => '100501',
            
            // ==================== TAS - TAS WANITA ====================
            'Tas Selempang' => '100095',
            'Tas Tangan' => '100094',
            'Tas Punggung Wanita' => '100089',
            'Clutch Wanita' => '100091',
            'Tas Pinggang Wanita' => '100092',
            
            // ==================== TAS - TAS PRIA ====================
            'Tas Selempang Pria' => '100570',
            'Tas Punggung Pria' => '100564',
            'Tas Pinggang Pria' => '100569',
            'Tas Kerja' => '100567',
            
            // ==================== TAS - RANSEL ====================
            'Ransel Sekolah' => '100564',
            'Ransel Laptop' => '100606',
            'Ransel Travel' => '100564',
            
            // ==================== TAS - DOMPET ====================
            'Dompet Pria' => '100611',
            'Dompet Wanita' => '100341',
            'Card Holder' => '100338',
            'Money Belt' => '100569',
            
            // ==================== TAS - KOPER & TRAVEL ====================
            'Koper Kabin' => '100085',
            'Koper Besar' => '100085',
            'Travel Bag' => '100320',
            'Tas Rias' => '100321',
            
            // ==================== SEPATU PRIA ====================
            'Sepatu Formal Pria' => '100066',
            'Sepatu Kasual Pria' => '100065',
            'Boots Pria' => '100255',
            
            // ==================== SEPATU WANITA ====================
            'Sepatu Hak Tinggi' => '100559',
            'Sepatu Datar Wanita' => '100588',
            'Boots Wanita' => '100586',
            
            // ==================== SNEAKERS ====================
            'Sneakers Pria' => '100064',
            'Sneakers Wanita' => '100557',
            'Sneakers Unisex' => '100064',
            
            // ==================== SANDAL & FLIP FLOP ====================
            'Sandal Pria' => '100259',
            'Sandal Wanita' => '100594',
            'Flip Flop' => '100259',
            
            // ==================== JAM TANGAN ====================
            'Jam Tangan Kasual Pria' => '100574',
            'Jam Tangan Formal Pria' => '100574',
            'Jam Tangan Olahraga Pria' => '100574',
            'Jam Tangan Kasual Wanita' => '100573',
            'Jam Tangan Formal Wanita' => '100573',
            'Jam Tangan Fashion Wanita' => '100573',
            'Smartwatch Pria' => '100270',
            'Smartwatch Wanita' => '100270',
            'Smartband' => '100270',
            
            // ==================== AKSESORIS FASHION ====================
            'Kalung' => '100029',
            'Gelang' => '100026',
            'Cincin' => '100021',
            'Anting' => '100022',
            'Kacamata Hitam' => '100151',
            'Kacamata Baca' => '100152',
            'Kacamata Olahraga' => '100151',
            'Jepit Rambut' => '100147',
            'Ikat Rambut' => '100146',
            'Bando' => '100145',
            'Ikat Pinggang Pria' => '100032',
            'Ikat Pinggang Wanita' => '100032',
            
            // ==================== HANDPHONE & AKSESORIS ====================
            'Smartphone' => '100073',
            'Feature Phone' => '100073',
            'Tablet Android' => '100072',
            'iPad' => '100072',
            'Casing HP' => '100490',
            'Tempered Glass' => '100289',
            'Casing Tablet' => '100489',
            'Charger Kepala' => '100482',
            'Kabel Data' => '100481',
            'Wireless Charger' => '100482',
            'Powerbank Standar' => '100486',
            'Powerbank Fast Charging' => '100486',
            'Powerbank Solar' => '100486',
            'Earphone Kabel' => '100578',
            'TWS (True Wireless)' => '100578',
            'Headphone' => '100578',
            
            // ==================== ELEKTRONIK ====================
            'Smart TV' => '100185',
            'TV Biasa' => '100185',
            'Home Theater' => '100626',
            'DSLR' => '100098',
            'Mirrorless' => '100093',
            'Kamera Saku' => '100092',
            'Action Camera' => '100094',
            'Speaker Portable' => '100625',
            'Soundbar' => '100625',
            'Speaker Bluetooth' => '100625',
            'PlayStation' => '100073',
            'Xbox' => '100074',
            'Nintendo' => '100078',
            'Game Controller' => '100696',
            
            // ==================== KOMPUTER & LAPTOP ====================
            'Laptop Gaming' => '100942',
            'Laptop Kantor' => '100942',
            'MacBook' => '100942',
            'Chromebook' => '100942',
            'PC Gaming' => '100944',
            'PC Kantor' => '100944',
            'All-in-One PC' => '100947',
            'Monitor Gaming' => '100933',
            'Monitor Kantor' => '100933',
            'Monitor IPS' => '100933',
            'Keyboard Mekanik' => '100999',
            'Keyboard Biasa' => '100999',
            'Mouse' => '100998',
            'Mouse Pad' => '100996',
            'Processor' => '100950',
            'RAM' => '100955',
            'VGA Card' => '100952',
            'Motherboard' => '100951',
            'Storage (SSD/HDD)' => '100961',
            'PSU (Power Supply)' => '100954',
            'Casing Komputer' => '100957',
            'Printer Inkjet' => '100982',
            'Printer Laser' => '100982',
            'Printer Multifungsi' => '100982',
            'Scanner' => '100982',
            
            // ==================== KECANTIKAN ====================
            'Facial Wash' => '100891',
            'Serum Wajah' => '100896',
            'Moisturizer' => '100893',
            'Sunscreen' => '100901',
            'Masker Wajah' => '100898',
            'Foundation' => '100628',
            'Lipstik' => '100642',
            'Eyeshadow' => '100636',
            'Bedak' => '100630',
            'Concealer' => '100631',
            'Shampoo' => '100869',
            'Conditioner' => '100872',
            'Hair Serum' => '100871',
            'Hair Styling' => '100873',
            'Body Wash' => '100003',
            'Body Lotion' => '100007',
            'Hand & Body Cream' => '100007',
            'Parfum Pria' => '100661',
            'Parfum Wanita' => '100661',
            'Parfum Unisex' => '100661',
            'Hair Dryer' => '100665',
            'Straightener & Curler' => '100666',
            'Facial Device' => '100661',
            'Alat Cukur & Trimmer' => '100624',
            
            // ==================== KESEHATAN ====================
            'Vitamin' => '100005',
            'Suplemen Herbal' => '100007',
            'Suplemen Fitness' => '100005',
            'Termometer' => '100423',
            'Tensi Darah' => '100420',
            'Masker Medis' => '100128',
            'Obat Umum' => '100126',
            'Obat Herbal' => '100120',
            
            // ==================== MAKANAN & MINUMAN ====================
            'Camilan Asin' => '100788',
            'Camilan Manis' => '100787',
            'Coklat & Permen' => '100786',
            'Makanan Instan' => '100782',
            'Makanan Kaleng' => '100800',
            'Makanan Beku' => '100855',
            'Minuman Ringan' => '100831',
            'Kopi & Teh' => '100824',
            'Susu' => '100594',
            'Bumbu Dapur' => '100808',
            'Beras & Sembako' => '100798',
            'Minyak & Saus' => '100803',
            
            // ==================== IBU & BAYI ====================
            'Popok & Diaper' => '100003',
            'Tisu & Lap Bayi' => '100975',
            'Botol & Dot' => '100958',
            'Stroller' => '100946',
            'Baju Bayi' => '100025',
            'Baju Anak' => '100041',
            'Aksesoris Bayi' => '100038',
            'Mainan Edukasi' => '100013',
            'Mainan Sensorik' => '100013',
            'Susu Formula' => '100991',
            'MPASI' => '100992',
            'Baju Hamil' => '100394',
            'Perawatan Ibu' => '100966',
            'Pompa ASI' => '100697',
            
            // ==================== OLAHRAGA & OUTDOOR ====================
            'Baju Olahraga' => '100311',
            'Celana Olahraga' => '100313',
            'Jaket Olahraga' => '100310',
            'Sepatu Lari' => '100299',
            'Sepatu Basket' => '100298',
            'Sepatu Futsal' => '100304',
            'Dumbbell & Barbel' => '100893',
            'Matras Yoga' => '100886',
            'Resistance Band' => '100888',
            'Bola Olahraga' => '100847',
            'Raket' => '100857',
            'Perlengkapan Renang' => '100885',
            'Tenda' => '100828',
            'Sleeping Bag' => '100831',
            'Perlengkapan Hiking' => '100828',
            'Sepeda Gunung' => '100824',
            'Sepeda Lipat' => '100824',
            'Sepeda Balap' => '100824',
            
            // ==================== OTOMOTIF ====================
            'Sarung Jok' => '100423',
            'Karpet Mobil' => '100421',
            'Pengharum Mobil' => '100418',
            'Dekorasi Mobil' => '100432',
            'Helm' => '100758',
            'Sarung Tangan Motor' => '100758',
            'Cover Motor' => '100475',
            'Oli Mesin' => '100467',
            'Cairan Pendingin' => '100470',
            'Cairan Rem' => '100471',
            
            // ==================== PERLENGKAPAN RUMAH ====================
            'Panci & Wajan' => '100218',
            'Pisau Dapur' => '100228',
            'Alat Masak Kecil' => '100218',
            'Tempat Penyimpanan Makanan' => '100220',
            'Piring & Mangkuk' => '100243',
            'Gelas & Cangkir' => '100240',
            'Cutlery Set' => '100244',
            'Vas & Pot Bunga' => '100161',
            'Hiasan Dinding' => '100156',
            'Jam Dinding' => '100158',
            'Bantal & Karpet' => '100160',
            'Alat Pel & Sapu' => '100202',
            'Kain Lap & Spons' => '100201',
            'Pembersih Lantai' => '100213',
            'Rak & Lemari' => '100174',
            'Box & Kotak Penyimpanan' => '100254',
            'Hanger & Gantungan' => '100253',
            'Kipas Angin' => '100466',
            'AC (Pendingin Ruangan)' => '100464',
            'Kulkas' => '100209',
            'Mesin Cuci' => '100461',
            'Microwave & Oven' => '100200',
            'Rice Cooker' => '100207',
            'Vacuum Cleaner' => '100177',
            'Lampu LED' => '100719',
            'Lampu Hias' => '100719',
            'Lampu Darurat' => '100719',
            
            // ==================== MAINAN & HOBI ====================
            'Mainan Mobil-mobilan' => '100407',
            'Boneka' => '100720',
            'Mainan STEM' => '100734',
            'Action Figure' => '100385',
            'Model Kit' => '100387',
            'Miniatur' => '100388',
            'Puzzle' => '100736',
            'Board Game' => '100400',
            
            // ==================== BUKU & ALAT TULIS ====================
            'Novel & Fiksi' => '100541',
            'Buku Pendidikan' => '100568',
            'Komik & Manga' => '100540',
            'Buku Agama' => '100564',
            'Pulpen & Pensil' => '100337',
            'Buku Tulis & Buku Catatan' => '100378',
            'Stabilo & Spidol' => '100340',
            'Cat & Kuas' => '100365',
            'Kanvas & Kertas Seni' => '100368',
            'Alat Mewarnai' => '100361',
            
            // ==================== PERAWATAN HEWAN ====================
            'Makanan Anjing' => '100906',
            'Makanan Kucing' => '100908',
            'Makanan Ikan' => '100912',
            'Kandang & Tempat Tidur Hewan' => '100684',
            'Mainan Hewan' => '100678',
            'Peralatan Mandi & Grooming' => '100929',
            'Kandang Hewan' => '100684',
            'Akuarium' => '100921',
            'Terrarium' => '100684',
        ];

        foreach ($codes as $name => $code) {
            DB::table('product_categories')
                ->where('name', $name)
                ->whereNotNull('parent_id') // Only leaf categories
                ->whereNotNull('spec_template') // Has spec_template = leaf
                ->update(['shopee_code' => $code]);
        }
    }
}