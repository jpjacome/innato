<?php

// Bootstrap Laravel
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Plant;
use App\Models\MaintenanceLog;
use App\Models\MaintenanceImage;
use Illuminate\Support\Facades\Storage;

// Find the jacaranda plant (assuming it was just created with ID 2)
$plantId = 2;
$plant = Plant::find($plantId);

if (!$plant) {
    echo "Error: Jacaranda plant with ID {$plantId} not found.\n";
    exit(1);
}

echo "Creating maintenance log for Jacaranda plant (ID: {$plant->id})...\n";

// Create the maintenance log with data from jacaranda.html
$maintenanceLog = MaintenanceLog::create([
    'plant_id' => $plant->id,
    'last_watering' => '2025-04-01',
    'next_watering' => '2025-04-08',
    'last_fertilization' => '2025-03-15',
    'next_fertilization' => '2025-04-15',
    'last_pruning' => '2025-02-10',
    'next_pruning' => '2026-02-10', // Yearly pruning
    'pest_disease_inspection' => 'No issues observed as of April 1, 2025'
]);

echo "Maintenance log created with ID: {$maintenanceLog->id}\n";

// Add maintenance log images from jacaranda.html
$images = [
    'https://tse3.mm.bing.net/th?id=OIP.qo1rR-J3XU9TlZjCVYb-HAHaE7&pid=Api',
    'https://tse1.mm.bing.net/th?id=OIP.YQp3WdtdiNMfHlTzvx88BAHaE8&pid=Api',
    'https://tse2.mm.bing.net/th?id=OIP.g3z4CQLDGXRjYiWTJnFH-AHaFj&pid=Api',
    'https://tse3.mm.bing.net/th?id=OIP.x6NlKZbZ_5hPp6m8B5QN_QHaE7&pid=Api'
];

// Import images
echo "Adding maintenance images...\n";
foreach ($images as $imageUrl) {
    try {
        // Create a unique filename
        $filename = 'maintenance/' . uniqid() . '.jpg';
        
        // Get image content
        $imageContent = @file_get_contents($imageUrl);
        
        if ($imageContent) {
            // Store the image
            Storage::disk('public')->put($filename, $imageContent);
            
            // Create image record
            $maintenanceLog->images()->create([
                'image_path' => '/storage/' . $filename
            ]);
            
            echo "Added maintenance image: $imageUrl\n";
        } else {
            echo "Failed to download maintenance image: $imageUrl\n";
        }
    } catch (Exception $e) {
        echo "Error adding maintenance image {$imageUrl}: {$e->getMessage()}\n";
    }
}

echo "\nJacaranda maintenance log has been added with " . count($maintenanceLog->images) . " images.\n";
echo "View the plant at: /admin/plants/{$plant->id}\n";
echo "View the maintenance log at: /admin/maintenance/{$maintenanceLog->id}\n";
echo "Public view at: /plants/{$plant->id}\n"; 