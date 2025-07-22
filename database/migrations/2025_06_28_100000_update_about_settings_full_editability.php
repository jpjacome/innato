<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('about_settings', function (Blueprint $table) {
            $table->string('hero_title')->nullable();
            $table->json('cards')->nullable();
            $table->string('banner_image')->nullable();
            $table->json('headline_cards')->nullable();
            $table->string('destinations_button_text')->nullable();
        });
    }

    public function down()
    {
        Schema::table('about_settings', function (Blueprint $table) {
            $table->dropColumn(['hero_title','cards','banner_image','headline_cards','destinations_button_text']);
        });
    }
};
