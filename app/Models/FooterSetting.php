<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FooterSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'address',
        'phone',
        'location',
        'twitter_url',
        'instagram_url',
        'newsletter_title',
        'newsletter_placeholder',
        'newsletter_button_text',
        'copyright_text',
        'attribution_text',
        'attribution_url',
        'attribution_link_text',
    ];

    public static function instance()
    {
        $instance = self::first();
        
        if (!$instance) {
            $instance = new self([
                'address' => 'LUIS CORDERO Y REINA VICTORIA',
                'phone' => '(593) 09 6710-7073',
                'location' => 'QUITO - ECUADOR',
                'twitter_url' => '',
                'instagram_url' => '',
                'newsletter_title' => 'Subscribe to our newsletter',
                'newsletter_placeholder' => 'Your email',
                'newsletter_button_text' => 'Send',
                'copyright_text' => '© 2025 INNATO – BRANNA BRANDS.',
                'attribution_text' => 'carefully crafted by',
                'attribution_url' => 'https://drpixel.it.nf/',
                'attribution_link_text' => 'DR PIXEL',
            ]);
        }
        
        return $instance;
    }
}
