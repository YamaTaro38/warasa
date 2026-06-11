<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Documentation extends Model
{
    protected $fillable = [
        'uuid', 'title', 'slug', 'content', 'category', 'sort_order', 'is_published'
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('title');
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($doc) {
            if (empty($doc->uuid)) {
                $doc->uuid = Str::uuid()->toString();
            }
            if (empty($doc->slug)) {
                $doc->slug = Str::slug($doc->title);
            }
        });
    }
}