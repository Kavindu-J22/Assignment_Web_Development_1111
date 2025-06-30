<?php
// ===== LOGIN STATUS CHECK =====
// This file checks if user is logged in and returns status

require_once 'config.php';

header('Content-Type: application/json');

try {
    // Check if user is logged in and session is valid
    if (isLoggedIn() && checkSessionTimeout()) {
        // Get user data
        $user = findUserByEmail($_SESSION['user_email']);
        
        if ($user) {
            echo json_encode([
                'loggedIn' => true,
                'user' => [
                    'id' => $user['id'],
                    'name' => $user['fullName'],
                    'email' => $user['email']
                ]
            ]);
        } else {
            // User not found, destroy session
            session_unset();
            session_destroy();
            echo json_encode(['loggedIn' => false]);
        }
    } else {
        echo json_encode(['loggedIn' => false]);
    }
    
} catch (Exception $e) {
    // Log the error
    error_log("Login status check error: " . $e->getMessage());
    
    // Return not logged in status
    echo json_encode(['loggedIn' => false]);
}

?>
