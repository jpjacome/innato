<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductsSetting extends Model
{
    protected $fillable = [
        'banner_title',
        'banner_description',
        'banner_image',
        'section_title',
        'section_description',
        'product1_title',
        'product1_description',
        'product1_image',
        'product2_title',
        'product2_description',
        'product2_image',
        'product3_title',
        'product3_description',
        'product3_image',
        'product4_title',
        'product4_description',
        'product4_image',
    ];

    /**
     * Get the singleton instance of the ProductsSetting.
     * This follows the same pattern as other settings models in the project.
     */
    public static function instance()
    {
        return static::first() ?: static::create([
            'banner_title' => 'PRODUCTOS LOCALES AUTÉNTICOS',
            'banner_description' => 'Descubre la autenticidad de Ecuador a través de nuestros productos locales, cuidadosamente seleccionados por su calidad y tradición.',
            'section_title' => 'NUESTROS PRODUCTOS DESTACADOS',
            'section_description' => 'Cada producto cuenta una historia de tradición, calidad y el amor por nuestra tierra ecuatoriana.',
            'product1_title' => 'CACAO ORGÁNICO',
            'product1_description' => 'Cacao de origen ecuatoriano, cultivado de manera orgánica en las mejores tierras del país.',
            'product2_title' => 'CAFÉ DE ALTURA',
            'product2_description' => 'Café cultivado en las montañas andinas, con notas únicas que reflejan la riqueza de nuestros suelos.',
            'product3_title' => 'TEXTILES ARTESANALES',
            'product3_description' => 'Textiles tradicionales tejidos a mano, preservando técnicas ancestrales de nuestras comunidades.',
            'product4_title' => 'MIEL DE ABEJA',
            'product4_description' => 'Miel pura y natural, recolectada de colmenas ubicadas en ecosistemas diversos y pristinos.',
        ]);
    }
}