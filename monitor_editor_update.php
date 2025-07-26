<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Log;

echo "=== Monitoring Editor Update Logs ===\n\n";
echo "This script will monitor the Laravel log file for editor update entries.\n";
echo "Please attempt to update an editor's name through the web interface now.\n";
echo "Press Ctrl+C to stop monitoring.\n\n";

// Get the current log file path
$logPath = storage_path('logs/laravel.log');

// Get the current size of the log file
$initialSize = filesize($logPath);
echo "Initial log file size: " . $initialSize . " bytes\n";
echo "Waiting for new log entries...\n\n";

// Function to read new log entries
function readNewLogEntries($logPath, &$lastSize) {
    $currentSize = filesize($logPath);

    if ($currentSize > $lastSize) {
        $handle = fopen($logPath, 'r');
        fseek($handle, $lastSize);
        $newContent = fread($handle, $currentSize - $lastSize);
        fclose($handle);

        $lastSize = $currentSize;
        return $newContent;
    }

    return null;
}

// Monitor the log file for changes
$lastSize = $initialSize;
$checkInterval = 1; // seconds

while (true) {
    $newEntries = readNewLogEntries($logPath, $lastSize);

    if ($newEntries) {
        // Filter for relevant entries
        $lines = explode("\n", $newEntries);
        foreach ($lines as $line) {
            if (strpos($line, 'user') !== false ||
                strpos($line, 'editor') !== false ||
                strpos($line, 'update') !== false) {
                echo date('H:i:s') . " - " . $line . "\n";
            }
        }
    }

    sleep($checkInterval);
}
