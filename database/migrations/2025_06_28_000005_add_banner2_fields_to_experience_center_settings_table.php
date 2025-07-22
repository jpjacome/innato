<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('experience_center_settings', function (Blueprint $table) {
            if (!Schema::hasColumn('experience_center_settings', 'banner2_title')) {
                $table->string('banner2_title')->nullable();
            }
            if (!Schema::hasColumn('experience_center_settings', 'banner2_description')) {
                $table->text('banner2_description')->nullable();
            }
            if (!Schema::hasColumn('experience_center_settings', 'banner2_button_text')) {
                $table->string('banner2_button_text')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('experience_center_settings', function (Blueprint $table) {
            $table->dropColumn(['banner2_title', 'banner2_description', 'banner2_button_text']);
        });
    }
};
