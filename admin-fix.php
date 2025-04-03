<?php
echo "<h1>Admin User Debug Tool</h1>";
echo "<pre>";

// Define application path
$basePath = __DIR__;

// Connect to database
$envPath = $basePath.'/.env';
$dbHost = 'localhost';
$dbPort = '3306';
$dbName = 'orustrav_laraveltest';
$dbUser = 'orustrav_jpj';
$dbPass = 'Psycho2psychote';

if (file_exists($envPath)) {
    $envContent = file_get_contents($envPath);
    
    // Parse database settings from .env
    preg_match('/DB_HOST=(.*)/', $envContent, $hostMatches);
    preg_match('/DB_PORT=(.*)/', $envContent, $portMatches);
    preg_match('/DB_DATABASE=(.*)/', $envContent, $dbMatches);
    preg_match('/DB_USERNAME=(.*)/', $envContent, $userMatches);
    preg_match('/DB_PASSWORD=(.*)/', $envContent, $passMatches);
    
    if (isset($hostMatches[1])) $dbHost = trim($hostMatches[1]);
    if (isset($portMatches[1])) $dbPort = trim($portMatches[1]);
    if (isset($dbMatches[1])) $dbName = trim($dbMatches[1]);
    if (isset($userMatches[1])) $dbUser = trim($userMatches[1]);
    if (isset($passMatches[1])) $dbPass = trim($passMatches[1]);
}

try {
    $dsn = "mysql:host=$dbHost;port=$dbPort;dbname=$dbName";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];
    
    $pdo = new PDO($dsn, $dbUser, $dbPass, $options);
    echo "✓ Connected to database\n\n";
    
    // Inspect admin user
    $stmt = $pdo->query("SELECT * FROM users WHERE email = 'admin@example.com'");
    if ($row = $stmt->fetch()) {
        echo "Admin user found:\n";
        echo "ID: {$row['id']}\n";
        echo "Name: {$row['name']}\n";
        echo "Email: {$row['email']}\n";
        echo "Role: " . (isset($row['role']) ? $row['role'] : 'NULL') . "\n";
        echo "is_admin: " . (isset($row['is_admin']) ? $row['is_admin'] : 'NULL') . "\n\n";
        
        // Fix potential issues with admin role
        $fixes = [];
        
        // Ensure is_admin is set to 1
        if (!isset($row['is_admin']) || $row['is_admin'] != 1) {
            $pdo->exec("UPDATE users SET is_admin = 1 WHERE email = 'admin@example.com'");
            $fixes[] = "Set is_admin flag to 1";
        }
        
        // Ensure role is 'admin'
        if (!isset($row['role']) || $row['role'] != 'admin') {
            $pdo->exec("UPDATE users SET role = 'admin' WHERE email = 'admin@example.com'");
            $fixes[] = "Set role to 'admin'";
        }
        
        if (!empty($fixes)) {
            echo "Applied fixes:\n";
            foreach ($fixes as $fix) {
                echo "- $fix\n";
            }
            echo "\n";
        } else {
            echo "No fixes needed for admin user\n\n";
        }
        
        // Check for middleware
        echo "Checking middleware implementation:\n";
        $adminMiddlewarePath = $basePath . '/app/Http/Middleware/AdminMiddleware.php';
        if (file_exists($adminMiddlewarePath)) {
            echo "✓ AdminMiddleware file exists\n";
            
            // Read and analyze the middleware
            $middlewareContent = file_get_contents($adminMiddlewarePath);
            
            if (strpos($middlewareContent, 'isAdmin()') !== false) {
                echo "✓ Middleware is checking isAdmin() method\n";
            } elseif (strpos($middlewareContent, 'is_admin') !== false) {
                echo "✓ Middleware is checking is_admin property\n";
            } else {
                echo "❌ Could not find admin check in middleware\n";
                
                // Fix the middleware
                echo "Creating proper admin middleware...\n";
                file_put_contents($adminMiddlewarePath, '<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user() || !$request->user()->is_admin) {
            abort(403, "Access denied");
        }

        return $next($request);
    }
}');
                echo "✓ Fixed AdminMiddleware implementation\n";
            }
        } else {
            echo "❌ AdminMiddleware file not found\n";
            
            // Create the middleware
            $middlewareDir = $basePath . '/app/Http/Middleware';
            if (!is_dir($middlewareDir)) {
                mkdir($middlewareDir, 0755, true);
            }
            
            file_put_contents($adminMiddlewarePath, '<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user() || !$request->user()->is_admin) {
            abort(403, "Access denied");
        }

        return $next($request);
    }
}');
            echo "✓ Created AdminMiddleware file\n";
        }
        
        // Check User model
        $userModelPath = $basePath . '/app/Models/User.php';
        if (file_exists($userModelPath)) {
            echo "\nChecking User model:\n";
            $userContent = file_get_contents($userModelPath);
            
            if (strpos($userContent, 'function isAdmin') !== false) {
                echo "✓ isAdmin() method exists in User model\n";
            } else {
                echo "Adding isAdmin() method to User model...\n";
                
                // Find the right spot to insert the method
                $modifiedContent = preg_replace(
                    '/(class\s+User\s+extends\s+Authenticatable\s*{.*?)(})$/s',
                    '$1    /**
     * Check if the user is an admin.
     */
    public function isAdmin()
    {
        return $this->is_admin;
    }
}',
                    $userContent
                );
                
                if ($modifiedContent !== $userContent) {
                    file_put_contents($userModelPath, $modifiedContent);
                    echo "✓ Added isAdmin() method to User model\n";
                } else {
                    echo "❌ Could not modify User model\n";
                }
            }
        } else {
            echo "❌ User model file not found\n";
        }
    } else {
        echo "❌ Admin user not found!\n";
        
        // Create admin user
        echo "Creating admin user...\n";
        $hashedPassword = password_hash('password', PASSWORD_BCRYPT, ['cost' => 12]);
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role, is_admin, created_at, updated_at) VALUES (?, ?, ?, ?, ?, NOW(), NOW())");
        $stmt->execute(['Admin', 'admin@example.com', $hashedPassword, 'admin', 1]);
        echo "✓ Admin user created\n";
    }
    
} catch (PDOException $e) {
    echo "❌ Database error: " . $e->getMessage() . "\n";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

echo "</pre>";
echo "<p>Return to <a href='/laravel-test'>homepage</a> and try logging in as admin again.</p>"; 