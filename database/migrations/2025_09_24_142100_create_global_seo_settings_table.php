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
        Schema::create('global_seo_settings', function (Blueprint $table) {
            $table->id();
            
            // Global Meta Tags
            $table->string('site_title', 255)->nullable();
            $table->text('site_description')->nullable();
            $table->string('site_keywords', 500)->nullable();
            $table->string('author', 255)->nullable();
            $table->string('site_language', 10)->default('es');
            
            // Open Graph Global
            $table->string('og_site_name', 255)->nullable();
            $table->string('og_image', 255)->nullable();
            $table->string('og_type', 50)->default('website');
            
            // Twitter Cards
            $table->string('twitter_card', 50)->default('summary_large_image');
            $table->string('twitter_site', 100)->nullable();
            $table->string('twitter_creator', 100)->nullable();
            
            // Analytics & Tracking
            $table->string('google_analytics_id', 50)->nullable();
            $table->string('google_tag_manager_id', 50)->nullable();
            $table->string('google_site_verification', 100)->nullable();
            $table->string('bing_site_verification', 100)->nullable();
            $table->string('yandex_site_verification', 100)->nullable();
            
            // Schema.org
            $table->json('organization_schema')->nullable();
            
            // Custom Scripts
            $table->text('head_scripts')->nullable();
            $table->text('body_scripts')->nullable();
            
            // SEO Features
            $table->boolean('enable_canonical_urls')->default(true);
            $table->boolean('enable_og_tags')->default(true);
            $table->boolean('enable_twitter_cards')->default(true);
            $table->boolean('enable_schema_markup')->default(true);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('global_seo_settings');
    }
};
