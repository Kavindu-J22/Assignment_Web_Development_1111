<?php
// ===== CONTACT HANDLER =====
// This file handles contact form submissions for the FoodExpress application

require_once 'config.php';

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

try {
    // Get and sanitize input data
    $firstName = sanitizeInput($_POST['firstName'] ?? '');
    $lastName = sanitizeInput($_POST['lastName'] ?? '');
    $email = sanitizeInput($_POST['email'] ?? '');
    $phone = sanitizeInput($_POST['phone'] ?? '');
    $subject = sanitizeInput($_POST['subject'] ?? '');
    $message = sanitizeInput($_POST['message'] ?? '');
    $newsletter = isset($_POST['newsletter']);
    
    // Validation array to collect errors
    $errors = [];
    
    // Validate first name
    if (empty($firstName)) {
        $errors['firstName'] = 'First name is required';
    } elseif (strlen($firstName) < 2) {
        $errors['firstName'] = 'First name must be at least 2 characters long';
    } elseif (!preg_match('/^[a-zA-Z]+$/', $firstName)) {
        $errors['firstName'] = 'First name can only contain letters';
    }
    
    // Validate last name
    if (empty($lastName)) {
        $errors['lastName'] = 'Last name is required';
    } elseif (strlen($lastName) < 2) {
        $errors['lastName'] = 'Last name must be at least 2 characters long';
    } elseif (!preg_match('/^[a-zA-Z]+$/', $lastName)) {
        $errors['lastName'] = 'Last name can only contain letters';
    }
    
    // Validate email
    if (empty($email)) {
        $errors['email'] = 'Email address is required';
    } elseif (!isValidEmail($email)) {
        $errors['email'] = 'Please enter a valid email address';
    }
    
    // Validate phone (optional)
    if (!empty($phone) && !isValidPhone($phone)) {
        $errors['phone'] = 'Please enter a valid phone number';
    }
    
    // Validate subject
    if (empty($subject)) {
        $errors['subject'] = 'Please select a subject';
    } elseif (!in_array($subject, ['general', 'order', 'delivery', 'feedback', 'complaint', 'partnership', 'other'])) {
        $errors['subject'] = 'Please select a valid subject';
    }
    
    // Validate message
    if (empty($message)) {
        $errors['message'] = 'Message is required';
    } elseif (strlen($message) < 10) {
        $errors['message'] = 'Message must be at least 10 characters long';
    } elseif (strlen($message) > 2000) {
        $errors['message'] = 'Message must be less than 2000 characters';
    }
    
    // If there are validation errors, return them
    if (!empty($errors)) {
        http_response_code(400);
        echo json_encode(['errors' => $errors]);
        exit;
    }
    
    // Create contact data
    $contactData = [
        'id' => uniqid('contact_', true),
        'firstName' => $firstName,
        'lastName' => $lastName,
        'fullName' => $firstName . ' ' . $lastName,
        'email' => $email,
        'phone' => $phone,
        'subject' => $subject,
        'message' => $message,
        'newsletter' => $newsletter,
        'submissionDate' => date('Y-m-d H:i:s'),
        'ipAddress' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
        'userAgent' => $_SERVER['HTTP_USER_AGENT'] ?? 'unknown',
        'status' => 'new'
    ];
    
    // Add user information if logged in
    if (isLoggedIn()) {
        $contactData['userId'] = $_SESSION['user_id'];
        $contactData['isRegisteredUser'] = true;
    } else {
        $contactData['userId'] = null;
        $contactData['isRegisteredUser'] = false;
    }
    
    // Save contact message to file
    if (!writeContact($contactData)) {
        http_response_code(500);
        echo json_encode(['error' => ERROR_FILE_WRITE]);
        exit;
    }
    
    // Log the contact submission
    logActivity("New contact message from: {$email} - Subject: {$subject}");
    
    // Send email notification (in a real application)
    // For this demo, we'll just log it
    logActivity("Email notification would be sent to admin about new contact message");
    
    // If user subscribed to newsletter, log that too
    if ($newsletter) {
        logActivity("User {$email} subscribed to newsletter");
    }
    
    // Return success response
    http_response_code(201);
    echo json_encode([
        'success' => true,
        'message' => SUCCESS_CONTACT,
        'contactId' => $contactData['id']
    ]);
    
} catch (Exception $e) {
    // Log the error
    error_log("Contact form error: " . $e->getMessage());
    
    // Return generic error response
    http_response_code(500);
    echo json_encode(['error' => 'An unexpected error occurred. Please try again.']);
}

?>
