<?php

// Bootstrap Laravel
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Plant;
use App\Models\PlantImage;
use Illuminate\Support\Facades\Storage;

echo "Creating Jacaranda plant record...\n";

// Create the plant record
$plant = Plant::create([
    'name' => 'Jacaranda Tree',
    'common_names' => 'Blue Jacaranda, Black Poui, Green Ebony Tree',
    'family' => 'Bignoniaceae',
    'native_range' => 'Argentina and Bolivia',
    'age' => '5 years',
    'current_height' => '10–15 ft (3–4.5 m)',
    'expected_height' => 'Up to 50 ft (15 m)',
    'leaf_type' => 'Bipinnately compound, bright green',
    'bloom_time' => 'Late spring to early summer',
    'flower_color' => 'Lavender-blue',
    'fruit' => 'Woody capsules with winged seeds',
    'light' => 'Full sun (6–8 hrs/day)',
    'soil' => 'Sandy, well-drained',
    'hardiness' => 'USDA zones 10–11',
    'other_comments' => 'This 5-year-old Jacaranda is entering its first consistent blooming seasons. Excellent shape and health. Expected to reach shade canopy status in 3 years. Minimal maintenance required aside from seasonal watering and once-yearly pruning. Recommended for centerpiece display in subtropical zones.'
]);

echo "Plant created with ID: {$plant->id}\n";

// Add sample images from the jacaranda.html
$images = [
    'https://tse2.mm.bing.net/th?id=OIP.aSqnOoTkVwVLJGIMv1bHVgHaFN&pid=Api',
    'https://tse1.mm.bing.net/th?id=OIP.5ekaXLWPV4sgKETql6SiqwHaHa&pid=Api',
    'https://tse3.mm.bing.net/th?id=OIP.RoMAZODYvz3ae2bpkxFLvgHaHa&pid=Api',
    'https://tse2.mm.bing.net/th?id=OIP.fPSmDHRHI5w5WFAOTF7F3AHaHj&pid=Api'
];

// Import images
echo "Adding images...\n";
$imageOrder = 0;
foreach ($images as $imageUrl) {
    try {
        // Create a unique filename
        $filename = 'plants/' . uniqid() . '.jpg';
        
        // Get image content
        $imageContent = @file_get_contents($imageUrl);
        
        if ($imageContent) {
            // Store the image
            Storage::disk('public')->put($filename, $imageContent);
            
            // Create image record
            $plant->images()->create([
                'image_path' => '/storage/' . $filename,
                'image_order' => $imageOrder++
            ]);
            
            echo "Added image: $imageUrl\n";
        } else {
            echo "Failed to download image: $imageUrl\n";
        }
    } catch (Exception $e) {
        echo "Error adding image {$imageUrl}: {$e->getMessage()}\n";
    }
}

echo "\nJacaranda plant has been added with " . count($plant->images) . " images.\n";
echo "View the plant at: /admin/plants/{$plant->id}\n";
echo "Public view at: /plants/{$plant->id}\n"; 