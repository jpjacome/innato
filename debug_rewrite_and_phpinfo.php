<?php
// debug_rewrite_and_phpinfo.php
// Place in the innato directory and access via https://drpixel.it.nf/innato/debug_rewrite_and_phpinfo.php

echo "<pre>";
echo "== REQUEST INFO ==\n";
echo 'REQUEST_URI: ' . $_SERVER['REQUEST_URI'] . "\n";
echo 'SCRIPT_NAME: ' . $_SERVER['SCRIPT_NAME'] . "\n";
echo 'PHP_SELF: ' . $_SERVER['PHP_SELF'] . "\n";
echo 'DOCUMENT_ROOT: ' . $_SERVER['DOCUMENT_ROOT'] . "\n";
echo 'SCRIPT_FILENAME: ' . $_SERVER['SCRIPT_FILENAME'] . "\n";
echo 'PATH_TRANSLATED: ' . (isset($_SERVER['PATH_TRANSLATED']) ? $_SERVER['PATH_TRANSLATED'] : 'N/A') . "\n";
echo 'QUERY_STRING: ' . $_SERVER['QUERY_STRING'] . "\n";
echo 'SERVER_SOFTWARE: ' . $_SERVER['SERVER_SOFTWARE'] . "\n";
echo 'SERVER_NAME: ' . $_SERVER['SERVER_NAME'] . "\n";
echo 'SERVER_PORT: ' . $_SERVER['SERVER_PORT'] . "\n";
echo 'REMOTE_ADDR: ' . $_SERVER['REMOTE_ADDR'] . "\n";
echo 'GATEWAY_INTERFACE: ' . $_SERVER['GATEWAY_INTERFACE'] . "\n";
echo "\n== APACHE HEADERS ==\n";
foreach (getallheaders() as $name => $value) {
    echo "$name: $value\n";
}
echo "\n== FILES IN CURRENT DIR ==\n";
$files = scandir(__DIR__);
foreach ($files as $file) {
    if ($file === '.' || $file === '..') continue;
    $perms = substr(sprintf('%o', fileperms($file)), -4);
    echo "$file\tperms: $perms\n";
}
echo "\n== PHPINFO (short) ==\n";
phpinfo(INFO_GENERAL | INFO_CONFIGURATION | INFO_MODULES);
echo "</pre>";

// Suggest checking logs
error_log('DEBUG: Accessed debug_rewrite_and_phpinfo.php at ' . date('c'));
echo "\n== LOG FILES ==\n";
$logPaths = [
    ini_get('error_log'),
    '/var/log/apache2/error.log',
    '/usr/local/apache/logs/error_log',
    '/var/log/httpd/error_log',
    __DIR__ . '/../error_log',
    __DIR__ . '/error_log',
];
foreach ($logPaths as $log) {
    if ($log && file_exists($log)) {
        echo "\n--- $log ---\n";
        $lines = @file($log);
        if ($lines) {
            echo implode("", array_slice($lines, -20));
        } else {
            echo "(Could not read log)\n";
        }
    }
}
