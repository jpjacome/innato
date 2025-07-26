<?php
// debug_innato_public.php
// Place this file in the innato/public directory and access it via your browser.

echo "<pre>";
echo "== DIRECTORY & FILE PERMISSIONS ==\n";

$base = __DIR__;
$files = scandir($base);
foreach ($files as $file) {
    if ($file === '.' || $file === '..') continue;
    $path = $base . DIRECTORY_SEPARATOR . $file;
    $perms = substr(sprintf('%o', fileperms($path)), -4);
    $type = is_dir($path) ? 'DIR ' : 'FILE';
    echo "$type  $file  perms: $perms\n";
}

echo "\n== index.php READ TEST ==\n";
$index = $base . DIRECTORY_SEPARATOR . 'index.php';
if (file_exists($index)) {
    echo "index.php exists\n";
    if (is_readable($index)) {
        echo "index.php is readable\n";
    } else {
        echo "index.php is NOT readable\n";
    }
} else {
    echo "index.php does NOT exist\n";
}

// Check for .htaccess rules
echo "\n== .htaccess CONTENTS ==\n";
$htaccess = $base . DIRECTORY_SEPARATOR . '.htaccess';
if (file_exists($htaccess)) {
    echo htmlspecialchars(file_get_contents($htaccess));
} else {
    echo ".htaccess does NOT exist in this directory.";
}

echo "\n\n== PHP USER ==\n";
echo get_current_user() . "\n";
echo "UID: ".getmyuid()."\n";
echo "GID: ".getmygid()."\n";

// Try to open index.php for reading
echo "\n== fopen() test on index.php ==\n";
$fp = @fopen($index, 'r');
if ($fp) {
    echo "fopen() succeeded\n";
    fclose($fp);
} else {
    echo "fopen() FAILED\n";
}
echo "</pre>";
