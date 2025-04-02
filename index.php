<?php

/**
 * Redirect to the public directory
 * This file makes deployment easier on shared hosting
 */

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? ''
);

// This file allows us to emulate Apache's "mod_rewrite" functionality
// Adjust for the subfolder
$subfolder = '/laravel-test';
if (strpos($uri, $subfolder) === 0) {
    $uri = substr($uri, strlen($subfolder));
}

if ($uri !== '/' && file_exists(__DIR__.'/public'.$uri)) {
    return false;
}

require_once __DIR__.'/public/index.php'; 