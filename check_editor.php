<?php

use App\Models\User;
use App\Models\Destination;

// Check editor assignment
$editor = User::where('email', 'editor@innato.com')->first();
$destination = Destination::where('slug', 'libertador-bolivar')->first();

echo "=== EDITOR ASSIGNMENT CHECK ===\n";

if ($editor) {
    echo "Editor found: " . $editor->name . " (" . $editor->email . ")\n";
    echo "Current role: " . $editor->role . "\n";
    echo "Current destination_id: " . ($editor->destination_id ?? 'NULL') . "\n";
} else {
    echo "ERROR: Editor not found!\n";
}

if ($destination) {
    echo "Destination found: " . $destination->title . " (ID: " . $destination->id . ")\n";
} else {
    echo "ERROR: Destination not found!\n";
}

// Fix assignment if needed
if ($editor && $destination && $editor->destination_id != $destination->id) {
    echo "\nFIXING ASSIGNMENT...\n";
    $editor->destination_id = $destination->id;
    $editor->save();
    echo "✅ Editor assigned to destination!\n";
} elseif ($editor && $destination) {
    echo "\n✅ Assignment is already correct!\n";
}

// Show all users for debugging
echo "\n=== ALL USERS ===\n";
$users = User::all(['name', 'email', 'role', 'destination_id']);
foreach ($users as $user) {
    echo "- {$user->name} ({$user->email}) - Role: {$user->role} - Destination ID: " . ($user->destination_id ?? 'NULL') . "\n";
}
