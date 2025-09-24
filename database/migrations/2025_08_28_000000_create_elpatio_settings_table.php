<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateElpatioSettingsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('elpatio_settings', function (Blueprint $table) {
            $table->id();
            $table->string('hero_background')->nullable();
            $table->string('loading_logo')->nullable();
            $table->string('about_title')->nullable();
            $table->text('about_text')->nullable();
            $table->string('about_image')->nullable();
            $table->string('about2_title')->nullable();
            $table->text('about2_text')->nullable();
            $table->string('about2_image')->nullable();
            $table->string('rooms_title')->nullable();
            $table->text('amenities_list')->nullable(); // JSON
            $table->text('gallery')->nullable(); // JSON
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('elpatio_settings');
    }
}
