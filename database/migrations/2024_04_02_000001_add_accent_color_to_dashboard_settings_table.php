<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('dashboard_settings', function (Blueprint $table) {
            $table->string('accent_color')->default('#6366f1')->after('secondary_color');
        });
    }

    public function down()
    {
        Schema::table('dashboard_settings', function (Blueprint $table) {
            $table->dropColumn('accent_color');
        });
    }
}; 