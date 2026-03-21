<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'name',
        'email',
        'message',
        'starts_at',
        'ends_at',
        'timezone',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
        ];
    }

    public function scopeBlocking($query)
    {
        return $query->where('status', '!=', 'cancelled');
    }
}
