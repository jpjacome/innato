<?php
/**
 * Database Schema Update Script
 * Run this after uploading new code to ensure database compatibility
 */
require_once __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

// Function to safely add a column
function addColumnIfNotExists($table, $column, $definition) {
    if (Schema::hasTable($table) && !Schema::hasColumn($table, $column)) {
        try {
            DB::statement("ALTER TABLE {$table} ADD COLUMN {$column} {$definition}");
            echo "Added {$column} to {$table}<br>";
            return true;
        } catch (Exception $e) {
            echo "Error adding {$column} to {$table}: " . $e->getMessage() . "<br>";
            return false;
        }
    }
    return false;
}

// Keep this updated with new columns from migrations
$schemaUpdates = [
    'dashboard_settings' => [
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
        // Add new columns here as your schema evolves
    ],
    // Add other tables as needed
];

// Apply all schema updates
foreach ($schemaUpdates as $table => $columns) {
    if (Schema::hasTable($table)) {
        echo "Updating {$table} table:<br>";
        foreach ($columns as $column => $definition) {
            addColumnIfNotExists($table, $column, $definition);
        }
    } else {
        echo "Table {$table} does not exist<br>";
    }
}

// Clear all caches
try {
    echo "Clearing caches:<br>";
    \Illuminate\Support\Facades\Artisan::call('view:clear');
    echo "Views cleared<br>";
    \Illuminate\Support\Facades\Artisan::call('cache:clear');
    echo "Cache cleared<br>";
    \Illuminate\Support\Facades\Artisan::call('config:clear');
    echo "Config cleared<br>";
    \Illuminate\Support\Facades\Artisan::call('route:clear');
    echo "Routes cleared<br>";
} catch (Exception $e) {
    echo "Error clearing caches: " . $e->getMessage() . "<br>";
}

echo "Schema update completed!"; 