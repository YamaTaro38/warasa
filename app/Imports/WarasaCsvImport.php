<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class WarasaCsvImport implements ToCollection, WithHeadingRow
{
    public $products = [];

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $product = [
                'no' => $row['no'] ?? null,
                'nama_produk' => $row['nama_produk'] ?? '',
                'url_produk' => $row['url_produk'] ?? '',
                'harga' => $this->parsePrice($row['harga'] ?? 0),
                'rating' => $row['rating'] ?? '',
                'terjual' => $row['terjual'] ?? '',
                'lokasi_toko' => $row['lokasi_toko'] ?? '',
                'url_gambar' => $this->parseJsonArray($row['url_gambar_gallery_json'] ?? '[]'),
                'varian' => $this->parseJsonArray($row['varian_json'] ?? '{}'),
                'spesifikasi' => $this->parseJsonArray($row['spesifikasi_json'] ?? '{}'),
                'deskripsi_produk' => $row['deskripsi_produk'] ?? '',
            ];
            $this->products[] = $product;
        }
    }

    private function parsePrice($price)
    {
        if (is_numeric($price)) return (int) $price;
        $clean = preg_replace('/[^0-9]/', '', $price);
        return (int) $clean;
    }

    private function parseJsonArray($json)
    {
        if (empty($json)) return [];
        $decoded = json_decode($json, true);
        return is_array($decoded) ? $decoded : [];
    }

    public function getProducts()
    {
        return $this->products;
    }
}