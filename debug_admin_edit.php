<?php

// Simple debugging script to test the admin edit route
require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Create a fake request to the admin edit route
$request = \Illuminate\Http\Request::create('/admin/destinations/1/edit', 'GET');
$request->headers->set('Host', '127.0.0.1:8000');

try {
    $response = $kernel->handle($request);
    
    echo "Response Status: " . $response->getStatusCode() . "\n";
    echo "Response Headers:\n";
    foreach ($response->headers->all() as $name => $values) {
        foreach ($values as $value) {
            echo "  $name: $value\n";
        }
    }
    echo "Content Length: " . strlen($response->getContent()) . "\n";
    echo "Content Preview (first 500 chars):\n";
    echo substr($response->getContent(), 0, 500) . "\n";
    
    if ($response->getStatusCode() === 302) {
        echo "Redirect Location: " . $response->headers->get('Location') . "\n";
    }
    
} catch (Exception $e) {
    echo "Exception: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
    echo "Trace:\n" . $e->getTraceAsString() . "\n";
}
