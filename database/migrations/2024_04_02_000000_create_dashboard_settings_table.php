<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('dashboard_settings', function (Blueprint $table) {
            $table->id();
            $table->string('primary_color')->default('#4F46E5');
            $table->string('secondary_color')->default('#818CF8');
            $table->string('dashboard_title')->nullable();
            $table->string('logo')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dashboard_settings');
    }
}; 