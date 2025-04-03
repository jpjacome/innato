<?php
echo "<h1>CSS Renaming Tool</h1>";
echo "<pre>";

// Define application path
$basePath = __DIR__;

// Step 1: Check if css.php exists and copy it to control-panel.css.php
if (file_exists($basePath . '/css.php')) {
    $cssContent = file_get_contents($basePath . '/css.php');
    file_put_contents($basePath . '/control-panel.css.php', $cssContent);
    echo "✓ Created control-panel.css.php from css.php\n";
} else {
    echo "❌ css.php not found\n";
    
    // Create control-panel.css.php from scratch
    $cssContent = <<<EOT
<?php
// Set the content type header to CSS
header('Content-Type: text/css');

// Disable caching for development
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');
?>
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
    file_put_contents($basePath . '/control-panel.css.php', $cssContent);
    echo "✓ Created new control-panel.css.php file\n";
}

// Step 2: Update all relevant Blade templates
$viewsPath = $basePath . '/resources/views';
if (is_dir($viewsPath)) {
    echo "\nUpdating Blade templates...\n";
    
    // List of directories to search in
    $directories = [
        $viewsPath . '/layouts',
        $viewsPath . '/components',
        $viewsPath . '/auth',
        $viewsPath . '/dashboard',
        $viewsPath . '/admin',
    ];
    
    $count = 0;
    foreach ($directories as $dir) {
        if (!is_dir($dir)) continue;
        
        // Get all blade files in directory
        $files = glob($dir . '/*.blade.php');
        foreach ($files as $file) {
            $content = file_get_contents($file);
            
            // Replace any references to css.php with control-panel.css.php
            $newContent = str_replace('css.php', 'control-panel.css.php', $content);
            $newContent = str_replace('control-panel.css', 'control-panel.css.php', $newContent);
            
            if ($content !== $newContent) {
                file_put_contents($file, $newContent);
                echo "  ✓ Updated {$file}\n";
                $count++;
            }
        }
        
        // Check subdirectories too (for components)
        $subdirs = glob($dir . '/*', GLOB_ONLYDIR);
        foreach ($subdirs as $subdir) {
            $files = glob($subdir . '/*.blade.php');
            foreach ($files as $file) {
                $content = file_get_contents($file);
                
                // Replace any references to css.php with control-panel.css.php
                $newContent = str_replace('css.php', 'control-panel.css.php', $content);
                $newContent = str_replace('control-panel.css', 'control-panel.css.php', $newContent);
                
                if ($content !== $newContent) {
                    file_put_contents($file, $newContent);
                    echo "  ✓ Updated {$file}\n";
                    $count++;
                }
            }
        }
    }
    
    if ($count === 0) {
        echo "  No templates needed updating\n";
    } else {
        echo "  ✓ Updated {$count} templates\n";
    }
    
    // Also check app.blade.php and guest.blade.php directly
    $importantFiles = [
        $viewsPath . '/layouts/app.blade.php',
        $viewsPath . '/layouts/guest.blade.php',
    ];
    
    foreach ($importantFiles as $file) {
        if (file_exists($file)) {
            $content = file_get_contents($file);
            
            // Add link if not present
            if (strpos($content, 'control-panel.css.php') === false && strpos($content, '</head>') !== false) {
                $cssLink = '<link rel="stylesheet" href="{{ url(\'/laravel-test/control-panel.css.php\') }}">';
                $content = str_replace('</head>', "    {$cssLink}\n</head>", $content);
                file_put_contents($file, $content);
                echo "  ✓ Added CSS link to {$file}\n";
            }
        }
    }
}

// Step 3: Check for component-based layouts
$componentPaths = [
    $basePath . '/resources/views/components/guest-layout.blade.php',
    $basePath . '/resources/views/components/app-layout.blade.php',
    $basePath . '/resources/views/components/layouts/guest.blade.php',
    $basePath . '/resources/views/components/layouts/app.blade.php',
];

echo "\nChecking component-based layouts...\n";
$found = false;
foreach ($componentPaths as $path) {
    if (file_exists($path)) {
        $found = true;
        echo "  Found component: {$path}\n";
        $content = file_get_contents($path);
        
        // Replace any existing CSS references
        $content = str_replace('css.php', 'control-panel.css.php', $content);
        $content = str_replace('control-panel.css', 'control-panel.css.php', $content);
        
        // Add CSS link if not present and there's a head tag
        if (strpos($content, 'control-panel.css.php') === false && strpos($content, '</head>') !== false) {
            $cssLink = '<link rel="stylesheet" href="{{ url(\'/laravel-test/control-panel.css.php\') }}">';
            $content = str_replace('</head>', "    {$cssLink}\n</head>", $content);
        }
        // If no head tag but has HTML structure, add style tag
        elseif (strpos($content, 'control-panel.css.php') === false && strpos($content, '<style') === false) {
            $cssUrl = "{{ url('/laravel-test/control-panel.css.php') }}";
            $styleTag = "<style>@import url({$cssUrl});</style>\n";
            
            if (strpos($content, '<div') !== false) {
                $content = preg_replace('/(<div[^>]*>)/', "{$styleTag}$1", $content, 1);
            } else {
                $content = $styleTag . $content;
            }
        }
        
        file_put_contents($path, $content);
        echo "  ✓ Updated component with CSS reference\n";
    }
}

if (!$found) {
    echo "  No component-based layouts found\n";
}

// Step 4: Update the login page directly
$loginPath = $basePath . '/resources/views/auth/login.blade.php';
if (file_exists($loginPath)) {
    echo "\nAdding CSS directly to login page...\n";
    $content = file_get_contents($loginPath);
    
    // Clean up any previous CSS work
    $content = preg_replace('/<style>[^<]*<\/style>/', '', $content);
    
    // Add new style import at the top of the login page
    if (strpos($content, '<x-guest-layout>') !== false) {
        $styleTag = "<style>@import url('{{ url(\"/laravel-test/control-panel.css.php\") }}');</style>\n";
        $content = str_replace('<x-guest-layout>', "<x-guest-layout>\n{$styleTag}", $content);
        file_put_contents($loginPath, $content);
        echo "  ✓ Added CSS import to login page\n";
    }
}

// Step 5: Update public index.php as a fallback
$indexPath = $basePath . '/public/index.php';
if (file_exists($indexPath)) {
    echo "\nUpdating public/index.php as fallback...\n";
    $content = file_get_contents($indexPath);
    
    // Remove any previous header hook
    $content = preg_replace('/\/\/ Quick CSS fix.*?ob_start\(\'fixHeader\'\);/s', '', $content);
    
    // Add new header hook
    $headerFix = <<<'EOT'

// Quick CSS fix for all pages
function fixHeader($buffer) {
    // Only modify HTML responses
    if (stripos($buffer, '<!DOCTYPE html>') !== false || stripos($buffer, '<html') !== false) {
        // Check if head tag exists
        if (stripos($buffer, '</head>') !== false) {
            // Add our CSS link to the head
            $cssLink = '<link rel="stylesheet" href="/laravel-test/control-panel.css.php">';
            $buffer = preg_replace('/<\/head>/', $cssLink . '</head>', $buffer, 1);
        } else if (stripos($buffer, '<body') !== false) {
            // No head tag, add before body
            $styleTag = '<style>@import url("/laravel-test/control-panel.css.php");</style>';
            $buffer = preg_replace('/<body/', $styleTag . '<body', $buffer, 1);
        }
    }
    return $buffer;
}

// Register the output buffer
ob_start('fixHeader');

EOT;
    $content = preg_replace('/^<\?php/', "<?php\n" . $headerFix, $content);
    file_put_contents($indexPath, $content);
    echo "  ✓ Added CSS link to output buffer in index.php\n";
}

// Create an additional fallback for the login page
echo "\nCreating direct login file...\n";
$directLoginPath = $basePath . '/login.php';
$directLogin = <<<EOT
<?php
// Set proper content type
header('Content-Type: text/html; charset=UTF-8');

// Get CSS directly
\$cssUrl = "/laravel-test/control-panel.css.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Laravel Test</title>
    <link rel="stylesheet" href="<?php echo \$cssUrl; ?>">
</head>
<body>
    <div class="login-container">
        <div class="auth-card">
            <h2 class="auth-title">Login</h2>
            
            <form method="POST" action="/laravel-test/login">
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
echo "  ✓ Created direct login page at login.php\n";

echo "</pre>";
echo "<p>CSS has been renamed to control-panel.css.php and all templates have been updated.</p>";
echo "<p>Try accessing the login page again. If it still doesn't work, you can use the direct login page at <a href='/laravel-test/login.php'>login.php</a>.</p>";
echo "<p>You can verify the CSS is working by visiting <a href='/laravel-test/control-panel.css.php'>control-panel.css.php</a> directly.</p>";
?> 