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
        Schema::table('destinations', function (Blueprint $table) {
            $table->string('altitude')->nullable()->after('climate_wet_season');
            $table->json('considerations')->nullable()->after('environmental_challenges');
            $table->json('what_to_bring')->nullable()->after('considerations');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('destinations', function (Blueprint $table) {
            $table->dropColumn(['altitude', 'considerations', 'what_to_bring']);
        });
    }
};
