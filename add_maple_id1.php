<?php

// Bootstrap Laravel
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Plant;
use App\Models\PlantImage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

echo "Creating Japanese Maple tree with ID 1...\n";

// To insert with a specific ID, we need to use DB::table instead of Eloquent's create
// First check if ID 1 exists
if (Plant::find(1)) {
    echo "Error: Plant with ID 1 already exists. Cannot create a new one with this ID.\n";
    exit(1);
}

// Create the plant record with ID 1
$plantId = DB::table('plants')->insertGetId([
    'id' => 1,
    'name' => 'Japanese Maple Tree',
    'common_names' => 'Acer palmatum, Japanese Maple, Smooth Japanese Maple',
    'family' => 'Aceraceae',
    'native_range' => 'Japan, Korea, China, eastern Mongolia, and southeast Russia',
    'age' => '3 years',
    'current_height' => '5–7 ft (1.5–2.1 m)',
    'expected_height' => 'Up to 25 ft (7.6 m)',
    'leaf_type' => 'Palmate, deeply lobed with 5-7 lobes, red to purple',
    'bloom_time' => 'Spring (April to May)',
    'flower_color' => 'Red to purple',
    'fruit' => 'Winged samaras',
    'light' => 'Partial shade to full sun',
    'soil' => 'Well-drained, slightly acidic',
    'hardiness' => 'USDA zones 5-8',
    'other_comments' => 'This young 3-year-old Japanese Maple has vibrant red foliage that turns brilliant scarlet in autumn. Perfect as an accent tree in small gardens or for container growing. Requires protection from intense afternoon sun in hot climates. Excellent specimen for adding year-round color and texture to the landscape.',
    'created_at' => now(),
    'updated_at' => now()
]);

echo "Plant created with ID: {$plantId}\n";

// Get the plant object for easier relationship management
$plant = Plant::find($plantId);

// Add sample images for Japanese Maple
$images = [
    'https://t4.ftcdn.net/jpg/02/86/02/67/360_F_286026731_gMZgQGsjTkYMO4GUzrP8fGq3QYRYfYpf.jpg',
    'https://t3.ftcdn.net/jpg/00/70/82/02/360_F_70820291_aoZgLOuWGzd3YC2p5YgMM8YKTvL2TyUl.jpg',
    'https://www.thespruce.com/thmb/2fCQiWrk_J7tnJrBfBXxoSFwfA0=/1500x0/filters:no_upscale():max_bytes(150000):strip_icc()/japanese-maple-trees-2131795-04-58032f885f9b5805c244aeba.jpg',
    'https://cdn.britannica.com/80/156480-050-A9B25208/Bloodgood-Japanese-maple.jpg'
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

// Add a maintenance log for the Japanese Maple
echo "\nCreating maintenance log for Japanese Maple...\n";

$maintenanceLog = $plant->maintenanceLogs()->create([
    'last_watering' => '2025-04-01',
    'next_watering' => '2025-04-06', // Maples need frequent watering when young
    'last_fertilization' => '2025-03-10',
    'next_fertilization' => '2025-05-10', // Spring fertilization
    'last_pruning' => '2024-12-15', // Winter pruning when dormant
    'next_pruning' => '2025-12-15', // Annual winter pruning
    'pest_disease_inspection' => 'Minor aphid presence on new growth, treated with neem oil on March 25, 2025. Monitor for recurrence.'
]);

echo "Maintenance log created with ID: {$maintenanceLog->id}\n";

echo "\nJapanese Maple tree has been added with ID 1 and " . count($plant->images) . " images.\n";
echo "View the plant at: /admin/plants/1\n";
echo "Public view at: /plants/1\n"; 