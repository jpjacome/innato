<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->string('reviewer');
            $table->text('text');
            $table->unsignedTinyInteger('rating'); // 1-5
            $table->string('location')->nullable();
            $table->enum('status', ['published', 'pending', 'hidden'])->default('published');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('reviews');
    }
};
