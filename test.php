<?php
// Simple PHP test file to check if PHP is working
echo "<h1>PHP Test</h1>";
echo "<p>PHP Version: " . phpversion() . "</p>";
echo "<p>Current Time: " . date('Y-m-d H:i:s') . "</p>";
echo "<p>Server: " . $_SERVER['SERVER_SOFTWARE'] . "</p>";

// Test if data directory is writable
$dataDir = __DIR__ . '/data/';
if (is_dir($dataDir)) {
    echo "<p>Data directory exists: ✓</p>";
    if (is_writable($dataDir)) {
        echo "<p>Data directory is writable: ✓</p>";
    } else {
        echo "<p>Data directory is NOT writable: ✗</p>";
    }
} else {
    echo "<p>Data directory does NOT exist: ✗</p>";
}

// Test basic PHP functions
echo "<h2>PHP Functions Test</h2>";
echo "<p>password_hash() available: " . (function_exists('password_hash') ? '✓' : '✗') . "</p>";
echo "<p>json_encode() available: " . (function_exists('json_encode') ? '✓' : '✗') . "</p>";
echo "<p>file_put_contents() available: " . (function_exists('file_put_contents') ? '✓' : '✗') . "</p>";

echo "<h2>Configuration</h2>";
echo "<p>If all tests show ✓, your PHP setup is working correctly!</p>";
echo "<p><a href='index.html'>Go to FoodExpress Homepage</a></p>";
?>
