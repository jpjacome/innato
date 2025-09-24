<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'title',
        'description',
        'image',
        'order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get active products ordered by their order field
     */
    public static function active()
    {
        return static::where('is_active', true)->orderBy('order')->orderBy('created_at');
    }

    /**
     * Get all products ordered by their order field
     */
    public static function ordered()
    {
        return static::orderBy('order')->orderBy('created_at');
    }
}
