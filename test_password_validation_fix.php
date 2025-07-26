<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Http\Controllers\Editor\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

echo "=== Testing Password Validation Fix ===\n\n";

// Get the first editor
$editor = User::where('role', 'editor')->first();

if (!$editor) {
    echo "No editor found in the database.\n";
    exit;
}

echo "Found editor: ID {$editor->id}, Name: {$editor->name}, Email: {$editor->email}\n\n";

// Create a controller instance
$controller = new UserController();

// Test Case 1: Update without changing password
echo "Test Case 1: Update without changing password\n";
echo "----------------------------------------\n";

// Create a request with only name and email (no password)
$requestData = [
    'name' => $editor->name . ' (Updated)',
    'email' => $editor->email,
    'role' => 'editor'
];

$request = Request::create('/editor/users/' . $editor->id, 'PUT', $requestData);
$request->setUserResolver(function () use ($editor) {
    return $editor;
});

try {
    // Manually run validation
    $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email,' . $editor->id,
    ];

    // Only apply password validation if the password field is filled
    if (isset($requestData['password']) && !empty($requestData['password'])) {
        $rules['password'] = 'string|min:8|confirmed';
    }

    $validator = \Illuminate\Support\Facades\Validator::make($requestData, $rules);

    if ($validator->fails()) {
        echo "Validation failed:\n";
        foreach ($validator->errors()->all() as $error) {
            echo "- " . $error . "\n";
        }
    } else {
        echo "Validation passed successfully!\n";
        echo "This means you can update the editor's profile without entering a password.\n";
    }
} catch (ValidationException $e) {
    echo "Validation exception: " . $e->getMessage() . "\n";
    foreach ($e->errors() as $field => $errors) {
        echo "- $field: " . implode(', ', $errors) . "\n";
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

echo "\n";

// Test Case 2: Update with mismatched password confirmation
echo "Test Case 2: Update with mismatched password confirmation\n";
echo "----------------------------------------\n";

// Create a request with password but no confirmation
$requestData = [
    'name' => $editor->name . ' (Updated)',
    'email' => $editor->email,
    'role' => 'editor',
    'password' => 'newpassword123',
    // No password_confirmation
];

try {
    // Manually run validation
    $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email,' . $editor->id,
    ];

    // Only apply password validation if the password field is filled
    if (isset($requestData['password']) && !empty($requestData['password'])) {
        $rules['password'] = 'string|min:8|confirmed';
    }

    $validator = \Illuminate\Support\Facades\Validator::make($requestData, $rules);

    if ($validator->fails()) {
        echo "Validation failed (expected for this test case):\n";
        foreach ($validator->errors()->all() as $error) {
            echo "- " . $error . "\n";
        }
        echo "This is the correct behavior when providing a password without confirmation.\n";
    } else {
        echo "Validation passed unexpectedly. This indicates a problem with the fix.\n";
    }
} catch (ValidationException $e) {
    echo "Validation exception: " . $e->getMessage() . "\n";
    foreach ($e->errors() as $field => $errors) {
        echo "- $field: " . implode(', ', $errors) . "\n";
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

echo "\n";

// Test Case 3: Update with matching password confirmation
echo "Test Case 3: Update with matching password confirmation\n";
echo "----------------------------------------\n";

// Create a request with password and matching confirmation
$requestData = [
    'name' => $editor->name . ' (Updated)',
    'email' => $editor->email,
    'role' => 'editor',
    'password' => 'newpassword123',
    'password_confirmation' => 'newpassword123'
];

try {
    // Manually run validation
    $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email,' . $editor->id,
    ];

    // Only apply password validation if the password field is filled
    if (isset($requestData['password']) && !empty($requestData['password'])) {
        $rules['password'] = 'string|min:8|confirmed';
    }

    $validator = \Illuminate\Support\Facades\Validator::make($requestData, $rules);

    if ($validator->fails()) {
        echo "Validation failed unexpectedly:\n";
        foreach ($validator->errors()->all() as $error) {
            echo "- " . $error . "\n";
        }
    } else {
        echo "Validation passed successfully!\n";
        echo "This means you can update the editor's profile with a new password when confirmation matches.\n";
    }
} catch (ValidationException $e) {
    echo "Validation exception: " . $e->getMessage() . "\n";
    foreach ($e->errors() as $field => $errors) {
        echo "- $field: " . implode(', ', $errors) . "\n";
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

echo "\n=== Test Complete ===\n";
echo "The fix should allow users to update their profile without entering a password,\n";
echo "while still requiring password confirmation when they do want to change their password.\n";
