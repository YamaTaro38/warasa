<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = ProductCategory::with('children')
            ->whereNull('parent_id')
            ->orderBy('id')
            ->paginate(20);

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        $parents = ProductCategory::whereNull('parent_id')->orderBy('id')->get();
        return view('admin.categories.create', compact('parents'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:product_categories',
            'slug' => 'required|unique:product_categories',
            'description' => 'nullable',
            'sort_order' => 'integer',
            'is_active' => 'boolean',
            'parent_id' => 'nullable|exists:product_categories,id',
        ]);

        $validated['uuid'] = Str::uuid()->toString();
        ProductCategory::create($validated);
        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil ditambahkan');
    }

    public function edit(ProductCategory $category)
    {
        $categories = [];
        if ($category->hasProducts()) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Kategori yang sudah memiliki produk tidak dapat diedit');
        }
        
        // Load sub-categories for parent edit view
        if ($category->children->count() > 0) {
            $category->load('children.products');
        }

        $parents = ProductCategory::whereNull('parent_id')
            ->where('id', '!=', $category->id)
            ->orderBy('id')
            ->get();
            
        return view('admin.categories.edit', compact('category', 'parents'));
    }

    public function update(Request $request, ProductCategory $category)
    {
        if ($category->hasProducts()) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Kategori yang sudah memiliki produk tidak dapat diupdate');
        }

        $validated = $request->validate([
            'name' => 'required|unique:product_categories,name,' . $category->id,
            'slug' => 'required|unique:product_categories,slug,' . $category->id,
            'description' => 'nullable',
            'sort_order' => 'integer',
            'spec_template' => 'nullable|array',
            'is_active' => 'boolean',
            'parent_id' => 'nullable|exists:product_categories,id',
        ]);

        $category->update($validated);
        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil diupdate');
    }

    public function destroy(ProductCategory $category)
    {
        if ($category->hasProducts()) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Kategori yang sudah memiliki produk tidak dapat dihapus');
        }

        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil dihapus');
    }

    public function toggleActive(ProductCategory $category)
    {
        if ($category->hasProducts()) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Kategori yang sudah memiliki produk tidak dapat diubah statusnya');
        }

        $category->update(['is_active' => !$category->is_active]);
        return back()->with('success', 'Status kategori berhasil diubah');
    }

    public function list(Request $request)
    {
        $categories = ProductCategory::where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get(['id', 'name', 'slug', 'parent_id']);

        $formatted = $categories->map(function ($cat) {
            return [
                'id' => $cat->id,
                'name' => $cat->name,
                'slug' => $cat->slug,
                'parent_id' => $cat->parent_id,
            ];
        });

        return response()->json([
            'success' => true,
            'categories' => $formatted
        ]);
    }
}