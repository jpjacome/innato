<?php
// Script to fix migrations and create missing plants table

// Database connection
$dbHost = 'localhost';
$dbName = 'orustrav_laraveltest';
$dbUser = 'orustrav_jpj';
$dbPass = 'Psycho2psychote';

try {
    // Connect to database
    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected to database successfully\n";
    
    // 1. Create plants table if it doesn't exist
    $createPlantsTable = "
    CREATE TABLE IF NOT EXISTS `plants` (
        `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        `name` varchar(255) NOT NULL,
        `description` text DEFAULT NULL,
        `created_at` timestamp NULL DEFAULT NULL,
        `updated_at` timestamp NULL DEFAULT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ";
    
    $pdo->exec($createPlantsTable);
    echo "Plants table created or verified\n";
    
    // 2. Mark core migrations as complete in the migrations table
    $migrations = [
        '0001_01_01_000001_create_cache_table',
        '0001_01_01_000002_create_jobs_table',
        '2014_10_12_000000_create_users_table',
        '2014_10_12_100000_create_password_reset_tokens_table',
        '2019_08_19_000000_create_failed_jobs_table',
        '2019_12_14_000001_create_personal_access_tokens_table',
    ];
    
    foreach ($migrations as $migration) {
        $stmt = $pdo->prepare("SELECT * FROM migrations WHERE migration = ?");
        $stmt->execute([$migration]);
        
        if ($stmt->rowCount() == 0) {
            $stmt = $pdo->prepare("INSERT INTO migrations (migration, batch) VALUES (?, 1)");
            $stmt->execute([$migration]);
            echo "Migration {$migration} marked as complete\n";
        } else {
            echo "Migration {$migration} already marked as complete\n";
        }
    }
    
    // 3. Create a migration entry for the plants table
    $plantsMigration = date('Y_m_d_His') . '_create_plants_table';
    $stmt = $pdo->prepare("INSERT INTO migrations (migration, batch) VALUES (?, 2)");
    $stmt->execute([$plantsMigration]);
    echo "Plants migration marked as complete\n";
    
    echo "\nAll fixes applied successfully!\n";
    
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage() . "\n");
} 