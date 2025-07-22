<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewsSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'reviews_data',
    ];

    public static function instance()
    {
        $instance = self::first();
        
        if (!$instance) {
            $instance = self::create([
                'title' => 'What Our Visitors Say',
                'subtitle' => 'Experience through their eyes',
                'reviews_data' => json_encode([
                    [
                        'text' => 'Excellent as always! This is a very nice choice if you like good food and a superb environment.',
                        'reviewer' => 'John Doe',
                        'rating' => 5,
                        'location' => 'New York, USA'
                    ],
                    [
                        'text' => 'A wonderful experience! The staff was friendly and the place was beautiful.',
                        'reviewer' => 'Maria Perez',
                        'rating' => 4,
                        'location' => 'Madrid, Spain'
                    ],
                    [
                        'text' => 'Unforgettable trip, highly recommended for families.',
                        'reviewer' => 'Carlos Ruiz',
                        'rating' => 5,
                        'location' => 'Mexico City, Mexico'
                    ],
                    [
                        'text' => 'Great value and amazing guides. Will come back!',
                        'reviewer' => 'Ana Gómez',
                        'rating' => 4,
                        'location' => 'Buenos Aires, Argentina'
                    ],
                    [
                        'text' => 'The best eco-tourism experience in Ecuador.',
                        'reviewer' => 'Luis Torres',
                        'rating' => 5,
                        'location' => 'Quito, Ecuador'
                    ]
                ]),
            ]);
        }
        
        return $instance;
    }

    public function getReviewsAttribute()
    {
        if ($this->reviews_data) {
            return json_decode($this->reviews_data, true) ?? [];
        }
        return [];
    }
}
