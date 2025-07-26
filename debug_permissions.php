<?php
// debug_permissions.php
// Place this file in public_html/drpixel/innato/public or public_html/drpixel/innato

header('Content-Type: text/plain');

// Check PHP version
printf("PHP Version: %s\n", phpversion());

// Check current user
printf("Current User: %s\n", get_current_user());

// Check script owner
$script = __FILE__;
printf("Script Owner: %s\n", fileowner($script));

// Check permissions for key folders
$paths = [
    __DIR__,
    dirname(__DIR__),
    __DIR__ . '/storage',
    __DIR__ . '/bootstrap/cache',
    __DIR__ . '/.htaccess',
    __DIR__ . '/index.php',
];

foreach ($paths as $path) {
    if (file_exists($path)) {
        printf("%s: exists, perms: %o\n", $path, fileperms($path) & 0777);
    } else {
        printf("%s: does not exist\n", $path);
    }
}

// Check if .htaccess is readable
$htaccess = __DIR__ . '/.htaccess';
if (file_exists($htaccess)) {
    $ht = file_get_contents($htaccess);
    echo "\n.htaccess contents:\n";
    echo $ht;
} else {
    echo "\n.htaccess not found in this directory.\n";
}

// Try to create a test file
$testfile = __DIR__ . '/test_write.txt';
$canWrite = @file_put_contents($testfile, 'test');
if ($canWrite !== false) {
    echo "\nWrite test: SUCCESS\n";
    unlink($testfile);
} else {
    echo "\nWrite test: FAILED\n";
}

// Check mod_rewrite (best effort)
echo "\nmod_rewrite check: ";
if (in_array('mod_rewrite', apache_get_modules() ?: [])) {
    echo "ENABLED\n";
} else {
    echo "UNKNOWN or DISABLED (cannot always detect in CGI/FastCGI)\n";
}
?>
