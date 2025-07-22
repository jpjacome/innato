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
        Schema::table('footer_settings', function (Blueprint $table) {
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('location')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('newsletter_title')->nullable();
            $table->string('newsletter_placeholder')->nullable();
            $table->string('newsletter_button_text')->nullable();
            $table->string('copyright_text')->nullable();
            $table->string('attribution_text')->nullable();
            $table->string('attribution_url')->nullable();
            $table->string('attribution_link_text')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('footer_settings', function (Blueprint $table) {
            $table->dropColumn([
                'address',
                'phone',
                'location',
                'twitter_url',
                'instagram_url',
                'newsletter_title',
                'newsletter_placeholder',
                'newsletter_button_text',
                'copyright_text',
                'attribution_text',
                'attribution_url',
                'attribution_link_text',
            ]);
        });
    }
};
