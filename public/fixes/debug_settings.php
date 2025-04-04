<?php
// Debug settings form submission
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

echo "<h2>Routes Check</h2>";
echo "<pre>";
// Check if settings update route exists
$routes = Route::getRoutes();
foreach ($routes as $route) {
    if (strpos($route->uri, 'settings') !== false && in_array('PUT', $route->methods)) {
        echo "Settings update route found: " . $route->uri . "\n";
        echo "Controller: " . $route->getActionName() . "\n\n";
    }
}
echo "</pre>";

echo "<h2>Settings Controller Check</h2>";
echo "<pre>";
// Check if the controller exists and is properly set up
$controllerPath = app_path('Http/Controllers/SettingsController.php');
if (file_exists($controllerPath)) {
    echo "Settings controller exists.\n";
    echo "Content:\n";
    highlight_file($controllerPath);
} else {
    echo "Settings controller not found at: $controllerPath\n";
}
echo "</pre>";

echo "<h2>Form Check</h2>";
echo "<pre>";
// Find the settings form in the view
$viewPath = resource_path('views/admin/settings/index.blade.php');
if (file_exists($viewPath)) {
    echo "Settings view exists.\n";
    echo "Form action and method:\n";
    $content = file_get_contents($viewPath);
    preg_match_all('/<form.*?action=[\'"]([^\'"]*)[\'"].*?>/i', $content, $matches);
    if (!empty($matches[0])) {
        foreach ($matches[0] as $form) {
            echo htmlspecialchars($form) . "\n";
        }
    } else {
        echo "No form tags found in the view.\n";
    }
} else {
    echo "Settings view not found at: $viewPath\n";
}
echo "</pre>";

echo "<h2>Database Permissions Check</h2>";
echo "<pre>";
// Check if we can write to the dashboard_settings table
try {
    $canWrite = DB::statement("UPDATE dashboard_settings SET updated_at = NOW() LIMIT 1");
    echo "Database write test: " . ($canWrite ? "Successful" : "Failed") . "\n";
} catch (Exception $e) {
    echo "Database write error: " . $e->getMessage() . "\n";
}
echo "</pre>";

echo "<h2>CSRF Token Check</h2>";
echo "<pre>";
// Check if CSRF token is properly set up
$layoutPath = resource_path('views/layouts/app.blade.php');
if (file_exists($layoutPath)) {
    $content = file_get_contents($layoutPath);
    if (strpos($content, 'csrf-token') !== false) {
        echo "CSRF meta tag found in layout.\n";
    } else {
        echo "CSRF meta tag not found in main layout.\n";
    }
}

// Check if forms include CSRF token
if (file_exists($viewPath)) {
    $content = file_get_contents($viewPath);
    if (strpos($content, '@csrf') !== false) {
        echo "CSRF token found in settings form.\n";
    } else {
        echo "CSRF token not found in settings form.\n";
    }
}
echo "</pre>";

echo "<h2>Error Logs</h2>";
echo "<pre>";
// Check recent error logs
$logFile = storage_path('logs/laravel.log');
if (file_exists($logFile)) {
    $lines = array_slice(file($logFile), -20);
    foreach ($lines as $line) {
        echo htmlspecialchars($line);
    }
} else {
    echo "Log file not found.\n";
}
echo "</pre>";