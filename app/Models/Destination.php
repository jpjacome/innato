<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
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
        'status'
    ];

    protected $casts = [
        'climate_dry_season' => 'array',
        'climate_wet_season' => 'array',
        'activities' => 'array',
        'services' => 'array',
        'tourism_criteria' => 'array',
        'environmental_challenges' => 'array',
        'gallery_images' => 'array'
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

    /**
     * Get the editor assigned to this destination.
     */
    public function assignedEditor()
    {
        return $this->hasOne(User::class, 'destination_id');
    }
}
