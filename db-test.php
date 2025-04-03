<?php
echo "<h1>Database Connection Test</h1>";
echo "<pre>";

// Define application path
$basePath = __DIR__;

// Get database settings from .env
$envPath = $basePath.'/.env';
$dbHost = 'localhost';
$dbPort = '3306';
$dbName = 'orustrav_laraveltest';
$dbUser = 'orustrav_jpj';
$dbPass = 'Psycho2psychote';

if (file_exists($envPath)) {
    $envContent = file_get_contents($envPath);
    
    // Parse database settings from .env
    preg_match('/DB_HOST=(.*)/', $envContent, $hostMatches);
    preg_match('/DB_PORT=(.*)/', $envContent, $portMatches);
    preg_match('/DB_DATABASE=(.*)/', $envContent, $dbMatches);
    preg_match('/DB_USERNAME=(.*)/', $envContent, $userMatches);
    preg_match('/DB_PASSWORD=(.*)/', $envContent, $passMatches);
    
    if (isset($hostMatches[1])) $dbHost = trim($hostMatches[1]);
    if (isset($portMatches[1])) $dbPort = trim($portMatches[1]);
    if (isset($dbMatches[1])) $dbName = trim($dbMatches[1]);
    if (isset($userMatches[1])) $dbUser = trim($userMatches[1]);
    if (isset($passMatches[1])) $dbPass = trim($passMatches[1]);
    
    echo "Environment file found, using settings from .env\n";
} else {
    echo "Environment file not found, using default settings\n";
}

echo "\nDatabase settings being tested:\n";
echo "Host: $dbHost\n";
echo "Port: $dbPort\n";
echo "Database: $dbName\n";
echo "Username: $dbUser\n";
echo "Password: " . str_repeat('*', strlen($dbPass)) . "\n\n";

// Test MySQL connection
echo "Testing database connection...\n";
try {
    $dsn = "mysql:host=$dbHost;port=$dbPort;dbname=$dbName";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];
    
    $pdo = new PDO($dsn, $dbUser, $dbPass, $options);
    echo "✓ Connection successful!\n";
    
    // Test if users table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'users'");
    if ($stmt->rowCount() > 0) {
        echo "✓ Users table exists!\n";
        
        // Check if default admin user exists
        $stmt = $pdo->query("SELECT * FROM users WHERE email = 'admin@example.com'");
        if ($stmt->rowCount() > 0) {
            echo "✓ Default admin user exists!\n";
        } else {
            echo "❌ Default admin user not found!\n";
        }
    } else {
        echo "❌ Users table not found!\n";
    }
    
} catch (PDOException $e) {
    echo "❌ Database connection failed: " . $e->getMessage() . "\n";
}

echo "</pre>";
echo "<p>Return to <a href='/laravel-test'>homepage</a></p>"; 