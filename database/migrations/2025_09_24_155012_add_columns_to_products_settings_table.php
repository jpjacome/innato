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
        Schema::table('products_settings', function (Blueprint $table) {
            // Banner section
            $table->string('banner_title')->nullable()->after('id');
            $table->text('banner_description')->nullable()->after('banner_title');
            $table->string('banner_image')->nullable()->after('banner_description');
            
            // Section titles
            $table->string('section_title')->nullable()->after('banner_image');
            $table->text('section_description')->nullable()->after('section_title');
            
            // Product 1 - Cacao Orgánico
            $table->string('product1_title')->nullable()->after('section_description');
            $table->text('product1_description')->nullable()->after('product1_title');
            $table->string('product1_image')->nullable()->after('product1_description');
            
            // Product 2 - Café de Altura
            $table->string('product2_title')->nullable()->after('product1_image');
            $table->text('product2_description')->nullable()->after('product2_title');
            $table->string('product2_image')->nullable()->after('product2_description');
            
            // Product 3 - Textiles Artesanales
            $table->string('product3_title')->nullable()->after('product2_image');
            $table->text('product3_description')->nullable()->after('product3_title');
            $table->string('product3_image')->nullable()->after('product3_description');
            
            // Product 4 - Miel de Abeja
            $table->string('product4_title')->nullable()->after('product3_image');
            $table->text('product4_description')->nullable()->after('product4_title');
            $table->string('product4_image')->nullable()->after('product4_description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products_settings', function (Blueprint $table) {
            $table->dropColumn([
                'banner_title',
                'banner_description', 
                'banner_image',
                'section_title',
                'section_description',
                'product1_title',
                'product1_description',
                'product1_image',
                'product2_title',
                'product2_description', 
                'product2_image',
                'product3_title',
                'product3_description',
                'product3_image',
                'product4_title',
                'product4_description',
                'product4_image'
            ]);
        });
    }
};
