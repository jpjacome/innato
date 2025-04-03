<?php
echo "<h1>Template Update Tool</h1>";
echo "<pre>";

// Define application path
$basePath = __DIR__;

// Target blade templates
$guestLayoutPath = $basePath . '/resources/views/layouts/guest.blade.php';

if (file_exists($guestLayoutPath)) {
    echo "Found guest.blade.php template\n";
    
    // Read the current template
    $guestLayout = file_get_contents($guestLayoutPath);
    
    // Remove any existing references to control-panel.css or inline styles
    $guestLayout = preg_replace('/<link[^>]*control-panel\.css[^>]*>/', '', $guestLayout);
    $guestLayout = preg_replace('/<style>[^<]*<\/style>/', '', $guestLayout);
    
    // Add reference to our PHP-based CSS file
    $cssLink = '<link rel="stylesheet" href="{{ url(\'/laravel-test/css.php\') }}">';
    
    // Insert the CSS link before the closing </head> tag
    $guestLayout = preg_replace('/<\/head>/', "    " . $cssLink . "\n</head>", $guestLayout);
    
    // Save the updated template
    file_put_contents($guestLayoutPath, $guestLayout);
    echo "✓ Updated guest.blade.php to use PHP-based CSS\n";
}

// Check the app layout as well
$appLayoutPath = $basePath . '/resources/views/layouts/app.blade.php';
if (file_exists($appLayoutPath)) {
    echo "\nFound app.blade.php template\n";
    
    // Read the current template
    $appLayout = file_get_contents($appLayoutPath);
    
    // Remove any existing references to CSS files or inline styles
    $appLayout = preg_replace('/<link[^>]*control-panel\.css[^>]*>/', '', $appLayout);
    $appLayout = preg_replace('/<style>[^<]*<\/style>/', '', $appLayout);
    
    // Add reference to our PHP-based CSS file
    $cssLink = '<link rel="stylesheet" href="{{ url(\'/laravel-test/css.php\') }}">';
    
    // Insert the CSS link before the closing </head> tag
    if (strpos($appLayout, '</head>') !== false) {
        $appLayout = preg_replace('/<\/head>/', "    " . $cssLink . "\n</head>", $appLayout);
        
        // Save the updated template
        file_put_contents($appLayoutPath, $appLayout);
        echo "✓ Updated app.blade.php to use PHP-based CSS\n";
    }
}

// Check if the login.blade.php file has inline styles and remove them
$loginBladePath = $basePath . '/resources/views/auth/login.blade.php';
if (file_exists($loginBladePath)) {
    echo "\nFound login.blade.php template\n";
    $loginBlade = file_get_contents($loginBladePath);
    
    // Remove any inline styles
    $loginBlade = preg_replace('/<style>[^<]*<\/style>/', '', $loginBlade);
    
    // Save the updated file
    file_put_contents($loginBladePath, $loginBlade);
    echo "✓ Removed inline styles from login.blade.php\n";
}

// Create a simple JS loader as well for JavaScript
$jsPhpPath = $basePath . '/js.php';
$jsContent = <<<EOT
<?php
// Set the content type header to JavaScript
header('Content-Type: application/javascript');

// Disable caching for development
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');
?>
// Common JavaScript functionality
document.addEventListener('DOMContentLoaded', function() {
    // Initialize any interactive elements
    const buttons = document.querySelectorAll('.form-button, .control-panel-button');
    buttons.forEach(button => {
        button.addEventListener('click', function() {
            // Add a loading state
            this.classList.add('loading');
        });
    });

    // Form validation
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            let isValid = true;
            const requiredInputs = this.querySelectorAll('[required]');
            
            requiredInputs.forEach(input => {
                if (!input.value.trim()) {
                    isValid = false;
                    input.classList.add('error');
                } else {
                    input.classList.remove('error');
                }
            });
            
            if (!isValid) {
                e.preventDefault();
            }
        });
    });
});
EOT;

file_put_contents($jsPhpPath, $jsContent);
echo "\n✓ Created js.php for JavaScript functionality\n";

// Update the templates to include the JavaScript file
if (file_exists($guestLayoutPath)) {
    $guestLayout = file_get_contents($guestLayoutPath);
    
    // Add reference to our PHP-based JS file if not already there
    if (strpos($guestLayout, 'js.php') === false) {
        $jsScriptTag = '<script src="{{ url(\'/laravel-test/js.php\') }}"></script>';
        
        // Insert the script tag before the closing </body> tag
        $guestLayout = preg_replace('/<\/body>/', "    " . $jsScriptTag . "\n</body>", $guestLayout);
        
        // Save the updated template
        file_put_contents($guestLayoutPath, $guestLayout);
        echo "✓ Added JavaScript reference to guest.blade.php\n";
    }
}

if (file_exists($appLayoutPath)) {
    $appLayout = file_get_contents($appLayoutPath);
    
    // Add reference to our PHP-based JS file if not already there
    if (strpos($appLayout, 'js.php') === false && strpos($appLayout, '</body>') !== false) {
        $jsScriptTag = '<script src="{{ url(\'/laravel-test/js.php\') }}"></script>';
        
        // Insert the script tag before the closing </body> tag
        $appLayout = preg_replace('/<\/body>/', "    " . $jsScriptTag . "\n</body>", $appLayout);
        
        // Save the updated template
        file_put_contents($appLayoutPath, $appLayout);
        echo "✓ Added JavaScript reference to app.blade.php\n";
    }
}

echo "</pre>";
echo "<p>Templates have been updated to use a single CSS file served via PHP.</p>";
echo "<p>Please refresh your login page to see the changes.</p>";
?> 