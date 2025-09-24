<?php

namespace App\Traits;

use App\Models\SeoMeta;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait HasSEO
{
    /**
     * Get the SEO meta data for this model.
     */
    public function seoMeta(): MorphOne
    {
        return $this->morphOne(SeoMeta::class, 'seoable');
    }
    
    /**
     * Get the SEO title (from SEO meta or default).
     */
    public function getSeoTitle(): string
    {
        return $this->seoMeta?->getEffectiveMetaTitle() ?? $this->getDefaultSeoTitle();
    }
    
    /**
     * Get the SEO description (from SEO meta or default).
     */
    public function getSeoDescription(): string
    {
        return $this->seoMeta?->getEffectiveMetaDescription() ?? $this->getDefaultSeoDescription();
    }
    
    /**
     * Get the SEO keywords.
     */
    public function getSeoKeywords(): ?string
    {
        return $this->seoMeta?->meta_keywords;
    }
    
    /**
     * Get the canonical URL.
     */
    public function getCanonicalUrl(): ?string
    {
        return $this->seoMeta?->canonical_url;
    }
    
    /**
     * Get the Open Graph image URL.
     */
    public function getOgImageUrl(): ?string
    {
        return $this->seoMeta?->og_image ? asset('storage/' . $this->seoMeta->og_image) : null;
    }
    
    /**
     * Check if this model should be indexed by search engines.
     */
    public function shouldBeIndexed(): bool
    {
        return $this->seoMeta?->robots_index ?? true;
    }
    
    /**
     * Check if search engines should follow links on this page.
     */
    public function shouldFollowLinks(): bool
    {
        return $this->seoMeta?->robots_follow ?? true;
    }
    
    /**
     * Get default SEO title for this model.
     * Must be implemented by models using this trait.
     */
    abstract protected function getDefaultSeoTitle(): string;
    
    /**
     * Get default SEO description for this model.
     * Must be implemented by models using this trait.
     */
    abstract protected function getDefaultSeoDescription(): string;
}