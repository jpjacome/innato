<?php

namespace Database\Seeders;

use App\Models\Plant;
use App\Models\PlantImage;
use App\Models\MaintenanceLog;
use App\Models\MaintenanceImage;
use Illuminate\Database\Seeder;

class PlantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Jacaranda Tree
        $plant = Plant::create([
            'name' => 'Jacaranda Tree',
            'common_names' => 'Blue Jacaranda, Black Poui, Green Ebony Tree',
            'family' => 'Bignoniaceae',
            'native_range' => 'Argentina and Bolivia',
            'age' => '5 years',
            'current_height' => '10-15 ft (3-4.5 m)',
            'expected_height' => 'Up to 50 ft (15 m)',
            'leaf_type' => 'Bipinnately compound, bright green',
            'bloom_time' => 'Late spring to early summer',
            'flower_color' => 'Lavender-blue',
            'fruit' => 'Woody capsules with winged seeds',
            'light' => 'Full sun (6-8 hrs/day)',
            'soil' => 'Sandy, well-drained',
            'hardiness' => 'USDA zones 10-11',
            'other_comments' => 'This 5-year-old Jacaranda is entering its first consistent blooming seasons. Excellent shape and health. Expected to reach shade canopy status in 3 years. Minimal maintenance required aside from seasonal watering and once-yearly pruning. Recommended for centerpiece display in subtropical zones.'
        ]);
        
        // Create maintenance log for Jacaranda
        $maintenanceLog = MaintenanceLog::create([
            'plant_id' => $plant->id,
            'last_watering' => '2025-04-01',
            'next_watering' => '2025-04-08',
            'last_fertilization' => '2025-03-15',
            'next_fertilization' => '2025-04-15',
            'last_pruning' => '2025-02-10',
            'next_pruning' => '2026-02-01',
            'pest_disease_inspection' => 'No issues observed as of April 1, 2025'
        ]);
        
        // Add gallery images for Jacaranda
        PlantImage::create([
            'plant_id' => $plant->id,
            'image_path' => 'https://th.bing.com/th/id/OIP.RoI-aOksCeTKZwm5wN-K_gHaE8?pid=ImgDet&rs=1',
            'image_order' => 1
        ]);
        
        PlantImage::create([
            'plant_id' => $plant->id,
            'image_path' => 'https://th.bing.com/th/id/OIP.RfEDaS3TfGYVKrgdVZNPOgHaE8?pid=ImgDet&rs=1',
            'image_order' => 2
        ]);
        
        PlantImage::create([
            'plant_id' => $plant->id,
            'image_path' => 'https://th.bing.com/th/id/OIP.GrIYbL1kouS5a9AuoJHfqwHaE8?pid=ImgDet&rs=1',
            'image_order' => 3
        ]);
        
        PlantImage::create([
            'plant_id' => $plant->id,
            'image_path' => 'https://th.bing.com/th/id/OIP.cKLiToShK9oLUYL3U4GgCgHaE4?pid=ImgDet&rs=1',
            'image_order' => 4
        ]);
        
        // Add thumbnail images for maintenance log
        MaintenanceImage::create([
            'maintenance_id' => $maintenanceLog->id,
            'image_path' => 'https://tse3.mm.bing.net/th?id=OIP.qo1rR-J3XU9TlZjCVYb-HAHaE7&pid=Api'
        ]);
        
        MaintenanceImage::create([
            'maintenance_id' => $maintenanceLog->id,
            'image_path' => 'https://tse1.mm.bing.net/th?id=OIP.YQp3WdtdiNMfHlTzvx88BAHaE8&pid=Api'
        ]);
        
        MaintenanceImage::create([
            'maintenance_id' => $maintenanceLog->id,
            'image_path' => 'https://tse2.mm.bing.net/th?id=OIP.g3z4CQLDGXRjYiWTJnFH-AHaFj&pid=Api'
        ]);
        
        MaintenanceImage::create([
            'maintenance_id' => $maintenanceLog->id,
            'image_path' => 'https://tse3.mm.bing.net/th?id=OIP.x6NlKZbZ_5hPp6m8B5QN_QHaE7&pid=Api'
        ]);
    }
}
