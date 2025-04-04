<?php
/**
 * Debug Script for Laravel Application
 * Use this to troubleshoot deployment issues
 */
require_once __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Route;

echo "<h1>Laravel Application Debug</h1>";

// Check Laravel error log
echo "<h2>Error Log</h2>";
echo "<pre>";
$logFile = __DIR__ . '/../storage/logs/laravel.log';
if (file_exists($logFile)) {
    $lines = array_slice(file($logFile), -50);
    foreach ($lines as $line) {
        echo htmlspecialchars($line);
    }
} else {
    echo "Log file not found at: " . $logFile;
}
echo "</pre>";

// Check PHP version and extensions
echo "<h2>PHP Info</h2>";
echo "<pre>";
echo "PHP Version: " . phpversion() . "\n";
echo "Memory Limit: " . ini_get('memory_limit') . "\n";
echo "Max Execution Time: " . ini_get('max_execution_time') . "\n";
echo "</pre>";

// Check important table structures
echo "<h2>Database Tables</h2>";
echo "<pre>";
try {
    $tables = ['users', 'dashboard_settings'];
    foreach ($tables as $table) {
        if (Schema::hasTable($table)) {
            echo "Table: {$table}\n";
            $columns = Schema::getColumnListing($table);
            foreach ($columns as $column) {
                echo "  - {$column}\n";
            }
            echo "\n";
        } else {
            echo "Table {$table} does not exist\n\n";
        }
    }
} catch (Exception $e) {
    echo "Error checking tables: " . $e->getMessage();
}
echo "</pre>";

// Check application routes
echo "<h2>Important Routes</h2>";
echo "<pre>";
$routes = Route::getRoutes();
$adminRoutes = [];
foreach ($routes as $route) {
    if (strpos($route->uri, 'admin') !== false || strpos($route->uri, 'settings') !== false) {
        $adminRoutes[] = [
            'uri' => $route->uri,
            'methods' => implode('|', $route->methods),
            'name' => $route->getName(),
            'action' => $route->getActionName()
        ];
    }
}

foreach ($adminRoutes as $route) {
    echo "Route: {$route['methods']} {$route['uri']}\n";
    echo "  Name: {$route['name']}\n";
    echo "  Action: {$route['action']}\n\n";
}
echo "</pre>";

// Check storage permissions
echo "<h2>Directory Permissions</h2>";
echo "<pre>";
$dirs = [
    'storage/app' => '0775',
    'storage/framework' => '0775',
    'storage/logs' => '0775',
    'bootstrap/cache' => '0775',
];

foreach ($dirs as $dir => $expected) {
    $fullPath = __DIR__ . '/../' . $dir;
    if (is_dir($fullPath)) {
        $perms = substr(sprintf('%o', fileperms($fullPath)), -4);
        echo "{$dir}: {$perms} " . (is_writable($fullPath) ? "(Writable)" : "(NOT WRITABLE)") . "\n";
    } else {
        echo "{$dir}: Directory not found\n";
    }
}
echo "</pre>";

echo "<p>Debug completed at: " . date('Y-m-d H:i:s') . "</p>"; 