<?php
echo "<h1>Inline CSS Fix Tool</h1>";
echo "<pre>";

// Define application path
$basePath = __DIR__;

// Target blade templates
$guestLayoutPath = $basePath . '/resources/views/layouts/guest.blade.php';

if (file_exists($guestLayoutPath)) {
    echo "Found guest.blade.php template\n";
    
    // Read the current template
    $guestLayout = file_get_contents($guestLayoutPath);
    
    // Remove any existing references to control-panel.css
    $guestLayout = preg_replace('/<link[^>]*control-panel\.css[^>]*>/', '', $guestLayout);
    
    // Check if there's already an inline style tag
    if (strpos($guestLayout, '<style>/* Fallback styles') === false) {
        // Create comprehensive inline styles
        $inlineStyles = <<<EOT
    <!-- Inline styles to replace external CSS -->
    <style>
    /* Control Panel Styles */
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
    }
    </style>
EOT;
        
        // Insert the inline styles before the closing </head> tag
        $guestLayout = preg_replace('/<\/head>/', $inlineStyles . "\n</head>", $guestLayout);
        
        // Save the updated template
        file_put_contents($guestLayoutPath, $guestLayout);
        echo "✓ Updated guest.blade.php with inline styles\n";
    } else {
        echo "✓ Inline styles already exist in guest.blade.php\n";
    }
} else {
    echo "❌ Could not find guest.blade.php template\n";
}

// Now try to also add Bootstrap as a fallback from a CDN
$guestLayoutPath = $basePath . '/resources/views/layouts/guest.blade.php';
if (file_exists($guestLayoutPath)) {
    $guestLayout = file_get_contents($guestLayoutPath);
    
    // Add Bootstrap CSS from CDN if not already present
    if (strpos($guestLayout, 'bootstrap') === false) {
        $bootstrapLink = '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">';
        $guestLayout = preg_replace('/<\/title>/', '</title>' . "\n    " . $bootstrapLink, $guestLayout);
        file_put_contents($guestLayoutPath, $guestLayout);
        echo "✓ Added Bootstrap CSS from CDN\n";
    }
}

// Check login.blade.php as well
$loginBladePath = $basePath . '/resources/views/auth/login.blade.php';
if (file_exists($loginBladePath)) {
    echo "\nFound login.blade.php template\n";
    $loginBlade = file_get_contents($loginBladePath);
    
    // Add inline styles to login form if needed
    if (strpos($loginBlade, '<style>') === false) {
        $loginStyles = <<<EOT
<style>
/* Additional login-specific styles */
.login-container {
    max-width: 28rem;
    margin: 3rem auto;
}
.login-title {
    text-align: center;
    margin-bottom: 2rem;
    color: #f9fafb;
}
.form-group {
    margin-bottom: 1.5rem;
}
.form-button {
    width: 100%;
    margin-top: 1rem;
}
</style>
EOT;
        
        // Find the right position to insert
        if (strpos($loginBlade, '@section(\'content\')') !== false) {
            $loginBlade = str_replace('@section(\'content\')', '@section(\'content\')' . "\n" . $loginStyles, $loginBlade);
            file_put_contents($loginBladePath, $loginBlade);
            echo "✓ Added inline styles to login.blade.php\n";
        }
    } else {
        echo "✓ Login page already has inline styles\n";
    }
}

// Test the file server to see if we can create and access a static file
$testFile = $basePath . '/public/test.css';
file_put_contents($testFile, 'body { color: black; }');
echo "\nCreated test.css file in public directory\n";

echo "\nPlease try the following steps:
1. Visit https://orustravel.org/laravel-test/test.css to see if CSS files are being served correctly
2. If that returns HTML instead of CSS text, your server is routing all requests through Laravel
3. Try refreshing the login page - the inline styles should work regardless of MIME type issues\n";

echo "</pre>";
echo "<p>Inline styles have been added to templates. Try refreshing the login page now.</p>";
?> 