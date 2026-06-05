<?php
// app/Models/ExportHistory.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExportHistory extends Model
{
    protected $fillable = [
        'user_id',
        'product_ids',
        'file_name',
        'file_path',
        'format',
    ];
    
    protected $casts = [
        'product_ids' => 'array',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}