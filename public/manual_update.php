<?php
// debug.php
// Upload this to your server and run it to see the error logs

// Output the last 50 lines of the Laravel error log
$logFile = __DIR__ . '/storage/logs/laravel.log';
if (file_exists($logFile)) {
    $lines = file($logFile);
    $last = array_slice($lines, -50);
    echo "<pre>";
    foreach ($last as $line) {
        echo htmlspecialchars($line);
    }
    echo "</pre>";
} else {
    echo "Log file not found at: " . $logFile;
}

// Also output PHP error information
echo "<h3>PHP Info:</h3>";
echo "<pre>";
echo "PHP Version: " . phpversion() . "\n";
echo "PHP Extensions: " . implode(', ', get_loaded_extensions()) . "\n";
echo "</pre>";

// Check for common template issues
$viewsPath = __DIR__ . '/resources/views';
echo "<h3>Checking critical view files:</h3>";
echo "<pre>";
$criticalFiles = [
    '/layouts/app.blade.php',
    '/components/control-panel-layout.blade.php',
    '/dashboard.blade.php',
    '/admin/settings/index.blade.php'
];

foreach ($criticalFiles as $file) {
    $fullPath = $viewsPath . $file;
    if (file_exists($fullPath)) {
        echo "File exists: " . $file . "\n";
    } else {
        echo "MISSING FILE: " . $file . "\n";
    }
}
echo "</pre>";