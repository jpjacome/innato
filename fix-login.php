<?php
echo "<h1>Login Fix Tool</h1>";
echo "<pre>";

// Define application path
$basePath = __DIR__;

// Update the .env file to use file sessions
$envPath = $basePath.'/.env';
if (file_exists($envPath)) {
    $content = file_get_contents($envPath);
    
    // Change session driver to file instead of database
    $content = preg_replace('/SESSION_DRIVER=.*/', 'SESSION_DRIVER=file', $content);
    
    file_put_contents($envPath, $content);
    echo "✓ Session driver changed to file-based!\n";
} else {
    echo "❌ .env file not found!\n";
}

// Create session directory if it doesn't exist
$sessionPath = $basePath.'/storage/framework/sessions';
if (!is_dir($sessionPath)) {
    mkdir($sessionPath, 0755, true);
    echo "✓ Session directory created!\n";
} else {
    echo "Session directory already exists!\n";
}

// Check storage permissions
$storagePath = $basePath.'/storage';
if (is_writable($storagePath)) {
    echo "✓ Storage directory is writable!\n";
} else {
    echo "❌ Storage directory is not writable. Fixing permissions...\n";
    chmod($storagePath, 0755);
    echo "  Permissions updated to 755\n";
}

echo "</pre>";
echo "<p>Return to <a href='/laravel-test'>homepage</a> and try logging in again.</p>"; 