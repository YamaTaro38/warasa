<?php

namespace App\Services;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use Illuminate\Support\Facades\Log;

class ExportService
{
    /**
     * Export products to Shopee Mass Upload Excel format.
     * 
     * Strategy: Copy the original Shopee template file and fill in product data
     * into the "Template" and "Contoh Upload" sheets starting from row 7.
     * Each variation option gets its own row.
     */
    public function exportToShopeeExcel($products)
    {
        $templatePath = base_path('Shopee_mass_upload_2026-06-12_basic_template.xlsx');
        
        if (!file_exists($templatePath)) {
            throw new \RuntimeException('Shopee template file not found: ' . $templatePath);
        }
        
        $spreadsheet = IOFactory::load($templatePath);
        
        // Write data to both "Template" and "Contoh Upload" sheets
        foreach (['Template', 'Contoh Upload'] as $sheetName) {
            $sheet = $spreadsheet->getSheetByName($sheetName);
            if (!$sheet) {
                continue;
            }
            
            // Clear existing data rows (keep rows 1-6 which are metadata)
            if ($sheetName === 'Contoh Upload') {
                $highestRow = $sheet->getHighestRow();
                $highestColIndex = Coordinate::columnIndexFromString($sheet->getHighestColumn());
                for ($r = 7; $r <= $highestRow; $r++) {
                    for ($ci = 1; $ci <= $highestColIndex; $ci++) {
                        $sheet->setCellValue(Coordinate::stringFromColumnIndex($ci) . $r, null);
                    }
                }
            }
            
            $row = 7;
            foreach ($products as $product) {
                $rows = $this->expandProductToRows($product);
                foreach ($rows as $rowData) {
                    $this->writeRow($sheet, $row, $rowData);
                    $row++;
                }
            }
        }
        
        // Save to temporary file
        $filename = 'exports/shopee_export_' . date('Ymd_His') . '.xlsx';
        $fullPath = storage_path('app/public/' . $filename);
        
        if (!is_dir(dirname($fullPath))) {
            mkdir(dirname($fullPath), 0755, true);
        }
        
        $writer = new Xlsx($spreadsheet);
        $writer->save($fullPath);
        
        return $fullPath;
    }
    
    /**
     * Expand a product into one or more rows based on its variations.
     * 
     * - No variations: 1 row
     * - 1 variation level: N rows (one per option)
     * - 2 variation levels: N*M rows (one per combination)
     */
    protected function expandProductToRows($product)
    {
        $images = $product->images()->orderBy('sort_order')->get();
        $categoryCode = optional($product->category)->shopee_code ?? '';
        
        // Parse dimension
        $dimension = ['length' => '', 'width' => '', 'height' => ''];
        if ($product->dimension) {
            $parts = preg_split('/\s*x\s*/i', $product->dimension);
            if (count($parts) === 3) {
                $dimension['length'] = floatval(trim($parts[0]));
                $dimension['width'] = floatval(trim($parts[1]));
                $dimension['height'] = floatval(trim($parts[2]));
            }
        }
        
        // Shipping options
        $shippingOptions = $product->shipping_options ?? ['jne', 'jnt', 'sicepat'];
        if (is_string($shippingOptions)) {
            $shippingOptions = json_decode($shippingOptions, true) ?: ['jne', 'jnt', 'sicepat'];
        }
        
        // Weight in kg
        $weightKg = round(($product->weight ?? 250) / 1000, 2);
        
        // Product name
        $productName = $product->ai_generated_title ?: $product->name;
        
        // Description
        $description = strip_tags($product->description ?? '');
        
        // SKU parent
        $skuParent = $product->sku ?: 'SKU-' . $product->id;
        
        // Cover image URL
        $coverImage = $images->first();
        $coverImageUrl = ($coverImage && $coverImage->path) ? $this->getFullImageUrl($coverImage->path) : '';
        
        // Additional image URLs (Foto Produk 1-8)
        $additionalImages = [];
        for ($i = 1; $i <= 8; $i++) {
            $img = $images[$i] ?? null;
            $additionalImages[] = ($img && $img->path) ? $this->getFullImageUrl($img->path) : '';
        }
        
        // Parse variations
        $variations = $product->variations ?? [];
        if (is_string($variations)) {
            $variations = json_decode($variations, true) ?: [];
        }
        
        $var1 = $variations[0] ?? null;
        $var2 = $variations[1] ?? null;
        
        $rows = [];
        
        // Get variation 1 options
        $var1Options = [];
        if ($var1 && !empty($var1['options'])) {
            foreach ($var1['options'] as $opt) {
                $value = is_array($opt) ? ($opt['value'] ?? '') : $opt;
                $image = is_array($opt) ? ($opt['image'] ?? null) : null;
                if (!empty($value)) {
                    $var1Options[] = ['value' => $value, 'image' => $image];
                }
            }
        }
        
        // Get variation 2 options
        $var2Options = [];
        if ($var2 && !empty($var2['options'])) {
            foreach ($var2['options'] as $opt) {
                $value = is_array($opt) ? ($opt['value'] ?? '') : $opt;
                $image = is_array($opt) ? ($opt['image'] ?? null) : null;
                if (!empty($value)) {
                    $var2Options[] = ['value' => $value, 'image' => $image];
                }
            }
        }
        
        // If no variations, create a single row
        if (empty($var1Options)) {
            $rows[] = $this->buildRowData(
                $categoryCode, $productName, $description, $skuParent,
                '', '', '', '', // No variation data
                $product->price, $product->stock, '',
                $coverImageUrl, $additionalImages,
                $weightKg, $dimension, $shippingOptions, $product->id
            );
            return $rows;
        }
        
        // If only 1 variation level
        if (!empty($var1Options) && empty($var2Options)) {
            $variationIntegrationCode = 'VAR-' . $product->id;
            
            foreach ($var1Options as $idx => $opt) {
                $optImageUrl = '';
                if (!empty($opt['image']) && str_contains($opt['image'], 'base64')) {
                    // Base64 image - skip for now (not a URL)
                } elseif (!empty($opt['image'])) {
                    $optImageUrl = $this->getFullImageUrl($opt['image']);
                }
                
                $variationSku = 'VAR-' . $product->id . '-' . str_replace(' ', '', $opt['value']);
                
                $rows[] = $this->buildRowData(
                    $categoryCode, $productName, $description, $skuParent,
                    $variationIntegrationCode,
                    $var1['name'] ?? '',
                    $opt['value'],
                    $optImageUrl,
                    $product->price, $product->stock, $variationSku,
                    $coverImageUrl, $additionalImages,
                    $weightKg, $dimension, $shippingOptions, $product->id
                );
            }
            return $rows;
        }
        
        // If 2 variation levels
        if (!empty($var1Options) && !empty($var2Options)) {
            $variationIntegrationCode = 'VAR-' . $product->id;
            
            foreach ($var1Options as $opt1) {
                $opt1ImageUrl = '';
                if (!empty($opt1['image']) && str_contains($opt1['image'], 'base64')) {
                    // Skip base64
                } elseif (!empty($opt1['image'])) {
                    $opt1ImageUrl = $this->getFullImageUrl($opt1['image']);
                }
                
                foreach ($var2Options as $opt2) {
                    $opt2ImageUrl = '';
                    if (!empty($opt2['image']) && str_contains($opt2['image'], 'base64')) {
                        // Skip base64
                    } elseif (!empty($opt2['image'])) {
                        $opt2ImageUrl = $this->getFullImageUrl($opt2['image']);
                    }
                    
                    $variationSku = 'VAR-' . $product->id . '-' . str_replace(' ', '', $opt1['value']) . '-' . str_replace(' ', '', $opt2['value']);
                    
                    $rows[] = $this->buildRowData(
                        $categoryCode, $productName, $description, $skuParent,
                        $variationIntegrationCode,
                        $var1['name'] ?? '',
                        $opt1['value'],
                        $opt1ImageUrl,
                        $product->price, $product->stock, $variationSku,
                        $coverImageUrl, $additionalImages,
                        $weightKg, $dimension, $shippingOptions, $product->id,
                        $var2['name'] ?? '',
                        $opt2['value']
                    );
                }
            }
            return $rows;
        }
        
        return $rows;
    }
    
    /**
     * Build a row data array for a single product/variation row.
     */
    protected function buildRowData(
        $categoryCode, $productName, $description, $skuParent,
        $variationIntegrationCode, $variationName1, $variationOption1, $variationImageUrl,
        $price, $stock, $variationSku,
        $coverImageUrl, $additionalImages,
        $weightKg, $dimension, $shippingOptions, $productId,
        $variationName2 = '', $variationOption2 = ''
    ) {
        return [
            'kategori' => $categoryCode,
            'nama_produk' => mb_substr($productName, 0, 255),
            'deskripsi' => mb_substr($description, 0, 3000),
            'sku_induk' => mb_substr($skuParent, 0, 100),
            'kode_integrasi_variasi' => $variationIntegrationCode,
            'nama_variasi_1' => mb_substr($variationName1, 0, 14),
            'varian_variasi_1' => mb_substr($variationOption1, 0, 20),
            'foto_per_varian' => $variationImageUrl,
            'nama_variasi_2' => mb_substr($variationName2, 0, 14),
            'varian_variasi_2' => mb_substr($variationOption2, 0, 20),
            'harga' => max(99, intval($price ?? 99)),
            'stok' => min(10000000, max(0, intval($stock ?? 0))),
            'kode_variasi' => $variationSku ?: 'SKU-' . $productId,
            'foto_sampul' => $coverImageUrl,
            'foto_produk' => $additionalImages,
            'berat' => $weightKg,
            'panjang' => $dimension['length'],
            'lebar' => $dimension['width'],
            'tinggi' => $dimension['height'],
            'next_day' => in_array('jne', $shippingOptions) ? 'Aktif' : 'Nonaktif',
            'reguler' => in_array('jnt', $shippingOptions) ? 'Aktif' : 'Nonaktif',
            'hemat_kargo' => in_array('sicepat', $shippingOptions) ? 'Aktif' : 'Nonaktif',
        ];
    }
    
    /**
     * Write a single row to the worksheet.
     */
    protected function writeRow($sheet, $row, $data)
    {
        // A = Kategori
        $sheet->setCellValue("A{$row}", $data['kategori']);
        // B = Nama Produk
        $sheet->setCellValue("B{$row}", $data['nama_produk']);
        // C = Deskripsi Produk
        $sheet->setCellValue("C{$row}", $data['deskripsi']);
        // D = Maks. Jumlah Pembelian (leave empty)
        // E = Maks. Jumlah Pembelian - Tanggal Mulai (leave empty)
        // F = Maks. Jumlah Pembelian - Jumlah Hari (leave empty)
        // G = Maks. Jumlah Pembelian - Tanggal Berakhir (leave empty)
        // H = Min. Jumlah Pembelian (leave empty)
        // I = SKU Induk
        $sheet->setCellValue("I{$row}", $data['sku_induk']);
        // J = Produk Berbahaya (leave empty)
        // K = Kode Integrasi Variasi
        $sheet->setCellValue("K{$row}", $data['kode_integrasi_variasi']);
        // L = Nama Variasi 1
        $sheet->setCellValue("L{$row}", $data['nama_variasi_1']);
        // M = Varian untuk Variasi 1
        $sheet->setCellValue("M{$row}", $data['varian_variasi_1']);
        // N = Foto Produk per Varian
        $sheet->setCellValue("N{$row}", $data['foto_per_varian']);
        // O = Nama Variasi 2
        $sheet->setCellValue("O{$row}", $data['nama_variasi_2']);
        // P = Varian untuk Variasi 2
        $sheet->setCellValue("P{$row}", $data['varian_variasi_2']);
        // Q = Harga
        $sheet->setCellValue("Q{$row}", $data['harga']);
        // R = Stok
        $sheet->setCellValue("R{$row}", $data['stok']);
        // S = Kode Variasi
        $sheet->setCellValue("S{$row}", $data['kode_variasi']);
        // T = Template Panduan Ukuran (leave empty)
        // U = Foto Panduan Ukuran (leave empty)
        // V = GTIN (leave empty)
        // W = Foto Sampul
        $sheet->setCellValue("W{$row}", $data['foto_sampul']);
        // X = Foto Produk 1
        $sheet->setCellValue("X{$row}", $data['foto_produk'][0] ?? '');
        // Y = Foto Produk 2
        $sheet->setCellValue("Y{$row}", $data['foto_produk'][1] ?? '');
        // Z = Foto Produk 3
        $sheet->setCellValue("Z{$row}", $data['foto_produk'][2] ?? '');
        // AA = Foto Produk 4
        $sheet->setCellValue("AA{$row}", $data['foto_produk'][3] ?? '');
        // AB = Foto Produk 5
        $sheet->setCellValue("AB{$row}", $data['foto_produk'][4] ?? '');
        // AC = Foto Produk 6
        $sheet->setCellValue("AC{$row}", $data['foto_produk'][5] ?? '');
        // AD = Foto Produk 7
        $sheet->setCellValue("AD{$row}", $data['foto_produk'][6] ?? '');
        // AE = Foto Produk 8
        $sheet->setCellValue("AE{$row}", $data['foto_produk'][7] ?? '');
        // AF = Berat
        $sheet->setCellValue("AF{$row}", $data['berat']);
        // AG = Panjang
        $sheet->setCellValue("AG{$row}", $data['panjang'] !== '' ? $data['panjang'] : '');
        // AH = Lebar
        $sheet->setCellValue("AH{$row}", $data['lebar'] !== '' ? $data['lebar'] : '');
        // AI = Tinggi
        $sheet->setCellValue("AI{$row}", $data['tinggi'] !== '' ? $data['tinggi'] : '');
        // AJ = Next Day
        $sheet->setCellValue("AJ{$row}", $data['next_day']);
        // AK = Reguler (Cashless)
        $sheet->setCellValue("AK{$row}", $data['reguler']);
        // AL = Hemat Kargo
        $sheet->setCellValue("AL{$row}", $data['hemat_kargo']);
        // AM = Dikirim Dalam Pre-order (leave empty)
        // AN = Alasan Gagal (leave empty)
    }
    
    /**
     * Get the full image URL from a relative path.
     */
    protected function getFullImageUrl($path)
    {
        if (empty($path)) {
            return '';
        }
        
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }
        
        return url($path);
    }
}