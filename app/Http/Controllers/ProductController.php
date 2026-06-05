<?php
// app/Http/Controllers/ProductController.php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductCategory;
use App\Models\Project;
use App\Models\ActivityLog;
use App\Services\ExportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    protected $exportService;

    public function __construct(ExportService $exportService)
    {
        $this->exportService = $exportService;
    }

    /**
     * Display a listing of the products.
     */
    public function index(Request $request)
    {
        $query = Product::where('user_id', Auth::id())
            ->where('is_archived', false)
            ->select('id', 'uuid', 'name', 'brand', 'price', 'stock', 'status', 'category_id', 'created_at');

        if ($request->has('project_id') && $request->project_id) {
            $query->where('project_id', $request->project_id);
        }

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->with('category:id,name')->orderBy('id', 'desc')->paginate(15);

        $projects = Project::where('user_id', Auth::id())
            ->where('is_archived', false)
            ->select('id', 'name')
            ->get();

        return view('products.index', compact('products', 'projects'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        $projects = Project::where('user_id', Auth::id())
            ->where('is_archived', false)
            ->get();

        return view('products.create', compact('projects'));
    }

    /**
     * Store a newly created product.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'project_id' => 'nullable|exists:projects,id',
            'category_id' => 'nullable|exists:product_categories,id',
            'brand' => 'nullable|string|max:255',
            'price' => 'nullable|numeric',
            'stock' => 'nullable|integer',
            'description' => 'nullable|string',
            'keywords' => 'nullable|string',
            'status' => 'required|in:draft,published',
        ]);

        $product = Product::create([
            'user_id' => Auth::id(),
            'uuid' => (string) Str::uuid(),
            ...$validated
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'product_create',
            'description' => 'Created product: ' . $product->name,
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('products.show', $product->uuid)
            ->with('success', 'Product created successfully!');
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product)
    {
        // Cek kepemilikan
        if ($product->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        $images = $product->images()->orderBy('sort_order')->get();
        $projects = Project::where('user_id', Auth::id())->where('is_archived', false)->get();

        return view('products.show', compact('product', 'images', 'projects'));
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product)
    {
        // Cek kepemilikan
        if ($product->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        $projects = Project::where('user_id', Auth::id())
            ->where('is_archived', false)
            ->get();

        $categories = ProductCategory::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        // Ambil gambar produk
        $images = $product->images()->orderBy('sort_order')->get();

        return view('products.edit', compact('product', 'projects', 'categories', 'images'));
    }

    protected function processVariations($variations)
    {
        if (empty($variations)) return [];

        $processed = [];
        foreach ($variations as $variation) {
            if (!isset($variation['name']) || empty($variation['name'])) continue;

            $hasImage = isset($variation['hasImage']) && $variation['hasImage'] === true;
            $options = [];

            if (isset($variation['options']) && is_array($variation['options'])) {
                foreach ($variation['options'] as $opt) {
                    if ($hasImage && is_array($opt)) {
                        $value = $opt['value'] ?? '';
                        $image = $opt['image'] ?? null;

                        if (empty($value)) continue;

                        $savedImage = null;
                        if ($image && str_contains($image, 'base64')) {
                            $savedImage = $this->saveBase64Image($image, 'variations');
                        } elseif ($image && str_contains($image, '/storage/')) {
                            $savedImage = $image;
                        }

                        $options[] = [
                            'value' => $value,
                            'image' => $savedImage
                        ];
                    } elseif (!$hasImage) {
                        $value = is_array($opt) ? ($opt['value'] ?? '') : $opt;
                        if (!empty($value)) {
                            $options[] = $value;
                        }
                    }
                }
            }

            if (!empty($options)) {
                $processed[] = [
                    'name' => $variation['name'],
                    'hasImage' => $hasImage,
                    'options' => $options
                ];
            }
        }

        return $processed;
    }

    /**
     * Save base64 image to storage
     */
    protected function saveBase64Image($base64Image, $subDir = 'products')
    {
        if (empty($base64Image) || !str_contains($base64Image, 'base64')) {
            return null;
        }

        try {
            if (preg_match('/^data:image\/(\w+);base64,/', $base64Image, $matches)) {
                $extension = $matches[1];
                $imageData = substr($base64Image, strpos($base64Image, ',') + 1);
                $imageData = base64_decode($imageData);

                if ($imageData === false || strlen($imageData) > 5 * 1024 * 1024) {
                    return null;
                }

                $filename = $subDir . '/' . date('Y/m/d') . '/' . Str::random(40) . '.' . $extension;
                $fullPath = storage_path('app/public/' . $filename);

                if (!file_exists(dirname($fullPath))) {
                    mkdir(dirname($fullPath), 0777, true);
                }

                file_put_contents($fullPath, $imageData);
                return 'storage/' . $filename;
            }
        } catch (\Exception $e) {
            \Log::error('Save base64 image failed: ' . $e->getMessage());
            return null;
        }

        return null;
    }

    /**
     * Update the specified product.
     */
    public function update(Request $request, Product $product)
    {
        // Cek kepemilikan
        if ($product->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        // Ambil data dari FormData (bisa string atau JSON string)
        $shippingOptions = $request->shipping_options ? json_decode($request->shipping_options, true) : ['jne', 'jnt', 'pos', 'sicepat'];
        $variations = $request->variations ? json_decode($request->variations, true) : [];
        $images = $request->images ? json_decode($request->images, true) : [];
        $deletedImages = $request->deleted_images ? json_decode($request->deleted_images, true) : [];

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'project_id' => 'nullable|exists:projects,id',
            'category_id' => 'nullable|exists:product_categories,id',
            'brand' => 'nullable|string|max:255',
            'price' => 'nullable|numeric',
            'stock' => 'nullable|integer',
            'weight' => 'nullable|numeric',
            'dimension' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'keywords' => 'nullable|string',
            'ai_generated_title' => 'nullable|string',
            'status' => 'required|in:draft,published',
        ]);

        // Update basic info
        $product->update([
            'name' => $validated['name'],
            'project_id' => $validated['project_id'],
            'category_id' => $validated['category_id'],
            'brand' => $validated['brand'],
            'price' => $validated['price'] ?? 0,
            'stock' => $validated['stock'] ?? 0,
            'weight' => $validated['weight'] ?? 250,
            'dimension' => $validated['dimension'],
            'description' => $validated['description'],
            'keywords' => $validated['keywords'],
            'ai_generated_title' => $validated['ai_generated_title'],
            'status' => $validated['status'],
            'shipping_options' => $shippingOptions,
            'variations' => $this->processVariations($variations),
        ]);

        // Handle deleted images
        if (!empty($deletedImages)) {
            foreach ($deletedImages as $imageId) {
                $image = ProductImage::find($imageId);
                if ($image && $image->product_id === $product->id) {
                    $path = str_replace('/storage/', '', $image->path);
                    if (Storage::disk('public')->exists($path)) {
                        Storage::disk('public')->delete($path);
                    }
                    $image->delete();
                }
            }
        }

        // Handle new images
        if (!empty($images)) {
            $currentSortOrder = $product->images()->count();
            foreach ($images as $imageData) {
                if (isset($imageData['is_new']) && $imageData['is_new'] === true && isset($imageData['path'])) {
                    $imagePath = $this->saveBase64Image($imageData['path'], 'products');
                    if ($imagePath) {
                        ProductImage::create([
                            'product_id' => $product->id,
                            'path' => $imagePath,
                            'sort_order' => $currentSortOrder++
                        ]);
                    }
                }
            }
        }

        return response()->json([
            'success' => true,
            'product' => $product,
            'message' => 'Product updated successfully!'
        ]);
    }

    /**
     * Remove the specified product.
     */
    public function destroy(Product $product)
    {
        // Cek kepemilikan
        if ($product->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        try {
            // Hapus gambar dari storage
            $images = ProductImage::where('product_id', $product->id)->get();
            
            foreach ($images as $image) {
                $path = str_replace('/storage/', '', $image->path);
                $fullPath = storage_path('app/public/' . $path);
                if (file_exists($fullPath)) {
                    unlink($fullPath);
                }
                $image->delete();
            }

            // Hapus produk
            $product->delete();

            return response()->json([
                'success' => true,
                'message' => 'Product deleted successfully'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Archive the specified product.
     */
    public function archive(Product $product)
    {
        if ($product->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $product->update(['is_archived' => true]);

        return response()->json(['success' => true]);
    }

    /**
     * Duplicate the specified product.
     */
    public function duplicate(Product $product)
    {
        if ($product->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        $newProduct = $product->replicate();
        $newProduct->uuid = (string) Str::uuid();
        $newProduct->name = $product->name . ' (Copy)';
        $newProduct->status = 'draft';
        $newProduct->created_at = now();
        $newProduct->updated_at = now();
        $newProduct->save();

        // Duplicate images (defensive: $product->images bisa null jika relasi tidak dimuat)
        $images = $product->images ?? collect();
        if ($images) {
            foreach ($images as $image) {
                $newProduct->images()->create($image->toArray());
            }
        }

        return redirect()->route('products.edit', $newProduct->uuid)
            ->with('success', 'Product duplicated successfully!');
    }

    /**
     * Export products to Excel.
     */
    public function export(Request $request)
    {
        $productIds = $request->input('product_ids', []);

        if (is_string($productIds)) {
            $productIds = json_decode($productIds, true);
        }

        if (empty($productIds)) {
            return back()->with('error', 'No products selected for export.');
        }

        $products = Product::whereIn('uuid', $productIds)
            ->where('user_id', Auth::id())
            ->get();

        $filePath = $this->exportService->exportToShopeeExcel($products);

        return response()->download($filePath)->deleteFileAfterSend(true);
    }

    /**
     * Bulk action for products.
     */
    public function bulkAction(Request $request)
    {
        $validated = $request->validate([
            'product_ids' => 'required|array',
            'action' => 'required|in:delete,archive,publish,draft',
        ]);

        $products = Product::whereIn('uuid', $validated['product_ids'])
            ->where('user_id', Auth::id())
            ->get();

        foreach ($products as $product) {
            switch ($validated['action']) {
                case 'delete':
                    $product->delete();
                    break;
                case 'archive':
                    $product->update(['is_archived' => true]);
                    break;
                case 'publish':
                    $product->update(['status' => 'published']);
                    break;
                case 'draft':
                    $product->update(['status' => 'draft']);
                    break;
            }
        }

        return response()->json(['success' => true]);
    }

    public function exportSelected()
{
    return $this->exportToShopee();
}
}
