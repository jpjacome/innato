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
        Schema::create('home_settings', function (Blueprint $table) {
            $table->id();
            $table->string('hero_title')->default('TURISMO COMUNITARIO');
            $table->string('hero_button_text')->default('CONOCE MÁS');
            $table->string('hero_video_path')->nullable();
            $table->string('headline_title')->default('CONÉCTATE CON LA ESENCIA DE ECUADOR');
            $table->text('headline_description')->nullable();
            $table->string('destinations_title')->default('EXPLORA ECUADOR Y SUS COMUNIDADES');
            $table->text('destinations_description')->nullable();
            $table->string('destinations_button_text')->default('CONOCE MÁS');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_settings');
    }
};
