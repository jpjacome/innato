<?php
echo "<h1>Laravel Cache Clearing Tool</h1>";
echo "<pre>";

// Define application path
$basePath = __DIR__;

// Clear various cache files
echo "Clearing Laravel caches...\n";

// Configuration cache
if (file_exists($basePath.'/bootstrap/cache/config.php')) {
    unlink($basePath.'/bootstrap/cache/config.php');
    echo "✓ Configuration cache cleared\n";
} else {
    echo "Configuration cache file not found\n";
}

// Route cache
if (file_exists($basePath.'/bootstrap/cache/routes-v7.php')) {
    unlink($basePath.'/bootstrap/cache/routes-v7.php');
    echo "✓ Route cache cleared\n";
} else {
    echo "Route cache file not found\n";
}

// Application cache
if (is_dir($basePath.'/bootstrap/cache')) {
    // Keep the directory but clear most cache files
    $cacheFiles = glob($basePath.'/bootstrap/cache/*.php');
    foreach ($cacheFiles as $file) {
        if (basename($file) != 'services.php') { // Keep services.php
            unlink($file);
        }
    }
    echo "✓ Application cache files cleared\n";
} else {
    echo "Cache directory not found\n";
}

// Check storage directory permissions
$directories = [
    '/storage',
    '/storage/app',
    '/storage/app/public',
    '/storage/framework',
    '/storage/framework/cache',
    '/storage/framework/sessions',
    '/storage/framework/views',
    '/storage/logs',
    '/bootstrap',
    '/bootstrap/cache'
];

echo "\nChecking directory permissions...\n";
foreach ($directories as $dir) {
    $fullPath = $basePath . $dir;
    if (!file_exists($fullPath)) {
        mkdir($fullPath, 0755, true);
        echo "Created missing directory: $dir\n";
    }
    
    if (is_writable($fullPath)) {
        echo "✓ $dir is writable\n";
    } else {
        echo "❌ $dir is not writable - fixing permissions\n";
        chmod($fullPath, 0755);
    }
}

echo "</pre>";
echo "<p>Return to <a href='/laravel-test'>homepage</a></p>"; 