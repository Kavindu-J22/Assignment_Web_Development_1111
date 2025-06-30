<?php
// ===== CONFIGURATION FILE =====
// This file contains configuration settings for the FoodExpress application

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ===== APPLICATION SETTINGS =====
define('APP_NAME', 'FoodExpress');
define('APP_VERSION', '1.0.0');
define('APP_URL', 'http://localhost');

// ===== FILE PATHS =====
define('DATA_DIR', __DIR__ . '/../data/');
define('USERS_FILE', DATA_DIR . 'users.txt');
define('CONTACTS_FILE', DATA_DIR . 'contacts.txt');

// ===== SECURITY SETTINGS =====
define('PASSWORD_MIN_LENGTH', 8);
define('SESSION_TIMEOUT', 3600); // 1 hour in seconds
define('MAX_LOGIN_ATTEMPTS', 5);
define('LOCKOUT_TIME', 900); // 15 minutes in seconds

// ===== ERROR MESSAGES =====
define('ERROR_INVALID_INPUT', 'Invalid input provided');
define('ERROR_USER_EXISTS', 'User with this email already exists');
define('ERROR_USER_NOT_FOUND', 'User not found');
define('ERROR_INVALID_CREDENTIALS', 'Invalid email or password');
define('ERROR_SESSION_EXPIRED', 'Your session has expired. Please log in again.');
define('ERROR_ACCESS_DENIED', 'Access denied. Please log in to continue.');
define('ERROR_FILE_WRITE', 'Unable to save data. Please try again.');

// ===== SUCCESS MESSAGES =====
define('SUCCESS_REGISTRATION', 'Registration successful! You can now log in.');
define('SUCCESS_LOGIN', 'Login successful! Welcome back.');
define('SUCCESS_LOGOUT', 'You have been logged out successfully.');
define('SUCCESS_CONTACT', 'Your message has been sent successfully. We will get back to you soon.');

// ===== UTILITY FUNCTIONS =====

/**
 * Sanitize input data
 */
function sanitizeInput($data) {
    if (is_array($data)) {
        return array_map('sanitizeInput', $data);
    }
    
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

/**
 * Validate email format
 */
function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Validate phone number format
 */
function isValidPhone($phone) {
    $cleaned = preg_replace('/\D/', '', $phone);
    return strlen($cleaned) >= 10 && strlen($cleaned) <= 15;
}

/**
 * Validate password strength
 */
function isValidPassword($password) {
    if (strlen($password) < PASSWORD_MIN_LENGTH) {
        return false;
    }
    
    // Check for at least one uppercase, one lowercase, and one number
    if (!preg_match('/(?=.*[a-z])(?=.*[A-Z])(?=.*\d)/', $password)) {
        return false;
    }
    
    return true;
}

/**
 * Hash password securely
 */
function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

/**
 * Verify password against hash
 */
function verifyPassword($password, $hash) {
    return password_verify($password, $hash);
}

/**
 * Generate CSRF token
 */
function generateCSRFToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Verify CSRF token
 */
function verifyCSRFToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Check if user is logged in
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']) && isset($_SESSION['user_email']);
}

/**
 * Check session timeout
 */
function checkSessionTimeout() {
    if (isset($_SESSION['last_activity'])) {
        if (time() - $_SESSION['last_activity'] > SESSION_TIMEOUT) {
            session_unset();
            session_destroy();
            return false;
        }
    }
    $_SESSION['last_activity'] = time();
    return true;
}

/**
 * Require login for protected pages
 */
function requireLogin() {
    if (!isLoggedIn() || !checkSessionTimeout()) {
        http_response_code(401);
        echo json_encode(['error' => ERROR_ACCESS_DENIED]);
        exit;
    }
}

/**
 * Log user activity (simple logging)
 */
function logActivity($message) {
    $logFile = DATA_DIR . 'activity.log';
    $timestamp = date('Y-m-d H:i:s');
    $logEntry = "[$timestamp] $message" . PHP_EOL;
    file_put_contents($logFile, $logEntry, FILE_APPEND | LOCK_EX);
}

/**
 * Create data directory if it doesn't exist
 */
function ensureDataDirectory() {
    if (!is_dir(DATA_DIR)) {
        mkdir(DATA_DIR, 0755, true);
    }
}

/**
 * Read users from file
 */
function readUsers() {
    ensureDataDirectory();
    
    if (!file_exists(USERS_FILE)) {
        return [];
    }
    
    $content = file_get_contents(USERS_FILE);
    if ($content === false) {
        return [];
    }
    
    $users = [];
    $lines = explode("\n", trim($content));
    
    foreach ($lines as $line) {
        if (empty($line)) continue;
        
        $userData = json_decode($line, true);
        if ($userData) {
            $users[] = $userData;
        }
    }
    
    return $users;
}

/**
 * Write user to file
 */
function writeUser($userData) {
    ensureDataDirectory();
    
    $userJson = json_encode($userData) . "\n";
    
    if (file_put_contents(USERS_FILE, $userJson, FILE_APPEND | LOCK_EX) === false) {
        return false;
    }
    
    return true;
}

/**
 * Find user by email
 */
function findUserByEmail($email) {
    $users = readUsers();
    
    foreach ($users as $user) {
        if ($user['email'] === $email) {
            return $user;
        }
    }
    
    return null;
}

/**
 * Write contact message to file
 */
function writeContact($contactData) {
    ensureDataDirectory();
    
    $contactJson = json_encode($contactData) . "\n";
    
    if (file_put_contents(CONTACTS_FILE, $contactJson, FILE_APPEND | LOCK_EX) === false) {
        return false;
    }
    
    return true;
}

/**
 * Send JSON response
 */
function sendJsonResponse($data, $statusCode = 200) {
    http_response_code($statusCode);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

/**
 * Send HTML response
 */
function sendHtmlResponse($html, $statusCode = 200) {
    http_response_code($statusCode);
    header('Content-Type: text/html');
    echo $html;
    exit;
}

/**
 * Rate limiting for login attempts
 */
function checkRateLimit($email) {
    if (!isset($_SESSION['login_attempts'])) {
        $_SESSION['login_attempts'] = [];
    }
    
    $attempts = &$_SESSION['login_attempts'];
    $now = time();
    
    // Clean old attempts
    foreach ($attempts as $attemptEmail => $data) {
        if ($now - $data['last_attempt'] > LOCKOUT_TIME) {
            unset($attempts[$attemptEmail]);
        }
    }
    
    // Check current email
    if (isset($attempts[$email])) {
        if ($attempts[$email]['count'] >= MAX_LOGIN_ATTEMPTS) {
            if ($now - $attempts[$email]['last_attempt'] < LOCKOUT_TIME) {
                return false; // Still locked out
            } else {
                unset($attempts[$email]); // Reset after lockout period
            }
        }
    }
    
    return true;
}

/**
 * Record failed login attempt
 */
function recordFailedLogin($email) {
    if (!isset($_SESSION['login_attempts'])) {
        $_SESSION['login_attempts'] = [];
    }
    
    $attempts = &$_SESSION['login_attempts'];
    
    if (!isset($attempts[$email])) {
        $attempts[$email] = ['count' => 0, 'last_attempt' => 0];
    }
    
    $attempts[$email]['count']++;
    $attempts[$email]['last_attempt'] = time();
}

/**
 * Clear login attempts for successful login
 */
function clearLoginAttempts($email) {
    if (isset($_SESSION['login_attempts'][$email])) {
        unset($_SESSION['login_attempts'][$email]);
    }
}

// ===== INITIALIZE APPLICATION =====
// Ensure data directory exists
ensureDataDirectory();

// Set timezone
date_default_timezone_set('America/New_York');

// Set error reporting for development (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

?>
