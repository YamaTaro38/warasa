<?php
// app/Models/ProductCategory.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // <-- Tambahkan ini
use Illuminate\Database\Eloquent\Relations\HasMany;   // <-- Tambahkan ini

class ProductCategory extends Model
{
    protected $fillable = [
        'name', 'slug', 'shopee_code', 'description', 'spec_template', 'is_active', 'sort_order', 'parent_id'
    ];
    
    protected $casts = [
        'spec_template' => 'array',
        'is_active' => 'boolean',
    ];
    
    /**
     * Relasi ke sub-kategori (child categories)
     */
    public function children(): HasMany
    {
        return $this->hasMany(ProductCategory::class, 'parent_id');
    }
    
    /**
     * Relasi ke kategori induk (parent category)
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'parent_id');
    }
    
    /**
     * Relasi ke produk
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'category_id');
    }
}