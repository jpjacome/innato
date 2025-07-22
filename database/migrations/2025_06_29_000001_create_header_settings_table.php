<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('header_settings', function (Blueprint $table) {
            $table->id();
            $table->string('logo')->nullable();
            $table->string('title')->nullable();
            $table->text('nav_links')->nullable();
            $table->string('nav_about_text')->default('About Us');
            $table->string('nav_destinations_text')->default('Destinations');
            $table->string('nav_experience_text')->default('Tourist Experience Center');
            $table->string('nav_hostal_text')->default('Hostal');
            $table->string('nav_contact_text')->default('Contact');
            $table->string('nav_reviews_text')->default('Reviews');
            $table->string('search_placeholder')->default('Search...');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('header_settings');
    }
};
