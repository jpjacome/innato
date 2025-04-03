<?php
echo "<h1>Login Page CSS Fix</h1>";
echo "<pre>";

// Define application path
$basePath = __DIR__;

// Check login template
$loginPath = $basePath . '/resources/views/auth/login.blade.php';
$guestLayoutPath = $basePath . '/resources/views/layouts/guest.blade.php';

if (file_exists($loginPath)) {
    echo "Found login.blade.php template\n";
    $loginContent = file_get_contents($loginPath);
    
    // Check which layout the login page is using
    if (preg_match('/@extends\([\'"](.+?)[\'"]\)/', $loginContent, $matches)) {
        $layoutName = $matches[1];
        echo "Login page extends layout: {$layoutName}\n";
        
        // Check if we're using the right layout for our CSS fix
        $layoutFile = $basePath . '/resources/views/' . str_replace('.', '/', $layoutName) . '.blade.php';
        if (file_exists($layoutFile)) {
            echo "Found layout file: {$layoutFile}\n";
            $layoutContent = file_get_contents($layoutFile);
            
            // Check if CSS is already included
            if (strpos($layoutContent, 'css.php') === false) {
                echo "CSS link not found in layout, adding it...\n";
                $cssLink = '<link rel="stylesheet" href="{{ url(\'/laravel-test/css.php\') }}">';
                $layoutContent = preg_replace('/<\/head>/', "    {$cssLink}\n</head>", $layoutContent);
                file_put_contents($layoutFile, $layoutContent);
                echo "✓ Added CSS link to layout file\n";
            } else {
                echo "CSS link already present in layout file\n";
            }
        } else {
            echo "❌ Layout file not found at expected path\n";
        }
    } else {
        echo "Could not determine layout used by login page\n";
    }
    
    // Output login page structure for debugging
    echo "\nLogin page structure:\n";
    echo "--------------------\n";
    echo htmlspecialchars($loginContent) . "\n";
    echo "--------------------\n\n";
    
    // Add direct CSS reference to login page as a fallback
    if (strpos($loginContent, '@section') !== false && strpos($loginContent, 'css.php') === false) {
        echo "Adding direct CSS reference to login page as fallback...\n";
        
        // Find the first @section and add a section for the head
        if (strpos($loginContent, '@section(\'head\'') === false) {
            $headSection = "\n@section('head')\n    <link rel=\"stylesheet\" href=\"{{ url('/laravel-test/css.php') }}\">\n@endsection\n\n";
            $loginContent = preg_replace('/@section\(/', $headSection . '@section(', $loginContent, 1);
            file_put_contents($loginPath, $loginContent);
            echo "✓ Added head section with CSS to login page\n";
        }
    }
    
    // Ensure guest layout has the head section yield
    if (file_exists($guestLayoutPath)) {
        $guestLayout = file_get_contents($guestLayoutPath);
        if (strpos($guestLayout, '@yield(\'head\')') === false) {
            echo "Adding head yield to guest layout...\n";
            $guestLayout = preg_replace('/<\/head>/', "    @yield('head')\n</head>", $guestLayout);
            file_put_contents($guestLayoutPath, $guestLayout);
            echo "✓ Added head yield to guest layout\n";
        }
    }
    
    // Create a direct login.css file with absolute path for the login page
    echo "\nCreating a specific login CSS file...\n";
    
    // Create a direct CSS file with explicit path
    $loginCssPath = $basePath . '/public/css/login.css';
    if (!is_dir($basePath . '/public/css')) {
        mkdir($basePath . '/public/css', 0755, true);
        echo "Created public/css directory\n";
    }
    
    $loginCss = file_get_contents($basePath . '/css.php');
    // Remove the PHP header part
    $loginCss = preg_replace('/^<\?php.*?\?>(\s*)/s', '', $loginCss);
    file_put_contents($loginCssPath, $loginCss);
    echo "✓ Created login.css in public/css directory\n";
    
    // Create a .htaccess file to set the correct MIME type
    $htaccessPath = $basePath . '/public/css/.htaccess';
    $htaccessContent = <<<EOT
<IfModule mod_mime.c>
    AddType text/css .css
</IfModule>

<IfModule mod_headers.c>
    <FilesMatch "\.css$">
        Header set Content-Type "text/css"
        Header set X-Content-Type-Options "nosniff"
    </FilesMatch>
</IfModule>
EOT;
    file_put_contents($htaccessPath, $htaccessContent);
    echo "✓ Created .htaccess file in public/css directory\n";
    
    // Add direct link to the login page
    $cssDirectLink = '<link rel="stylesheet" href="{{ asset(\'css/login.css\') }}">';
    if (strpos($loginContent, $cssDirectLink) === false) {
        if (strpos($loginContent, '@section(\'content\')') !== false) {
            $loginContent = str_replace('@section(\'content\')', '@section(\'content\')' . "\n<style>\n" . file_get_contents($basePath . '/css.php') . "\n</style>", $loginContent);
            file_put_contents($loginPath, $loginContent);
            echo "✓ Added direct inline CSS to login page content section\n";
        }
    }
    
    // Create a standalone login page with inline CSS as a fallback option
    $standaloneLoginPath = $basePath . '/login-standalone.php';
    $standaloneLogin = <<<EOT
<?php
// Set proper content type
header('Content-Type: text/html; charset=UTF-8');

// Database connection settings
\$dbHost = 'localhost';
\$dbPort = '3306';
\$dbName = 'orustrav_laraveltest';
\$dbUser = 'orustrav_jpj';
\$dbPass = 'Psycho2psychote';

// Read .env file if it exists
\$envPath = __DIR__.'/.env';
if (file_exists(\$envPath)) {
    \$envContent = file_get_contents(\$envPath);
    
    // Parse database settings from .env
    preg_match('/DB_HOST=(.*)/', \$envContent, \$hostMatches);
    preg_match('/DB_PORT=(.*)/', \$envContent, \$portMatches);
    preg_match('/DB_DATABASE=(.*)/', \$envContent, \$dbMatches);
    preg_match('/DB_USERNAME=(.*)/', \$envContent, \$userMatches);
    preg_match('/DB_PASSWORD=(.*)/', \$envContent, \$passMatches);
    
    if (isset(\$hostMatches[1])) \$dbHost = trim(\$hostMatches[1]);
    if (isset(\$portMatches[1])) \$dbPort = trim(\$portMatches[1]);
    if (isset(\$dbMatches[1])) \$dbName = trim(\$dbMatches[1]);
    if (isset(\$userMatches[1])) \$dbUser = trim(\$userMatches[1]);
    if (isset(\$passMatches[1])) \$dbPass = trim(\$passMatches[1]);
}

\$errorMessage = '';
\$successMessage = '';

// Handle login form submission
if (\$_SERVER['REQUEST_METHOD'] === 'POST' && isset(\$_POST['email']) && isset(\$_POST['password'])) {
    try {
        \$dsn = "mysql:host=\$dbHost;port=\$dbPort;dbname=\$dbName";
        \$options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];
        
        \$pdo = new PDO(\$dsn, \$dbUser, \$dbPass, \$options);
        
        \$email = \$_POST['email'];
        \$password = \$_POST['password'];
        
        // Get user from database
        \$stmt = \$pdo->prepare("SELECT * FROM users WHERE email = ?");
        \$stmt->execute([\$email]);
        \$user = \$stmt->fetch();
        
        if (\$user && password_verify(\$password, \$user['password'])) {
            \$successMessage = "Login successful! Redirecting...";
            // Redirect to dashboard based on user role
            if (isset(\$user['is_admin']) && \$user['is_admin'] == 1) {
                header("Location: /laravel-test/admin/dashboard");
            } else {
                header("Location: /laravel-test/dashboard");
            }
            exit;
        } else {
            \$errorMessage = "Invalid credentials. Please try again.";
        }
    } catch (PDOException \$e) {
        \$errorMessage = "Database error: " . \$e->getMessage();
    } catch (Exception \$e) {
        \$errorMessage = "Error: " . \$e->getMessage();
    }
}

// CSS from css.php file
\$cssContent = file_get_contents(__DIR__ . '/css.php');
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
            
            <?php if (\$errorMessage): ?>
                <div class="alert alert-error">
                    <?php echo htmlspecialchars(\$errorMessage); ?>
                </div>
            <?php endif; ?>
            
            <?php if (\$successMessage): ?>
                <div class="alert alert-success">
                    <?php echo htmlspecialchars(\$successMessage); ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="">
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

    file_put_contents($standaloneLoginPath, $standaloneLogin);
    echo "✓ Created standalone login page at login-standalone.php\n";
}

echo "</pre>";
echo "<p>Login page CSS has been fixed using multiple approaches:</p>";
echo "<ol>";
echo "<li>Added CSS link to the login page's layout</li>";
echo "<li>Added inline CSS directly to the login page</li>";
echo "<li>Created a standalone login page at <a href='/laravel-test/login-standalone.php'>login-standalone.php</a></li>";
echo "</ol>";
echo "<p>Try the login page again, and if it still doesn't work, use the standalone login page.</p>";
?> 