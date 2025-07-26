<?php

// This script demonstrates the logic for editor user edit permissions
// It simulates the controller logic without actually making HTTP requests

// Create mock User objects
class MockUser {
    public $id;
    public $role;
    public $is_admin;

    public function __construct($id, $role, $is_admin = false) {
        $this->id = $id;
        $this->role = $role;
        $this->is_admin = $is_admin;
    }

    public function isAdmin() {
        return $this->is_admin || $this->role === 'admin';
    }

    public function isEditor() {
        return $this->role === 'editor';
    }
}

// Create a function that simulates the controller's edit method logic
function canAccessEditPage($authUser, $requestedUser) {
    // Admins can edit any user
    if ($authUser->isAdmin()) {
        return true;
    }

    // Editors can only edit themselves
    if ($authUser->isEditor() && (int)$authUser->id === (int)$requestedUser->id) {
        return true;
    }

    // Otherwise, access is denied
    return false;
}

// Test cases
echo "Running tests for editor user edit permissions:\n";
echo "---------------------------------------------\n";

// Test 1: Editor accessing their own edit page
$editor = new MockUser(2, 'editor');
$result = canAccessEditPage($editor, $editor);
echo "Test 1: Editor accessing their own edit page: " .
     ($result ? "ALLOWED ✓" : "DENIED ✗") . "\n";

// Test 2: Editor accessing another user's edit page
$editor = new MockUser(2, 'editor');
$otherUser = new MockUser(3, 'editor');
$result = canAccessEditPage($editor, $otherUser);
echo "Test 2: Editor accessing another user's edit page: " .
     ($result ? "ALLOWED ✗" : "DENIED ✓") . "\n";

// Test 3: Admin accessing any user's edit page
$admin = new MockUser(1, 'admin', true);
$editor = new MockUser(2, 'editor');
$result = canAccessEditPage($admin, $editor);
echo "Test 3: Admin accessing any user's edit page: " .
     ($result ? "ALLOWED ✓" : "DENIED ✗") . "\n";

// Test 4: String vs integer ID comparison (simulating route parameter)
$editor = new MockUser('2', 'editor'); // String ID
$sameEditorDifferentType = new MockUser(2, 'editor'); // Integer ID
$result = canAccessEditPage($editor, $sameEditorDifferentType);
echo "Test 4: String vs integer ID comparison: " .
     ($result ? "ALLOWED ✓" : "DENIED ✗") . "\n";

echo "\nAll tests completed.\n";
