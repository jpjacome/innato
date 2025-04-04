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
        Schema::table('dashboard_settings', function (Blueprint $table) {
            $table->string('dark_primary_color')->default('#6366f1');
            $table->string('dark_secondary_color')->default('#818CF8');
            $table->string('dark_accent_color')->default('#4F46E5');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dashboard_settings', function (Blueprint $table) {
            $table->dropColumn([
                'dark_primary_color',
                'dark_secondary_color',
                'dark_accent_color'
            ]);
        });
    }
};
