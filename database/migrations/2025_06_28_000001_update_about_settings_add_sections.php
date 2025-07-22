<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('about_settings', function (Blueprint $table) {
            $table->string('card_1')->nullable();
            $table->string('card_2')->nullable();
            $table->string('card_3')->nullable();
            $table->string('card_4')->nullable();
            $table->string('banner_text')->nullable();
            $table->string('headline_title')->nullable();
            $table->string('headline_1_name')->nullable();
            $table->string('headline_1_role')->nullable();
            $table->text('headline_1_desc')->nullable();
            $table->string('headline_1_img')->nullable();
            $table->string('headline_2_name')->nullable();
            $table->string('headline_2_role')->nullable();
            $table->text('headline_2_desc')->nullable();
            $table->string('headline_2_img')->nullable();
            $table->string('destinations_title')->nullable();
            $table->string('destinations_button')->nullable();
        });
    }

    public function down()
    {
        Schema::table('about_settings', function (Blueprint $table) {
            $table->dropColumn([
                'card_1','card_2','card_3','card_4','banner_text','headline_title',
                'headline_1_name','headline_1_role','headline_1_desc','headline_1_img',
                'headline_2_name','headline_2_role','headline_2_desc','headline_2_img',
                'destinations_title','destinations_button'
            ]);
        });
    }
};
