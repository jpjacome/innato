<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('hero_settings', function (Blueprint $table) {
            $table->id();
            $table->string('title_text')->default('WELCOME');
            $table->string('title_color')->default('#FFFFFF');
            $table->string('title_size')->default('4rem');
            $table->string('title_font')->default('Arial');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('hero_settings');
    }
}; 