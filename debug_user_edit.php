<?php
// Debug script to simulate the exact request to "/users/2/edit"

// Bootstrap Laravel
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Create a request to "/users/2/edit"
$request = Illuminate\Http\Request::create('/users/2/edit', 'GET');

// Set the authenticated user (assuming user ID 2 is logged in)
$user = \App\Models\User::find(2);
if (!$user) {
    echo "User with ID 2 not found.\n";
    exit;
}

echo "=== Debug Information ===\n";
echo "Authenticated User:\n";
echo "ID: " . $user->id . " (type: " . gettype($user->id) . ")\n";
echo "Role: " . $user->role . "\n";
echo "Is Editor: " . ($user->isEditor() ? 'Yes' : 'No') . "\n";
echo "Is Admin: " . ($user->isAdmin() ? 'Yes' : 'No') . "\n";
echo "\n";

// Get the user to edit (also user ID 2)
$userToEdit = \App\Models\User::find(2);
echo "User to Edit:\n";
echo "ID: " . $userToEdit->id . " (type: " . gettype($userToEdit->id) . ")\n";
echo "Role: " . $userToEdit->role . "\n";
echo "\n";

echo "=== Comparison Tests ===\n";
echo "Direct comparison (==): " . ($user->id == $userToEdit->id ? 'Equal' : 'Not Equal') . "\n";
echo "Strict comparison (===): " . ($user->id === $userToEdit->id ? 'Equal' : 'Not Equal') . "\n";
echo "Int cast comparison ((int)id === (int)id): " . ((int)$user->id === (int)$userToEdit->id ? 'Equal' : 'Not Equal') . "\n";
echo "String cast comparison ((string)id === (string)id): " . ((string)$user->id === (string)$userToEdit->id ? 'Equal' : 'Not Equal') . "\n";

// Simulate the controller's edit method logic
$canEdit = false;
if ($user->isAdmin()) {
    $canEdit = true;
    echo "User can edit because they are an admin.\n";
} elseif ($user->isEditor() && (int)$user->id === (int)$userToEdit->id) {
    $canEdit = true;
    echo "User can edit because they are an editor editing their own profile.\n";
} else {
    echo "User cannot edit this profile.\n";

    // Additional debug info
    if ($user->isEditor()) {
        echo "User is an editor but ID comparison failed.\n";
        echo "User ID: " . $user->id . " (as int: " . (int)$user->id . ")\n";
        echo "Edit ID: " . $userToEdit->id . " (as int: " . (int)$userToEdit->id . ")\n";
    }
}

echo "\nAuthorization result: " . ($canEdit ? 'Authorized' : 'Unauthorized') . "\n";

// Now let's try to directly access the controller method
echo "\n=== Simulating Controller Method ===\n";
$controller = new \App\Http\Controllers\UserManagementController();

// We need to set the authenticated user in the auth guard
\Illuminate\Support\Facades\Auth::login($user);

try {
    // Call the edit method directly
    $response = $controller->edit($userToEdit);
    echo "Controller method executed successfully.\n";
    echo "Response type: " . get_class($response) . "\n";
} catch (\Exception $e) {
    echo "Exception thrown: " . $e->getMessage() . "\n";
    echo "Exception type: " . get_class($e) . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}

echo "\nDebug complete.\n";
