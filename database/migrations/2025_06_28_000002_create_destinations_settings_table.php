<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('destinations_settings', function (Blueprint $table) {
            $table->id();
            $table->string('banner_title')->nullable();
            $table->text('banner_description')->nullable();
            $table->string('banner_image')->nullable();
            $table->string('headline_title')->nullable();
            $table->json('headline_cards')->nullable();
            $table->string('destinations_title')->nullable();
            $table->string('destinations_button_text')->nullable();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('destinations_settings');
    }
};
