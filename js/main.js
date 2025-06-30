// ===== MAIN JAVASCRIPT FILE =====
// This file contains core functionality for the FoodExpress website

document.addEventListener('DOMContentLoaded', function() {
    // Initialize all components
    initializeNavigation();
    initializeThemeToggle();
    initializeModals();
    initializePasswordToggles();
    initializeFormAnimations();
    checkLoginStatus();

    console.log('FoodExpress website initialized successfully!');
});

// ===== NAVIGATION FUNCTIONALITY =====
function initializeNavigation() {
    const mobileMenu = document.getElementById('mobile-menu');
    const navMenu = document.querySelector('.nav-menu');
    
    if (mobileMenu && navMenu) {
        mobileMenu.addEventListener('click', function() {
            mobileMenu.classList.toggle('active');
            navMenu.classList.toggle('active');
        });
        
        // Close mobile menu when clicking on nav links
        const navLinks = document.querySelectorAll('.nav-link');
        navLinks.forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.classList.remove('active');
                navMenu.classList.remove('active');
            });
        });
        
        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            if (!mobileMenu.contains(event.target) && !navMenu.contains(event.target)) {
                mobileMenu.classList.remove('active');
                navMenu.classList.remove('active');
            }
        });
    }
}

// ===== THEME TOGGLE FUNCTIONALITY =====
function initializeThemeToggle() {
    const themeToggle = document.getElementById('theme-toggle');
    const themeIcon = themeToggle?.querySelector('i');
    
    // Check for saved theme preference or default to light mode
    const currentTheme = localStorage.getItem('theme') || 'light';
    document.documentElement.setAttribute('data-theme', currentTheme);
    
    // Update icon based on current theme
    if (themeIcon) {
        themeIcon.className = currentTheme === 'dark' ? 'fas fa-sun' : 'fas fa-moon';
    }
    
    if (themeToggle) {
        themeToggle.addEventListener('click', function() {
            const currentTheme = document.documentElement.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            
            document.documentElement.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            
            // Update icon
            if (themeIcon) {
                themeIcon.className = newTheme === 'dark' ? 'fas fa-sun' : 'fas fa-moon';
            }
            
            // Add transition effect
            document.body.style.transition = 'background-color 0.3s ease, color 0.3s ease';
            setTimeout(() => {
                document.body.style.transition = '';
            }, 300);
        });
    }
}

// ===== MODAL FUNCTIONALITY =====
function initializeModals() {
    const modals = document.querySelectorAll('.modal');
    
    modals.forEach(modal => {
        const closeBtn = modal.querySelector('.close');
        const closeButtons = modal.querySelectorAll('[id*="close"], [id*="Close"]');
        
        // Close modal when clicking close button
        if (closeBtn) {
            closeBtn.addEventListener('click', () => closeModal(modal));
        }
        
        // Close modal when clicking other close buttons
        closeButtons.forEach(btn => {
            btn.addEventListener('click', () => closeModal(modal));
        });
        
        // Close modal when clicking outside
        modal.addEventListener('click', function(event) {
            if (event.target === modal) {
                closeModal(modal);
            }
        });
        
        // Close modal with Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' && modal.classList.contains('show')) {
                closeModal(modal);
            }
        });
    });
}

function showModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.add('show');
        document.body.style.overflow = 'hidden'; // Prevent background scrolling
        
        // Focus on the modal for accessibility
        modal.focus();
    }
}

function closeModal(modal) {
    if (modal) {
        modal.classList.remove('show');
        document.body.style.overflow = ''; // Restore scrolling
    }
}

// ===== PASSWORD TOGGLE FUNCTIONALITY =====
function initializePasswordToggles() {
    const passwordToggles = document.querySelectorAll('.password-toggle');
    
    passwordToggles.forEach(toggle => {
        toggle.addEventListener('click', function() {
            const passwordInput = this.parentElement.querySelector('input[type="password"], input[type="text"]');
            const icon = this.querySelector('i');
            
            if (passwordInput) {
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    icon.className = 'fas fa-eye-slash';
                } else {
                    passwordInput.type = 'password';
                    icon.className = 'fas fa-eye';
                }
            }
        });
    });
}

// ===== FORM ANIMATIONS =====
function initializeFormAnimations() {
    const formInputs = document.querySelectorAll('.form-input');
    
    formInputs.forEach(input => {
        // Add focus animation
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('focused');
        });
        
        input.addEventListener('blur', function() {
            if (!this.value) {
                this.parentElement.classList.remove('focused');
            }
        });
        
        // Check if input has value on page load
        if (input.value) {
            input.parentElement.classList.add('focused');
        }
    });
}

// ===== UTILITY FUNCTIONS =====

// Show loading state on buttons
function showLoading(button) {
    if (button) {
        button.classList.add('loading');
        button.disabled = true;
    }
}

function hideLoading(button) {
    if (button) {
        button.classList.remove('loading');
        button.disabled = false;
    }
}

// Show toast notifications
function showToast(message, type = 'info') {
    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.innerHTML = `
        <div class="toast-content">
            <i class="fas fa-${getToastIcon(type)}"></i>
            <span>${message}</span>
        </div>
    `;
    
    document.body.appendChild(toast);
    
    // Show toast
    setTimeout(() => toast.classList.add('show'), 100);
    
    // Hide toast after 3 seconds
    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => document.body.removeChild(toast), 300);
    }, 3000);
}

function getToastIcon(type) {
    switch (type) {
        case 'success': return 'check-circle';
        case 'error': return 'exclamation-circle';
        case 'warning': return 'exclamation-triangle';
        default: return 'info-circle';
    }
}

// Smooth scroll to element
function smoothScrollTo(elementId) {
    const element = document.getElementById(elementId);
    if (element) {
        element.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    }
}

// Format phone number (Sri Lankan format)
function formatPhoneNumber(phoneNumber) {
    const cleaned = phoneNumber.replace(/\D/g, '');

    // Format mobile numbers (07XXXXXXXX)
    if (cleaned.length === 10 && cleaned.startsWith('07')) {
        return cleaned.replace(/^(\d{3})(\d{3})(\d{4})$/, '$1 $2 $3');
    }

    // Format landline numbers (0XXXXXXXXX)
    if (cleaned.length === 10 && cleaned.startsWith('0')) {
        return cleaned.replace(/^(\d{3})(\d{3})(\d{4})$/, '$1 $2 $3');
    }

    // Format international mobile (+94 7XXXXXXXX)
    if (cleaned.length === 11 && cleaned.startsWith('947')) {
        return '+94 ' + cleaned.substring(2).replace(/^(\d{2})(\d{3})(\d{4})$/, '$1 $2 $3');
    }

    // Format international landline (+94 XXXXXXXXX)
    if (cleaned.length === 11 && cleaned.startsWith('94')) {
        return '+94 ' + cleaned.substring(2).replace(/^(\d{2})(\d{3})(\d{4})$/, '$1 $2 $3');
    }

    return phoneNumber;
}

// Validate email format
function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// Validate phone number format (Sri Lankan format)
function isValidPhone(phone) {
    // Remove all non-digit characters
    const cleaned = phone.replace(/\D/g, '');

    // Sri Lankan phone number patterns:
    // Mobile: 07XXXXXXXX (10 digits) or +94 7XXXXXXXX (12 digits with country code)
    // Landline: 0XXXXXXXXX (10 digits) or +94 XXXXXXXXX (12 digits with country code)

    // Check for mobile numbers starting with 07
    if (/^07[0-9]{8}$/.test(cleaned)) {
        return true;
    }

    // Check for international format mobile +94 7XXXXXXXX
    if (/^947[0-9]{8}$/.test(cleaned)) {
        return true;
    }

    // Check for landline numbers (Sri Lankan area codes)
    if (/^0(11|21|23|24|25|26|27|31|32|33|34|35|36|37|38|41|45|47|51|52|54|55|57|63|65|66|67|81|91)[0-9]{7}$/.test(cleaned)) {
        return true;
    }

    // Check for international format landline +94 XXXXXXXXX
    if (/^94(11|21|23|24|25|26|27|31|32|33|34|35|36|37|38|41|45|47|51|52|54|55|57|63|65|66|67|81|91)[0-9]{7}$/.test(cleaned)) {
        return true;
    }

    return false;
}

// Debounce function for search/input
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Local storage helpers
function setLocalStorage(key, value) {
    try {
        localStorage.setItem(key, JSON.stringify(value));
    } catch (error) {
        console.error('Error saving to localStorage:', error);
    }
}

function getLocalStorage(key) {
    try {
        const item = localStorage.getItem(key);
        return item ? JSON.parse(item) : null;
    } catch (error) {
        console.error('Error reading from localStorage:', error);
        return null;
    }
}

// ===== GLOBAL ERROR HANDLER =====
window.addEventListener('error', function(event) {
    console.error('Global error:', event.error);
    // You can add error reporting here
});

// ===== LOGIN STATUS MANAGEMENT =====
function checkLoginStatus() {
    // Check if we're on a page that needs login status
    const currentPage = window.location.pathname.split('/').pop();

    // Skip login check for login and register pages
    if (currentPage === 'login.html' || currentPage === 'register.html') {
        return;
    }

    // Check login status via PHP
    fetch('php/check_login_status.php', {
        method: 'GET',
        credentials: 'same-origin'
    })
    .then(response => response.json())
    .then(data => {
        if (data.loggedIn) {
            updateNavigationForLoggedInUser(data.user);
        } else {
            updateNavigationForGuestUser();
        }
    })
    .catch(error => {
        console.log('Login status check failed:', error);
        updateNavigationForGuestUser();
    });
}

function updateNavigationForLoggedInUser(user) {
    const navMenu = document.querySelector('.nav-menu');
    if (!navMenu) return;

    // Hide login and register links
    const loginLink = navMenu.querySelector('a[href="login.html"]');
    const registerLink = navMenu.querySelector('a[href="register.html"]');

    if (loginLink) loginLink.parentElement.style.display = 'none';
    if (registerLink) registerLink.parentElement.style.display = 'none';

    // Add user menu if it doesn't exist
    let userMenu = navMenu.querySelector('.user-menu');
    if (!userMenu) {
        const userMenuItem = document.createElement('li');
        userMenuItem.className = 'nav-item user-menu';
        userMenuItem.innerHTML = `
            <a href="profile.html" class="nav-link">
                <i class="fas fa-user"></i> ${user ? user.name : 'Profile'}
            </a>
        `;
        navMenu.appendChild(userMenuItem);

        const logoutMenuItem = document.createElement('li');
        logoutMenuItem.className = 'nav-item logout-menu';
        logoutMenuItem.innerHTML = `
            <a href="#" class="nav-link" onclick="logout()">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        `;
        navMenu.appendChild(logoutMenuItem);
    }
}

function updateNavigationForGuestUser() {
    const navMenu = document.querySelector('.nav-menu');
    if (!navMenu) return;

    // Show login and register links
    const loginLink = navMenu.querySelector('a[href="login.html"]');
    const registerLink = navMenu.querySelector('a[href="register.html"]');

    if (loginLink) loginLink.parentElement.style.display = 'block';
    if (registerLink) registerLink.parentElement.style.display = 'block';

    // Remove user menu if it exists
    const userMenu = navMenu.querySelector('.user-menu');
    const logoutMenu = navMenu.querySelector('.logout-menu');

    if (userMenu) userMenu.remove();
    if (logoutMenu) logoutMenu.remove();
}

function logout() {
    if (confirm('Are you sure you want to logout?')) {
        fetch('php/logout_handler.php', {
            method: 'POST',
            credentials: 'same-origin'
        })
        .then(() => {
            updateNavigationForGuestUser();
            window.location.href = 'index.html';
        })
        .catch(() => {
            // Even if logout fails, redirect to home
            window.location.href = 'index.html';
        });
    }
}

// ===== EXPORT FUNCTIONS FOR OTHER SCRIPTS =====
window.FoodExpress = {
    showModal,
    closeModal,
    showLoading,
    hideLoading,
    showToast,
    smoothScrollTo,
    formatPhoneNumber,
    isValidEmail,
    isValidPhone,
    debounce,
    setLocalStorage,
    getLocalStorage,
    checkLoginStatus,
    updateNavigationForLoggedInUser,
    updateNavigationForGuestUser,
    logout
};
