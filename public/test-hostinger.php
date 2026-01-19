<?php
/**
 * Diagnostic Test File for Hostinger
 * Upload this to public_html and access: https://nebatech.com/test-hostinger.php
 * DELETE THIS FILE after testing!
 */

echo "<h1>Nebatech Hostinger Diagnostic</h1>";
echo "<hr>";

// 1. PHP Version
echo "<h2>1. PHP Version</h2>";
echo "<p>PHP Version: " . phpversion() . "</p>";

// 2. Check current directory
echo "<h2>2. Current Directory</h2>";
echo "<p>__DIR__: " . __DIR__ . "</p>";
echo "<p>getcwd(): " . getcwd() . "</p>";

// 3. Check if key files exist
echo "<h2>3. File Existence Check</h2>";
$files = [
    'index.php',
    '.env',
    '.htaccess',
    'vendor/autoload.php',
    'src/helpers.php',
    'config/app.php',
    'config/database.php',
    'routes/web.php',
    'src/Core/Router.php',
    'src/Core/Controller.php',
    'src/Controllers/HomeController.php',
    'src/Views/home/index.php',
    'src/Views/layouts/main.php'
];

echo "<table border='1' cellpadding='5'>";
echo "<tr><th>File</th><th>Exists</th></tr>";
foreach ($files as $file) {
    $exists = file_exists(__DIR__ . '/' . $file);
    $color = $exists ? 'green' : 'red';
    echo "<tr><td>{$file}</td><td style='color:{$color}'>" . ($exists ? 'YES' : 'NO') . "</td></tr>";
}
echo "</table>";

// 4. Check .env contents (without sensitive data)
echo "<h2>4. Environment Variables</h2>";
if (file_exists(__DIR__ . '/.env')) {
    $envContent = file_get_contents(__DIR__ . '/.env');
    $lines = explode("\n", $envContent);
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>Key</th><th>Has Value</th></tr>";
    foreach ($lines as $line) {
        $line = trim($line);
        if (empty($line) || strpos($line, '#') === 0) continue;
        if (strpos($line, '=') !== false) {
            list($key, $value) = explode('=', $line, 2);
            $hasValue = !empty(trim($value, '"\''));
            // Hide sensitive keys
            if (strpos(strtolower($key), 'password') !== false || 
                strpos(strtolower($key), 'secret') !== false ||
                strpos(strtolower($key), 'key') !== false) {
                $display = $hasValue ? '***HIDDEN***' : 'EMPTY';
            } else {
                $display = $hasValue ? trim($value, '"\'') : 'EMPTY';
            }
            $color = $hasValue ? 'green' : 'orange';
            echo "<tr><td>{$key}</td><td style='color:{$color}'>{$display}</td></tr>";
        }
    }
    echo "</table>";
} else {
    echo "<p style='color:red'>.env file NOT FOUND!</p>";
}

// 5. Test autoloader
echo "<h2>5. Autoloader Test</h2>";
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    try {
        require_once __DIR__ . '/vendor/autoload.php';
        echo "<p style='color:green'>Autoloader loaded successfully!</p>";
        
        // Check if Dotenv exists
        if (class_exists('Dotenv\Dotenv')) {
            echo "<p style='color:green'>Dotenv class exists!</p>";
        } else {
            echo "<p style='color:red'>Dotenv class NOT found!</p>";
        }
    } catch (Exception $e) {
        echo "<p style='color:red'>Autoloader Error: " . $e->getMessage() . "</p>";
    }
} else {
    echo "<p style='color:red'>vendor/autoload.php NOT FOUND!</p>";
}

// 6. Test database connection
echo "<h2>6. Database Connection Test</h2>";
try {
    if (file_exists(__DIR__ . '/.env')) {
        $envContent = file_get_contents(__DIR__ . '/.env');
        preg_match('/DB_HOST=(.*)/', $envContent, $hostMatch);
        preg_match('/DB_NAME=(.*)/', $envContent, $nameMatch);
        preg_match('/DB_USER=(.*)/', $envContent, $userMatch);
        preg_match('/DB_PASSWORD=(.*)/', $envContent, $passMatch);
        
        $host = trim($hostMatch[1] ?? 'localhost');
        $name = trim($nameMatch[1] ?? '');
        $user = trim($userMatch[1] ?? '');
        $pass = trim($passMatch[1] ?? '');
        
        echo "<p>Attempting connection to: {$host} / {$name} as {$user}</p>";
        
        $pdo = new PDO("mysql:host={$host};dbname={$name}", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "<p style='color:green'>Database connection SUCCESSFUL!</p>";
        
        // Count tables
        $stmt = $pdo->query("SHOW TABLES");
        $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
        echo "<p>Tables found: " . count($tables) . "</p>";
    }
} catch (PDOException $e) {
    echo "<p style='color:red'>Database Error: " . $e->getMessage() . "</p>";
}

// 7. Directory listing
echo "<h2>7. Root Directory Contents</h2>";
$items = scandir(__DIR__);
echo "<ul>";
foreach ($items as $item) {
    if ($item === '.' || $item === '..') continue;
    $isDir = is_dir(__DIR__ . '/' . $item);
    echo "<li>" . ($isDir ? "📁 " : "📄 ") . $item . "</li>";
}
echo "</ul>";

// 8. PHP Extensions
echo "<h2>8. Required PHP Extensions</h2>";
$extensions = ['pdo', 'pdo_mysql', 'mbstring', 'json', 'openssl', 'curl'];
echo "<table border='1' cellpadding='5'>";
echo "<tr><th>Extension</th><th>Loaded</th></tr>";
foreach ($extensions as $ext) {
    $loaded = extension_loaded($ext);
    $color = $loaded ? 'green' : 'red';
    echo "<tr><td>{$ext}</td><td style='color:{$color}'>" . ($loaded ? 'YES' : 'NO') . "</td></tr>";
}
echo "</table>";

echo "<hr>";
echo "<p><strong>⚠️ DELETE THIS FILE AFTER TESTING!</strong></p>";
