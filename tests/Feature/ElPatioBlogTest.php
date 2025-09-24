<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\ElPatioPost;

class ElPatioBlogTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function public_blog_index_is_accessible()
    {
        ElPatioPost::factory()->count(3)->create();

        $response = $this->get('/elpatio/blog');

        $response->assertStatus(200);
        $response->assertSee('Blog');
    }

    /** @test */
    public function single_post_page_is_accessible()
    {
        $post = ElPatioPost::factory()->create();

        $response = $this->get('/elpatio/blog/' . $post->slug);

        $response->assertStatus(200);
        $response->assertSee($post->title);
    }

    // Additional tests for admin CRUD would go here (requires auth setup)
}
