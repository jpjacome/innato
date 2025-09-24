<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ElPatioSetting extends Model
{
    use HasFactory;

    protected $table = 'elpatio_settings';

    protected $fillable = [
        'hero_background',
        'loading_logo',
        'about_title',
    'about_title_highlight',
        'about_text',
        'about_image',
        'about2_title',
    'about2_title_highlight',
        'about2_text',
        'about2_image',
        'rooms_title',
    'rooms_title_highlight',
        'amenities_list',
        'gallery',
        'header_menu',
        'social_links',
        'footer',
    ];

    /**
     * Cast JSON/text columns to arrays when accessed.
     */
    protected $casts = [
        'gallery' => 'array',
        'amenities_list' => 'array',
    'header_menu' => 'array',
    'social_links' => 'array',
    'footer' => 'array',
    ];

    /**
     * Return the singleton instance (first record) creating a default if missing
     */
    public static function instance()
    {
        return static::firstOrCreate([]);
    }
}
