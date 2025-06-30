<?php
// Debug profile page to check session and user data
require_once 'php/config.php';

echo "<h1>Profile Debug Information</h1>";

echo "<h2>Session Status</h2>";
echo "<p>Session ID: " . session_id() . "</p>";
echo "<p>Session started: " . (session_status() === PHP_SESSION_ACTIVE ? 'Yes' : 'No') . "</p>";

echo "<h2>Session Data</h2>";
echo "<pre>";
print_r($_SESSION);
echo "</pre>";

echo "<h2>Login Check</h2>";
echo "<p>isLoggedIn(): " . (isLoggedIn() ? 'TRUE' : 'FALSE') . "</p>";
echo "<p>checkSessionTimeout(): " . (checkSessionTimeout() ? 'TRUE' : 'FALSE') . "</p>";

if (isset($_SESSION['user_email'])) {
    echo "<h2>User Data</h2>";
    $user = findUserByEmail($_SESSION['user_email']);
    if ($user) {
        echo "<p>User found: " . $user['fullName'] . "</p>";
        echo "<p>Email: " . $user['email'] . "</p>";
        echo "<pre>";
        print_r($user);
        echo "</pre>";
    } else {
        echo "<p>User NOT found in data file</p>";
    }
} else {
    echo "<p>No user email in session</p>";
}

echo "<h2>Data File Check</h2>";
$usersFile = __DIR__ . '/data/users.txt';
echo "<p>Users file exists: " . (file_exists($usersFile) ? 'Yes' : 'No') . "</p>";
if (file_exists($usersFile)) {
    echo "<p>Users file readable: " . (is_readable($usersFile) ? 'Yes' : 'No') . "</p>";
    echo "<p>File size: " . filesize($usersFile) . " bytes</p>";

    $content = file_get_contents($usersFile);
    echo "<h3>File Content:</h3>";
    echo "<pre>" . htmlspecialchars($content) . "</pre>";
}

echo "<h2>Test Links</h2>";
echo "<p><a href='php/check_login_status.php'>Check Login Status</a></p>";
echo "<p><a href='php/profile_handler.php'>Profile Handler</a></p>";
echo "<p><a href='profile.html'>Profile Page</a></p>";
echo "<p><a href='login.html'>Login Page</a></p>";
