<?php

namespace App\Services;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

class ExportService
{
    public function exportToShopeeExcel($products)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Shopee Mass Upload');
        
        // Headers sesuai template Shopee
        $headers = [
            'A' => 'Kategori',
            'B' => 'Nama Produk',
            'C' => 'Deskripsi Produk',
            'D' => 'SKU Induk',
            'E' => 'Kode Integrasi Variasi',
            'F' => 'Nama Variasi 1',
            'G' => 'Varian untuk Variasi 1',
            'H' => 'Foto Produk per Varian',
            'I' => 'Nama Variasi 2',
            'J' => 'Varian untuk Variasi 2',
            'K' => 'Harga',
            'L' => 'Stok',
            'M' => 'Kode Variasi',
            'N' => 'HS Code',
            'O' => 'Tax Code',
            'P' => 'Foto Sampul',
            'Q' => 'Foto Produk 1',
            'R' => 'Foto Produk 2',
            'S' => 'Foto Produk 3',
            'T' => 'Foto Produk 4',
            'U' => 'Foto Produk 5',
            'V' => 'Foto Produk 6',
            'W' => 'Foto Produk 7',
            'X' => 'Foto Produk 8',
            'Y' => 'Berat',
            'Z' => 'Panjang',
            'AA' => 'Lebar',
            'AB' => 'Tinggi',
            'AC' => 'Jasa Kirim 1',
            'AD' => 'Jasa Kirim 2',
            'AE' => 'Jasa Kirim 3',
            'AF' => 'Jangka Dikirim Dalam',
            'AG' => 'Dikirim Dalam Pre-order',
            'AH' => 'Merek',
        ];
        
        // Define header rows metadata (Row 1: Title, Row 2: Mandatory status, Row 3: Description, Row 4: Constraint)
        $headersMetadata = [
            'A' => ['Kategori', 'Wajib', 'Kategori yang tepat membantu pembeli menemukan produk Anda dengan mudah.', 'Karakter (Min 1, Maks 19, Angka saja)'],
            'B' => ['Nama Produk', 'Wajib', 'Tulis nama produk yang lengkap, jelas, dan informatif.', 'Karakter (Min 10, Maks 120)'],
            'C' => ['Deskripsi Produk', 'Wajib', 'Berikan informasi detail mengenai produk Anda.', 'Karakter (Min 20, Maks 3000)'],
            'D' => ['SKU Induk', 'Pilihan', 'Kode unik untuk mengelompokkan produk utama.', 'Karakter (Min 0, Maks 40)'],
            'E' => ['Kode Integrasi Variasi', 'Pilihan', 'Kode integrasi variasi untuk produk.', 'Karakter (Min 0, Maks 40)'],
            'F' => ['Nama Variasi 1', 'Pilihan', 'Nama variasi pertama (misal: Ukuran, Warna).', 'Karakter (Min 0, Maks 14)'],
            'G' => ['Varian untuk Variasi 1', 'Pilihan', 'Pilihan nilai variasi pertama (misal: S, M, L / Merah, Biru).', 'Karakter (Min 0, Maks 20)'],
            'H' => ['Foto Produk per Varian', 'Pilihan', 'Tautan URL foto untuk setiap pilihan variasi pertama.', 'Tautan Gambar (Maks 1)'],
            'I' => ['Nama Variasi 2', 'Pilihan', 'Nama variasi kedua (misal: Warna).', 'Karakter (Min 0, Maks 14)'],
            'J' => ['Varian untuk Variasi 2', 'Pilihan', 'Pilihan nilai variasi kedua (misal: Merah, Biru).', 'Karakter (Min 0, Maks 20)'],
            'K' => ['Harga', 'Wajib', 'Harga jual produk dalam Rupiah.', 'Angka saja'],
            'L' => ['Stok', 'Wajib', 'Jumlah stok produk yang tersedia.', 'Angka saja'],
            'M' => ['Kode Variasi', 'Pilihan', 'SKU khusus untuk variasi tertentu.', 'Karakter (Min 0, Maks 40)'],
            'N' => ['HS Code', 'Pilihan', 'Harmonized System Code untuk perdagangan internasional.', 'Karakter (Min 0, Maks 10)'],
            'O' => ['Tax Code', 'Pilihan', 'Kode pajak produk.', 'Karakter (Min 0, Maks 10)'],
            'P' => ['Foto Sampul', 'Wajib', 'Foto utama produk (URL publik).', 'Tautan Gambar (Wajib 1)'],
            'Q' => ['Foto Produk 1', 'Pilihan', 'Foto tambahan produk ke-1.', 'Tautan Gambar (Pilihan)'],
            'R' => ['Foto Produk 2', 'Pilihan', 'Foto tambahan produk ke-2.', 'Tautan Gambar (Pilihan)'],
            'S' => ['Foto Produk 3', 'Pilihan', 'Foto tambahan produk ke-3.', 'Tautan Gambar (Pilihan)'],
            'T' => ['Foto Produk 4', 'Pilihan', 'Foto tambahan produk ke-4.', 'Tautan Gambar (Pilihan)'],
            'U' => ['Foto Produk 5', 'Pilihan', 'Foto tambahan produk ke-5.', 'Tautan Gambar (Pilihan)'],
            'V' => ['Foto Produk 6', 'Pilihan', 'Foto tambahan produk ke-6.', 'Tautan Gambar (Pilihan)'],
            'W' => ['Foto Produk 7', 'Pilihan', 'Foto tambahan produk ke-7.', 'Tautan Gambar (Pilihan)'],
            'X' => ['Foto Produk 8', 'Pilihan', 'Foto tambahan produk ke-8.', 'Tautan Gambar (Pilihan)'],
            'Y' => ['Berat', 'Wajib', 'Berat produk dalam kilogram.', 'Desimal (maksimal 2 desimal)'],
            'Z' => ['Panjang', 'Pilihan', 'Panjang paket dalam sentimeter.', 'Desimal (maksimal 2 desimal)'],
            'AA' => ['Lebar', 'Pilihan', 'Lebar paket dalam sentimeter.', 'Desimal (maksimal 2 desimal)'],
            'AB' => ['Tinggi', 'Pilihan', 'Tinggi paket dalam sentimeter.', 'Desimal (maksimal 2 desimal)'],
            'AC' => ['Jasa Kirim 1', 'Pilihan', 'Pengaturan jasa kirim ke-1 (Aktif/Nonaktif).', 'Pilihan'],
            'AD' => ['Jasa Kirim 2', 'Pilihan', 'Pengaturan jasa kirim ke-2 (Aktif/Nonaktif).', 'Pilihan'],
            'AE' => ['Jasa Kirim 3', 'Pilihan', 'Pengaturan jasa kirim ke-3 (Aktif/Nonaktif).', 'Pilihan'],
            'AF' => ['Jangka Dikirim Dalam', 'Pilihan', 'Lama waktu pengemasan.', 'Angka saja'],
            'AG' => ['Dikirim Dalam Pre-order', 'Pilihan', 'Status Pre-order (Aktif/Nonaktif).', 'Pilihan'],
            'AH' => ['Merek', 'Wajib', 'Merek produk. Isi \'Tidak Ada Merek\' jika tidak ada merek.', 'Pilihan'],
        ];

        // Apply headers metadata
        foreach ($headersMetadata as $col => $metadata) {
            $sheet->setCellValue($col . '1', $metadata[0]);
            $sheet->setCellValue($col . '2', $metadata[1]);
            $sheet->setCellValue($col . '3', $metadata[2]);
            $sheet->setCellValue($col . '4', $metadata[3]);

            // Style Row 1: Header names
            $sheet->getStyle($col . '1')->applyFromArray([
                'font' => ['bold' => true, 'size' => 11, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1F4E78']], // Dark Blue
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER]
            ]);

            // Style Row 2: Requirement status (Wajib/Pilihan)
            $isWajib = ($metadata[1] === 'Wajib');
            $sheet->getStyle($col . '2')->applyFromArray([
                'font' => [
                    'bold' => $isWajib, 
                    'size' => 10, 
                    'color' => ['rgb' => $isWajib ? 'C00000' : '595959'] // Red for Wajib, Grey for Pilihan
                ],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFFFF']]
            ]);

            // Style Row 3: Column Description
            $sheet->getStyle($col . '3')->applyFromArray([
                'font' => ['size' => 9, 'color' => ['rgb' => '595959']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT, 'vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'F2F2F2']] // Light Grey
            ]);

            // Style Row 4: Formatting constraints
            $sheet->getStyle($col . '4')->applyFromArray([
                'font' => ['size' => 9, 'italic' => true, 'color' => ['rgb' => '7F7F7F']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT, 'vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'F2F2F2']] // Light Grey
            ]);
        }

        // Set row heights for visual balance
        $sheet->getRowDimension(1)->setRowHeight(28);
        $sheet->getRowDimension(2)->setRowHeight(20);
        $sheet->getRowDimension(3)->setRowHeight(35);
        $sheet->getRowDimension(4)->setRowHeight(25);
        
        $row = 5;
        foreach ($products as $product) {
            $images = $product->images()->orderBy('sort_order')->get();
            $categoryCode = optional($product->category)->shopee_code ?? '';
            
            // Parse dimension
            $dimension = ['length' => '', 'width' => '', 'height' => ''];
            if ($product->dimension) {
                $parts = explode('x', $product->dimension);
                if (count($parts) === 3) {
                    $dimension['length'] = floatval($parts[0]);
                    $dimension['width'] = floatval($parts[1]);
                    $dimension['height'] = floatval($parts[2]);
                }
            }
            
            // Shipping options
            $shippingOptions = $product->shipping_options ?? ['jne', 'jnt', 'sicepat'];
            if (is_string($shippingOptions)) {
                $shippingOptions = json_decode($shippingOptions, true) ?: ['jne', 'jnt', 'sicepat'];
            }
            
            // Main product row
            $sheet->setCellValue("A{$row}", $categoryCode);
            $sheet->setCellValue("B{$row}", $product->ai_generated_title ?: $product->name);
            $sheet->setCellValue("C{$row}", strip_tags($product->description ?? ''));
            $sheet->setCellValue("D{$row}", $product->sku ?: 'SKU-' . $product->id);
            $sheet->setCellValue("K{$row}", $product->price);
            $sheet->setCellValue("L{$row}", $product->stock ?: 100);
            $sheet->setCellValue("M{$row}", 'VAR-' . $product->id . '-001');
            $sheet->setCellValue("P{$row}", $images[0]->path ?? '');
            $sheet->setCellValue("Q{$row}", $images[1]->path ?? '');
            $sheet->setCellValue("R{$row}", $images[2]->path ?? '');
            $sheet->setCellValue("S{$row}", $images[3]->path ?? '');
            $sheet->setCellValue("T{$row}", $images[4]->path ?? '');
            $sheet->setCellValue("U{$row}", $images[5]->path ?? '');
            $sheet->setCellValue("V{$row}", $images[6]->path ?? '');
            $sheet->setCellValue("W{$row}", $images[7]->path ?? '');
            $sheet->setCellValue("X{$row}", $images[8]->path ?? '');
            $sheet->setCellValue("Y{$row}", ($product->weight ?? 250) / 1000);
            $sheet->setCellValue("Z{$row}", $dimension['length']);
            $sheet->setCellValue("AA{$row}", $dimension['width']);
            $sheet->setCellValue("AB{$row}", $dimension['height']);
            $sheet->setCellValue("AC{$row}", in_array('jne', $shippingOptions) ? 'Aktif' : '');
            $sheet->setCellValue("AD{$row}", in_array('jnt', $shippingOptions) ? 'Aktif' : '');
            $sheet->setCellValue("AE{$row}", in_array('sicepat', $shippingOptions) ? 'Aktif' : '');
            $sheet->setCellValue("AH{$row}", $product->brand ?? 'Tidak Ada Merek');
            
            $row++;
        }
        
        // Auto-size columns
        foreach (range('A', 'AH') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }
        
        // Save file
        $filename = 'exports/shopee_export_' . date('Ymd_His') . '.xlsx';
        $fullPath = storage_path('app/public/' . $filename);
        
        if (!is_dir(dirname($fullPath))) {
            mkdir(dirname($fullPath), 0755, true);
        }
        
        $writer = new Xlsx($spreadsheet);
        $writer->save($fullPath);
        
        return $filename;
    }
}