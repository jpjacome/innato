<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MaintenanceLog extends Model
{
    protected $fillable = [
        'plant_id',
        'last_watering',
        'next_watering',
        'last_fertilization',
        'next_fertilization',
        'last_pruning',
        'next_pruning',
        'pest_disease_inspection',
    ];

    protected $casts = [
        'last_watering' => 'date',
        'next_watering' => 'date',
        'last_fertilization' => 'date',
        'next_fertilization' => 'date',
        'last_pruning' => 'date',
        'next_pruning' => 'date',
    ];

    /**
     * Get the plant that owns this maintenance log
     */
    public function plant(): BelongsTo
    {
        return $this->belongsTo(Plant::class);
    }

    /**
     * Get the images for this maintenance log
     */
    public function images(): HasMany
    {
        return $this->hasMany(MaintenanceImage::class, 'maintenance_id');
    }
}
