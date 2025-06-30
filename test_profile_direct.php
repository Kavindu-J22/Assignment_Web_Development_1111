<?php
// Direct test of profile functionality
require_once 'php/config.php';

echo "<h1>Direct Profile Test</h1>";

// Check if user is logged in
if (isLoggedIn() && checkSessionTimeout()) {
    echo "<p style='color: green;'>✓ User is logged in</p>";
    
    // Get user data
    $user = findUserByEmail($_SESSION['user_email']);
    
    if ($user) {
        echo "<p style='color: green;'>✓ User data found</p>";
        echo "<h2>User Information:</h2>";
        echo "<p><strong>Name:</strong> " . htmlspecialchars($user['fullName']) . "</p>";
        echo "<p><strong>Email:</strong> " . htmlspecialchars($user['email']) . "</p>";
        echo "<p><strong>Phone:</strong> " . htmlspecialchars($user['phone']) . "</p>";
        
        // Test the profile HTML generation
        echo "<h2>Testing Profile HTML Generation:</h2>";
        
        // Include the profile handler functions
        include 'php/profile_handler.php';
        
    } else {
        echo "<p style='color: red;'>✗ User data not found</p>";
    }
} else {
    echo "<p style='color: red;'>✗ User is not logged in</p>";
    echo "<p>Session data:</p>";
    echo "<pre>";
    print_r($_SESSION);
    echo "</pre>";
}

echo "<hr>";
echo "<p><a href='login.html'>Go to Login</a> | <a href='profile.html'>Go to Profile</a></p>";
?>
