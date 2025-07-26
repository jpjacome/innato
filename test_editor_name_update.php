<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

echo "=== Testing Editor Name Update ===\n\n";

// Get the first editor
$editor = User::where('role', 'editor')->first();

if (!$editor) {
    echo "No editor found in the database.\n";
    exit;
}

echo "Found editor: ID {$editor->id}, Name: {$editor->name}, Email: {$editor->email}\n";
echo "Current destination_id: " . ($editor->destination_id ?? 'None') . "\n\n";

// Store original values for comparison
$originalName = $editor->name;
$originalEmail = $editor->email;
$originalDestinationId = $editor->destination_id;

// Generate a new name (append timestamp to make it unique)
$newName = "Editor" . time();

echo "Attempting to update editor name to: {$newName}\n";

// Log the update attempt
Log::info('Test script: Attempting to update editor name', [
    'editor_id' => $editor->id,
    'original_name' => $originalName,
    'new_name' => $newName
]);

try {
    // Method 1: Using the update method directly
    echo "\nMethod 1: Using update() method\n";
    $result = $editor->update([
        'name' => $newName
    ]);

    echo "Update result: " . ($result ? "Success" : "Failed") . "\n";
    echo "Name after update: " . $editor->name . "\n";

    // Check if the name was actually updated
    $updatedEditor = User::find($editor->id);
    echo "Name in database after update: " . $updatedEditor->name . "\n";

    // Log the result
    Log::info('Test script: Method 1 update result', [
        'editor_id' => $editor->id,
        'success' => $result,
        'name_in_memory' => $editor->name,
        'name_in_db' => $updatedEditor->name,
        'name_changed' => $updatedEditor->name !== $originalName
    ]);

    // Reset to original name
    $editor->update(['name' => $originalName]);
    echo "Reset name to original: " . $originalName . "\n\n";

    // Method 2: Using the save method
    echo "Method 2: Using save() method\n";
    $editor = User::find($editor->id); // Refresh the model
    $editor->name = $newName . "_2";
    $result = $editor->save();

    echo "Save result: " . ($result ? "Success" : "Failed") . "\n";
    echo "Name after save: " . $editor->name . "\n";

    // Check if the name was actually updated
    $updatedEditor = User::find($editor->id);
    echo "Name in database after save: " . $updatedEditor->name . "\n";

    // Log the result
    Log::info('Test script: Method 2 update result', [
        'editor_id' => $editor->id,
        'success' => $result,
        'name_in_memory' => $editor->name,
        'name_in_db' => $updatedEditor->name,
        'name_changed' => $updatedEditor->name !== $originalName
    ]);

    // Reset to original name
    $editor->name = $originalName;
    $editor->save();
    echo "Reset name to original: " . $originalName . "\n\n";

    // Method 3: Using query builder
    echo "Method 3: Using query builder\n";
    $newName = $newName . "_3";
    $result = User::where('id', $editor->id)->update(['name' => $newName]);

    echo "Query builder update result: " . $result . " rows affected\n";

    // Check if the name was actually updated
    $updatedEditor = User::find($editor->id);
    echo "Name in database after query builder update: " . $updatedEditor->name . "\n";

    // Log the result
    Log::info('Test script: Method 3 update result', [
        'editor_id' => $editor->id,
        'rows_affected' => $result,
        'name_in_db' => $updatedEditor->name,
        'name_changed' => $updatedEditor->name !== $originalName
    ]);

    // Reset to original name
    User::where('id', $editor->id)->update(['name' => $originalName]);
    echo "Reset name to original: " . $originalName . "\n\n";

    // Check if there are any database triggers
    echo "Checking for database triggers on users table...\n";
    $triggers = DB::select("SHOW TRIGGERS LIKE 'users'");

    if (count($triggers) > 0) {
        echo "Found " . count($triggers) . " triggers on users table:\n";
        foreach ($triggers as $trigger) {
            echo "- " . $trigger->Trigger . " (" . $trigger->Timing . " " . $trigger->Event . ")\n";
        }
    } else {
        echo "No triggers found on users table.\n";
    }

} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";

    // Log the error
    Log::error('Test script: Error updating editor name', [
        'editor_id' => $editor->id,
        'error' => $e->getMessage(),
        'trace' => $e->getTraceAsString()
    ]);

    // Reset to original name just in case
    try {
        $editor = User::find($editor->id);
        $editor->update(['name' => $originalName]);
    } catch (\Exception $e2) {
        echo "Error resetting name: " . $e2->getMessage() . "\n";
    }
}

echo "\n=== Test Complete ===\n";
