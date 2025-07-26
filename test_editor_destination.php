<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Models\Destination;
use Illuminate\Support\Facades\DB;

echo "=== Testing Editor-Destination Relationships ===\n\n";

// Get all editors
$editors = User::where('role', 'editor')->get();
echo "Found " . $editors->count() . " editors\n";

foreach ($editors as $editor) {
    echo "\nEditor ID: " . $editor->id . "\n";
    echo "Name: " . $editor->name . "\n";
    echo "Email: " . $editor->email . "\n";
    echo "Destination ID: " . ($editor->destination_id ?? 'None') . "\n";

    // Check if editor has a destination
    if ($editor->destination_id) {
        $destination = Destination::find($editor->destination_id);
        if ($destination) {
            echo "Assigned to destination: " . $destination->title . "\n";
            echo "Destination slug: " . $destination->slug . "\n";

            // Check if slug contains editor name
            $nameInSlug = stripos($destination->slug, $editor->name) !== false;
            echo "Editor name appears in slug: " . ($nameInSlug ? 'Yes' : 'No') . "\n";
        } else {
            echo "Warning: Assigned destination ID does not exist!\n";
        }
    } else {
        echo "No destination assigned\n";
    }
}

// Get database schema for users table
echo "\n=== User Table Schema ===\n";
$columns = DB::select('SHOW COLUMNS FROM users');
foreach ($columns as $column) {
    echo $column->Field . " - " . $column->Type . " - " . ($column->Null === "YES" ? "Nullable" : "Not Nullable");
    if ($column->Key) echo " - Key: " . $column->Key;
    if ($column->Default) echo " - Default: " . $column->Default;
    echo "\n";
}

// Get database schema for destinations table
echo "\n=== Destination Table Schema ===\n";
$columns = DB::select('SHOW COLUMNS FROM destinations');
foreach ($columns as $column) {
    echo $column->Field . " - " . $column->Type . " - " . ($column->Null === "YES" ? "Nullable" : "Not Nullable");
    if ($column->Key) echo " - Key: " . $column->Key;
    if ($column->Default) echo " - Default: " . $column->Default;
    echo "\n";
}

// Check if there are any constraints on the slug field
echo "\n=== Checking for slug constraints ===\n";
try {
    $constraints = DB::select("
        SELECT CONSTRAINT_NAME, COLUMN_NAME, REFERENCED_TABLE_NAME, REFERENCED_COLUMN_NAME
        FROM information_schema.KEY_COLUMN_USAGE
        WHERE TABLE_NAME = 'destinations' AND COLUMN_NAME = 'slug'
    ");

    if (count($constraints) > 0) {
        foreach ($constraints as $constraint) {
            echo "Constraint: " . $constraint->CONSTRAINT_NAME . "\n";
            if ($constraint->REFERENCED_TABLE_NAME) {
                echo "References: " . $constraint->REFERENCED_TABLE_NAME . "." . $constraint->REFERENCED_COLUMN_NAME . "\n";
            }
        }
    } else {
        echo "No foreign key constraints found on slug field\n";
    }
} catch (\Exception $e) {
    echo "Error checking constraints: " . $e->getMessage() . "\n";
}

// Check if there are any unique indexes on the slug field
try {
    $indexes = DB::select("SHOW INDEXES FROM destinations WHERE Column_name = 'slug'");
    if (count($indexes) > 0) {
        echo "\nIndexes on slug field:\n";
        foreach ($indexes as $index) {
            echo "Index: " . $index->Key_name . " - ";
            echo "Non-unique: " . ($index->Non_unique ? 'Yes' : 'No') . "\n";
        }
    } else {
        echo "\nNo indexes found on slug field\n";
    }
} catch (\Exception $e) {
    echo "Error checking indexes: " . $e->getMessage() . "\n";
}

echo "\n=== Test Complete ===\n";
