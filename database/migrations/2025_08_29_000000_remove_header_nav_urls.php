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
        Schema::table('header_settings', function (Blueprint $table) {
            // Drop the nav_*_url columns if they exist (these were added by mistake earlier)
            if (Schema::hasColumn('header_settings', 'nav_about_url')) {
                $table->dropColumn('nav_about_url');
            }
            if (Schema::hasColumn('header_settings', 'nav_destinations_url')) {
                $table->dropColumn('nav_destinations_url');
            }
            if (Schema::hasColumn('header_settings', 'nav_experience_url')) {
                $table->dropColumn('nav_experience_url');
            }
            if (Schema::hasColumn('header_settings', 'nav_hostal_url')) {
                $table->dropColumn('nav_hostal_url');
            }
            if (Schema::hasColumn('header_settings', 'nav_contact_url')) {
                $table->dropColumn('nav_contact_url');
            }
            if (Schema::hasColumn('header_settings', 'nav_reviews_url')) {
                $table->dropColumn('nav_reviews_url');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('header_settings', function (Blueprint $table) {
            if (!Schema::hasColumn('header_settings', 'nav_about_url')) {
                $table->string('nav_about_url')->default('/about');
            }
            if (!Schema::hasColumn('header_settings', 'nav_destinations_url')) {
                $table->string('nav_destinations_url')->default('/destinations');
            }
            if (!Schema::hasColumn('header_settings', 'nav_experience_url')) {
                $table->string('nav_experience_url')->default('/experience-center');
            }
            if (!Schema::hasColumn('header_settings', 'nav_hostal_url')) {
                $table->string('nav_hostal_url')->default('/hostal');
            }
            if (!Schema::hasColumn('header_settings', 'nav_contact_url')) {
                $table->string('nav_contact_url')->default('/contact');
            }
            if (!Schema::hasColumn('header_settings', 'nav_reviews_url')) {
                $table->string('nav_reviews_url')->default('/reviews');
            }
        });
    }
};
