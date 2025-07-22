<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('experience_center_settings', function (Blueprint $table) {
            $table->string('container2_video')->nullable();
            $table->string('container3_image')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('experience_center_settings', function (Blueprint $table) {
            $table->dropColumn(['container2_video', 'container3_image']);
        });
    }
};
