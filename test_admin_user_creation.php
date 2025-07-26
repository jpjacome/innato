<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

echo "=== Testing Admin User Creation Routes ===\n\n";

// First, let's check if the routes are registered correctly
echo "Checking if routes are registered correctly...\n";
$routes = Route::getRoutes();
$userCreateRoute = null;
$userStoreRoute = null;

foreach ($routes as $route) {
    if ($route->getName() === 'users.create') {
        $userCreateRoute = $route;
        echo "Found users.create route: " . $route->uri() . " [" . implode(', ', $route->methods()) . "]\n";
        echo "Middleware: " . implode(', ', $route->gatherMiddleware()) . "\n\n";
    }
    if ($route->getName() === 'users.store') {
        $userStoreRoute = $route;
        echo "Found users.store route: " . $route->uri() . " [" . implode(', ', $route->methods()) . "]\n";
        echo "Middleware: " . implode(', ', $route->gatherMiddleware()) . "\n\n";
    }
}

if (!$userCreateRoute || !$userStoreRoute) {
    echo "ERROR: One or more user creation routes not found!\n";
    exit(1);
}

// Now, let's try to access the route as an admin
echo "Attempting to access the user creation route as an admin...\n";

// Find an admin user
$admin = User::where('is_admin', true)->orWhere('role', 'admin')->first();

if (!$admin) {
    echo "No admin user found in the database. Creating one...\n";
    $admin = User::create([
        'name' => 'Test Admin',
        'email' => 'testadmin@example.com',
        'password' => bcrypt('password'),
        'role' => 'admin',
        'is_admin' => true
    ]);
    echo "Created admin user with ID: " . $admin->id . "\n";
} else {
    echo "Found admin user: " . $admin->name . " (ID: " . $admin->id . ")\n";
}

// Login as the admin
Auth::login($admin);
echo "Logged in as admin: " . Auth::user()->name . "\n";

// Create a request to the user creation route
$request = Request::create('/users/create', 'GET');
$request->setUserResolver(function () use ($admin) {
    return $admin;
});

try {
    // Dispatch the request to the route
    echo "Dispatching request to /users/create...\n";
    $response = app()->handle($request);

    // Check the response
    $statusCode = $response->getStatusCode();
    echo "Response status code: " . $statusCode . "\n";

    if ($statusCode === 200) {
        echo "SUCCESS: The user creation route is accessible!\n";

        // Check if the response contains the expected content
        $content = $response->getContent();
        if (strpos($content, 'Create User') !== false || strpos($content, 'user-form') !== false) {
            echo "Response contains expected content for user creation form.\n";
        } else {
            echo "WARNING: Response doesn't contain expected content for user creation form.\n";
        }
    } else {
        echo "ERROR: Unexpected status code " . $statusCode . "\n";
        echo "Response: " . $response->getContent() . "\n";
    }
} catch (\Exception $e) {
    echo "EXCEPTION: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}

echo "\n=== Test Complete ===\n";
