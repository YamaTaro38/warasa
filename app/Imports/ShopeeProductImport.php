<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ShopeeProductImport implements ToArray, WithHeadingRow
{
    protected $products = [];

    public function array(array $array)
    {
        foreach ($array as $row) {
            $this->products[] = [
                'name' => $row['nama_produk'] ?? $row['product_name'] ?? '',
                'price' => $row['harga'] ?? $row['price'] ?? 0,
                'category' => $row['kategori'] ?? $row['category'] ?? '',
                'description' => $row['deskripsi'] ?? $row['description'] ?? '',
                'stock' => $row['stok'] ?? $row['stock'] ?? 0,
            ];
        }
    }

    public function getProducts()
    {
        return $this->products;
    }
}