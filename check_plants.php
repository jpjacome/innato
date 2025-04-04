<?php

// Bootstrap Laravel
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Plant;

// Check for plant ID 1
$plant1 = Plant::find(1);

echo "== Plant ID 1 Check ==\n";
if ($plant1) {
    echo "Plant with ID 1 exists:\n";
    echo "Name: {$plant1->name}\n";
    echo "Created at: {$plant1->created_at}\n";
} else {
    echo "No plant found with ID 1. It may have been deleted.\n";
}

// List all plants
echo "\n== All Plants in Database ==\n";
$plants = Plant::orderBy('id')->get();

if ($plants->isEmpty()) {
    echo "No plants found in the database.\n";
} else {
    foreach ($plants as $plant) {
        echo "ID: {$plant->id}, Name: {$plant->name}, Created: {$plant->created_at}\n";
    }
    
    echo "\nFound " . $plants->count() . " plants in total.\n";
}

// Check for deleted plants
echo "\n== Checking for Gaps in ID Sequence ==\n";
$maxId = Plant::max('id');
echo "Current maximum ID: $maxId\n";

$existingIds = $plants->pluck('id')->toArray();
$missingIds = [];

for ($i = 1; $i <= $maxId; $i++) {
    if (!in_array($i, $existingIds)) {
        $missingIds[] = $i;
    }
}

if (empty($missingIds)) {
    echo "No gaps in ID sequence found.\n";
} else {
    echo "Missing IDs: " . implode(', ', $missingIds) . "\n";
    echo "These IDs were likely used by plants that have been deleted.\n";
} 