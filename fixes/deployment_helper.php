<?php
/**
 * Comprehensive Deployment Helper for Laravel Application
 * 
 * This script is designed to be run IMMEDIATELY after deploying updated code to the server.
 * It provides a one-click solution to common deployment issues including:
 * 
 * 1. Missing database tables and columns
 * 2. Missing migration records
 * 3. Laravel Telescope setup issues
 * 4. Cache and configuration issues
 * 5. Permission problems
 * 
 * USAGE:
 * - Upload this file to your server
 * - Access it via browser: https://yourdomain.com/laravel-test/fixes/deployment_helper.php
 * - Follow any prompted instructions
 */

// Step 0: Show nice formatted output
header("Content-Type: text/html; charset=utf-8");
echo "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Laravel Deployment Helper</title>
    <style>
        body { font-family: system-ui, sans-serif; max-width: 800px; margin: 0 auto; padding: 20px; line-height: 1.6; }
        h1 { color: #4338ca; }
        h2 { color: #6366f1; margin-top: 30px; }
        pre { background: #f1f5f9; padding: 15px; border-radius: 5px; overflow: auto; }
        .success { color: #16a34a; }
        .error { color: #dc2626; }
        .warning { color: #ca8a04; }
        code { background: #f1f5f9; padding: 2px 4px; border-radius: 3px; }
    </style>
</head>
<body>
    <h1>Laravel Deployment Helper</h1>
    <p>Running comprehensive deployment fixes...</p>
";

// Helper function to output status
function output($message, $type = 'info') {
    echo "<p class='{$type}'>{$message}</p>";
    ob_flush();
    flush();
}

try {
    // Step 1: Load Laravel environment
    output("Loading Laravel environment...");
    
    if (!file_exists(__DIR__ . '/../vendor/autoload.php')) {
        throw new Exception("Autoloader not found. Make sure this script is in the /fixes directory of your Laravel application.");
    }
    
    require_once __DIR__ . '/../vendor/autoload.php';
    $app = require_once __DIR__ . '/../bootstrap/app.php';
    $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
    
    output("Laravel environment loaded successfully.", "success");
    
    // Step 2: Check required tables exist and create them if not
    output("Checking and creating required database tables...");
    
    // 2.1: Define all required tables with their basic structure
    $requiredTables = [
        'plants' => "
            CREATE TABLE IF NOT EXISTS `plants` (
                `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
                `name` varchar(255) NOT NULL,
                `description` text DEFAULT NULL,
                `created_at` timestamp NULL DEFAULT NULL,
                `updated_at` timestamp NULL DEFAULT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ",
        'telescope_entries' => "
            CREATE TABLE IF NOT EXISTS `telescope_entries` (
                `sequence` bigint unsigned NOT NULL AUTO_INCREMENT,
                `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
                `batch_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
                `family_hash` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                `should_display_on_index` tinyint(1) NOT NULL DEFAULT '1',
                `type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
                `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
                `created_at` datetime DEFAULT NULL,
                PRIMARY KEY (`sequence`),
                UNIQUE KEY `telescope_entries_uuid_unique` (`uuid`),
                KEY `telescope_entries_batch_id_index` (`batch_id`),
                KEY `telescope_entries_family_hash_index` (`family_hash`),
                KEY `telescope_entries_created_at_index` (`created_at`),
                KEY `telescope_entries_type_should_display_on_index_index` (`type`,`should_display_on_index`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ",
        'telescope_entries_tags' => "
            CREATE TABLE IF NOT EXISTS `telescope_entries_tags` (
                `entry_uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
                `tag` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                KEY `telescope_entries_tags_entry_uuid_tag_index` (`entry_uuid`,`tag`),
                KEY `telescope_entries_tags_tag_index` (`tag`),
                CONSTRAINT `telescope_entries_tags_entry_uuid_foreign` FOREIGN KEY (`entry_uuid`) REFERENCES `telescope_entries` (`uuid`) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ",
        'telescope_monitoring' => "
            CREATE TABLE IF NOT EXISTS `telescope_monitoring` (
                `tag` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        "
    ];
    
    // 2.2: Execute the create table statements
    foreach ($requiredTables as $table => $sql) {
        if (!Schema::hasTable($table)) {
            try {
                DB::statement($sql);
                output("Created missing table: {$table}", "success");
            } catch (Exception $e) {
                output("Error creating table {$table}: " . $e->getMessage(), "error");
            }
        } else {
            output("Table exists: {$table}", "success");
        }
    }
    
    // Step 3: Update existing tables with required columns
    output("Checking and adding required columns to existing tables...");
    
    // 3.1: Define required columns for existing tables
    $requiredColumns = [
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
        ]
    ];
    
    // 3.2: Add missing columns to existing tables
    foreach ($requiredColumns as $table => $columns) {
        if (Schema::hasTable($table)) {
            foreach ($columns as $column => $definition) {
                if (!Schema::hasColumn($table, $column)) {
                    try {
                        DB::statement("ALTER TABLE {$table} ADD COLUMN {$column} {$definition}");
                        output("Added missing column: {$table}.{$column}", "success");
                    } catch (Exception $e) {
                        output("Error adding column {$table}.{$column}: " . $e->getMessage(), "error");
                    }
                } else {
                    output("Column exists: {$table}.{$column}", "success");
                }
            }
        } else {
            output("Table {$table} does not exist, skipping column checks", "warning");
        }
    }
    
    // Step 4: Fix migrations table to mark core migrations as complete
    output("Fixing migration records...");
    
    // 4.1: Check if migrations table exists and create it if not
    if (!Schema::hasTable('migrations')) {
        DB::statement("
            CREATE TABLE IF NOT EXISTS `migrations` (
                `id` int unsigned NOT NULL AUTO_INCREMENT,
                `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                `batch` int NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ");
        output("Created missing migrations table", "success");
    }
    
    // 4.2: Mark core migrations as complete in the migrations table
    $coreMigrations = [
        '0001_01_01_000001_create_cache_table',
        '0001_01_01_000002_create_jobs_table',
        '2014_10_12_000000_create_users_table',
        '2014_10_12_100000_create_password_reset_tokens_table',
        '2019_08_19_000000_create_failed_jobs_table',
        '2019_12_14_000001_create_personal_access_tokens_table',
        '2018_08_08_100000_create_telescope_entries_table', // Telescope migrations
        date('Y_m_d_His') . '_create_plants_table', // Dynamic plants table migration entry
    ];
    
    foreach ($coreMigrations as $migration) {
        $exists = DB::table('migrations')->where('migration', $migration)->exists();
        if (!$exists) {
            DB::table('migrations')->insert([
                'migration' => $migration,
                'batch' => 1
            ]);
            output("Marked migration as complete: {$migration}", "success");
        } else {
            output("Migration already marked complete: {$migration}", "success");
        }
    }
    
    // Step 5: Fix file permissions
    output("Setting correct file permissions...");
    
    $permissionDirs = [
        '../storage',
        '../storage/app',
        '../storage/app/public',
        '../storage/framework',
        '../storage/framework/cache',
        '../storage/framework/sessions',
        '../storage/framework/views',
        '../storage/logs',
        '../bootstrap/cache'
    ];
    
    foreach ($permissionDirs as $dir) {
        $fullPath = realpath(__DIR__ . '/' . $dir);
        if ($fullPath) {
            if (is_writable($fullPath)) {
                output("Directory {$dir} is writable", "success");
            } else {
                output("Setting permissions for {$dir}", "warning");
                @chmod($fullPath, 0775);
                if (is_writable($fullPath)) {
                    output("Successfully set permissions for {$dir}", "success");
                } else {
                    output("Failed to set permissions for {$dir}. Please set manually: chmod -R 775 " . $fullPath, "error");
                }
            }
        } else {
            output("Directory {$dir} not found", "warning");
        }
    }
    
    // Step 6: Clear all caches
    output("Clearing Laravel caches...");
    
    try {
        // Clear artisan caches
        Artisan::call('view:clear');
        output("Views cache cleared", "success");
        
        Artisan::call('cache:clear');
        output("Application cache cleared", "success");
        
        Artisan::call('config:clear');
        output("Configuration cache cleared", "success");
        
        Artisan::call('route:clear');
        output("Route cache cleared", "success");
        
        // Remove cached configuration files directly
        $configCache = __DIR__ . '/../bootstrap/cache/config.php';
        if (file_exists($configCache)) {
            @unlink($configCache);
            output("Removed cached config file", "success");
        }
        
        $routesCache = __DIR__ . '/../bootstrap/cache/routes.php';
        if (file_exists($routesCache)) {
            @unlink($routesCache);
            output("Removed cached routes file", "success");
        }
    } catch (Exception $e) {
        output("Error while clearing caches: " . $e->getMessage(), "error");
    }
    
    // Step 7: Verify storage link exists
    output("Checking storage link...");
    
    $publicStorage = __DIR__ . '/../public/storage';
    
    if (!file_exists($publicStorage)) {
        try {
            Artisan::call('storage:link');
            output("Storage link created", "success");
        } catch (Exception $e) {
            output("Error creating storage link: " . $e->getMessage() . ". You may need to run 'php artisan storage:link' manually.", "error");
        }
    } else {
        output("Storage link already exists", "success");
    }
    
    // Step 8: Final verification
    output("Performing final verification...");
    
    try {
        // Test database connectivity with a simple query
        $user_count = DB::table('users')->count();
        output("Database connection verified (Users: {$user_count})", "success");
        
        // Verify important tables
        $tables = ['migrations', 'users', 'telescope_entries', 'plants'];
        $missing_tables = [];
        
        foreach ($tables as $table) {
            if (!Schema::hasTable($table)) {
                $missing_tables[] = $table;
            }
        }
        
        if (count($missing_tables) > 0) {
            output("Warning: Some tables are still missing: " . implode(', ', $missing_tables), "warning");
        } else {
            output("All required tables verified", "success");
        }
    } catch (Exception $e) {
        output("Verification error: " . $e->getMessage(), "error");
    }
    
    // Success message
    echo "<h2>Deployment Helper Results</h2>";
    output("Deployment helper completed successfully!", "success");
    output("Your application should now be functioning properly. If you still encounter issues, check the error logs at storage/logs/laravel.log", "info");
    
    echo "<h2>Next Steps</h2>";
    echo "<ol>
        <li>Visit your application homepage</li>
        <li>Try logging in</li>
        <li>Test critical functionality (especially anything new in this deployment)</li>
        <li>If any issues persist, check the error logs and run the <code>fixes/debug.php</code> script</li>
    </ol>";
    
    echo "<h2>Deployment Checklist for Future Updates</h2>";
    echo "<ol>
        <li>Always backup your database before deploying</li>
        <li>Upload all new code files</li>
        <li>Run this deployment helper script immediately after uploading</li>
        <li>Update the required tables and columns in this script for future deployments</li>
        <li>Test critical functionality after deployment</li>
        <li>Keep documentation updated with any new deployment requirements</li>
    </ol>";
    
} catch (Exception $e) {
    output("Critical error: " . $e->getMessage(), "error");
    
    echo "<h2>Troubleshooting</h2>";
    echo "<ol>
        <li>Check that all files were uploaded correctly</li>
        <li>Verify database credentials in your .env file</li>
        <li>Ensure PHP has sufficient permissions to execute this script</li>
        <li>Check server error logs for additional information</li>
    </ol>";
}

echo "</body></html>"; 