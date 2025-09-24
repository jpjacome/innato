<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$s = App\Models\ElPatioSetting::first();
echo "about_title_highlight=" . ($s->about_title_highlight ?? 'NULL') . PHP_EOL;
echo "about2_title_highlight=" . ($s->about2_title_highlight ?? 'NULL') . PHP_EOL;
echo "rooms_title_highlight=" . ($s->rooms_title_highlight ?? 'NULL') . PHP_EOL;
