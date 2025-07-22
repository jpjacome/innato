<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutSetting extends Model
{
    protected $table = 'about_settings';
    protected $fillable = [
        'title',
        'description',
        'card_1',
        'card_2',
        'card_3',
        'card_4',
        'cards',
        'hero_title',
        'banner_text',
        'banner_image',
        'headline_title',
        'headline_1_name',
        'headline_1_role',
        'headline_1_desc',
        'headline_1_img',
        'headline_2_name',
        'headline_2_role',
        'headline_2_desc',
        'headline_2_img',
        'headline_cards',
        'destinations_title',
        'destinations_button',
        'destinations_button_text',
    ];

    public $timestamps = false;

    // Singleton pattern for settings
    public static function instance()
    {
        return static::firstOrCreate([], [
            'title' => '¿QUIÉNES SOMOS?',
            'description' => 'Somos un centro de experiencias que ofrece inmersión cultural, compromiso con la sostenibilidad, turismo comunitario y gastronomía con productos locales. Atraer a viajeros conscientes y amantes de la cultura que compartan nuestros mismos valores:',
            'hero_title' => 'TURISMO COMUNITARIO',
            'cards' => json_encode([
                ['title' => 'Autenticidad'],
                ['title' => 'Sostenibilidad'],
                ['title' => 'Conexión'],
                ['title' => 'Aprendizaje'],
            ]),
            'banner_text' => '"TRAVEL WITH RESPECT FOR NATURE AND CULTURES”',
            'banner_image' => null,
            'headline_title' => '¿QUIÉN ESTÁ DETRÁS DE INNATO?',
            'headline_cards' => json_encode([
                [
                    'title' => 'JOHANNA VITERI',
                    'subtitle' => 'Founder',
                    'degree' => 'Ms. en Gestión de Destinos Turísticos.',
                    'description' => 'Administración de Empresas Hoteleras y Turísticas. Gest de recursos hotelero y turístico.',
                    'image' => 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=600&q=80',
                ],
                [
                    'title' => 'CYNTHIA VITERI',
                    'subtitle' => 'Founder',
                    'degree' => 'Ms. en RI en Econ. para el Desarrollo.',
                    'description' => 'Gerencia de proyectos de desarrollo rural, administración y gestión financiera.',
                    'image' => 'https://images.unsplash.com/photo-1464983953574-0892a716854b?auto=format&fit=crop&w=600&q=80',
                ],
            ]),
            'destinations_title' => 'VISITA EL CENTRO DE EXPERIENCIAS TURÍSTICAS',
            'destinations_button_text' => 'UBICACIÓN',
        ]);
    }
}
