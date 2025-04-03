<?php

/**
 * Redirect to the public directory
 * This file makes deployment easier on shared hosting
 */

// Define the subdirectory
$subfolder = '/laravel-test';

// Get the request URI
$requestUri = $_SERVER['REQUEST_URI'];

// If we're already in the subfolder path, strip it for internal processing
if (strpos($requestUri, $subfolder) === 0) {
    $_SERVER['REQUEST_URI'] = substr($requestUri, strlen($subfolder));
}

// If the URI is empty or just /, make sure it's treated as a root request
if ($_SERVER['REQUEST_URI'] === '' || $_SERVER['REQUEST_URI'] === '/') {
    $_SERVER['REQUEST_URI'] = '/';
}

// Check if this is a direct file request
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '');
if ($uri !== '/' && file_exists(__DIR__.'/public'.$uri)) {
    return false;
}

// Load the Laravel application
require_once __DIR__.'/public/index.php'; 