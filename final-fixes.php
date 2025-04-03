<?php
echo "<h1>Final Fixes Tool</h1>";
echo "<pre>";

// Define application path
$basePath = __DIR__;

// 1. Fix cache driver in .env
echo "Fixing cache configuration...\n";
$envPath = $basePath.'/.env';
if (file_exists($envPath)) {
    $content = file_get_contents($envPath);
    
    // Change cache driver to file
    $content = preg_replace('/CACHE_DRIVER=.*/', 'CACHE_DRIVER=file', $content);
    
    // Also update cache store if present
    if (strpos($content, 'CACHE_STORE=') !== false) {
        $content = preg_replace('/CACHE_STORE=.*/', 'CACHE_STORE=file', $content);
    } else {
        // Add it if not present
        $content .= "\nCACHE_STORE=file";
    }
    
    file_put_contents($envPath, $content);
    echo "✓ Cache driver changed to file-based\n";
} else {
    echo "❌ .env file not found\n";
}

// 2. Fix guest.blade.php template
echo "\nFixing guest layout CSS route...\n";
$guestLayoutPath = $basePath.'/resources/views/layouts/guest.blade.php';
if (file_exists($guestLayoutPath)) {
    $layoutContent = file_get_contents($guestLayoutPath);
    
    // Replace route reference with direct CSS link
    $fixedContent = str_replace(
        '<link href="{{ route(\'control-panel.css\') }}" rel="stylesheet">',
        '<link href="{{ asset(\'css/control-panel.css\') }}" rel="stylesheet">',
        $layoutContent
    );
    
    // If the replacement didn't work, try other route patterns
    if ($fixedContent === $layoutContent) {
        $fixedContent = preg_replace(
            '/<link\s+[^>]*href\s*=\s*["\']{{.*?route\([\'"]control-panel\.css[\'"].*?}}["\']/i',
            '<link href="{{ asset(\'css/control-panel.css\') }}" rel="stylesheet">',
            $layoutContent
        );
    }
    
    if ($fixedContent !== $layoutContent) {
        file_put_contents($guestLayoutPath, $fixedContent);
        echo "✓ Fixed guest layout CSS reference\n";
    } else {
        echo "❌ Could not find CSS route reference in guest layout\n";
        
        // Show the current link tags for debugging
        preg_match_all('/<link[^>]*>/', $layoutContent, $matches);
        if (!empty($matches[0])) {
            echo "\nCurrent link tags in the file:\n";
            foreach ($matches[0] as $match) {
                echo "  $match\n";
            }
        }
    }
} else {
    echo "❌ Guest layout file not found\n";
}

// 3. Check for StyleController and create routes
echo "\nChecking StyleController and routes...\n";
$styleControllerPath = $basePath.'/app/Http/Controllers/StyleController.php';
if (file_exists($styleControllerPath)) {
    echo "✓ StyleController exists\n";
    
    // Copy the CSS file to public directory if it doesn't exist
    $publicCssDir = $basePath.'/public/css';
    if (!is_dir($publicCssDir)) {
        mkdir($publicCssDir, 0755, true);
        echo "Created public CSS directory\n";
    }
    
    $controlPanelCssPath = $publicCssDir.'/control-panel.css';
    $sourceCssPath = $basePath.'/public/css/control-panel.css';
    
    if (file_exists($sourceCssPath)) {
        if (!file_exists($controlPanelCssPath) || filesize($controlPanelCssPath) === 0) {
            copy($sourceCssPath, $controlPanelCssPath);
            echo "✓ Copied control-panel.css to public directory\n";
        } else {
            echo "✓ control-panel.css already exists in public directory\n";
        }
    } else {
        echo "❌ Source CSS file not found\n";
        
        // Create a basic CSS file
        $basicCss = "/* Basic control panel styles */
:root {
    --primary-color: #4F46E5;
    --secondary-color: #1f2937;
    --accent-color: #6366f1;
    --white: #ffffff;
    --text-color: #f9fafb;
}

body {
    background-color: var(--secondary-color);
    color: var(--text-color);
    font-family: 'Figtree', Arial, sans-serif;
}

.control-panel-card {
    background-color: var(--secondary-color);
    border: 1px solid var(--accent-color);
    border-radius: 0.5rem;
    padding: 1rem;
    margin-bottom: 1rem;
}

.control-panel-title {
    color: var(--white);
    font-size: 1.5rem;
    margin-bottom: 1rem;
}

.control-panel-button {
    display: inline-block;
    background-color: var(--primary-color);
    color: var(--white);
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
    text-decoration: none;
    border: none;
    cursor: pointer;
}

.control-panel-input {
    width: 100%;
    padding: 0.5rem;
    border: 1px solid var(--accent-color);
    border-radius: 0.375rem;
    background-color: var(--secondary-color);
    color: var(--white);
}";
        
        file_put_contents($controlPanelCssPath, $basicCss);
        echo "✓ Created basic control-panel.css in public directory\n";
    }
} else {
    echo "❌ StyleController not found\n";
}

// Clear any cache files
echo "\nClearing cache files...\n";
$cachePath = $basePath.'/bootstrap/cache';
if (is_dir($cachePath)) {
    $cacheFiles = glob($cachePath.'/*.php');
    foreach ($cacheFiles as $file) {
        unlink($file);
        echo "Removed cache file: " . basename($file) . "\n";
    }
} else {
    echo "Cache directory not found\n";
}

echo "</pre>";
echo "<p>All fixes have been applied. <a href='/laravel-test/login'>Try logging in again</a> with admin@example.com and password 'password'.</p>"; 