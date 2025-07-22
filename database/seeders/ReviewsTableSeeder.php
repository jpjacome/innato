<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;

class ReviewsTableSeeder extends Seeder
{
    public function run()
    {
        $defaultReviews = [
            [
                'text' => 'Excellent as always! This is a very nice choice if you like good food and a superb environment.',
                'reviewer' => 'John Doe',
                'rating' => 5,
                'location' => 'New York, USA',
                'status' => 'published',
            ],
            [
                'text' => 'A wonderful experience! The staff was friendly and the place was beautiful.',
                'reviewer' => 'Maria Perez',
                'rating' => 4,
                'location' => 'Madrid, Spain',
                'status' => 'published',
            ],
            [
                'text' => 'Unforgettable trip, highly recommended for families.',
                'reviewer' => 'Carlos Ruiz',
                'rating' => 5,
                'location' => 'Mexico City, Mexico',
                'status' => 'published',
            ],
            [
                'text' => 'Great value and amazing guides. Will come back!',
                'reviewer' => 'Ana Gómez',
                'rating' => 4,
                'location' => 'Buenos Aires, Argentina',
                'status' => 'published',
            ],
            [
                'text' => 'The best eco-tourism experience in Ecuador.',
                'reviewer' => 'Luis Torres',
                'rating' => 5,
                'location' => 'Quito, Ecuador',
                'status' => 'published',
            ],
        ];

        foreach ($defaultReviews as $review) {
            Review::create($review);
        }
    }
}
