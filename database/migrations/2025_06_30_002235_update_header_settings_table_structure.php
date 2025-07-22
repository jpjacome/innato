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
            // Drop old columns only if they exist
            if (Schema::hasColumn('header_settings', 'logo')) {
                $table->dropColumn('logo');
            }
            if (Schema::hasColumn('header_settings', 'title')) {
                $table->dropColumn('title');
            }
            if (Schema::hasColumn('header_settings', 'nav_links')) {
                $table->dropColumn('nav_links');
            }

            // Add new columns only if they don't exist
            if (!Schema::hasColumn('header_settings', 'nav_about_text')) {
                $table->string('nav_about_text')->default('About Us');
            }
            if (!Schema::hasColumn('header_settings', 'nav_destinations_text')) {
                $table->string('nav_destinations_text')->default('Destinations');
            }
            if (!Schema::hasColumn('header_settings', 'nav_experience_text')) {
                $table->string('nav_experience_text')->default('Tourist Experience Center');
            }
            if (!Schema::hasColumn('header_settings', 'nav_hostal_text')) {
                $table->string('nav_hostal_text')->default('Hostal');
            }
            if (!Schema::hasColumn('header_settings', 'nav_contact_text')) {
                $table->string('nav_contact_text')->default('Contact');
            }
            if (!Schema::hasColumn('header_settings', 'nav_reviews_text')) {
                $table->string('nav_reviews_text')->default('Reviews');
            }
            if (!Schema::hasColumn('header_settings', 'search_placeholder')) {
                $table->string('search_placeholder')->default('Search...');
            }
            if (!Schema::hasColumn('header_settings', 'created_at') && !Schema::hasColumn('header_settings', 'updated_at')) {
                $table->timestamps();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('header_settings', function (Blueprint $table) {
            // Reverse the changes, drop new columns only if they exist
            if (Schema::hasColumn('header_settings', 'nav_about_text')) {
                $table->dropColumn('nav_about_text');
            }
            if (Schema::hasColumn('header_settings', 'nav_destinations_text')) {
                $table->dropColumn('nav_destinations_text');
            }
            if (Schema::hasColumn('header_settings', 'nav_experience_text')) {
                $table->dropColumn('nav_experience_text');
            }
            if (Schema::hasColumn('header_settings', 'nav_hostal_text')) {
                $table->dropColumn('nav_hostal_text');
            }
            if (Schema::hasColumn('header_settings', 'nav_contact_text')) {
                $table->dropColumn('nav_contact_text');
            }
            if (Schema::hasColumn('header_settings', 'nav_reviews_text')) {
                $table->dropColumn('nav_reviews_text');
            }
            if (Schema::hasColumn('header_settings', 'search_placeholder')) {
                $table->dropColumn('search_placeholder');
            }
            if (Schema::hasColumn('header_settings', 'created_at') && Schema::hasColumn('header_settings', 'updated_at')) {
                $table->dropTimestamps();
            }

            // Add back old columns only if they don't exist
            if (!Schema::hasColumn('header_settings', 'logo')) {
                $table->string('logo')->nullable();
            }
            if (!Schema::hasColumn('header_settings', 'title')) {
                $table->string('title')->nullable();
            }
            if (!Schema::hasColumn('header_settings', 'nav_links')) {
                $table->text('nav_links')->nullable();
            }
        });
    }
};
