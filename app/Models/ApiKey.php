<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiKey extends Model
{
    protected $fillable = [
        'provider', 'key', 'status', 'last_checked_at', 
        'fail_count', 'notes', 'priority'
    ];

    protected $casts = [
        'last_checked_at' => 'datetime',
        'priority' => 'integer',
        'fail_count' => 'integer',
    ];

    // Scope untuk mendapatkan key yang aktif
    public function scopeActive($query, $provider = null)
    {
        $query->where('status', 'active');
        if ($provider) {
            $query->where('provider', $provider);
        }
        return $query->orderBy('priority', 'desc')->orderBy('id');
    }

    // Tandai key sebagai limited
    public function markAsLimited()
    {
        $this->status = 'limited';
        $this->last_checked_at = now();
        $this->fail_count++;
        $this->save();
    }

    // Tandai key sebagai aktif kembali (misal setelah cooldown)
    public function markAsActive()
    {
        $this->status = 'active';
        $this->last_checked_at = now();
        $this->fail_count = 0;
        $this->save();
    }
}