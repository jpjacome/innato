<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('experience_center_settings', function (Blueprint $table) {
            $table->id();
            $table->string('banner_title')->nullable();
            $table->text('banner_description')->nullable();
            $table->string('banner_image')->nullable();
            $table->string('button_text')->nullable();
            // Second banner fields
            $table->string('banner2_title')->nullable();
            $table->text('banner2_description')->nullable();
            $table->string('banner2_button_text')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('experience_center_settings');
    }
};
