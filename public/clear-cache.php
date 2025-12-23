<?php
// Clear opcache
if (function_exists('opcache_reset')) {
    opcache_reset();
    echo "OPcache cleared successfully!\n";
} else {
    echo "OPcache not available\n";
}

// Clear specific file
$file = __DIR__ . '/../src/Controllers/DashboardController.php';
if (function_exists('opcache_invalidate')) {
    opcache_invalidate($file, true);
    echo "File cache invalidated: $file\n";
}

echo "\nDone. Please refresh the dashboard page.";
