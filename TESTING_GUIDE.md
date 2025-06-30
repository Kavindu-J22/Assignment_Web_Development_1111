# FoodExpress Testing Guide

This document provides comprehensive testing instructions for the FoodExpress web application.

## Prerequisites

Before testing, ensure you have:
1. A local web server (XAMPP, WAMP, or similar) with PHP support
2. The project files placed in your web server's document root
3. PHP 7.4 or higher
4. Modern web browser (Chrome, Firefox, Safari, Edge)

## Setup Instructions

1. **Install Web Server**
   - Download and install XAMPP from https://www.apachefriends.org/
   - Start Apache and PHP services

2. **Deploy Application**
   - Copy all project files to `htdocs` folder (XAMPP) or `www` folder (WAMP)
   - Ensure proper folder structure is maintained

3. **Verify Setup**
   - Open browser and navigate to `http://localhost/Assignment_Web_Development_1111/`
   - You should see the FoodExpress homepage

## Testing Checklist

### 1. Homepage Testing (index.html)

**Visual Elements:**
- [ ] Logo and navigation bar display correctly
- [ ] Hero section with title and description
- [ ] Features section with 4 feature cards
- [ ] Popular restaurants section
- [ ] Footer with contact information

**Functionality:**
- [ ] Navigation links work correctly
- [ ] Theme toggle button switches between light/dark mode
- [ ] Mobile menu opens/closes on small screens
- [ ] Smooth scrolling to sections
- [ ] All buttons have hover effects

**Responsive Design:**
- [ ] Test on desktop (1920x1080)
- [ ] Test on tablet (768x1024)
- [ ] Test on mobile (375x667)
- [ ] Navigation collapses to hamburger menu on mobile
- [ ] Content stacks properly on smaller screens

### 2. Registration Page Testing (register.html)

**Form Validation:**
- [ ] Full name validation (required, min 2 chars, letters only)
- [ ] Email validation (required, valid format, unique)
- [ ] Phone validation (required, valid format)
- [ ] Address validation (required, min 10 chars)
- [ ] Password validation (required, min 8 chars, complexity)
- [ ] Confirm password validation (matches password)
- [ ] Terms checkbox validation (required)

**User Experience:**
- [ ] Password show/hide toggle works
- [ ] Real-time validation messages appear
- [ ] Form submission shows loading state
- [ ] Success modal appears on successful registration
- [ ] Error handling for server errors

**Test Cases:**
1. **Valid Registration:**
   - Fill all fields with valid data
   - Check terms checkbox
   - Submit form
   - Verify success message and redirect option

2. **Invalid Data:**
   - Test each field with invalid data
   - Verify appropriate error messages
   - Ensure form doesn't submit with errors

3. **Duplicate Email:**
   - Register with same email twice
   - Verify error message about existing user

### 3. Login Page Testing (login.html)

**Form Validation:**
- [ ] Email validation (required, valid format)
- [ ] Password validation (required)
- [ ] Remember me checkbox functionality

**Authentication Flow:**
- [ ] Valid credentials allow login
- [ ] Invalid credentials show error
- [ ] Rate limiting after multiple failed attempts
- [ ] Session creation on successful login
- [ ] Redirect to profile page after login

**Test Cases:**
1. **Valid Login:**
   - Use registered email and password
   - Verify successful login and redirect

2. **Invalid Credentials:**
   - Test wrong email
   - Test wrong password
   - Verify error messages

3. **Rate Limiting:**
   - Attempt 6+ failed logins
   - Verify lockout message

### 4. Profile Page Testing (profile.html)

**Access Control:**
- [ ] Redirects to login if not authenticated
- [ ] Displays user information when logged in
- [ ] Session timeout handling

**Content Display:**
- [ ] User's personal information
- [ ] Account details and status
- [ ] Order history (empty state)
- [ ] Preferences toggles

**Functionality:**
- [ ] Logout button works
- [ ] Profile editing buttons (placeholder)
- [ ] Preference toggles work
- [ ] Responsive design on all devices

### 5. Contact Page Testing (contact.html)

**Form Validation:**
- [ ] First name validation (required, min 2 chars, letters only)
- [ ] Last name validation (required, min 2 chars, letters only)
- [ ] Email validation (required, valid format)
- [ ] Phone validation (optional, valid format if provided)
- [ ] Subject validation (required, valid option)
- [ ] Message validation (required, min 10 chars)

**User Experience:**
- [ ] Form submission shows loading state
- [ ] Success modal on successful submission
- [ ] Error handling for server errors
- [ ] Newsletter subscription checkbox

**Content:**
- [ ] Contact information display
- [ ] FAQ section
- [ ] Responsive design

### 6. JavaScript Functionality Testing

**Theme Toggle:**
- [ ] Switches between light and dark themes
- [ ] Saves preference in localStorage
- [ ] Applies saved theme on page reload

**Form Validation:**
- [ ] Real-time validation on blur
- [ ] Error message display/clearing
- [ ] Password strength indicators
- [ ] Phone number formatting

**Modal Functionality:**
- [ ] Modals open/close correctly
- [ ] Close on outside click
- [ ] Close on Escape key
- [ ] Prevent background scrolling

**Mobile Navigation:**
- [ ] Hamburger menu toggle
- [ ] Menu closes on link click
- [ ] Menu closes on outside click

### 7. PHP Backend Testing

**Registration Handler:**
- [ ] Validates all input fields
- [ ] Prevents duplicate registrations
- [ ] Hashes passwords securely
- [ ] Saves user data to file
- [ ] Returns appropriate responses

**Login Handler:**
- [ ] Validates credentials
- [ ] Creates secure sessions
- [ ] Implements rate limiting
- [ ] Handles remember me functionality
- [ ] Logs user activity

**Profile Handler:**
- [ ] Requires authentication
- [ ] Displays user information
- [ ] Handles session timeout
- [ ] Returns proper error codes

**Contact Handler:**
- [ ] Validates form data
- [ ] Saves messages to file
- [ ] Handles optional fields
- [ ] Logs submissions

### 8. Security Testing

**Input Validation:**
- [ ] XSS prevention (script injection)
- [ ] SQL injection prevention (if using database)
- [ ] CSRF token validation
- [ ] Input sanitization

**Session Security:**
- [ ] Session timeout implementation
- [ ] Secure session configuration
- [ ] Proper logout functionality
- [ ] Session hijacking prevention

**File Security:**
- [ ] Data directory protection (.htaccess)
- [ ] Sensitive file access prevention
- [ ] Proper error handling

### 9. Performance Testing

**Page Load Times:**
- [ ] Homepage loads under 3 seconds
- [ ] Form pages load quickly
- [ ] CSS and JS files load efficiently

**Resource Optimization:**
- [ ] Images are appropriately sized
- [ ] CSS is minified (if applicable)
- [ ] JavaScript is optimized

### 10. Cross-Browser Testing

Test on multiple browsers:
- [ ] Google Chrome (latest)
- [ ] Mozilla Firefox (latest)
- [ ] Microsoft Edge (latest)
- [ ] Safari (if available)

### 11. Accessibility Testing

**Keyboard Navigation:**
- [ ] All interactive elements are keyboard accessible
- [ ] Tab order is logical
- [ ] Focus indicators are visible

**Screen Reader Compatibility:**
- [ ] Proper heading structure
- [ ] Alt text for images
- [ ] Form labels are associated correctly

## Common Issues and Solutions

### Issue: PHP files not executing
**Solution:** Ensure web server is running and PHP is enabled

### Issue: Data not saving
**Solution:** Check file permissions on data directory

### Issue: Session not working
**Solution:** Verify PHP session configuration

### Issue: Responsive design broken
**Solution:** Check CSS media queries and viewport meta tag

### Issue: JavaScript errors
**Solution:** Check browser console for error messages

## Test Data

Use this sample data for testing:

**Valid User Registration:**
- Name: John Doe
- Email: john.doe@example.com
- Phone: (555) 123-4567
- Address: 123 Main Street, Anytown, ST 12345
- Password: SecurePass123

**Valid Contact Form:**
- First Name: Jane
- Last Name: Smith
- Email: jane.smith@example.com
- Phone: (555) 987-6543
- Subject: General Inquiry
- Message: This is a test message for the contact form.

## Reporting Issues

When reporting issues, include:
1. Browser and version
2. Operating system
3. Steps to reproduce
4. Expected vs actual behavior
5. Screenshots if applicable
6. Console error messages

## Success Criteria

The application passes testing if:
- All forms validate correctly
- User registration and login work
- Profile page displays user data
- Contact form submissions are saved
- Responsive design works on all devices
- No security vulnerabilities found
- Cross-browser compatibility confirmed
