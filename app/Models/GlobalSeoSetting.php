<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GlobalSeoSetting extends Model
{
    protected $fillable = [
        'site_title',
        'site_description',
        'site_keywords',
        'author',
        'site_language',
        'og_site_name',
        'og_image',
        'og_type',
        'twitter_card',
        'twitter_site',
        'twitter_creator',
        'google_analytics_id',
        'google_tag_manager_id',
        'google_site_verification',
        'bing_site_verification',
        'yandex_site_verification',
        'organization_schema',
        'head_scripts',
        'body_scripts',
        'enable_canonical_urls',
        'enable_og_tags',
        'enable_twitter_cards',
        'enable_schema_markup',
    ];

    protected $casts = [
        'organization_schema' => 'array',
        'enable_canonical_urls' => 'boolean',
        'enable_og_tags' => 'boolean',
        'enable_twitter_cards' => 'boolean',
        'enable_schema_markup' => 'boolean',
    ];

    /**
     * Get the singleton instance of global SEO settings.
     */
    public static function instance(): self
    {
        return static::first() ?? static::create([
            'site_title' => 'INNATO - Turismo y Naturaleza en Ecuador',
            'site_description' => 'Descubre los mejores destinos turísticos de Ecuador con INNATO. Explora la biodiversidad, cultura y aventuras que ofrece nuestro país.',
            'site_language' => 'es',
            'og_type' => 'website',
            'twitter_card' => 'summary_large_image',
            'enable_canonical_urls' => true,
            'enable_og_tags' => true,
            'enable_twitter_cards' => true,
            'enable_schema_markup' => true,
        ]);
    }

    /**
     * Get the default organization schema.
     */
    public function getDefaultOrganizationSchema(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => $this->site_title ?? 'INNATO',
            'description' => $this->site_description,
            'url' => url('/'),
            'logo' => $this->og_image ? url('storage/' . $this->og_image) : null,
            'sameAs' => [],
        ];
    }
}
