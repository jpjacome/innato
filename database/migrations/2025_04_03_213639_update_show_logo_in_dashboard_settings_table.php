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
            if (!Schema::hasColumn('dashboard_settings', 'show_logo')) {
                $table->boolean('show_logo')->default(true)->after('logo');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dashboard_settings', function (Blueprint $table) {
            if (Schema::hasColumn('dashboard_settings', 'show_logo')) {
                $table->dropColumn('show_logo');
            }
        });
    }
};
