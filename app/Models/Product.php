<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'uuid',
        'user_id',
        'project_id',
        'category_id',
        'name',
        'category',
        'brand',
        'price',
        'stock',
        'weight',
        'dimension',
        'shipping_options',
        'variations',
        'description',
        'keywords',
        'ai_generated_title',
        'ai_generated_description',
        'status',
        'is_archived',
        'watermark_enabled'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'shipping_options' => 'array',
        'variations' => 'array',
        'is_archived' => 'boolean',
        'watermark_enabled' => 'boolean',
        'stock' => 'integer',
        'weight' => 'float'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) \Illuminate\Support\Str::uuid();
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id')->orderBy('sort_order');
    }
    
    public function getPrimaryImageAttribute()
    {
        if ($this->relationLoaded('images')) {
            $primary = $this->images->firstWhere('is_primary', true);
            return $primary ? $primary->path : ($this->images->first()->path ?? null);
        }
        return $this->images()->where('is_primary', true)->value('path') 
            ?? $this->images()->value('path');
    }

    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }
}
