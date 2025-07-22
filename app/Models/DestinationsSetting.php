<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DestinationsSetting extends Model
{
    protected $table = 'destinations_settings';
    protected $guarded = [];
    public $timestamps = false;

    // Singleton pattern for easy access
    public static function instance()
    {
        return static::first();
    }
}
