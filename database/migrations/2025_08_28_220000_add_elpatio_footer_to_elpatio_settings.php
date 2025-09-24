<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddElpatioFooterToElpatioSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('elpatio_settings', function (Blueprint $table) {
            // Use text for broader compatibility (SQLite) and store JSON
            $table->text('footer')->nullable()->after('social_links');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('elpatio_settings', function (Blueprint $table) {
            $table->dropColumn('footer');
        });
    }
}
