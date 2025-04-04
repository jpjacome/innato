<?php
// Fix file permissions
$directories = [
    'storage/app' => 0775,
    'storage/framework' => 0775,
    'storage/logs' => 0775,
    'bootstrap/cache' => 0775
];

foreach ($directories as $dir => $permission) {
    if (is_dir(__DIR__ . '/' . $dir)) {
        chmod(__DIR__ . '/' . $dir, $permission);
        echo "Set permissions for $dir<br/>";
    } else {
        echo "Directory $dir not found<br/>";
    }
}

echo "Permissions updated!";