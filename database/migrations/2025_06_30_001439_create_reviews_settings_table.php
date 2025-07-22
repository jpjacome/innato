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
        Schema::create('reviews_settings', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('What Our Visitors Say');
            $table->string('subtitle')->nullable();
            $table->longText('reviews_data')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews_settings');
    }
};
