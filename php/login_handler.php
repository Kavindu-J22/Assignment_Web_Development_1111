<?php
// ===== LOGIN HANDLER =====
// This file handles user authentication for the FoodExpress application

require_once 'config.php';

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

try {
    // Get and sanitize input data
    $email = sanitizeInput($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $rememberMe = isset($_POST['rememberMe']);

    // Validation array to collect errors
    $errors = [];

    // Validate email
    if (empty($email)) {
        $errors['email'] = 'Email address is required';
    } elseif (!isValidEmail($email)) {
        $errors['email'] = 'Please enter a valid email address';
    }

    // Validate password
    if (empty($password)) {
        $errors['password'] = 'Password is required';
    }

    // If there are validation errors, return them
    if (!empty($errors)) {
        http_response_code(400);
        echo json_encode(['errors' => $errors]);
        exit;
    }

    // Check rate limiting
    if (!checkRateLimit($email)) {
        http_response_code(429);
        echo json_encode([
            'error' => 'Too many failed login attempts. Please try again in 15 minutes.',
            'lockout' => true
        ]);
        exit;
    }

    // Find user by email
    $user = findUserByEmail($email);

    if (!$user) {
        recordFailedLogin($email);
        logActivity("Failed login attempt for non-existent user: {$email}");

        http_response_code(401);
        echo json_encode(['error' => ERROR_INVALID_CREDENTIALS]);
        exit;
    }

    // Verify password
    if (!verifyPassword($password, $user['password'])) {
        recordFailedLogin($email);
        logActivity("Failed login attempt for user: {$email} (wrong password)");

        http_response_code(401);
        echo json_encode(['error' => ERROR_INVALID_CREDENTIALS]);
        exit;
    }

    // Check if user account is active
    if (!$user['isActive']) {
        http_response_code(403);
        echo json_encode(['error' => 'Your account has been deactivated. Please contact support.']);
        exit;
    }

    // Clear failed login attempts
    clearLoginAttempts($email);

    // Start session and set session variables
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_email'] = $user['email'];
    $_SESSION['user_name'] = $user['fullName'];
    $_SESSION['login_time'] = time();
    $_SESSION['last_activity'] = time();
    $_SESSION['is_logged_in'] = true;

    // Generate CSRF token for future requests
    generateCSRFToken();

    // Set remember me cookie if requested
    if ($rememberMe) {
        $cookieValue = base64_encode(json_encode([
            'user_id' => $user['id'],
            'email' => $user['email'],
            'token' => hash('sha256', $user['password'] . $user['registrationDate'])
        ]));

        setcookie('remember_me', $cookieValue, time() + (30 * 24 * 60 * 60), '/', '', false, true); // 30 days
    }

    // Update last login time (in a real application, you'd update the database)
    // For file-based storage, we'll just log it
    logActivity("Successful login for user: {$email}");

    // Return success response
    http_response_code(200);
    echo json_encode([
        'success' => true,
        'message' => SUCCESS_LOGIN,
        'user' => [
            'id' => $user['id'],
            'fullName' => $user['fullName'],
            'email' => $user['email'],
            'phone' => $user['phone'],
            'address' => $user['address']
        ],
        'csrf_token' => $_SESSION['csrf_token'],
        'redirect' => 'profile.html'
    ]);
} catch (Exception $e) {
    // Log the error
    error_log("Login error: " . $e->getMessage());

    // Return generic error response
    http_response_code(500);
    echo json_encode(['error' => 'An unexpected error occurred. Please try again.']);
}
