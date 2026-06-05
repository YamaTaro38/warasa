<?php
// app/Http/Controllers/ProductExportController.php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class ProductExportController extends Controller
{
    /**
     * Export selected products to Shopee CSV format
     */
    public function exportToShopee(Request $request)
    {
        $productIds = $request->input('product_ids', []);
        
        if (is_string($productIds)) {
            $productIds = json_decode($productIds, true);
        }
        
        if (empty($productIds)) {
            return response()->json(['success' => false, 'message' => 'Tidak ada produk yang dipilih'], 400);
        }
        
        $products = Product::whereIn('id', $productIds)
            ->where('status', 'published')
            ->with('category')
            ->get();
        
        if ($products->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Tidak ada produk yang dipublikasikan'], 400);
        }
        
        return $this->generateShopeeExcel($products);
    }
    
    /**
     * Export single product to Shopee CSV format
     */
    public function exportSingle($uuid)
    {
        $product = Product::where('uuid', $uuid)
            ->where('status', 'published')
            ->with('category')
            ->first();
        
        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Produk tidak ditemukan atau belum dipublikasikan'], 404);
        }
        
        return $this->generateShopeeExcel(collect([$product]));
    }
    
    /**
     * Generate Shopee Excel file
     */
    private function generateShopeeExcel($products)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Set sheet title
        $sheet->setTitle('Shopee Mass Upload');
        
        // Define headers sesuai template Shopee
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
        foreach ($headersMetadata as $column => $metadata) {
            $sheet->setCellValue($column . '1', $metadata[0]);
            $sheet->setCellValue($column . '2', $metadata[1]);
            $sheet->setCellValue($column . '3', $metadata[2]);
            $sheet->setCellValue($column . '4', $metadata[3]);

            // Style Row 1: Header names
            $sheet->getStyle($column . '1')->applyFromArray([
                'font' => ['bold' => true, 'size' => 11, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1F4E78']], // Dark Blue
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER]
            ]);

            // Style Row 2: Requirement status (Wajib/Pilihan)
            $isWajib = ($metadata[1] === 'Wajib');
            $sheet->getStyle($column . '2')->applyFromArray([
                'font' => [
                    'bold' => $isWajib, 
                    'size' => 10, 
                    'color' => ['rgb' => $isWajib ? 'C00000' : '595959'] // Red for Wajib, Grey for Pilihan
                ],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFFFF']]
            ]);

            // Style Row 3: Column Description
            $sheet->getStyle($column . '3')->applyFromArray([
                'font' => ['size' => 9, 'color' => ['rgb' => '595959']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT, 'vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'F2F2F2']] // Light Grey
            ]);

            // Style Row 4: Formatting constraints
            $sheet->getStyle($column . '4')->applyFromArray([
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
            // Get category code
            $categoryCode = $this->getCategoryCode($product->category);
            
            // Get product images
            $images = $product->images->pluck('path')->toArray();
            $coverImage = !empty($images) ? asset($images[0]) : '';
            $productImages = array_slice($images, 1, 7); // Max 8 images total (1 cover + 7 others)
            
            // Get variations
            $variations = is_array($product->variations) ? $product->variations : (is_string($product->variations) ? json_decode($product->variations, true) : []);
            
            // If product has variations, create multiple rows
            if (!empty($variations)) {
                $rows = $this->expandVariations($product, $variations, $categoryCode, $coverImage, $productImages);
                foreach ($rows as $rowData) {
                    $this->writeRow($sheet, $row, $rowData, $headers);
                    $row++;
                }
            } else {
                // Single product without variations
                $rowData = $this->buildSingleProductRow($product, $categoryCode, $coverImage, $productImages);
                $this->writeRow($sheet, $row, $rowData, $headers);
                $row++;
            }
        }
        
        // Auto size columns
        foreach (range('A', 'AH') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }
        
        // Create response
        $writer = new Xlsx($spreadsheet);
        $filename = 'shopee_mass_upload_' . date('Y-m-d_His') . '.xlsx';
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output');
        exit;
    }
    
    /**
     * Get Shopee category code
     */
    private function getCategoryCode($category)
    {
        if (!$category) return '';
        
        // Mapping kategori ke kode Shopee
        $categoryMapping = [
            'Elektronik' => '120000',
            'Handphone & Aksesoris' => '120100',
            'Fashion Pria' => '110000',
            'Fashion Wanita' => '110100',
            'Kesehatan & Kecantikan' => '130000',
            'Rumah Tangga' => '140000',
            'Olahraga' => '150000',
            'Mainan & Hobi' => '160000',
            'Makanan & Minuman' => '170000',
            'Perlengkapan Bayi' => '180000',
            'Otomotif' => '190000',
            'Buku & Alat Tulis' => '200000',
            'Komputer & Laptop' => '210000',
            'Kamera' => '220000',
            'Perawatan Tubuh' => '230000',
        ];
        
        return $categoryMapping[$category->name] ?? '120039';
    }
    
    /**
     * Build single product row
     */
    private function buildSingleProductRow($product, $categoryCode, $coverImage, $productImages)
    {
        return [
            'Kategori' => $categoryCode,
            'Nama Produk' => $product->name,
            'Deskripsi Produk' => strip_tags($product->description),
            'SKU Induk' => 'SKU_' . $product->uuid,
            'Kode Integrasi Variasi' => '',
            'Nama Variasi 1' => '',
            'Varian untuk Variasi 1' => '',
            'Foto Produk per Varian' => '',
            'Nama Variasi 2' => '',
            'Varian untuk Variasi 2' => '',
            'Harga' => $product->price,
            'Stok' => $product->stock,
            'Kode Variasi' => 'VAR_' . substr($product->uuid, 0, 8),
            'HS Code' => '',
            'Tax Code' => '',
            'Foto Sampul' => $coverImage,
            'Foto Produk 1' => $productImages[0] ?? '',
            'Foto Produk 2' => $productImages[1] ?? '',
            'Foto Produk 3' => $productImages[2] ?? '',
            'Foto Produk 4' => $productImages[3] ?? '',
            'Foto Produk 5' => $productImages[4] ?? '',
            'Foto Produk 6' => $productImages[5] ?? '',
            'Foto Produk 7' => $productImages[6] ?? '',
            'Foto Produk 8' => '',
            'Berat' => $product->weight / 1000, // Convert to kg for Shopee
            'Panjang' => $this->getDimensionValue($product->dimension, 'length'),
            'Lebar' => $this->getDimensionValue($product->dimension, 'width'),
            'Tinggi' => $this->getDimensionValue($product->dimension, 'height'),
            'Jasa Kirim 1' => in_array('jne', $product->shipping_options ?? []) ? 'Aktif' : '',
            'Jasa Kirim 2' => in_array('jnt', $product->shipping_options ?? []) ? 'Aktif' : '',
            'Jasa Kirim 3' => in_array('sicepat', $product->shipping_options ?? []) ? 'Aktif' : '',
            'Jangka Dikirim Dalam' => '',
            'Dikirim Dalam Pre-order' => '',
            'Merek' => $product->brand ?? 'Tidak Ada Merek',
        ];
    }
    
    /**
     * Expand product variations into multiple rows
     */
    private function expandVariations($product, $variations, $categoryCode, $coverImage, $productImages)
    {
        $rows = [];
        
        // Support up to 2 variation levels
        $variation1 = isset($variations[0]) ? $variations[0] : null;
        $variation2 = isset($variations[1]) ? $variations[1] : null;
        
        $variation1Name = $variation1 ? $variation1['name'] : '';
        $variation2Name = $variation2 ? $variation2['name'] : '';
        
        $variation1Options = $variation1 ? $variation1['options'] : [];
        $variation2Options = $variation2 ? $variation2['options'] : [];
        
        // If only 1 variation level
        if ($variation1 && !$variation2) {
            foreach ($variation1Options as $option) {
                $optionValue = is_array($option) ? $option['value'] : $option;
                $optionImage = is_array($option) && isset($option['image']) ? $option['image'] : '';
                
                $rows[] = [
                    'Kategori' => $categoryCode,
                    'Nama Produk' => $product->name,
                    'Deskripsi Produk' => strip_tags($product->description),
                    'SKU Induk' => 'SKU_' . $product->uuid,
                    'Kode Integrasi Variasi' => '',
                    'Nama Variasi 1' => $variation1Name,
                    'Varian untuk Variasi 1' => $optionValue,
                    'Foto Produk per Varian' => $optionImage,
                    'Nama Variasi 2' => '',
                    'Varian untuk Variasi 2' => '',
                    'Harga' => $product->price,
                    'Stok' => $product->stock,
                    'Kode Variasi' => 'VAR_' . substr($product->uuid, 0, 8) . '_' . str_replace(' ', '', $optionValue),
                    'HS Code' => '',
                    'Tax Code' => '',
                    'Foto Sampul' => $coverImage,
                    'Foto Produk 1' => $productImages[0] ?? '',
                    'Foto Produk 2' => $productImages[1] ?? '',
                    'Foto Produk 3' => $productImages[2] ?? '',
                    'Foto Produk 4' => $productImages[3] ?? '',
                    'Foto Produk 5' => $productImages[4] ?? '',
                    'Foto Produk 6' => $productImages[5] ?? '',
                    'Foto Produk 7' => $productImages[6] ?? '',
                    'Foto Produk 8' => '',
                    'Berat' => $product->weight / 1000,
                    'Panjang' => $this->getDimensionValue($product->dimension, 'length'),
                    'Lebar' => $this->getDimensionValue($product->dimension, 'width'),
                    'Tinggi' => $this->getDimensionValue($product->dimension, 'height'),
                    'Jasa Kirim 1' => in_array('jne', $product->shipping_options ?? []) ? 'Aktif' : '',
                    'Jasa Kirim 2' => in_array('jnt', $product->shipping_options ?? []) ? 'Aktif' : '',
                    'Jasa Kirim 3' => in_array('sicepat', $product->shipping_options ?? []) ? 'Aktif' : '',
                    'Jangka Dikirim Dalam' => '',
                    'Dikirim Dalam Pre-order' => '',
                    'Merek' => $product->brand ?? 'Tidak Ada Merek',
                ];
            }
        }
        // If 2 variation levels
        else if ($variation1 && $variation2) {
            foreach ($variation1Options as $option1) {
                $option1Value = is_array($option1) ? $option1['value'] : $option1;
                $option1Image = is_array($option1) && isset($option1['image']) ? $option1['image'] : '';
                
                foreach ($variation2Options as $option2) {
                    $option2Value = is_array($option2) ? $option2['value'] : $option2;
                    
                    $rows[] = [
                        'Kategori' => $categoryCode,
                        'Nama Produk' => $product->name,
                        'Deskripsi Produk' => strip_tags($product->description),
                        'SKU Induk' => 'SKU_' . $product->uuid,
                        'Kode Integrasi Variasi' => '',
                        'Nama Variasi 1' => $variation1Name,
                        'Varian untuk Variasi 1' => $option1Value,
                        'Foto Produk per Varian' => $option1Image,
                        'Nama Variasi 2' => $variation2Name,
                        'Varian untuk Variasi 2' => $option2Value,
                        'Harga' => $product->price,
                        'Stok' => $product->stock,
                        'Kode Variasi' => 'VAR_' . substr($product->uuid, 0, 8) . '_' . str_replace(' ', '', $option1Value) . '_' . str_replace(' ', '', $option2Value),
                        'HS Code' => '',
                        'Tax Code' => '',
                        'Foto Sampul' => $coverImage,
                        'Foto Produk 1' => $productImages[0] ?? '',
                        'Foto Produk 2' => $productImages[1] ?? '',
                        'Foto Produk 3' => $productImages[2] ?? '',
                        'Foto Produk 4' => $productImages[3] ?? '',
                        'Foto Produk 5' => $productImages[4] ?? '',
                        'Foto Produk 6' => $productImages[5] ?? '',
                        'Foto Produk 7' => $productImages[6] ?? '',
                        'Foto Produk 8' => '',
                        'Berat' => $product->weight / 1000,
                        'Panjang' => $this->getDimensionValue($product->dimension, 'length'),
                        'Lebar' => $this->getDimensionValue($product->dimension, 'width'),
                        'Tinggi' => $this->getDimensionValue($product->dimension, 'height'),
                        'Jasa Kirim 1' => in_array('jne', $product->shipping_options ?? []) ? 'Aktif' : '',
                        'Jasa Kirim 2' => in_array('jnt', $product->shipping_options ?? []) ? 'Aktif' : '',
                        'Jasa Kirim 3' => in_array('sicepat', $product->shipping_options ?? []) ? 'Aktif' : '',
                        'Jangka Dikirim Dalam' => '',
                        'Dikirim Dalam Pre-order' => '',
                        'Merek' => $product->brand ?? 'Tidak Ada Merek',
                    ];
                }
            }
        }
        
        return $rows;
    }
    
    /**
     * Get dimension value from dimension string
     */
    private function getDimensionValue($dimension, $type)
    {
        if (!$dimension) return '';
        
        $parts = explode('x', $dimension);
        if (count($parts) === 3) {
            switch ($type) {
                case 'length': return floatval($parts[0]);
                case 'width': return floatval($parts[1]);
                case 'height': return floatval($parts[2]);
                default: return '';
            }
        }
        
        return '';
    }
    
    /**
     * Write row to sheet
     */
    private function writeRow($sheet, $row, $rowData, $headers)
    {
        $columnIndex = 0;
        foreach ($headers as $column => $header) {
            $key = $header;
            $value = isset($rowData[$key]) ? $rowData[$key] : '';
            $sheet->setCellValue($column . $row, $value);
            $columnIndex++;
        }
    }
}