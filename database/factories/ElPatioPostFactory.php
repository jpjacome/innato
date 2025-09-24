<?php
namespace Database\Factories;

use App\Models\ElPatioPost;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ElPatioPostFactory extends Factory
{
    protected $model = ElPatioPost::class;

    public function definition()
    {
        $title = $this->faker->sentence();
        return [
            'title' => $title,
            'slug' => Str::slug($title) . '-' . time(),
            'excerpt' => $this->faker->paragraph(),
            'body' => '<p>' . implode('</p><p>', $this->faker->paragraphs(3)) . '</p>',
            'published_at' => now(),
        ];
    }
}
