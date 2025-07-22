<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'reviewer',
        'text',
        'rating',
        'location',
        'status',
    ];

    // Optionally, add scopes for published reviews
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }
}
