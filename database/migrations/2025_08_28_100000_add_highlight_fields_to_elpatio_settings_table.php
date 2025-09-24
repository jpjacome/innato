<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('elpatio_settings', function (Blueprint $table) {
            if (!Schema::hasColumn('elpatio_settings', 'about_title_highlight')) {
                $table->string('about_title_highlight')->nullable()->after('about_title');
            }
            if (!Schema::hasColumn('elpatio_settings', 'about2_title_highlight')) {
                $table->string('about2_title_highlight')->nullable()->after('about2_title');
            }
            if (!Schema::hasColumn('elpatio_settings', 'rooms_title_highlight')) {
                $table->string('rooms_title_highlight')->nullable()->after('rooms_title');
            }
        });
    }

    public function down()
    {
        Schema::table('elpatio_settings', function (Blueprint $table) {
            if (Schema::hasColumn('elpatio_settings', 'about_title_highlight')) {
                $table->dropColumn('about_title_highlight');
            }
            if (Schema::hasColumn('elpatio_settings', 'about2_title_highlight')) {
                $table->dropColumn('about2_title_highlight');
            }
            if (Schema::hasColumn('elpatio_settings', 'rooms_title_highlight')) {
                $table->dropColumn('rooms_title_highlight');
            }
        });
    }
};
