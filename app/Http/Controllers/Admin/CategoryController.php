<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = ProductCategory::orderBy('sort_order')->paginate(20);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:product_categories',
            'slug' => 'required|unique:product_categories',
            'description' => 'nullable',
            'sort_order' => 'integer',
        ]);

        ProductCategory::create($validated);
        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil ditambahkan');
    }

    public function edit(ProductCategory $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, ProductCategory $category)
    {
        $validated = $request->validate([
            'name' => 'required|unique:product_categories,name,' . $category->id,
            'slug' => 'required|unique:product_categories,slug,' . $category->id,
            'description' => 'nullable',
            'sort_order' => 'integer',
            'spec_template' => 'nullable|array',
        ]);

        $category->update($validated);
        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil diupdate');
    }

    public function destroy(ProductCategory $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil dihapus');
    }

    public function list(Request $request)
    {
        $categories = ProductCategory::where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get(['id', 'name', 'slug', 'parent_id']);

        // Format untuk frontend
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
