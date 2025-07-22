<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('contact_settings', function (Blueprint $table) {
            $table->id();
            $table->string('banner_title')->nullable();
            $table->text('banner_description')->nullable();
            $table->string('banner_image')->nullable();
            $table->string('button_text')->nullable();
            $table->string('newsletter_label')->nullable();
        });
    }
    public function down() {
        Schema::dropIfExists('contact_settings');
    }
};
