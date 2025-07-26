<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Artisan;

echo "=== Clearing All Laravel Caches ===\n\n";

// Clear route cache
echo "Clearing route cache...\n";
Artisan::call('route:clear');
echo Artisan::output();

// Clear config cache
echo "\nClearing config cache...\n";
Artisan::call('config:clear');
echo Artisan::output();

// Clear application cache
echo "\nClearing application cache...\n";
Artisan::call('cache:clear');
echo Artisan::output();

// Clear view cache
echo "\nClearing view cache...\n";
Artisan::call('view:clear');
echo Artisan::output();

// Clear compiled views
echo "\nClearing compiled views...\n";
Artisan::call('clear-compiled');
echo Artisan::output();

// Optimize the application
echo "\nOptimizing the application...\n";
Artisan::call('optimize:clear');
echo Artisan::output();

echo "\n=== All Caches Cleared Successfully ===\n";
echo "Now try updating the editor's name through the web interface again.\n";
echo "The changes should be visible after the update.\n";
