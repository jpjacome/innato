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
        Schema::table('home_settings', function (Blueprint $table) {
            $table->string('headline_coast_image')->nullable()->after('headline_description');
            $table->string('headline_andes_image')->nullable()->after('headline_coast_image');
            $table->string('headline_amazon_image')->nullable()->after('headline_andes_image');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('home_settings', function (Blueprint $table) {
            $table->dropColumn(['headline_coast_image', 'headline_andes_image', 'headline_amazon_image']);
        });
    }
};
