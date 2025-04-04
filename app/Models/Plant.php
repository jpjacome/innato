<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plant extends Model
{
    protected $fillable = [
        'name',
        'common_names',
        'family',
        'native_range',
        'age',
        'current_height',
        'expected_height',
        'leaf_type',
        'bloom_time',
        'flower_color',
        'fruit',
        'light',
        'soil',
        'hardiness',
        'other_comments',
    ];

    /**
     * Get all images for this plant
     */
    public function images(): HasMany
    {
        return $this->hasMany(PlantImage::class)->orderBy('image_order');
    }

    /**
     * Get all maintenance logs for this plant
     */
    public function maintenanceLogs(): HasMany
    {
        return $this->hasMany(MaintenanceLog::class)->orderBy('created_at', 'desc');
    }
}
