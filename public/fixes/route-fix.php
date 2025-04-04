<?php
// fix_routes.php
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Update routes file
$routesPath = base_path('routes/web.php');
if (file_exists($routesPath)) {
    $routes = file_get_contents($routesPath);
    
    // Change the route name to match the form
    $routes = str_replace(
        "Route::put('/admin/settings', [SettingsController::class, 'update'])->name('admin.settings.update');",
        "Route::put('/admin/settings', [SettingsController::class, 'update'])->name('settings.update');",
        $routes
    );
    
    // Or alternate approach to find similar patterns
    $routes = preg_replace(
        '/Route::put\(\'\/admin\/settings\',\s*\[[^\]]+\],\s*\'update\'\)\)\->name\(\'[^\']+\'\);/',
        "Route::put('/admin/settings', [SettingsController::class, 'update'])->name('settings.update');",
        $routes
    );
    
    file_put_contents($routesPath, $routes);
    echo "Routes updated!<br>";
}

// Clear route cache
try {
    \Illuminate\Support\Facades\Artisan::call('route:clear');
    echo "Route cache cleared!<br>";
} catch (Exception $e) {
    echo "Error clearing route cache: " . $e->getMessage() . "<br>";
}