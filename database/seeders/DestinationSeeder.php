<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Destination;

class DestinationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Destination::create([
            'slug' => 'libertador-bolivar',
            'title' => 'TURISMO RURAL LIBERTADOR BOLÍVAR',
            'subtitle' => 'Ecoturismo - Turismo Cultural / Natural',
            'coordinates' => 'S 1°52\'56" W 80°44\'03" - 0 M.S.N.M',
            'conservation_status' => 'Estado de conservación: Bueno',
            
            // Location
            'province' => 'Santa Elena',
            'canton' => 'Santa Elena',
            'parish' => 'Simón Bolívar',
            'sector' => 'Malecón Libertador Bolívar',
            'reference_distance' => '49.9 KM del GAD de Santa Elena',
            
            // Climate
            'climate_dry_season' => [
                'name' => 'Época Seca',
                'months' => 'Junio - Noviembre',
                'temperature' => '27°C'
            ],
            'climate_wet_season' => [
                'name' => 'Época Húmeda',
                'months' => 'Diciembre - Mayo',
                'temperature' => '20°C'
            ],
            
            // Access
            'access_from' => 'Comuna Atravezado (1.4 KM)',
            'access_route' => 'Asfaltado/Lastrada (Bueno)',
            'access_transport' => 'Público/Privado (Cada 30 min)',
            'access_time' => '3-4 horas',
            
            // Schedule
            'schedule_hours' => '06:00 - 17:00',
            'entry_fee' => 'GRATIS ($0 USD)',
            'season_availability' => 'Todo el año',
            'requirements' => 'Ninguno',
            
            // Contact
            'contact_person' => 'Luis Coronado',
            'contact_role' => 'Presidente',
            'contact_phone' => '995597497',
            'contact_email' => 'comunaatravezado@hotmail.com',
            
            // Activities
            'activities' => [
                ['icon' => 'ph ph-sun', 'name' => 'Relax en la playa'],
                ['icon' => 'ph ph-fork-knife', 'name' => 'Gastronomía local'],
                ['icon' => 'ph ph-shopping-bag', 'name' => 'Compras de artesanías'],
                ['icon' => 'ph ph-waves', 'name' => 'Deportes acuáticos'],
                ['icon' => 'ph ph-mountains', 'name' => 'Senderismo'],
                ['icon' => 'ph ph-binoculars', 'name' => 'Excursiones']
            ],
            
            // Target Audience
            'target_audience_type' => 'Turistas que gustan del mar',
            'target_audience_origin' => 'Nacional e Internacional',
            'target_audience_age' => 'Todas las edades',
            'target_audience_transport' => 'Privado',
            'target_audience_stay' => '1-2 noches',
            
            // Services
            'services' => [
                ['icon' => 'ph ph-car', 'name' => 'Estacionamiento', 'available' => true],
                ['icon' => 'ph ph-fork-knife', 'name' => 'Alimentación', 'available' => true],
                ['icon' => 'ph ph-bed', 'name' => 'Alojamiento', 'available' => true],
                ['icon' => 'ph ph-toilet-paper', 'name' => 'Baterías Sanitarias', 'available' => true],
                ['icon' => 'ph ph-user-check', 'name' => 'Visitas Guiadas', 'available' => true],
                ['icon' => 'ph ph-wrench', 'name' => 'Talleres', 'available' => true],
                ['icon' => 'ph ph-signpost', 'name' => 'Señalización', 'available' => true],
                ['icon' => 'ph ph-shield-check', 'name' => 'Seguridad', 'available' => true]
            ],
            
            // Pricing
            'average_price' => '$33 USD/persona',
            'capacity' => '40 PAX',
            'payment_methods' => 'Solo efectivo',
            'mobile_coverage' => 'Sí disponible',
            
            // Tourism Criteria
            'tourism_criteria' => [
                ['name' => 'Acceso para personas mayores/discapacitadas', 'status' => 'positive'],
                ['name' => 'Seguridad en los alrededores', 'status' => 'positive'],
                ['name' => 'Cordialidad del personal: Bueno', 'status' => 'positive'],
                ['name' => 'Personal multilingüe: No', 'status' => 'neutral'],
                ['name' => 'Manejo de desechos: No', 'status' => 'neutral'],
                ['name' => 'Decoración: Propia de la costa', 'status' => 'positive']
            ],
            
            // Descriptions
            'main_description' => 'El producto turístico en Libertador Bolívar se caracteriza por una combinación de experiencias que incluyen disfrutar de su extensa playa, ideal para relajarse y nadar, y deleitarse con los platos típicos en las cabañas frente al mar.',
            'secondary_description' => 'Los visitantes pueden adquirir artesanías de tagua, sombreros y hamacas, que son representativas de la región, perfectas para llevar como souvenirs. La zona también ofrece oportunidades para actividades al aire libre, como paseos en kayak y senderismo, permitiendo explorar la belleza natural de los alrededores.',
            'strengths_benefits' => 'La diversidad de experiencias que se ofrecen, junto con la posibilidad de disfrutar de la gastronomía local y adquirir artesanías únicas, fomenta el apoyo a la economía de la comunidad y promueve la cultura y las tradiciones locales. Además se genera un sentido de conexión entre los visitantes y los anfitriones.',
            
            // Environmental Challenges
            'environmental_challenges' => [
                [
                    'icon' => 'ph ph-trash',
                    'title' => 'Contaminación',
                    'description' => 'Generación de residuos, especialmente plásticos en feriados que contaminan el entorno natural y marino.'
                ]
            ],
            
            // Media
            'hero_image' => '/assets/imgs/destinations/libertador-bolivar-hero.jpg',
            'gallery_images' => [
                '/assets/imgs/destinations/libertador-bolivar-1.jpg',
                '/assets/imgs/destinations/libertador-bolivar-2.jpg',
                '/assets/imgs/destinations/libertador-bolivar-3.jpg'
            ],
            
            'status' => 'active'
        ]);
    }
}
