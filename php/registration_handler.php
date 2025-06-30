<?php
// ===== REGISTRATION HANDLER =====
// This file handles user registration for the FoodExpress application

require_once 'config.php';

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

try {
    // Get and sanitize input data
    $fullName = sanitizeInput($_POST['fullName'] ?? '');
    $email = sanitizeInput($_POST['email'] ?? '');
    $phone = sanitizeInput($_POST['phone'] ?? '');
    $address = sanitizeInput($_POST['address'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirmPassword'] ?? '';
    $terms = isset($_POST['terms']);
    
    // Validation array to collect errors
    $errors = [];
    
    // Validate full name
    if (empty($fullName)) {
        $errors['fullName'] = 'Full name is required';
    } elseif (strlen($fullName) < 2) {
        $errors['fullName'] = 'Full name must be at least 2 characters long';
    } elseif (!preg_match('/^[a-zA-Z\s]+$/', $fullName)) {
        $errors['fullName'] = 'Full name can only contain letters and spaces';
    }
    
    // Validate email
    if (empty($email)) {
        $errors['email'] = 'Email address is required';
    } elseif (!isValidEmail($email)) {
        $errors['email'] = 'Please enter a valid email address';
    } else {
        // Check if user already exists
        $existingUser = findUserByEmail($email);
        if ($existingUser) {
            $errors['email'] = ERROR_USER_EXISTS;
        }
    }
    
    // Validate phone
    if (empty($phone)) {
        $errors['phone'] = 'Phone number is required';
    } elseif (!isValidPhone($phone)) {
        $errors['phone'] = 'Please enter a valid phone number';
    }
    
    // Validate address
    if (empty($address)) {
        $errors['address'] = 'Delivery address is required';
    } elseif (strlen($address) < 10) {
        $errors['address'] = 'Please provide a complete address';
    }
    
    // Validate password
    if (empty($password)) {
        $errors['password'] = 'Password is required';
    } elseif (!isValidPassword($password)) {
        $errors['password'] = 'Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, and one number';
    }
    
    // Validate confirm password
    if (empty($confirmPassword)) {
        $errors['confirmPassword'] = 'Please confirm your password';
    } elseif ($password !== $confirmPassword) {
        $errors['confirmPassword'] = 'Passwords do not match';
    }
    
    // Validate terms acceptance
    if (!$terms) {
        $errors['terms'] = 'You must agree to the terms and conditions';
    }
    
    // If there are validation errors, return them
    if (!empty($errors)) {
        http_response_code(400);
        echo json_encode(['errors' => $errors]);
        exit;
    }
    
    // Create user data
    $userData = [
        'id' => uniqid('user_', true),
        'fullName' => $fullName,
        'email' => $email,
        'phone' => $phone,
        'address' => $address,
        'password' => hashPassword($password),
        'registrationDate' => date('Y-m-d H:i:s'),
        'lastLogin' => null,
        'isActive' => true
    ];
    
    // Save user to file
    if (!writeUser($userData)) {
        http_response_code(500);
        echo json_encode(['error' => ERROR_FILE_WRITE]);
        exit;
    }
    
    // Log the registration
    logActivity("New user registered: {$email}");
    
    // Return success response
    http_response_code(201);
    echo json_encode([
        'success' => true,
        'message' => SUCCESS_REGISTRATION,
        'user' => [
            'id' => $userData['id'],
            'fullName' => $userData['fullName'],
            'email' => $userData['email']
        ]
    ]);
    
} catch (Exception $e) {
    // Log the error
    error_log("Registration error: " . $e->getMessage());
    
    // Return generic error response
    http_response_code(500);
    echo json_encode(['error' => 'An unexpected error occurred. Please try again.']);
}

?>
