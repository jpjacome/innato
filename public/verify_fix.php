<?php
// This script verifies that the fix for the user edit authorization issue works
// It should be run in the browser at http://127.0.0.1:8000/verify_fix.php

// Output instructions
echo "<h1>User Edit Authorization Fix Verification</h1>";
echo "<p>This script will help verify if the fix for the user edit authorization issue works.</p>";
echo "<p>Please follow these steps:</p>";
echo "<ol>";
echo "<li>Login as an editor (e.g., editor1@example.com)</li>";
echo "<li>After logging in, <a href='/users/2/edit' target='_blank'>click here to access /users/2/edit</a></li>";
echo "<li>If the fix worked, you should see the editor's user edit page instead of a 403 error</li>";
echo "</ol>";

// Add a button to go back to the dashboard
echo "<p><a href='/dashboard' style='display: inline-block; padding: 10px 20px; background-color: #4F46E5; color: white; text-decoration: none; border-radius: 5px;'>Go to Dashboard</a></p>";

// Add some debug information
echo "<h2>Debug Information</h2>";

// Check if the user is logged in
if (auth()->check()) {
    $user = auth()->user();
    echo "<p>You are currently logged in as:</p>";
    echo "<ul>";
    echo "<li>Name: " . htmlspecialchars($user->name) . "</li>";
    echo "<li>Email: " . htmlspecialchars($user->email) . "</li>";
    echo "<li>ID: " . htmlspecialchars($user->id) . "</li>";
    echo "<li>Role: " . htmlspecialchars($user->role) . "</li>";
    echo "<li>Is Admin: " . ($user->isAdmin() ? "Yes" : "No") . "</li>";
    echo "<li>Is Editor: " . ($user->isEditor() ? "Yes" : "No") . "</li>";
    echo "</ul>";

    // If the user is an editor with ID 2, provide a direct link
    if ($user->isEditor() && $user->id == 2) {
        echo "<p style='color: green; font-weight: bold;'>You are logged in as an editor with ID 2. You should be able to access your edit page.</p>";
        echo "<p><a href='/users/2/edit' style='display: inline-block; padding: 10px 20px; background-color: #10B981; color: white; text-decoration: none; border-radius: 5px;'>Go to Your Edit Page</a></p>";
    } elseif ($user->isEditor()) {
        echo "<p style='color: orange; font-weight: bold;'>You are logged in as an editor, but your ID is not 2. You should NOT be able to access the edit page for user ID 2.</p>";
    } elseif ($user->isAdmin()) {
        echo "<p style='color: blue; font-weight: bold;'>You are logged in as an admin. You should be able to access any user's edit page.</p>";
        echo "<p><a href='/users/2/edit' style='display: inline-block; padding: 10px 20px; background-color: #3B82F6; color: white; text-decoration: none; border-radius: 5px;'>Go to User 2's Edit Page</a></p>";
    }
} else {
    echo "<p style='color: red; font-weight: bold;'>You are not logged in. Please log in first.</p>";
    echo "<p><a href='/login' style='display: inline-block; padding: 10px 20px; background-color: #EF4444; color: white; text-decoration: none; border-radius: 5px;'>Go to Login Page</a></p>";
}
