<?php
echo "<h1>Component Layout CSS Fix</h1>";
echo "<pre>";

// Define application path
$basePath = __DIR__;

// First, check for the guest-layout component
$componentPath = $basePath . '/resources/views/components/guest-layout.blade.php';
if (!file_exists($componentPath)) {
    $componentPath = $basePath . '/resources/views/layouts/guest.blade.php';
    if (!file_exists($componentPath)) {
        // Try to find the component using a more general search
        echo "Searching for guest layout component...\n";
        $possiblePaths = [
            $basePath . '/app/View/Components/GuestLayout.php',
            $basePath . '/resources/views/components/layouts/guest.blade.php', 
            $basePath . '/resources/views/components/guest.blade.php',
        ];
        
        foreach ($possiblePaths as $path) {
            if (file_exists($path)) {
                $componentPath = $path;
                echo "Found component at: $path\n";
                break;
            }
        }
    }
}

if (file_exists($componentPath)) {
    echo "Found guest layout component: $componentPath\n";
    
    // Read the component content
    $componentContent = file_get_contents($componentPath);
    
    // Output component structure for debugging
    echo "\nComponent structure:\n";
    echo "--------------------\n";
    echo htmlspecialchars($componentContent) . "\n";
    echo "--------------------\n\n";
    
    // Check if we can find the head or html structure
    $hasHead = strpos($componentContent, '</head>') !== false;
    $hasHtml = strpos($componentContent, '<html') !== false;
    
    echo "Component has head tag: " . ($hasHead ? "Yes" : "No") . "\n";
    echo "Component has html tag: " . ($hasHtml ? "Yes" : "No") . "\n";
    
    // Add CSS reference to the component
    $modified = false;
    
    if ($hasHead) {
        // Insert CSS link before head closing tag
        $cssLink = '<link rel="stylesheet" href="{{ url(\'/laravel-test/css.php\') }}">';
        if (strpos($componentContent, 'css.php') === false) {
            $componentContent = preg_replace('/<\/head>/', "    {$cssLink}\n</head>", $componentContent);
            $modified = true;
        }
    } else {
        // If it's a slot component without a full HTML structure, we'll add the CSS inline
        if (strpos($componentContent, '<style') === false) {
            // Read the CSS content
            $cssPath = $basePath . '/css.php';
            if (file_exists($cssPath)) {
                $cssContent = file_get_contents($cssPath);
                // Remove PHP headers
                $cssContent = preg_replace('/^<\?php.*?\?>(\s*)/s', '', $cssContent);
                
                // Add style tag to beginning of component
                if (strpos($componentContent, '{{-- Page Content --}}') !== false) {
                    $inlineStyle = "<style>\n{$cssContent}\n</style>\n\n";
                    $componentContent = str_replace('{{-- Page Content --}}', $inlineStyle . '{{-- Page Content --}}', $componentContent);
                    $modified = true;
                } elseif (strpos($componentContent, '<div') !== false) {
                    // Insert before the first div
                    $inlineStyle = "<style>\n{$cssContent}\n</style>\n\n";
                    $componentContent = preg_replace('/(<div[^>]*>)/', $inlineStyle . '$1', $componentContent, 1);
                    $modified = true;
                } else {
                    // Just add at the beginning
                    $inlineStyle = "<style>\n{$cssContent}\n</style>\n\n";
                    $componentContent = $inlineStyle . $componentContent;
                    $modified = true;
                }
            }
        }
    }
    
    if ($modified) {
        file_put_contents($componentPath, $componentContent);
        echo "✓ Added CSS to guest layout component\n";
    } else {
        echo "No changes needed to guest layout component\n";
    }
    
    // Now let's also check for the app-layout component
    $appComponentPath = $basePath . '/resources/views/components/app-layout.blade.php';
    if (file_exists($appComponentPath)) {
        echo "\nFound app layout component\n";
        $appComponentContent = file_get_contents($appComponentPath);
        
        if (strpos($appComponentContent, 'css.php') === false && strpos($appComponentContent, '</head>') !== false) {
            $cssLink = '<link rel="stylesheet" href="{{ url(\'/laravel-test/css.php\') }}">';
            $appComponentContent = preg_replace('/<\/head>/', "    {$cssLink}\n</head>", $appComponentContent);
            file_put_contents($appComponentPath, $appComponentContent);
            echo "✓ Added CSS to app layout component\n";
        }
    }
    
    // Also check for any Laravel 9+ Blade components in app/View/Components directory
    $componentsDir = $basePath . '/app/View/Components';
    if (is_dir($componentsDir)) {
        echo "\nChecking PHP component classes...\n";
        $files = scandir($componentsDir);
        foreach ($files as $file) {
            if ($file === '.' || $file === '..') continue;
            
            if (strpos($file, 'GuestLayout.php') !== false || strpos($file, 'AppLayout.php') !== false) {
                echo "Found component class: $file\n";
                $classPath = $componentsDir . '/' . $file;
                
                // Check which template this component renders
                $classContent = file_get_contents($classPath);
                
                if (preg_match('/return view\([\'"](.+?)[\'"]\)/', $classContent, $matches)) {
                    $viewName = $matches[1];
                    echo "Component renders view: $viewName\n";
                    
                    // Locate the view file
                    $viewPath = $basePath . '/resources/views/' . str_replace('.', '/', $viewName) . '.blade.php';
                    if (file_exists($viewPath)) {
                        echo "Found view file: $viewPath\n";
                        $viewContent = file_get_contents($viewPath);
                        
                        if (strpos($viewContent, 'css.php') === false && strpos($viewContent, '</head>') !== false) {
                            $cssLink = '<link rel="stylesheet" href="{{ url(\'/laravel-test/css.php\') }}">';
                            $viewContent = preg_replace('/<\/head>/', "    {$cssLink}\n</head>", $viewContent);
                            file_put_contents($viewPath, $viewContent);
                            echo "✓ Added CSS to view file\n";
                        } elseif (strpos($viewContent, 'css.php') === false) {
                            // If no head tag, add style tag
                            $cssPath = $basePath . '/css.php';
                            if (file_exists($cssPath)) {
                                $cssContent = file_get_contents($cssPath);
                                // Remove PHP headers
                                $cssContent = preg_replace('/^<\?php.*?\?>(\s*)/s', '', $cssContent);
                                
                                // Add style tag to beginning of view
                                $inlineStyle = "<style>\n{$cssContent}\n</style>\n\n";
                                $viewContent = $inlineStyle . $viewContent;
                                file_put_contents($viewPath, $viewContent);
                                echo "✓ Added inline CSS to view file\n";
                            }
                        }
                    }
                }
            }
        }
    }
    
    // Fix input.blade.php components
    $inputComponentPaths = [
        $basePath . '/resources/views/components/text-input.blade.php',
        $basePath . '/resources/views/components/input.blade.php',
        $basePath . '/resources/views/components/input-label.blade.php',
        $basePath . '/resources/views/components/button.blade.php',
        $basePath . '/resources/views/components/primary-button.blade.php',
    ];
    
    echo "\nChecking UI components...\n";
    foreach ($inputComponentPaths as $inputPath) {
        if (file_exists($inputPath)) {
            echo "Found component: " . basename($inputPath) . "\n";
            $inputContent = file_get_contents($inputPath);
            
            // Add our custom CSS classes to these components
            if (basename($inputPath) === 'text-input.blade.php' || basename($inputPath) === 'input.blade.php') {
                // Add form-input class to inputs
                if (strpos($inputContent, 'form-input') === false) {
                    $inputContent = str_replace('class="', 'class="form-input ', $inputContent);
                    file_put_contents($inputPath, $inputContent);
                    echo "✓ Added form-input class to " . basename($inputPath) . "\n";
                }
            } elseif (basename($inputPath) === 'input-label.blade.php') {
                // Add form-label class to labels
                if (strpos($inputContent, 'form-label') === false) {
                    $inputContent = str_replace('class="', 'class="form-label ', $inputContent);
                    file_put_contents($inputPath, $inputContent);
                    echo "✓ Added form-label class to " . basename($inputPath) . "\n";
                }
            } elseif (basename($inputPath) === 'button.blade.php' || basename($inputPath) === 'primary-button.blade.php') {
                // Add form-button class to buttons
                if (strpos($inputContent, 'form-button') === false) {
                    $inputContent = str_replace('class="', 'class="form-button ', $inputContent);
                    file_put_contents($inputPath, $inputContent);
                    echo "✓ Added form-button class to " . basename($inputPath) . "\n";
                }
            }
        }
    }
    
    // Create a direct login page that doesn't use components
    echo "\nCreating a direct login page...\n";
    $directLoginPath = $basePath . '/public/direct-login.php';
    $directLogin = <<<EOT
<?php
// Set proper content type
header('Content-Type: text/html; charset=UTF-8');

// Helper function to get current URL
function current_url() {
    \$protocol = isset(\$_SERVER['HTTPS']) && \$_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
    \$host = \$_SERVER['HTTP_HOST'];
    \$uri = \$_SERVER['REQUEST_URI'];
    return \$protocol . '://' . \$host . \$uri;
}

// Get CSS from css.php with proper content type
\$cssUrl = str_replace('direct-login.php', 'css.php', current_url());
\$ch = curl_init();
curl_setopt(\$ch, CURLOPT_URL, \$cssUrl);
curl_setopt(\$ch, CURLOPT_RETURNTRANSFER, true);
\$cssContent = curl_exec(\$ch);
curl_close(\$ch);

// Remove PHP headers if present
\$cssContent = preg_replace('/^<\?php.*?\?>(\s*)/s', '', \$cssContent);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Laravel Test</title>
    <style>
    <?php echo \$cssContent; ?>
    </style>
</head>
<body>
    <div class="login-container">
        <div class="auth-card">
            <h2 class="auth-title">Login</h2>
            
            <?php if (isset(\$_GET['error'])): ?>
                <div class="alert alert-error">
                    <?php echo htmlspecialchars(\$_GET['error']); ?>
                </div>
            <?php endif; ?>
            
            <?php if (isset(\$_GET['success'])): ?>
                <div class="alert alert-success">
                    <?php echo htmlspecialchars(\$_GET['success']); ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="/laravel-test/login">
                <input type="hidden" name="_token" value="<?php echo htmlspecialchars(file_get_contents('/tmp/csrf_token.txt')); ?>">
                
                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input id="email" type="email" name="email" class="form-input" required autofocus>
                </div>
                
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input id="password" type="password" name="password" class="form-input" required>
                </div>
                
                <div class="form-group">
                    <label for="remember_me" class="flex items-center">
                        <input id="remember_me" type="checkbox" name="remember" class="form-checkbox">
                        <span class="form-label">Remember me</span>
                    </label>
                </div>
                
                <div class="flex justify-between items-center mt-4">
                    <a href="/laravel-test/forgot-password" class="form-link">Forgot your password?</a>
                    
                    <button type="submit" class="form-button">Log in</button>
                </div>
                
                <div class="flex justify-between items-center mt-4">
                    <a href="/laravel-test/register" class="form-link">Need an account? Register</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
EOT;

    file_put_contents($directLoginPath, $directLogin);
    echo "✓ Created direct login page at /public/direct-login.php\n";
    
} else {
    echo "❌ Could not find guest layout component\n";
    
    // Let's create a quick fix using a direct asset URL in the head
    echo "Creating a direct CSS link in the head...\n";
    $indexPath = $basePath . '/public/index.php';
    if (file_exists($indexPath)) {
        $indexContent = file_get_contents($indexPath);
        
        // This is a bit hacky but might work - add a header hook
        if (strpos($indexContent, 'function fixHeader') === false) {
            $headerFix = <<<'EOT'

// Quick CSS fix
function fixHeader($buffer) {
    // Only modify HTML responses
    if (stripos($buffer, '<!DOCTYPE html>') !== false || stripos($buffer, '<html') !== false) {
        // Add our CSS link to the head
        $cssLink = '<link rel="stylesheet" href="/laravel-test/css.php">';
        $buffer = preg_replace('/<\/head>/', $cssLink . '</head>', $buffer, 1);
    }
    return $buffer;
}

// Register the output buffer
ob_start('fixHeader');

EOT;
            $indexContent = str_replace('<?php', "<?php\n" . $headerFix, $indexContent);
            file_put_contents($indexPath, $indexContent);
            echo "✓ Added CSS link to output buffer in index.php\n";
        }
    }
}

echo "</pre>";
echo "<p>Component CSS has been fixed using multiple approaches:</p>";
echo "<ol>";
echo "<li>Added CSS to the guest layout component</li>";
echo "<li>Added CSS classes to form components</li>";
echo "<li>Created a direct login page at <a href='/laravel-test/public/direct-login.php'>direct-login.php</a></li>";
echo "</ol>";
echo "<p>Try the login page again. If it still doesn't work, use the direct login page.</p>";
?> 