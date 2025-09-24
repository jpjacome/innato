<?php
require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Use the Reservation model
use App\Models\Reservation;

echo "=== RESERVATION DATABASE ANALYSIS ===\n";
echo "Total reservations: " . Reservation::count() . "\n\n";

if (Reservation::count() > 0) {
    echo "Recent reservations (last 5):\n";
    $reservations = Reservation::with('destination')->latest()->take(5)->get();
    
    foreach ($reservations as $reservation) {
        echo "- {$reservation->name} ({$reservation->email})\n";
        echo "  Destination: " . ($reservation->destination ? $reservation->destination->title : 'No destination') . "\n";
        echo "  Date: {$reservation->date}\n";
        echo "  People: {$reservation->people_count}\n";
        echo "  Phone: {$reservation->phone_number}\n";
        echo "  Created: {$reservation->created_at}\n\n";
    }
} else {
    echo "No reservations found in database.\n";
}

echo "=== TABLE STRUCTURE ===\n";
echo "Columns in reservations table:\n";
$columns = \Illuminate\Support\Facades\Schema::getColumnListing('reservations');
foreach ($columns as $column) {
    echo "- {$column}\n";
}