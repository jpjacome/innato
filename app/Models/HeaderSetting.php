<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeaderSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'nav_about_text',
        'nav_destinations_text',
        'nav_experience_text',
        'nav_hostal_text',
        'nav_contact_text',
        'nav_reviews_text',
        'search_placeholder',
    ];

    public static function instance()
    {
        $instance = self::first();
        
        if (!$instance) {
            $instance = new self([
                'nav_about_text' => 'About Us',
                'nav_destinations_text' => 'Destinations',
                'nav_experience_text' => 'Tourist Experience Center',
                'nav_hostal_text' => 'Hostal',
                'nav_contact_text' => 'Contact',
                'nav_reviews_text' => 'Reviews',
                'search_placeholder' => 'Search...',
            ]);
        }
        
        return $instance;
    }
}
