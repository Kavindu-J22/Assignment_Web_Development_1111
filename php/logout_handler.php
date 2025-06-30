<?php
// ===== LOGOUT HANDLER =====
// This file handles user logout for the FoodExpress application

require_once 'config.php';

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

try {
    // Log the logout if user was logged in
    if (isLoggedIn()) {
        logActivity("User logged out: " . $_SESSION['user_email']);
    }
    
    // Clear remember me cookie if it exists
    if (isset($_COOKIE['remember_me'])) {
        setcookie('remember_me', '', time() - 3600, '/', '', false, true);
    }
    
    // Destroy session
    session_unset();
    session_destroy();
    
    // Return success response
    http_response_code(200);
    echo json_encode([
        'success' => true,
        'message' => SUCCESS_LOGOUT
    ]);
    
} catch (Exception $e) {
    // Log the error
    error_log("Logout error: " . $e->getMessage());
    
    // Return generic error response
    http_response_code(500);
    echo json_encode(['error' => 'An unexpected error occurred during logout.']);
}

?>
