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
        Schema::table('home_settings', function (Blueprint $table) {
            $table->string('dest_span_amazonia')->nullable();
            $table->string('dest_span_costa')->nullable();
            $table->string('dest_span_sierra')->nullable();
            $table->string('dest_span_galapagos')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('home_settings', function (Blueprint $table) {
            $table->dropColumn([
                'dest_span_amazonia',
                'dest_span_costa',
                'dest_span_sierra',
                'dest_span_galapagos',
            ]);
        });
    }
};
