<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaintenanceImage extends Model
{
    protected $fillable = [
        'maintenance_id',
        'image_path',
    ];

    /**
     * Get the maintenance log that owns this image
     */
    public function maintenanceLog(): BelongsTo
    {
        return $this->belongsTo(MaintenanceLog::class, 'maintenance_id');
    }
}
