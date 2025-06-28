<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeSetting extends Model
{
    protected $fillable = [
        'hero_title',
        'hero_button_text',
        'hero_video_path',
        'headline_title',
        'headline_description',
        'headline_coast_image',
        'headline_andes_image',
        'headline_amazon_image',
        'destinations_title',
        'destinations_description',
        'destinations_button_text',
        'destinations_footer_text',
    ];

    /**
     * Default values for attributes
     */
    protected $attributes = [
        'hero_title' => 'TURISMO COMUNITARIO',
        'hero_button_text' => 'CONOCE MÁS',
        'headline_title' => 'CONÉCTATE CON LA ESENCIA DE ECUADOR',
        'headline_description' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna liquam erat volutpat.',
        'headline_coast_image' => null,
        'headline_andes_image' => null,
        'headline_amazon_image' => null,
        'destinations_title' => 'EXPLORA ECUADOR Y SUS COMUNIDADES',
        'destinations_description' => 'Ecuador es conocido por la diversidad de sus regiones principales: Amazonía, Costa, Sierra.',
        'destinations_button_text' => 'CONOCE MÁS',
        'destinations_footer_text' => 'Haz clic en una región para observarla más de cerca.',
    ];

    /**
     * Get the first (singleton) home setting instance
     */
    public static function instance()
    {
        return static::firstOrCreate([]);
    }
}
