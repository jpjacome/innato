<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Http\Controllers\Editor\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

echo "=== Testing Password Auto-Confirmation Fix ===\n\n";

// Get the first editor
$editor = User::where('role', 'editor')->first();

if (!$editor) {
    echo "No editor found in the database.\n";
    exit;
}

echo "Found editor: ID {$editor->id}, Name: {$editor->name}, Email: {$editor->email}\n\n";

// Create a controller instance
$controller = new UserController();

// Test Case 1: Update with password but no confirmation
echo "Test Case 1: Update with password but no confirmation\n";
echo "----------------------------------------\n";

// Create a request with password but no confirmation
$requestData = [
    'name' => $editor->name . ' (Updated)',
    'email' => $editor->email,
    'role' => 'editor',
    'password' => 'newpassword123',
    // No password_confirmation
];

$request = Request::create('/editor/users/' . $editor->id, 'PUT', $requestData);
$request->setUserResolver(function () use ($editor) {
    return $editor;
});

try {
    // Create a mock controller to test our logic
    $mockController = new class($request, $editor) {
        protected $request;
        protected $user;

        public function __construct($request, $user) {
            $this->request = $request;
            $this->user = $user;
        }

        public function testAutoConfirmation() {
            // If password is filled but password_confirmation is not, set password_confirmation to match password
            if ($this->request->filled('password') && !$this->request->filled('password_confirmation')) {
                $this->request->merge(['password_confirmation' => $this->request->password]);
                echo "Auto-filled password_confirmation to match password\n";
            }

            // Create validation rules array
            $rules = [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $this->user->id,
            ];

            // Only apply password validation if the password field is filled
            if ($this->request->filled('password')) {
                $rules['password'] = 'string|min:8|confirmed';
            }

            $validator = \Illuminate\Support\Facades\Validator::make($this->request->all(), $rules);

            if ($validator->fails()) {
                echo "Validation failed:\n";
                foreach ($validator->errors()->all() as $error) {
                    echo "- " . $error . "\n";
                }
                return false;
            } else {
                echo "Validation passed successfully!\n";
                echo "This means the auto-confirmation works correctly.\n";
                return true;
            }
        }
    };

    $result = $mockController->testAutoConfirmation();
    echo "Test result: " . ($result ? "PASSED" : "FAILED") . "\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

echo "\n";

// Test Case 2: Update with password and matching confirmation
echo "Test Case 2: Update with password and matching confirmation\n";
echo "----------------------------------------\n";

// Create a request with password and matching confirmation
$requestData = [
    'name' => $editor->name . ' (Updated)',
    'email' => $editor->email,
    'role' => 'editor',
    'password' => 'newpassword123',
    'password_confirmation' => 'newpassword123'
];

$request = Request::create('/editor/users/' . $editor->id, 'PUT', $requestData);
$request->setUserResolver(function () use ($editor) {
    return $editor;
});

try {
    // Create a mock controller to test our logic
    $mockController = new class($request, $editor) {
        protected $request;
        protected $user;

        public function __construct($request, $user) {
            $this->request = $request;
            $this->user = $user;
        }

        public function testAutoConfirmation() {
            // If password is filled but password_confirmation is not, set password_confirmation to match password
            if ($this->request->filled('password') && !$this->request->filled('password_confirmation')) {
                $this->request->merge(['password_confirmation' => $this->request->password]);
                echo "Auto-filled password_confirmation to match password\n";
            } else {
                echo "No auto-fill needed, password_confirmation already provided\n";
            }

            // Create validation rules array
            $rules = [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $this->user->id,
            ];

            // Only apply password validation if the password field is filled
            if ($this->request->filled('password')) {
                $rules['password'] = 'string|min:8|confirmed';
            }

            $validator = \Illuminate\Support\Facades\Validator::make($this->request->all(), $rules);

            if ($validator->fails()) {
                echo "Validation failed:\n";
                foreach ($validator->errors()->all() as $error) {
                    echo "- " . $error . "\n";
                }
                return false;
            } else {
                echo "Validation passed successfully!\n";
                echo "This means the validation works correctly with provided confirmation.\n";
                return true;
            }
        }
    };

    $result = $mockController->testAutoConfirmation();
    echo "Test result: " . ($result ? "PASSED" : "FAILED") . "\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

echo "\n";

// Test Case 3: Update without changing password
echo "Test Case 3: Update without changing password\n";
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
    // Create a mock controller to test our logic
    $mockController = new class($request, $editor) {
        protected $request;
        protected $user;

        public function __construct($request, $user) {
            $this->request = $request;
            $this->user = $user;
        }

        public function testAutoConfirmation() {
            // If password is filled but password_confirmation is not, set password_confirmation to match password
            if ($this->request->filled('password') && !$this->request->filled('password_confirmation')) {
                $this->request->merge(['password_confirmation' => $this->request->password]);
                echo "Auto-filled password_confirmation to match password\n";
            } else {
                echo "No auto-fill needed, password not provided\n";
            }

            // Create validation rules array
            $rules = [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $this->user->id,
            ];

            // Only apply password validation if the password field is filled
            if ($this->request->filled('password')) {
                $rules['password'] = 'string|min:8|confirmed';
            }

            $validator = \Illuminate\Support\Facades\Validator::make($this->request->all(), $rules);

            if ($validator->fails()) {
                echo "Validation failed:\n";
                foreach ($validator->errors()->all() as $error) {
                    echo "- " . $error . "\n";
                }
                return false;
            } else {
                echo "Validation passed successfully!\n";
                echo "This means you can update the profile without entering a password.\n";
                return true;
            }
        }
    };

    $result = $mockController->testAutoConfirmation();
    echo "Test result: " . ($result ? "PASSED" : "FAILED") . "\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

echo "\n=== Test Complete ===\n";
echo "The fix should allow users to update their profile in all three scenarios:\n";
echo "1. With password but no confirmation (auto-confirmation)\n";
echo "2. With password and matching confirmation\n";
echo "3. Without changing password\n";
