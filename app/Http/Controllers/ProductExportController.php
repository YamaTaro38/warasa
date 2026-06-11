<?php
// app/Http/Controllers/ProductExportController.php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\ExportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductExportController extends Controller
{
    protected $exportService;

    public function __construct(ExportService $exportService)
    {
        $this->exportService = $exportService;
    }

    /**
     * Export selected products to Shopee Mass Upload format
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
            ->with(['category', 'images' => function ($q) {
                $q->orderBy('sort_order');
            }])
            ->get();
        
        if ($products->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Tidak ada produk yang ditemukan'], 400);
        }
        
        try {
            $filePath = $this->exportService->exportToShopeeExcel($products);
            
            $filename = 'shopee_mass_upload_' . date('Y-m-d_His') . '.xlsx';
            
            return response()->download($filePath, $filename)->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            Log::error('Export to Shopee failed: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Gagal export: ' . $e->getMessage()], 500);
        }
    }
    
    /**
     * Export single product to Shopee Mass Upload format
     */
    public function exportSingle($uuid)
    {
        $product = Product::where('uuid', $uuid)
            ->with(['category', 'images' => function ($q) {
                $q->orderBy('sort_order');
            }])
            ->first();
        
        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Produk tidak ditemukan'], 404);
        }
        
        try {
            $filePath = $this->exportService->exportToShopeeExcel(collect([$product]));
            
            $filename = 'shopee_export_' . $product->id . '_' . date('Y-m-d_His') . '.xlsx';
            
            return response()->download($filePath, $filename)->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            Log::error('Export single product failed: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Gagal export: ' . $e->getMessage()], 500);
        }
    }
}