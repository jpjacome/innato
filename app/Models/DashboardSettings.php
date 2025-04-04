<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DashboardSettings extends Model
{
    protected $fillable = [
        'primary_color',
        'secondary_color',
        'accent_color',
        'dark_primary_color',
        'dark_secondary_color',
        'dark_accent_color',
        'dashboard_title',
        'logo',
        'show_logo'
    ];
} 