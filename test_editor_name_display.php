<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

echo "=== Testing Editor Name Display ===\n\n";

// Get all editors
$editors = User::where('role', 'editor')->get();
echo "Found " . $editors->count() . " editors\n\n";

foreach ($editors as $editor) {
    echo "Editor ID: " . $editor->id . "\n";
    echo "Name: " . $editor->name . "\n";
    echo "Email: " . $editor->email . "\n";
    echo "Destination ID: " . ($editor->destination_id ?? 'None') . "\n";

    // Check if there's a cached version of this user
    $cacheKey = 'user.' . $editor->id;
    $cachedUser = Cache::get($cacheKey);

    if ($cachedUser) {
        echo "\nFound cached user data:\n";
        echo "Cached Name: " . $cachedUser->name . "\n";
        echo "Cached Email: " . $cachedUser->email . "\n";

        // Check if cache is stale
        if ($cachedUser->name !== $editor->name) {
            echo "WARNING: Cache is stale! Database name and cached name don't match.\n";
        }
    } else {
        echo "\nNo cached user data found.\n";
    }

    // Check session data if available
    try {
        $sessionKey = 'user_' . $editor->id;
        $sessionUser = Session::get($sessionKey);

        if ($sessionUser) {
            echo "\nFound session user data:\n";
            echo "Session Name: " . $sessionUser->name . "\n";
            echo "Session Email: " . $sessionUser->email . "\n";

            // Check if session is stale
            if ($sessionUser->name !== $editor->name) {
                echo "WARNING: Session is stale! Database name and session name don't match.\n";
            }
        } else {
            echo "\nNo session user data found.\n";
        }
    } catch (\Exception $e) {
        echo "\nCouldn't check session data: " . $e->getMessage() . "\n";
    }

    echo "\n";
}

// Check for any view caching
echo "Checking for view caching...\n";
$viewCachePath = storage_path('framework/views');
$viewCacheFiles = glob($viewCachePath . '/*.php');

echo "Found " . count($viewCacheFiles) . " cached view files.\n";

// Check if there's a route cache
echo "\nChecking for route caching...\n";
$routeCachePath = base_path('bootstrap/cache/routes-v7.php');
if (file_exists($routeCachePath)) {
    echo "Route cache exists at: " . $routeCachePath . "\n";
} else {
    echo "No route cache found.\n";
}

// Check for config caching
echo "\nChecking for config caching...\n";
$configCachePath = base_path('bootstrap/cache/config.php');
if (file_exists($configCachePath)) {
    echo "Config cache exists at: " . $configCachePath . "\n";
} else {
    echo "No config cache found.\n";
}

// Create a test function to simulate a form submission
echo "\nSimulating a form submission to update editor name...\n";

function simulateFormSubmission($editorId, $newName) {
    // Get the editor
    $editor = User::find($editorId);
    if (!$editor) {
        echo "Editor not found with ID: " . $editorId . "\n";
        return false;
    }

    $originalName = $editor->name;
    echo "Original name: " . $originalName . "\n";

    // Create a request array similar to what would be submitted by the form
    $requestData = [
        'name' => $newName,
        'email' => $editor->email,
        'role' => 'editor',
        'password' => null,
        'password_confirmation' => null
    ];

    // Log the request data
    Log::info('Simulated form submission', [
        'editor_id' => $editorId,
        'request_data' => $requestData
    ]);

    // Update the editor using the update method
    try {
        $editor->update([
            'name' => $newName,
            'email' => $editor->email,
            'role' => 'editor'
        ]);

        // Refresh from database
        $editor->refresh();

        echo "Updated name in database: " . $editor->name . "\n";
        echo "Update successful: " . ($editor->name === $newName ? 'Yes' : 'No') . "\n";

        // Reset to original name
        $editor->update(['name' => $originalName]);
        $editor->refresh();
        echo "Reset name to original: " . $editor->name . "\n";

        return true;
    } catch (\Exception $e) {
        echo "Error updating editor: " . $e->getMessage() . "\n";
        return false;
    }
}

// Simulate a form submission for the first editor
if ($editors->count() > 0) {
    $firstEditor = $editors->first();
    $newName = "TestEditor" . time();

    echo "\nSimulating form submission for editor ID: " . $firstEditor->id . "\n";
    simulateFormSubmission($firstEditor->id, $newName);
} else {
    echo "No editors found to simulate form submission.\n";
}

echo "\n=== Test Complete ===\n";
