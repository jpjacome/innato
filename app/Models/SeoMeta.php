<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class SeoMeta extends Model
{
    protected $table = 'seo_meta';
    
    protected $fillable = [
        'meta_title',
        'meta_description',
        'meta_keywords',
        'canonical_url',
        'og_title',
        'og_description',
        'og_image',
        'og_type',
        'twitter_card',
        'robots_index',
        'robots_follow',
        'custom_meta',
    ];
    
    protected $casts = [
        'robots_index' => 'boolean',
        'robots_follow' => 'boolean',
        'custom_meta' => 'array',
    ];
    
    /**
     * Get the owning seoable model.
     */
    public function seoable(): MorphTo
    {
        return $this->morphTo();
    }
    
    /**
     * Get the effective meta title (fallback to model default if empty).
     */
    public function getEffectiveMetaTitle(): ?string
    {
        return $this->meta_title ?: ($this->seoable ? $this->seoable->getDefaultSeoTitle() : null);
    }
    
    /**
     * Get the effective meta description (fallback to model default if empty).
     */
    public function getEffectiveMetaDescription(): ?string
    {
        return $this->meta_description ?: ($this->seoable ? $this->seoable->getDefaultSeoDescription() : null);
    }
}
