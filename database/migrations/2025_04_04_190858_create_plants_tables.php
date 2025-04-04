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
        // Main plants table
        Schema::create('plants', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->text('common_names')->nullable();
            $table->string('family', 100)->nullable();
            $table->text('native_range')->nullable();
            $table->string('age', 50)->nullable();
            $table->string('current_height', 100)->nullable();
            $table->string('expected_height', 100)->nullable();
            $table->text('leaf_type')->nullable();
            $table->string('bloom_time', 255)->nullable();
            $table->string('flower_color', 100)->nullable();
            $table->text('fruit')->nullable();
            $table->string('light', 255)->nullable();
            $table->string('soil', 255)->nullable();
            $table->string('hardiness', 100)->nullable();
            $table->text('other_comments')->nullable();
            $table->timestamps();
        });

        // Plant images table
        Schema::create('plant_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plant_id')->constrained()->onDelete('cascade');
            $table->string('image_path', 255);
            $table->integer('image_order')->default(0);
            $table->timestamps();
        });

        // Maintenance logs for plants
        Schema::create('maintenance_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plant_id')->constrained()->onDelete('cascade');
            $table->date('last_watering')->nullable();
            $table->date('next_watering')->nullable();
            $table->date('last_fertilization')->nullable();
            $table->date('next_fertilization')->nullable();
            $table->date('last_pruning')->nullable();
            $table->date('next_pruning')->nullable();
            $table->text('pest_disease_inspection')->nullable();
            $table->timestamps();
        });

        // Maintenance images
        Schema::create('maintenance_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('maintenance_id')->constrained('maintenance_logs')->onDelete('cascade');
            $table->string('image_path', 255);
            $table->timestamps();
        });

        // Create the plant_details view
        \DB::statement("
            CREATE VIEW plant_details AS
            SELECT 
                p.*,
                m.last_watering,
                m.next_watering,
                m.last_fertilization,
                m.next_fertilization,
                m.last_pruning,
                m.next_pruning,
                m.pest_disease_inspection,
                m.id AS maintenance_id
            FROM 
                plants p
            LEFT JOIN 
                maintenance_logs m ON p.id = m.plant_id
            WHERE 
                m.id = (SELECT MAX(id) FROM maintenance_logs WHERE plant_id = p.id)
                OR m.id IS NULL
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        \DB::statement("DROP VIEW IF EXISTS plant_details");
        Schema::dropIfExists('maintenance_images');
        Schema::dropIfExists('maintenance_logs');
        Schema::dropIfExists('plant_images');
        Schema::dropIfExists('plants');
    }
};
