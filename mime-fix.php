<?php
echo "<h1>MIME Type Fix Tool</h1>";
echo "<pre>";

// Define application path
$basePath = __DIR__;

// Create .htaccess in the public/css directory
$cssDir = $basePath . '/public/css';
if (!is_dir($cssDir)) {
    mkdir($cssDir, 0755, true);
    echo "Created CSS directory\n";
}

$cssHtaccess = <<<EOT
# Set proper MIME types for CSS files
<IfModule mod_mime.c>
    AddType text/css .css
</IfModule>

# Force CSS MIME type regardless of server configuration
<IfModule mod_headers.c>
    <FilesMatch "\.css$">
        Header set Content-Type "text/css"
    </FilesMatch>
</IfModule>
EOT;

file_put_contents($cssDir . '/.htaccess', $cssHtaccess);
echo "✓ Created .htaccess file in public/css directory\n";

// Create .htaccess in public/build directory
$buildDir = $basePath . '/public/build';
if (!is_dir($buildDir)) {
    mkdir($buildDir, 0755, true);
    echo "Created build directory\n";
}

$buildHtaccess = <<<EOT
# Set proper MIME types for asset files
<IfModule mod_mime.c>
    AddType text/css .css
    AddType application/javascript .js
    AddType application/json .json
    AddType image/svg+xml .svg
    AddType image/png .png
    AddType image/jpeg .jpg .jpeg
</IfModule>

# Force correct MIME types regardless of server configuration
<IfModule mod_headers.c>
    <FilesMatch "\.css$">
        Header set Content-Type "text/css"
    </FilesMatch>
    <FilesMatch "\.js$">
        Header set Content-Type "application/javascript"
    </FilesMatch>
    <FilesMatch "\.json$">
        Header set Content-Type "application/json"
    </FilesMatch>
</IfModule>
EOT;

file_put_contents($buildDir . '/.htaccess', $buildHtaccess);
echo "✓ Created .htaccess file in public/build directory\n";

// Also create a root public .htaccess to handle assets
$publicDir = $basePath . '/public';
$publicHtaccess = $publicDir . '/.htaccess';

if (file_exists($publicHtaccess)) {
    // Add MIME types to existing .htaccess
    $existingHtaccess = file_get_contents($publicHtaccess);
    
    if (strpos($existingHtaccess, 'AddType text/css') === false) {
        $mimeSection = <<<EOT
        
# Set proper MIME types for asset files
<IfModule mod_mime.c>
    AddType text/css .css
    AddType application/javascript .js
    AddType application/json .json
    AddType image/svg+xml .svg
    AddType image/png .png
    AddType image/jpeg .jpg .jpeg
</IfModule>

EOT;
        $existingHtaccess = preg_replace('/<IfModule mod_rewrite.c>/', $mimeSection . '<IfModule mod_rewrite.c>', $existingHtaccess);
        file_put_contents($publicHtaccess, $existingHtaccess);
        echo "✓ Added MIME types to existing public/.htaccess file\n";
    } else {
        echo "MIME types already exist in public/.htaccess file\n";
    }
} else {
    echo "Creating new public/.htaccess file\n";
    $newPublicHtaccess = <<<EOT
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>
    
    # Set proper MIME types for asset files
    <IfModule mod_mime.c>
        AddType text/css .css
        AddType application/javascript .js
        AddType application/json .json
        AddType image/svg+xml .svg
        AddType image/png .png
        AddType image/jpeg .jpg .jpeg
    </IfModule>
    
    RewriteEngine On
    
    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]
    
    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]
    
    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
EOT;
    file_put_contents($publicHtaccess, $newPublicHtaccess);
    echo "✓ Created new public/.htaccess file with MIME types\n";
}

// Copy the control-panel.css directly to the right location
$controlPanelCssContent = <<<EOT
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
EOT;

file_put_contents($cssDir . '/control-panel.css', $controlPanelCssContent);
echo "✓ Created control-panel.css with appropriate content type\n";

// Also modify the guest.blade.php template to use inline styles as a fallback
$guestLayoutPath = $basePath . '/resources/views/layouts/guest.blade.php';
if (file_exists($guestLayoutPath)) {
    $guestLayout = file_get_contents($guestLayoutPath);
    
    // Add alternative styling directly in the template as a fallback
    $styleBlock = <<<EOT
    <style>
    /* Fallback styles in case external CSS fails to load */
    body {
        background-color: #1f2937;
        color: #f9fafb;
        font-family: ui-sans-serif, system-ui, sans-serif;
    }
    .auth-card {
        max-width: 28rem;
        margin: 2rem auto;
        background-color: #111827;
        border-radius: 0.5rem;
        padding: 2rem;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }
    .form-label {
        display: block;
        color: #d1d5db;
        margin-bottom: 0.5rem;
    }
    .form-input {
        width: 100%;
        padding: 0.5rem;
        background-color: #374151;
        border: 1px solid #4b5563;
        border-radius: 0.375rem;
        color: #f9fafb;
    }
    .form-button {
        background-color: #4F46E5;
        color: #ffffff;
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        border: none;
        cursor: pointer;
    }
    </style>
EOT;

    // Add the style block before the closing head tag
    $updatedLayout = preg_replace('/<\/head>/', $styleBlock . "\n</head>", $guestLayout);
    
    if ($updatedLayout !== $guestLayout) {
        file_put_contents($guestLayoutPath, $updatedLayout);
        echo "✓ Added fallback inline styles to guest layout\n";
    }
}

echo "</pre>";
echo "<p>MIME type fixes have been applied. Try refreshing the page now.</p>"; 