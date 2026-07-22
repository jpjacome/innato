<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasSEO;
use Illuminate\Support\Str;

class Destination extends Model
{
    use HasSEO;
    // ...existing code...
    protected $fillable = [
        'slug',
        'title',
        'subtitle',
        'coordinates',
        'conservation_status',
        'province',
        'canton',
        'parish',
        'sector',
        'reference_distance',
        'climate_dry_season',
        'climate_wet_season',
        'access_from',
        'access_route',
        'access_transport',
        'access_time',
        'schedule_hours',
        'entry_fee',
        'season_availability',
        'requirements',
        'contact_person',
        'contact_role',
        'contact_phone',
        'contact_email',
        'activities',
        'target_audience_type',
        'target_audience_origin',
        'target_audience_age',
        'target_audience_transport',
        'target_audience_stay',
        'services',
        'average_price',
        'capacity',
        'payment_methods',
        'mobile_coverage',
        'tourism_criteria',
        'main_description',
        'secondary_description',
        'strengths_benefits',
        'environmental_challenges',
        'hero_image',
        'gallery_images',
        'status',
        'altitude',
        'considerations',
        'what_to_bring',
        'difficulty_level'
    ];

    protected $casts = [
        'climate_dry_season' => 'array',
        'climate_wet_season' => 'array',
        'activities' => 'array',
        'services' => 'array',
        'tourism_criteria' => 'array',
        'environmental_challenges' => 'array',
        'gallery_images' => 'array',
        'considerations' => 'array',
        'what_to_bring' => 'array'
    ];

    // Helper methods for formatted output
    public function getFormattedActivities()
    {
        return $this->activities ? collect($this->activities)->map(function ($activity) {
            return [
                'icon' => $activity['icon'] ?? 'ph ph-activity',
                'name' => $activity['name'] ?? $activity
            ];
        }) : collect();
    }

    public function getFormattedServices()
    {
        return $this->services ? collect($this->services)->map(function ($service) {
            return [
                'icon' => $service['icon'] ?? 'ph ph-check',
                'name' => $service['name'] ?? $service,
                'available' => $service['available'] ?? true
            ];
        }) : collect();
    }

    public function getFormattedCriteria()
    {
        return $this->tourism_criteria ? collect($this->tourism_criteria)->map(function ($criteria) {
            return [
                'icon' => $criteria['status'] === 'positive' ? 'ph ph-check-circle' : 'ph ph-x-circle',
                'name' => $criteria['name'],
                'status' => $criteria['status'] // positive, neutral, negative
            ];
        }) : collect();
    }

    public function getClimateSeasons()
    {
        return [
            'dry' => $this->climate_dry_season,
            'wet' => $this->climate_wet_season
        ];
    }

    public function getFormattedConsiderations()
    {
        return $this->considerations ? collect($this->considerations)->map(function ($consideration) {
            return [
                'icon' => $consideration['icon'] ?? 'ph ph-warning-circle',
                'text' => $consideration['text'] ?? $consideration
            ];
        }) : collect();
    }

    public function getFormattedWhatToBring()
    {
        return $this->what_to_bring ? collect($this->what_to_bring)->map(function ($item) {
            return [
                'icon' => $item['icon'] ?? 'ph ph-backpack',
                'text' => $item['text'] ?? $item
            ];
        }) : collect();
    }

    public function getDifficultyData()
    {
        $raw = $this->difficulty_level ?? 2;

        $intMap = [
            1 => ['level' => 1, 'percentage' => 33, 'color' => 'success', 'label' => 'Fácil'],
            2 => ['level' => 2, 'percentage' => 66, 'color' => 'warning', 'label' => 'Moderado'],
            3 => ['level' => 3, 'percentage' => 100, 'color' => 'danger', 'label' => 'Difícil'],
        ];

        $legacyMap = [
            'bajo'  => $intMap[1],
            'medio' => $intMap[2],
            'alto'  => $intMap[3],
        ];

        if (is_numeric($raw)) {
            return $intMap[(int) $raw] ?? $intMap[2];
        }

        return $legacyMap[strtolower($raw)] ?? $intMap[2];
    }

    /**
     * Get the editor assigned to this destination.
     */
    public function assignedEditor()
    {
        return $this->hasOne(User::class, 'destination_id');
    }
    
    /**
     * Get default SEO title for this destination.
     */
    protected function getDefaultSeoTitle(): string
    {
        return $this->title . ' - Turismo Comunitario Ecuador | INNATO';
    }
    
    /**
     * Get default SEO description for this destination.
     */
    protected function getDefaultSeoDescription(): string
    {
        $description = $this->main_description ?? $this->secondary_description ?? $this->subtitle ?? '';
        return Str::limit(strip_tags($description), 155);
    }
}
