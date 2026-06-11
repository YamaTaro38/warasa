<?php
// app/Models/ProductCategory.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductCategory extends Model
{
    protected $fillable = [
        'uuid', 'name', 'slug', 'shopee_code', 'description', 'spec_template', 'is_active', 'sort_order', 'parent_id'
    ];
    
    protected $casts = [
        'spec_template' => 'array',
        'is_active' => 'boolean',
    ];

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    public function hasProducts(): bool
    {
        return $this->products()->count() > 0;
    }
    
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
}