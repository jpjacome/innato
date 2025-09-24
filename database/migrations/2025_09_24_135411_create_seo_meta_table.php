<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('seo_meta', function (Blueprint $table) {
            $table->id();
            
            // Polymorphic relationship
            $table->string('seoable_type');
            $table->unsignedBigInteger('seoable_id');
            
            // SEO Meta fields
            $table->string('meta_title', 255)->nullable();
            $table->string('meta_description', 160)->nullable();
            $table->text('meta_keywords')->nullable();
            $table->string('canonical_url')->nullable();
            
            // Open Graph fields
            $table->string('og_title')->nullable();
            $table->text('og_description')->nullable();
            $table->string('og_image')->nullable();
            $table->string('og_type')->default('website');
            
            // Twitter Card fields
            $table->string('twitter_card')->default('summary_large_image');
            
            // Robots directives
            $table->boolean('robots_index')->default(true);
            $table->boolean('robots_follow')->default(true);
            
            // Custom meta data (JSON)
            $table->json('custom_meta')->nullable();
            
            $table->timestamps();
            
            // Indexes for performance
            $table->index(['seoable_type', 'seoable_id']);
            $table->unique(['seoable_type', 'seoable_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seo_meta');
    }
};
