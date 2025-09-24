<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$g = App\Models\ElPatioSetting::first();
echo json_encode(['gallery' => $g?->gallery, 'raw' => $g?->getAttributes()['gallery'] ?? null], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
