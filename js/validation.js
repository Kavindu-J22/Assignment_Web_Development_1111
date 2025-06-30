// ===== FORM VALIDATION JAVASCRIPT =====
// This file contains all form validation logic for the FoodExpress website

document.addEventListener('DOMContentLoaded', function() {
    initializeFormValidation();
});

// ===== FORM VALIDATION INITIALIZATION =====
function initializeFormValidation() {
    // Initialize registration form validation
    const registerForm = document.getElementById('registerForm');
    if (registerForm) {
        initializeRegistrationValidation(registerForm);
    }
    
    // Initialize login form validation
    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        initializeLoginValidation(loginForm);
    }
    
    // Initialize contact form validation
    const contactForm = document.getElementById('contactForm');
    if (contactForm) {
        initializeContactValidation(contactForm);
    }
}

// ===== REGISTRATION FORM VALIDATION =====
function initializeRegistrationValidation(form) {
    const fields = {
        fullName: form.querySelector('#fullName'),
        email: form.querySelector('#email'),
        phone: form.querySelector('#phone'),
        address: form.querySelector('#address'),
        password: form.querySelector('#password'),
        confirmPassword: form.querySelector('#confirmPassword'),
        terms: form.querySelector('#terms')
    };
    
    // Real-time validation
    if (fields.fullName) {
        fields.fullName.addEventListener('blur', () => validateFullName(fields.fullName));
        fields.fullName.addEventListener('input', () => clearError('fullNameError'));
    }
    
    if (fields.email) {
        fields.email.addEventListener('blur', () => validateEmail(fields.email));
        fields.email.addEventListener('input', () => clearError('emailError'));
    }
    
    if (fields.phone) {
        fields.phone.addEventListener('blur', () => validatePhone(fields.phone));
        fields.phone.addEventListener('input', () => {
            clearError('phoneError');
            // Format phone number as user types
            fields.phone.value = window.FoodExpress.formatPhoneNumber(fields.phone.value);
        });
    }
    
    if (fields.address) {
        fields.address.addEventListener('blur', () => validateAddress(fields.address));
        fields.address.addEventListener('input', () => clearError('addressError'));
    }
    
    if (fields.password) {
        fields.password.addEventListener('blur', () => validatePassword(fields.password));
        fields.password.addEventListener('input', () => {
            clearError('passwordError');
            // Also validate confirm password if it has a value
            if (fields.confirmPassword && fields.confirmPassword.value) {
                validateConfirmPassword(fields.confirmPassword, fields.password.value);
            }
        });
    }
    
    if (fields.confirmPassword) {
        fields.confirmPassword.addEventListener('blur', () => 
            validateConfirmPassword(fields.confirmPassword, fields.password.value));
        fields.confirmPassword.addEventListener('input', () => clearError('confirmPasswordError'));
    }
    
    if (fields.terms) {
        fields.terms.addEventListener('change', () => validateTerms(fields.terms));
    }
    
    // Form submission
    form.addEventListener('submit', function(event) {
        event.preventDefault();
        
        if (validateRegistrationForm(fields)) {
            submitRegistrationForm(form, fields);
        }
    });
}

// ===== LOGIN FORM VALIDATION =====
function initializeLoginValidation(form) {
    const fields = {
        email: form.querySelector('#email'),
        password: form.querySelector('#password')
    };
    
    // Real-time validation
    if (fields.email) {
        fields.email.addEventListener('blur', () => validateEmail(fields.email));
        fields.email.addEventListener('input', () => clearError('emailError'));
    }
    
    if (fields.password) {
        fields.password.addEventListener('blur', () => validateLoginPassword(fields.password));
        fields.password.addEventListener('input', () => clearError('passwordError'));
    }
    
    // Form submission
    form.addEventListener('submit', function(event) {
        event.preventDefault();
        
        if (validateLoginForm(fields)) {
            submitLoginForm(form, fields);
        }
    });
}

// ===== CONTACT FORM VALIDATION =====
function initializeContactValidation(form) {
    const fields = {
        firstName: form.querySelector('#firstName'),
        lastName: form.querySelector('#lastName'),
        email: form.querySelector('#email'),
        phone: form.querySelector('#phone'),
        subject: form.querySelector('#subject'),
        message: form.querySelector('#message')
    };
    
    // Real-time validation
    if (fields.firstName) {
        fields.firstName.addEventListener('blur', () => validateName(fields.firstName, 'firstNameError'));
        fields.firstName.addEventListener('input', () => clearError('firstNameError'));
    }
    
    if (fields.lastName) {
        fields.lastName.addEventListener('blur', () => validateName(fields.lastName, 'lastNameError'));
        fields.lastName.addEventListener('input', () => clearError('lastNameError'));
    }
    
    if (fields.email) {
        fields.email.addEventListener('blur', () => validateEmail(fields.email));
        fields.email.addEventListener('input', () => clearError('emailError'));
    }
    
    if (fields.phone) {
        fields.phone.addEventListener('blur', () => validateOptionalPhone(fields.phone));
        fields.phone.addEventListener('input', () => {
            clearError('phoneError');
            if (fields.phone.value) {
                fields.phone.value = window.FoodExpress.formatPhoneNumber(fields.phone.value);
            }
        });
    }
    
    if (fields.subject) {
        fields.subject.addEventListener('change', () => validateSubject(fields.subject));
    }
    
    if (fields.message) {
        fields.message.addEventListener('blur', () => validateMessage(fields.message));
        fields.message.addEventListener('input', () => clearError('messageError'));
    }
    
    // Form submission
    form.addEventListener('submit', function(event) {
        event.preventDefault();
        
        if (validateContactForm(fields)) {
            submitContactForm(form, fields);
        }
    });
}

// ===== INDIVIDUAL FIELD VALIDATORS =====
function validateFullName(field) {
    const value = field.value.trim();
    const errorElement = 'fullNameError';
    
    if (!value) {
        showError(errorElement, 'Full name is required');
        return false;
    }
    
    if (value.length < 2) {
        showError(errorElement, 'Full name must be at least 2 characters long');
        return false;
    }
    
    if (!/^[a-zA-Z\s]+$/.test(value)) {
        showError(errorElement, 'Full name can only contain letters and spaces');
        return false;
    }
    
    clearError(errorElement);
    return true;
}

function validateName(field, errorElementId) {
    const value = field.value.trim();
    
    if (!value) {
        showError(errorElementId, 'This field is required');
        return false;
    }
    
    if (value.length < 2) {
        showError(errorElementId, 'Name must be at least 2 characters long');
        return false;
    }
    
    if (!/^[a-zA-Z]+$/.test(value)) {
        showError(errorElementId, 'Name can only contain letters');
        return false;
    }
    
    clearError(errorElementId);
    return true;
}

function validateEmail(field) {
    const value = field.value.trim();
    const errorElement = 'emailError';
    
    if (!value) {
        showError(errorElement, 'Email address is required');
        return false;
    }
    
    if (!window.FoodExpress.isValidEmail(value)) {
        showError(errorElement, 'Please enter a valid email address');
        return false;
    }
    
    clearError(errorElement);
    return true;
}

function validatePhone(field) {
    const value = field.value.trim();
    const errorElement = 'phoneError';

    if (!value) {
        showError(errorElement, 'Phone number is required');
        return false;
    }

    if (!window.FoodExpress.isValidPhone(value)) {
        showError(errorElement, 'Please enter a valid Sri Lankan phone number (e.g., 0771234567 or +94771234567)');
        return false;
    }

    clearError(errorElement);
    return true;
}

function validateOptionalPhone(field) {
    const value = field.value.trim();
    const errorElement = 'phoneError';

    if (value && !window.FoodExpress.isValidPhone(value)) {
        showError(errorElement, 'Please enter a valid Sri Lankan phone number (e.g., 0771234567 or +94771234567)');
        return false;
    }

    clearError(errorElement);
    return true;
}

function validateAddress(field) {
    const value = field.value.trim();
    const errorElement = 'addressError';
    
    if (!value) {
        showError(errorElement, 'Delivery address is required');
        return false;
    }
    
    if (value.length < 10) {
        showError(errorElement, 'Please provide a complete address');
        return false;
    }
    
    clearError(errorElement);
    return true;
}

function validatePassword(field) {
    const value = field.value;
    const errorElement = 'passwordError';
    
    if (!value) {
        showError(errorElement, 'Password is required');
        return false;
    }
    
    if (value.length < 8) {
        showError(errorElement, 'Password must be at least 8 characters long');
        return false;
    }
    
    if (!/(?=.*[a-z])(?=.*[A-Z])(?=.*\d)/.test(value)) {
        showError(errorElement, 'Password must contain at least one uppercase letter, one lowercase letter, and one number');
        return false;
    }
    
    clearError(errorElement);
    return true;
}

function validateLoginPassword(field) {
    const value = field.value;
    const errorElement = 'passwordError';
    
    if (!value) {
        showError(errorElement, 'Password is required');
        return false;
    }
    
    clearError(errorElement);
    return true;
}

function validateConfirmPassword(field, originalPassword) {
    const value = field.value;
    const errorElement = 'confirmPasswordError';
    
    if (!value) {
        showError(errorElement, 'Please confirm your password');
        return false;
    }
    
    if (value !== originalPassword) {
        showError(errorElement, 'Passwords do not match');
        return false;
    }
    
    clearError(errorElement);
    return true;
}

function validateTerms(field) {
    const errorElement = 'termsError';
    
    if (!field.checked) {
        showError(errorElement, 'You must agree to the terms and conditions');
        return false;
    }
    
    clearError(errorElement);
    return true;
}

function validateSubject(field) {
    const value = field.value;
    const errorElement = 'subjectError';
    
    if (!value) {
        showError(errorElement, 'Please select a subject');
        return false;
    }
    
    clearError(errorElement);
    return true;
}

function validateMessage(field) {
    const value = field.value.trim();
    const errorElement = 'messageError';
    
    if (!value) {
        showError(errorElement, 'Message is required');
        return false;
    }
    
    if (value.length < 10) {
        showError(errorElement, 'Message must be at least 10 characters long');
        return false;
    }
    
    clearError(errorElement);
    return true;
}

// ===== FORM VALIDATION FUNCTIONS =====
function validateRegistrationForm(fields) {
    let isValid = true;
    
    if (!validateFullName(fields.fullName)) isValid = false;
    if (!validateEmail(fields.email)) isValid = false;
    if (!validatePhone(fields.phone)) isValid = false;
    if (!validateAddress(fields.address)) isValid = false;
    if (!validatePassword(fields.password)) isValid = false;
    if (!validateConfirmPassword(fields.confirmPassword, fields.password.value)) isValid = false;
    if (!validateTerms(fields.terms)) isValid = false;
    
    return isValid;
}

function validateLoginForm(fields) {
    let isValid = true;
    
    if (!validateEmail(fields.email)) isValid = false;
    if (!validateLoginPassword(fields.password)) isValid = false;
    
    return isValid;
}

function validateContactForm(fields) {
    let isValid = true;
    
    if (!validateName(fields.firstName, 'firstNameError')) isValid = false;
    if (!validateName(fields.lastName, 'lastNameError')) isValid = false;
    if (!validateEmail(fields.email)) isValid = false;
    if (!validateOptionalPhone(fields.phone)) isValid = false;
    if (!validateSubject(fields.subject)) isValid = false;
    if (!validateMessage(fields.message)) isValid = false;
    
    return isValid;
}

// ===== FORM SUBMISSION FUNCTIONS =====
function submitRegistrationForm(form, fields) {
    const submitButton = form.querySelector('button[type="submit"]');
    window.FoodExpress.showLoading(submitButton);
    
    // Create FormData object
    const formData = new FormData(form);
    
    // Submit form
    fetch(form.action, {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        window.FoodExpress.hideLoading(submitButton);
        
        if (data.includes('success') || data.includes('registered')) {
            window.FoodExpress.showModal('successModal');
            form.reset();
        } else {
            window.FoodExpress.showToast('Registration failed. Please try again.', 'error');
        }
    })
    .catch(error => {
        window.FoodExpress.hideLoading(submitButton);
        console.error('Registration error:', error);
        window.FoodExpress.showToast('An error occurred. Please try again.', 'error');
    });
}

function submitLoginForm(form, fields) {
    const submitButton = form.querySelector('button[type="submit"]');
    window.FoodExpress.showLoading(submitButton);

    // Create FormData object
    const formData = new FormData(form);

    // Submit form
    fetch(form.action, {
        method: 'POST',
        body: formData,
        credentials: 'same-origin'
    })
    .then(response => response.json())
    .then(data => {
        window.FoodExpress.hideLoading(submitButton);

        if (data.success) {
            // Login successful
            window.FoodExpress.showToast('Login successful! Redirecting...', 'success');

            // Update navigation immediately
            if (window.FoodExpress.updateNavigationForLoggedInUser) {
                window.FoodExpress.updateNavigationForLoggedInUser(data.user);
            }

            // Redirect to profile page
            setTimeout(() => {
                window.location.href = 'profile.html';
            }, 1000);
        } else {
            // Login failed
            if (data.lockout) {
                window.FoodExpress.showToast('Too many failed attempts. Please try again later.', 'error');
            } else {
                window.FoodExpress.showModal('errorModal');
            }
        }
    })
    .catch(error => {
        window.FoodExpress.hideLoading(submitButton);
        console.error('Login error:', error);
        window.FoodExpress.showToast('An error occurred. Please try again.', 'error');
    });
}

function submitContactForm(form, fields) {
    const submitButton = form.querySelector('button[type="submit"]');
    window.FoodExpress.showLoading(submitButton);
    
    // Create FormData object
    const formData = new FormData(form);
    
    // Submit form
    fetch(form.action, {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        window.FoodExpress.hideLoading(submitButton);
        
        if (data.includes('success') || data.includes('sent')) {
            window.FoodExpress.showModal('successModal');
            form.reset();
        } else {
            window.FoodExpress.showToast('Failed to send message. Please try again.', 'error');
        }
    })
    .catch(error => {
        window.FoodExpress.hideLoading(submitButton);
        console.error('Contact form error:', error);
        window.FoodExpress.showToast('An error occurred. Please try again.', 'error');
    });
}

// ===== UTILITY FUNCTIONS =====
function showError(elementId, message) {
    const errorElement = document.getElementById(elementId);
    if (errorElement) {
        errorElement.textContent = message;
        errorElement.style.display = 'block';
        
        // Add error styling to input
        const input = errorElement.parentElement.querySelector('.form-input');
        if (input) {
            input.style.borderColor = 'var(--error-color)';
        }
    }
}

function clearError(elementId) {
    const errorElement = document.getElementById(elementId);
    if (errorElement) {
        errorElement.textContent = '';
        errorElement.style.display = 'none';
        
        // Remove error styling from input
        const input = errorElement.parentElement.querySelector('.form-input');
        if (input) {
            input.style.borderColor = '';
        }
    }
}
