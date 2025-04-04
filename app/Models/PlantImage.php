<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlantImage extends Model
{
    protected $fillable = [
        'plant_id',
        'image_path',
        'image_order',
    ];

    /**
     * Get the plant that owns this image
     */
    public function plant(): BelongsTo
    {
        return $this->belongsTo(Plant::class);
    }
}
