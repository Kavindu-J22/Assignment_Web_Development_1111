# FoodExpress Troubleshooting Guide

## 🚨 **Fixing "Internal Server Error"**

### Step 1: Test PHP Installation
1. First, test if PHP is working by visiting: `http://localhost/Assignment_Web_Development_1111/test.php`
2. If this shows a PHP test page, PHP is working correctly
3. If you get an error, PHP is not properly configured

### Step 2: Check XAMPP Configuration
1. **Start XAMPP Control Panel**
2. **Start Apache** (should show green "Running")
3. **Start MySQL** (optional, but recommended)
4. Click **Admin** next to Apache to open `http://localhost/`

### Step 3: Verify File Placement
Ensure your files are in the correct location:
```
C:\xampp\htdocs\Assignment_Web_Development_1111\
├── index.html
├── css/
├── js/
├── php/
└── data/
```

### Step 4: Fix .htaccess Issues
If the error persists, temporarily rename `.htaccess` files:
1. Rename `.htaccess` to `.htaccess.backup`
2. Rename `data/.htaccess` to `data/.htaccess.backup`
3. Try accessing the site again

### Step 5: Check File Permissions (Windows)
1. Right-click on the `Assignment_Web_Development_1111` folder
2. Select **Properties** → **Security**
3. Ensure **Users** have **Full Control**

### Step 6: Enable Error Reporting
Create a file called `debug.php` with this content:
```php
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "Error reporting enabled. Now try accessing index.html";
?>
```

## 📱 **Sri Lankan Phone Number Validation**

### Supported Formats:
- **Mobile Numbers:**
  - `0771234567` (Dialog, Hutch, Airtel)
  - `0701234567` (Mobitel)
  - `0751234567` (Dialog)
  - `+94771234567` (International format)

- **Landline Numbers:**
  - `0112345678` (Colombo)
  - `0212345678` (Kandy)
  - `0312345678` (Negombo)
  - `+94112345678` (International format)

### Valid Area Codes:
- **Colombo:** 011
- **Kandy:** 081
- **Galle:** 091
- **Negombo:** 031
- **Kurunegala:** 037
- **Anuradhapura:** 025
- **Ratnapura:** 045
- **Badulla:** 055
- **Batticaloa:** 065
- **Jaffna:** 021

### Test Phone Numbers:
Use these for testing:
- `0771234567` (Valid mobile)
- `0112345678` (Valid Colombo landline)
- `+94771234567` (Valid international mobile)
- `1234567890` (Invalid - will show error)

## 🔧 **Common Solutions**

### Problem: "Internal Server Error"
**Solutions:**
1. Check if Apache is running in XAMPP
2. Verify PHP is enabled
3. Check file permissions
4. Temporarily disable .htaccess files
5. Check Apache error logs

### Problem: "Page Not Found"
**Solutions:**
1. Verify URL: `http://localhost/Assignment_Web_Development_1111/`
2. Check file placement in htdocs folder
3. Ensure index.html exists

### Problem: "PHP files download instead of executing"
**Solutions:**
1. Restart Apache in XAMPP
2. Check PHP module is loaded
3. Verify .php files are in correct location

### Problem: "Permission Denied"
**Solutions:**
1. Run XAMPP as Administrator
2. Check folder permissions
3. Ensure data directory is writable

### Problem: "Session not working"
**Solutions:**
1. Check if sessions are enabled in PHP
2. Verify session directory is writable
3. Clear browser cookies

## 📋 **Quick Setup Checklist**

- [ ] XAMPP installed and running
- [ ] Apache service started (green in XAMPP)
- [ ] Files in correct directory (`C:\xampp\htdocs\Assignment_Web_Development_1111\`)
- [ ] PHP test page works (`test.php`)
- [ ] Data directory exists and is writable
- [ ] No .htaccess conflicts

## 🆘 **Emergency Fixes**

### If nothing works:
1. **Reinstall XAMPP:**
   - Download fresh copy from https://www.apachefriends.org/
   - Install with default settings
   - Copy project files again

2. **Use Alternative Server:**
   - Try WAMP (Windows) or MAMP (Mac)
   - Or use built-in PHP server: `php -S localhost:8000`

3. **Disable All Security:**
   - Rename all `.htaccess` files
   - Remove security headers
   - Test basic functionality first

## 📞 **Getting Help**

If you're still having issues:
1. Check XAMPP error logs: `C:\xampp\apache\logs\error.log`
2. Take screenshot of exact error message
3. Note your operating system and XAMPP version
4. Try the test.php file first

## ✅ **Success Indicators**

You'll know it's working when:
- `http://localhost/Assignment_Web_Development_1111/` shows the homepage
- `http://localhost/Assignment_Web_Development_1111/test.php` shows PHP info
- You can register a new user account
- Phone validation accepts Sri Lankan numbers
- Forms submit without errors

## 🔄 **After Fixing**

Once everything works:
1. Test user registration with Sri Lankan phone number
2. Test login functionality
3. Check profile page access
4. Submit contact form
5. Test responsive design on mobile

Remember: The most common issue is simply that Apache isn't running in XAMPP!
