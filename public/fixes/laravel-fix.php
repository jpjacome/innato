<?php
// disable_telescope.php
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// 1. Comment out Telescope provider in config/app.php
$configPath = __DIR__ . '/config/app.php';
if (file_exists($configPath)) {
    $config = file_get_contents($configPath);
    // More aggressive search and replace
    $config = preg_replace('/([^\\/])(App\\\\Providers\\\\TelescopeServiceProvider::class)/', '$1// $2', $config);
    file_put_contents($configPath, $config);
    echo "Telescope disabled in config/app.php<br>";
}

// 2. Disable the TelescopeServiceProvider
$providerPath = app_path('Providers/TelescopeServiceProvider.php');
if (file_exists($providerPath)) {
    $content = file_get_contents($providerPath);
    $content = str_replace('return $this->app->isLocal();', 'return false;', $content);
    file_put_contents($providerPath, $content);
    echo "TelescopeServiceProvider updated to always return false<br>";
}

echo "Telescope disabled. Clear your caches now.";