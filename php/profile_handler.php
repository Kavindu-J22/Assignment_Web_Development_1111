<?php
// ===== PROFILE HANDLER =====
// This file handles user profile display and management for the FoodExpress application

require_once 'config.php';

// Check if user is logged in and session is valid
if (!isLoggedIn() || !checkSessionTimeout()) {
    // Always return 401 for unauthorized access
    http_response_code(401);
    echo json_encode(['error' => ERROR_ACCESS_DENIED]);
    exit;
}

try {
    // Get user data
    $user = findUserByEmail($_SESSION['user_email']);

    if (!$user) {
        // User not found, destroy session
        session_unset();
        session_destroy();

        http_response_code(404);
        echo json_encode(['error' => ERROR_USER_NOT_FOUND]);
        exit;
    }

    // Handle different request methods
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        // Return profile HTML content
        $profileHtml = generateProfileHTML($user);
        echo $profileHtml;
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Handle profile updates (if implemented)
        handleProfileUpdate($user);
    } else {
        http_response_code(405);
        echo json_encode(['error' => 'Method not allowed']);
    }
} catch (Exception $e) {
    // Log the error
    error_log("Profile error: " . $e->getMessage());

    // Return generic error response
    http_response_code(500);
    echo json_encode(['error' => 'An unexpected error occurred. Please try again.']);
}

/**
 * Generate profile HTML content
 */
function generateProfileHTML($user)
{
    $lastLogin = $user['lastLogin'] ? date('F j, Y g:i A', strtotime($user['lastLogin'])) : 'First time login';
    $memberSince = date('F j, Y', strtotime($user['registrationDate']));

    return '
    <div class="profile-container">
        <div class="profile-header">
            <div class="profile-avatar">
                <i class="fas fa-user-circle"></i>
            </div>
            <div class="profile-info">
                <h1 class="profile-name">' . htmlspecialchars($user['fullName']) . '</h1>
                <p class="profile-email">' . htmlspecialchars($user['email']) . '</p>
                <span class="profile-status">
                    <i class="fas fa-check-circle"></i>
                    Active Member
                </span>
            </div>
            <div class="profile-actions">
                <button class="btn btn-secondary" onclick="editProfile()">
                    <i class="fas fa-edit"></i>
                    Edit Profile
                </button>
                <button class="btn btn-primary" onclick="logout()">
                    <i class="fas fa-sign-out-alt"></i>
                    Logout
                </button>
            </div>
        </div>
        
        <div class="profile-content">
            <div class="profile-section">
                <h2 class="section-title">Personal Information</h2>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-user"></i>
                            Full Name
                        </div>
                        <div class="info-value">' . htmlspecialchars($user['fullName']) . '</div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-envelope"></i>
                            Email Address
                        </div>
                        <div class="info-value">' . htmlspecialchars($user['email']) . '</div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-phone"></i>
                            Phone Number
                        </div>
                        <div class="info-value">' . htmlspecialchars($user['phone']) . '</div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-map-marker-alt"></i>
                            Delivery Address
                        </div>
                        <div class="info-value">' . htmlspecialchars($user['address']) . '</div>
                    </div>
                </div>
            </div>
            
            <div class="profile-section">
                <h2 class="section-title">Account Details</h2>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-calendar-alt"></i>
                            Member Since
                        </div>
                        <div class="info-value">' . $memberSince . '</div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-clock"></i>
                            Last Login
                        </div>
                        <div class="info-value">' . $lastLogin . '</div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-shield-alt"></i>
                            Account Status
                        </div>
                        <div class="info-value">
                            <span class="status-badge status-active">
                                <i class="fas fa-check"></i>
                                Active
                            </span>
                        </div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-key"></i>
                            Password
                        </div>
                        <div class="info-value">
                            <button class="btn btn-sm btn-secondary" onclick="changePassword()">
                                Change Password
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="profile-section">
                <h2 class="section-title">Order History</h2>
                <div class="order-history">
                    <div class="empty-state">
                        <i class="fas fa-shopping-bag"></i>
                        <h3>No Orders Yet</h3>
                        <p>You haven\'t placed any orders yet. Start exploring our restaurants!</p>
                        <a href="../index.html" class="btn btn-primary">
                            <i class="fas fa-utensils"></i>
                            Browse Restaurants
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="profile-section">
                <h2 class="section-title">Preferences</h2>
                <div class="preferences-grid">
                    <div class="preference-item">
                        <div class="preference-label">
                            <i class="fas fa-bell"></i>
                            Email Notifications
                        </div>
                        <div class="preference-control">
                            <label class="switch">
                                <input type="checkbox" checked>
                                <span class="slider"></span>
                            </label>
                        </div>
                    </div>
                    
                    <div class="preference-item">
                        <div class="preference-label">
                            <i class="fas fa-mobile-alt"></i>
                            SMS Notifications
                        </div>
                        <div class="preference-control">
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                        </div>
                    </div>
                    
                    <div class="preference-item">
                        <div class="preference-label">
                            <i class="fas fa-heart"></i>
                            Save Favorites
                        </div>
                        <div class="preference-control">
                            <label class="switch">
                                <input type="checkbox" checked>
                                <span class="slider"></span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <style>
    .profile-container {
        max-width: 1000px;
        margin: 0 auto;
        padding: var(--spacing-xl);
    }
    
    .profile-header {
        display: flex;
        align-items: center;
        gap: var(--spacing-xl);
        background: var(--bg-primary);
        padding: var(--spacing-xl);
        border-radius: var(--border-radius-lg);
        box-shadow: var(--shadow-sm);
        margin-bottom: var(--spacing-xl);
    }
    
    .profile-avatar i {
        font-size: 4rem;
        color: var(--primary-color);
    }
    
    .profile-name {
        font-size: var(--font-size-2xl);
        margin-bottom: var(--spacing-sm);
    }
    
    .profile-email {
        color: var(--text-secondary);
        margin-bottom: var(--spacing-sm);
    }
    
    .profile-status {
        display: inline-flex;
        align-items: center;
        gap: var(--spacing-xs);
        color: var(--success-color);
        font-weight: 500;
    }
    
    .profile-actions {
        margin-left: auto;
        display: flex;
        gap: var(--spacing-md);
    }
    
    .profile-section {
        background: var(--bg-primary);
        padding: var(--spacing-xl);
        border-radius: var(--border-radius-lg);
        box-shadow: var(--shadow-sm);
        margin-bottom: var(--spacing-xl);
    }
    
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: var(--spacing-lg);
    }
    
    .info-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: var(--spacing-md);
        border: 1px solid var(--border-light);
        border-radius: var(--border-radius-md);
    }
    
    .info-label {
        display: flex;
        align-items: center;
        gap: var(--spacing-sm);
        font-weight: 500;
        color: var(--text-secondary);
    }
    
    .info-value {
        font-weight: 500;
        color: var(--text-primary);
    }
    
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: var(--spacing-xs);
        padding: var(--spacing-xs) var(--spacing-sm);
        border-radius: var(--border-radius-sm);
        font-size: var(--font-size-sm);
        font-weight: 500;
    }
    
    .status-active {
        background-color: rgba(39, 174, 96, 0.1);
        color: var(--success-color);
    }
    
    .empty-state {
        text-align: center;
        padding: var(--spacing-xxl);
        color: var(--text-secondary);
    }
    
    .empty-state i {
        font-size: 3rem;
        margin-bottom: var(--spacing-lg);
        opacity: 0.5;
    }
    
    .preferences-grid {
        display: grid;
        gap: var(--spacing-lg);
    }
    
    .preference-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: var(--spacing-md);
        border: 1px solid var(--border-light);
        border-radius: var(--border-radius-md);
    }
    
    .switch {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 24px;
    }
    
    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }
    
    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 24px;
    }
    
    .slider:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }
    
    input:checked + .slider {
        background-color: var(--primary-color);
    }
    
    input:checked + .slider:before {
        transform: translateX(26px);
    }
    
    @media (max-width: 768px) {
        .profile-header {
            flex-direction: column;
            text-align: center;
        }
        
        .profile-actions {
            margin-left: 0;
        }
        
        .info-grid {
            grid-template-columns: 1fr;
        }
        
        .info-item {
            flex-direction: column;
            align-items: flex-start;
            gap: var(--spacing-sm);
        }
    }
    </style>
    
    <script>
    function editProfile() {
        alert("Profile editing feature coming soon!");
    }
    
    function changePassword() {
        alert("Password change feature coming soon!");
    }
    
    function logout() {
        if (confirm("Are you sure you want to logout?")) {
            fetch("php/logout_handler.php", {
                method: "POST"
            })
            .then(() => {
                window.location.href = "index.html";
            })
            .catch(() => {
                window.location.href = "index.html";
            });
        }
    }
    </script>
    ';
}

/**
 * Handle profile updates (placeholder for future implementation)
 */
function handleProfileUpdate($user)
{
    // This would handle profile updates
    // For now, just return a placeholder response
    echo json_encode(['message' => 'Profile update feature coming soon!']);
}
