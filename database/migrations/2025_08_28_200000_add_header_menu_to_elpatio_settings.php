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
        Schema::table('elpatio_settings', function (Blueprint $table) {
            if (!Schema::hasColumn('elpatio_settings', 'header_menu')) {
                $table->text('header_menu')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('elpatio_settings', function (Blueprint $table) {
            if (Schema::hasColumn('elpatio_settings', 'header_menu')) {
                $table->dropColumn('header_menu');
            }
        });
    }
};
