<?php
echo "<h1>Login Page Style Fix</h1>";
echo "<pre>";

// Define application path
$basePath = __DIR__;

// First, check where the CSS file is currently located
echo "Checking CSS file locations...\n";
$paths = [
    'public/css/control-panel.css',
    'public/build/assets/app-*.css'
];

$cssFilesFound = [];
foreach ($paths as $pattern) {
    $files = glob($basePath . '/' . $pattern);
    foreach ($files as $file) {
        $relativePath = str_replace($basePath . '/', '', $file);
        $cssFilesFound[] = $relativePath;
        echo "✓ Found CSS file: $relativePath (size: " . filesize($file) . " bytes)\n";
    }
}

if (empty($cssFilesFound)) {
    echo "❌ No CSS files found\n";
}

// Now check guest layout template
$guestLayoutPath = $basePath . '/resources/views/layouts/guest.blade.php';
if (file_exists($guestLayoutPath)) {
    echo "\nExamining guest layout file...\n";
    $guestLayout = file_get_contents($guestLayoutPath);
    
    // Show current style links
    preg_match_all('/<link[^>]*>/', $guestLayout, $matches);
    if (!empty($matches[0])) {
        echo "Current link tags in the file:\n";
        foreach ($matches[0] as $match) {
            echo "  $match\n";
        }
    }
    
    // Fix the guest layout
    echo "\nFixing guest layout...\n";
    
    // Create new styling content
    $styleLinks = '
    <!-- Application styles -->
    <link rel="stylesheet" href="{{ asset(\'css/control-panel.css\') }}">
    <style>
        /* Emergency inline styles */
        body {
            background-color: #1f2937;
            color: #f9fafb;
            font-family: ui-sans-serif, system-ui, sans-serif;
            line-height: 1.5;
        }
        .auth-card {
            max-width: 28rem;
            margin-left: auto;
            margin-right: auto;
            margin-top: 2rem;
            background-color: #111827;
            border-radius: 0.5rem;
            padding: 2rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
        .auth-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .auth-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #f9fafb;
            margin-bottom: 0.5rem;
        }
        .auth-form {
            margin-top: 1.5rem;
        }
        .form-group {
            margin-bottom: 1rem;
        }
        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: #d1d5db;
            margin-bottom: 0.5rem;
        }
        .form-input {
            width: 100%;
            padding: 0.5rem 0.75rem;
            background-color: #374151;
            border: 1px solid #4b5563;
            border-radius: 0.375rem;
            color: #f9fafb;
            line-height: 1.25;
        }
        .form-input:focus {
            outline: 2px solid #6366f1;
            outline-offset: 2px;
        }
        .form-button {
            display: inline-flex;
            padding: 0.5rem 1rem;
            background-color: #4F46E5;
            color: #ffffff;
            font-weight: 500;
            border-radius: 0.375rem;
            border: none;
            cursor: pointer;
        }
        .form-button:hover {
            background-color: #4338ca;
        }
        .form-checkbox {
            margin-right: 0.5rem;
        }
        .form-link {
            color: #6366f1;
            text-decoration: none;
        }
        .form-link:hover {
            text-decoration: underline;
        }
    </style>';
    
    // Replace existing style section or head content
    $newLayout = preg_replace('/<\/head>/', $styleLinks . "\n</head>", $guestLayout);
    
    if ($newLayout !== $guestLayout) {
        file_put_contents($guestLayoutPath, $newLayout);
        echo "✓ Added emergency styles to guest layout\n";
    } else {
        echo "❌ Could not update guest layout\n";
        
        // Show file content for debugging
        echo "\nGuest layout content:\n";
        echo substr($guestLayout, 0, 500) . "... (truncated)\n";
    }
} else {
    echo "❌ Guest layout file not found\n";
}

// Also check auth blade views
$loginViewPath = $basePath . '/resources/views/auth/login.blade.php';
if (file_exists($loginViewPath)) {
    echo "\nChecking login view...\n";
    $loginView = file_get_contents($loginViewPath);
    
    // Check for common CSS classes
    $commonClasses = ['mb-4', 'mt-4', 'form-control', 'btn', 'card'];
    $missingBootstrap = true;
    
    foreach ($commonClasses as $class) {
        if (strpos($loginView, "class=\"$class\"") !== false || 
            strpos($loginView, "class='$class'") !== false) {
            $missingBootstrap = false;
            break;
        }
    }
    
    if ($missingBootstrap) {
        echo "Login view doesn't appear to use Bootstrap classes\n";
    } else {
        echo "Login view appears to use Bootstrap - adding Bootstrap CSS reference\n";
        
        // Add Bootstrap reference to guest layout
        $guestLayout = file_get_contents($guestLayoutPath);
        $bootstrapLink = '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">';
        
        if (strpos($guestLayout, 'bootstrap') === false) {
            $newLayout = preg_replace('/<\/head>/', "$bootstrapLink\n</head>", $guestLayout);
            file_put_contents($guestLayoutPath, $newLayout);
            echo "✓ Added Bootstrap CSS to guest layout\n";
        }
    }
} else {
    echo "❌ Login view file not found\n";
}

// Finally, ensure the public CSS directory has the control panel CSS
$cssDir = $basePath . '/public/css';
if (!is_dir($cssDir)) {
    mkdir($cssDir, 0755, true);
    echo "✓ Created public CSS directory\n";
}

$controlPanelCssPath = $cssDir . '/control-panel.css';
if (!file_exists($controlPanelCssPath) || filesize($controlPanelCssPath) < 100) {
    // Create a decent CSS file
    $css = '/* Control Panel Styles */
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
    font-family: ui-sans-serif, system-ui, sans-serif;
    line-height: 1.5;
}

.control-panel-card, .auth-card {
    background-color: #111827;
    border: 1px solid var(--accent-color);
    border-radius: 0.5rem;
    padding: 2rem;
    margin-bottom: 1rem;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
}

.auth-card {
    max-width: 28rem;
    margin-left: auto;
    margin-right: auto;
    margin-top: 2rem;
}

.control-panel-title, .auth-title {
    color: var(--white);
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 1rem;
}

.control-panel-button, .form-button {
    display: inline-block;
    background-color: var(--primary-color);
    color: var(--white);
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
    text-decoration: none;
    border: none;
    cursor: pointer;
    font-weight: 500;
}

.control-panel-button:hover, .form-button:hover {
    background-color: #4338ca;
}

.control-panel-input, .form-input {
    width: 100%;
    padding: 0.5rem 0.75rem;
    border: 1px solid #4b5563;
    border-radius: 0.375rem;
    background-color: #374151;
    color: var(--white);
    line-height: 1.25;
}

.control-panel-input:focus, .form-input:focus {
    outline: 2px solid var(--accent-color);
    outline-offset: 2px;
}

.form-label {
    display: block;
    font-size: 0.875rem;
    font-weight: 500;
    color: #d1d5db;
    margin-bottom: 0.5rem;
}

.form-group {
    margin-bottom: 1rem;
}

.form-checkbox {
    margin-right: 0.5rem;
}

.form-link {
    color: var(--accent-color);
    text-decoration: none;
}

.form-link:hover {
    text-decoration: underline;
}';

    file_put_contents($controlPanelCssPath, $css);
    echo "✓ Created comprehensive control-panel.css in public directory\n";
}

echo "</pre>";
echo "<p>Styles have been fixed! <a href='/laravel-test/login'>Return to login page</a> to see the changes.</p>"; 