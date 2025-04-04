<?php
// add_missing_columns.php
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

// Ensure all required columns exist
if (Schema::hasTable('dashboard_settings')) {
    $columns = [
        'primary_color' => "VARCHAR(7) DEFAULT '#4F46E5'",
        'secondary_color' => "VARCHAR(7) DEFAULT '#818CF8'",
        'accent_color' => "VARCHAR(7) DEFAULT '#6366f1'",
        'dark_primary_color' => "VARCHAR(7) DEFAULT '#2D3748'",
        'dark_secondary_color' => "VARCHAR(7) DEFAULT '#4A5568'",
        'dark_accent_color' => "VARCHAR(7) DEFAULT '#667EEA'",
        'text_color' => "VARCHAR(7) DEFAULT '#000000'",
        'dark_text_color' => "VARCHAR(7) DEFAULT '#FFFFFF'",
        'dashboard_title' => "VARCHAR(255) DEFAULT 'Dashboard'",
        'show_logo' => "BOOLEAN DEFAULT 0",
        'logo' => "VARCHAR(255) DEFAULT NULL"
    ];
    
    foreach ($columns as $column => $definition) {
        if (!Schema::hasColumn('dashboard_settings', $column)) {
            try {
                DB::statement("ALTER TABLE dashboard_settings ADD COLUMN $column $definition");
                echo "Added column $column<br>";
            } catch (Exception $e) {
                echo "Error adding $column: " . $e->getMessage() . "<br>";
            }
        } else {
            echo "Column $column already exists<br>";
        }
    }
}

echo "Database schema update completed!";