<?php

namespace App\Http\Controllers;

use App\Imports\WarasaCsvImport;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use App\Models\Project;
use App\Services\AIService;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class ProductGeneratorController extends Controller
{
    protected $aiService;
    protected $imageService;

    public function __construct(AIService $aiService, ImageService $imageService)
    {
        $this->aiService = $aiService;
        $this->imageService = $imageService;
    }

    public function index()
    {
        return redirect()->route('generator.quick');
    }

    public function quickGenerate()
    {
        $projects = Project::where('user_id', Auth::id())
            ->where('is_archived', false)
            ->orderBy('created_at', 'desc')
            ->get();

        $categories = ProductCategory::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('generator.quick', compact('projects', 'categories'));
    }

    public function smartGenerate()
    {
        $projects = Project::where('user_id', Auth::id())
            ->where('is_archived', false)
            ->orderBy('created_at', 'desc')
            ->get();

        $categories = ProductCategory::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('generator.smart', compact('projects', 'categories'));
    }

    public function uploadCsv(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:10240',
        ]);

        try {
            $import = new WarasaCsvImport();
            Excel::import($import, $request->file('csv_file'));
            $products = $import->getProducts();

            return response()->json([
                'success' => true,
                'products' => $products,
                'count' => count($products)
            ]);
        } catch (\Exception $e) {
            Log::error('CSV Upload error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal memproses file CSV: ' . $e->getMessage()
            ], 500);
        }
    }

    public function generateComplete(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'additional_prompt' => 'nullable|string',
                'csv_data' => 'nullable|array',
                'csv_products' => 'nullable|array',
                'generate_image' => 'nullable|boolean',
                'image_prompt' => 'nullable|string',
                'image_count' => 'nullable|integer|min:0|max:3',
            ]);

            $name = $validated['name'];
            $additionalInfo = $validated['additional_prompt'] ?? '';
            $csvData = $validated['csv_data'] ?? null;
            $csvProducts = $validated['csv_products'] ?? null;

            // === ANALISIS KOMPETITOR DARI CSV (jika ada banyak row) ===
            $competitorAnalysis = null;
            if (!empty($csvProducts) && is_array($csvProducts) && count($csvProducts) > 0) {
                $competitorAnalysis = $this->aiService->analyzeCompetitor($csvProducts);
            }

            // === SMART GENERATE: gunakan data kompetitor untuk hasil lebih baik ===
            if ($competitorAnalysis) {
                // Pakai method berbasis kompetitor
                $aiTitle = $this->aiService->generateCompetitorBasedTitle($name, $competitorAnalysis, $additionalInfo);
                $aiDescription = $this->aiService->generateCompetitorBasedDescription($name, $competitorAnalysis, $additionalInfo);
                $keywords = $this->aiService->generateCompetitorKeywords($name, $competitorAnalysis, $additionalInfo);
                $price = $this->aiService->recommendCompetitivePrice($name, $competitorAnalysis, $additionalInfo);
            } else {
                // Single row / tanpa data: pakai method standar
                $contextFromCsv = '';
                if ($csvData) {
                    $contextFromCsv = "\n\nData dari CSV:\n";
                    $contextFromCsv .= "- Nama: " . ($csvData['nama_produk'] ?? '') . "\n";
                    $contextFromCsv .= "- Harga: " . ($csvData['harga'] ?? '') . "\n";
                    $contextFromCsv .= "- Deskripsi: " . substr($csvData['deskripsi_produk'] ?? '', 0, 300) . "\n";
                }

                $aiTitle = $this->aiService->generateProductTitle($name, $additionalInfo);
                $aiDescription = $this->aiService->generateProductDescription(
                    $name . ($additionalInfo ? " Info: " . $additionalInfo : "") . $contextFromCsv,
                    $additionalInfo
                );
                $keywords = $this->aiService->generateKeywords($name, $additionalInfo);
                $price = $this->aiService->recommendPrice($name, $additionalInfo);
            }

            $categoryName = $this->aiService->recommendCategoryName($name, $additionalInfo);
            $categoryId = null;
            if ($categoryName) {
                $category = ProductCategory::where('name', 'like', '%' . $categoryName . '%')->first();
                $categoryId = $category->id ?? null;
            }

            $brand = $this->aiService->recommendBrand($name, $additionalInfo);
            $weight = $this->aiService->recommendWeight($name, $additionalInfo);
            $dimension = $this->aiService->recommendDimension($name, $additionalInfo);
            $variations = $this->aiService->recommendVariations($name, $additionalInfo);

            // === HITUNG SEO SCORE dari data yang di-generate ===
            $seoData = [
                'title'       => $aiTitle,
                'description' => $aiDescription,
                'keywords'    => $keywords,
                'brand'       => $brand,
                'category_id' => $categoryId,
                'price'       => $price,
                'variations'  => $variations,
                'images'      => [],
            ];
            $seoScore = $this->aiService->calculateSeoScore($seoData);

            $result = [
                'ai_title' => $aiTitle ?: $name,
                'ai_description' => $aiDescription ?: 'Deskripsi produk ' . $name,
                'keywords' => $keywords ?: $name,
                'recommended_price' => $price,
                'recommended_category_id' => $categoryId,
                'recommended_brand' => $brand,
                'recommended_weight' => $weight,
                'recommended_dimension' => $dimension,
                'recommended_shipping_options' => ['jne', 'jnt', 'pos', 'sicepat'],
                'recommended_variations' => $variations,
                'images' => [],
                'competitor_analysis' => $competitorAnalysis,
                'seo_score' => $seoScore,
                'is_smart_mode' => !empty($competitorAnalysis),
            ];

            return response()->json(['success' => true, 'data' => $result]);
        } catch (\Exception $e) {
            Log::error('Complete generate error: ' . $e->getMessage());
            return response()->json([
                'success' => true,
                'data' => [
                    'ai_title' => $request->name ?? 'Produk',
                    'ai_description' => 'Deskripsi produk ' . ($request->name ?? ''),
                    'keywords' => $request->name ?? '',
                    'recommended_price' => 0,
                    'recommended_category_id' => null,
                    'recommended_brand' => '',
                    'recommended_weight' => 250,
                    'recommended_dimension' => '',
                    'recommended_shipping_options' => ['jne', 'jnt', 'pos', 'sicepat'],
                    'recommended_variations' => [],
                    'images' => [],
                    'competitor_analysis' => null,
                    'seo_score' => null,
                    'is_smart_mode' => false,
                ]
            ]);
        }
    }

    /**
     * Hitung SEO score saja (tanpa regenerate).
     */
    public function seoScore(Request $request)
    {
        try {
            $data = $request->validate([
                'title' => 'nullable|string',
                'description' => 'nullable|string',
                'keywords' => 'nullable|string',
                'brand' => 'nullable|string',
                'category_id' => 'nullable|integer',
                'price' => 'nullable|numeric',
                'variations' => 'nullable|array',
                'images' => 'nullable|array',
            ]);

            $score = $this->aiService->calculateSeoScore($data);
            return response()->json(['success' => true, 'data' => $score]);
        } catch (\Exception $e) {
            Log::error('SEO score error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Analisis cepat data kompetitor dari CSV (sebelum generate).
     */
    public function analyzeCompetitor(Request $request)
    {
        try {
            $request->validate([
                'products' => 'required|array|min:1',
            ]);

            $analysis = $this->aiService->analyzeCompetitor($request->products);
            return response()->json([
                'success' => true,
                'data' => $analysis,
            ]);
        } catch (\Exception $e) {
            Log::error('Analyze competitor error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function generateImage(Request $request)
    {
        try {
            $request->validate([
                'prompt' => 'required|string',
                'count' => 'nullable|integer|min:1|max:3',
            ]);

            $count = min($request->count ?? 1, 3);
            $images = $this->imageService->generateMultipleImages($request->prompt, $count);

            return response()->json([
                'success' => true,
                'images' => $images,
                'count' => count($images)
            ]);
        } catch (\Exception $e) {
            Log::error('Image generation error: ' . $e->getMessage());
            $images = [];
            $count = min($request->count ?? 1, 3);
            for ($i = 0; $i < $count; $i++) {
                $images[] = "https://placehold.co/1024x1024/ee4d2d/white?text=Image+Error";
            }
            return response()->json([
                'success' => true,
                'images' => $images,
                'count' => $count,
                'fallback' => true
            ]);
        }
    }

    public function save(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'ai_title' => 'nullable|string',
                'description' => 'nullable|string',
                'keywords' => 'nullable|string',
                'category_id' => 'nullable|exists:product_categories,id',
                'brand' => 'nullable|string|max:255',
                'price' => 'nullable|numeric',
                'stock' => 'nullable|integer',
                'weight' => 'nullable|numeric',
                'dimension' => 'nullable|string|max:50',
                'shipping_options' => 'nullable|array',
                'variations' => 'nullable|array',
                'project_id' => 'nullable|exists:projects,id',
                'images' => 'nullable|array',
            ]);

            // Proses variasi
            $variations = $this->processVariations($request->variations ?? []);

            // Generate UUID untuk produk
            $productUuid = (string) Str::uuid();

            // Simpan produk
            $product = Product::create([
                'user_id' => Auth::id(),
                'uuid' => $productUuid,
                'project_id' => $request->project_id,
                'category_id' => $request->category_id,
                'name' => $request->name,
                'brand' => $request->brand,
                'ai_generated_title' => $request->ai_title,
                'description' => $request->description,
                'keywords' => $request->keywords,
                'price' => $request->price ?? 0,
                'stock' => $request->stock ?? 10,
                'weight' => $request->weight ?? 250,
                'dimension' => $request->dimension,
                'shipping_options' => $request->shipping_options,
                'variations' => $variations,
                'watermark_enabled' => false,
                'status' => 'draft',
            ]);

            // Simpan gambar produk
            if ($request->has('images') && is_array($request->images)) {
                foreach ($request->images as $index => $imageData) {
                    $imagePath = $this->saveImage($imageData);
                    if ($imagePath) {
                        ProductImage::create([
                            'product_id' => $product->id,
                            'path' => $imagePath,
                            'sort_order' => $index
                        ]);
                    }
                }
            }

            Log::info('Product saved successfully', ['product_id' => $product->id, 'uuid' => $product->uuid, 'user_id' => Auth::id()]);

            return response()->json([
                'success' => true,
                'product' => [
                    'id' => $product->id,
                    'uuid' => $product->uuid,
                    'name' => $product->name
                ],
                'message' => 'Product saved successfully!'
            ]);
        } catch (\Exception $e) {
            Log::error('Save product error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
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

    /**
     * Update the specified product.
     */
    public function update(Request $request, Product $product)
    {
        // Cek kepemilikan
        if ($product->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

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
            'shipping_options' => 'nullable|array',
            'variations' => 'nullable|array',
            'images' => 'nullable|array',
            'deleted_images' => 'nullable|array',
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
            'shipping_options' => $validated['shipping_options'] ?? ['jne', 'jnt', 'pos', 'sicepat'],
            'variations' => $this->processVariations($validated['variations'] ?? []),
        ]);

        // Handle deleted images
        if ($request->has('deleted_images') && is_array($request->deleted_images)) {
            foreach ($request->deleted_images as $imageId) {
                $image = ProductImage::find($imageId);
                if ($image && $image->product_id === $product->id) {
                    // Hapus file fisik
                    $path = str_replace('/storage/', '', $image->path);
                    if (Storage::disk('public')->exists($path)) {
                        Storage::disk('public')->delete($path);
                    }
                    $image->delete();
                }
            }
        }

        // Handle new images (base64)
        if ($request->has('images') && is_array($request->images)) {
            $currentSortOrder = $product->images()->count();
            foreach ($request->images as $imageData) {
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
                        } elseif ($image && (str_contains($image, '/storage/') || str_contains($image, 'http'))) {
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

    protected function saveImage($imageData)
    {
        if (is_string($imageData) && str_contains($imageData, 'base64')) {
            return $this->saveBase64Image($imageData, 'products');
        }

        if (is_string($imageData) && (str_contains($imageData, '/storage/') || str_contains($imageData, 'http'))) {
            return $imageData;
        }

        return null;
    }

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
                    Log::warning('Image too large or decode failed');
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
            Log::error('Save base64 image failed: ' . $e->getMessage());
            return null;
        }

        return null;
    }
}
