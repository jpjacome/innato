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
        if (!Schema::hasTable('destinations')) {
            Schema::create('destinations', function (Blueprint $table) {
                $table->id();
                $table->string('slug')->unique();
                $table->string('title');
                $table->string('subtitle')->nullable();
                $table->string('coordinates')->nullable();
                $table->string('conservation_status')->nullable();
                $table->string('province')->nullable();
                $table->string('canton')->nullable();
                $table->string('parish')->nullable();
                $table->string('sector')->nullable();
                $table->string('reference_distance')->nullable();
                $table->json('climate_dry_season')->nullable();
                $table->json('climate_wet_season')->nullable();
                $table->string('access_from')->nullable();
                $table->string('access_route')->nullable();
                $table->string('access_transport')->nullable();
                $table->string('access_time')->nullable();
                $table->string('schedule_hours')->nullable();
                $table->string('entry_fee')->nullable();
                $table->string('season_availability')->nullable();
                $table->string('requirements')->nullable();
                $table->string('contact_person')->nullable();
                $table->string('contact_role')->nullable();
                $table->string('contact_phone')->nullable();
                $table->string('contact_email')->nullable();
                $table->json('activities')->nullable();
                $table->string('target_audience_type')->nullable();
                $table->string('target_audience_origin')->nullable();
                $table->string('target_audience_age')->nullable();
                $table->string('target_audience_transport')->nullable();
                $table->string('target_audience_stay')->nullable();
                $table->json('services')->nullable();
                $table->string('average_price')->nullable();
                $table->string('capacity')->nullable();
                $table->string('payment_methods')->nullable();
                $table->string('mobile_coverage')->nullable();
                $table->text('main_description')->nullable();
                $table->text('secondary_description')->nullable();
                $table->text('strengths_benefits')->nullable();
                $table->json('gallery_images')->nullable();
                $table->json('tourism_criteria')->nullable();
                $table->json('environmental_challenges')->nullable();
                $table->enum('status', ['active', 'inactive'])->default('active');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('destinations');
    }
};
