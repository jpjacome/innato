<?php
echo "<h1>Laravel Log Viewer</h1>";

// Define application path
$basePath = __DIR__;
$logPath = $basePath . '/storage/logs/laravel.log';

// Function to make error messages more readable
function formatLogEntry($entry) {
    // Highlight error details
    $entry = preg_replace('/(Error|Exception|Stack trace):/i', '<strong style="color: red;">$1:</strong>', $entry);
    
    // Highlight timestamps
    $entry = preg_replace('/\[\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}\]/', '<span style="color: #888;">$0</span>', $entry);
    
    // Highlight file paths and line numbers
    $entry = preg_replace('/(\/[\w\/\.\-]+\.php)(\(\d+\))/', '<span style="color: #0066cc;">$1</span><span style="color: #cc6600;">$2</span>', $entry);
    
    return $entry;
}

// Display the log file
if (file_exists($logPath)) {
    // Get the size of the log file
    $fileSize = filesize($logPath);
    
    if ($fileSize > 0) {
        // Read the last part of the log file (limit to 100KB to avoid memory issues)
        $maxBytes = 100 * 1024; // 100KB
        
        if ($fileSize > $maxBytes) {
            // Read only the last portion of the file
            $handle = fopen($logPath, 'r');
            fseek($handle, -$maxBytes, SEEK_END);
            $content = fread($handle, $maxBytes);
            fclose($handle);
            
            // Find the first complete log entry (starting with [YYYY-MM-DD)
            if (preg_match('/\[\d{4}-\d{2}-\d{2}/', $content) !== 1) {
                $content = preg_replace('/^.*?\[\d{4}-\d{2}-\d{2}/s', '['.$matches[0], $content);
            }
            
            echo "<p><strong>Note:</strong> Log file is large. Showing only the last " . round($maxBytes/1024) . "KB</p>";
        } else {
            // Read the entire file
            $content = file_get_contents($logPath);
        }
        
        // Split log by entries (each entry typically starts with [YYYY-MM-DD)
        $entries = preg_split('/(?=\[\d{4}-\d{2}-\d{2})/', $content, -1, PREG_SPLIT_NO_EMPTY);
        
        // Display the most recent entries first (up to 20)
        $entries = array_reverse($entries);
        $displayEntries = array_slice($entries, 0, 20);
        
        echo "<div style='margin-top: 20px;'>";
        foreach ($displayEntries as $index => $entry) {
            // Format the log entry
            $formattedEntry = formatLogEntry($entry);
            
            echo "<div style='background: #f5f5f5; border: 1px solid #ddd; padding: 10px; margin-bottom: 10px; white-space: pre-wrap; font-family: monospace;'>";
            echo $formattedEntry;
            echo "</div>";
        }
        echo "</div>";
        
        if (count($entries) > 20) {
            echo "<p>Showing 20 most recent log entries of " . count($entries) . " total entries found.</p>";
        }
    } else {
        echo "<p>Log file exists but is empty.</p>";
    }
} else {
    echo "<p>Log file not found at: $logPath</p>";
    
    // Check for other log files
    $logsDir = $basePath . '/storage/logs/';
    if (is_dir($logsDir)) {
        $logFiles = glob($logsDir . '*.log');
        if (!empty($logFiles)) {
            echo "<p>Other log files found:</p><ul>";
            foreach ($logFiles as $file) {
                $fileName = basename($file);
                echo "<li>$fileName (" . round(filesize($file)/1024, 2) . "KB)</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>No log files found in the logs directory.</p>";
        }
    } else {
        echo "<p>Logs directory not found.</p>";
    }
}

echo "<p><a href='/laravel-test'>Return to homepage</a></p>"; 