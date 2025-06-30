# FoodExpress - Food Delivery Service Website

A complete web application for food delivery service built with HTML5, CSS3, JavaScript, and PHP.

## 🚀 Features

- **Responsive Design**: Works perfectly on desktop, tablet, and mobile devices
- **User Authentication**: Secure registration and login system
- **Form Validation**: Client-side and server-side validation
- **Session Management**: Secure user sessions with timeout
- **Contact System**: Contact form with message storage
- **Theme Toggle**: Light/dark mode support
- **Security**: Input sanitization, password hashing, CSRF protection
- **Modern UI**: Professional design with smooth animations

## 📁 Project Structure

```
Assignment_Web_Development_1111/
├── css/
│   └── style.css              # Main stylesheet with responsive design
├── js/
│   ├── main.js               # Core JavaScript functionality
│   └── validation.js         # Form validation logic
├── php/
│   ├── config.php            # Configuration and utility functions
│   ├── registration_handler.php  # User registration handler
│   ├── login_handler.php     # User authentication handler
│   ├── profile_handler.php   # User profile management
│   ├── contact_handler.php   # Contact form handler
│   └── logout_handler.php    # User logout handler
├── data/                     # Data storage directory (protected)
├── assets/                   # Images, icons, and other assets
├── index.html               # Homepage
├── register.html            # User registration page
├── login.html              # User login page
├── profile.html            # User profile page
├── contact.html            # Contact page
├── .htaccess               # Security configuration
├── README.md               # This file
└── TESTING_GUIDE.md        # Comprehensive testing guide
```

## 🛠️ Installation & Setup

### Prerequisites

- Web server with PHP support (XAMPP, WAMP, MAMP, or similar)
- PHP 7.4 or higher
- Modern web browser

### Step-by-Step Setup

1. **Download and Install XAMPP**
   - Visit https://www.apachefriends.org/
   - Download XAMPP for your operating system
   - Install and start Apache and PHP services

2. **Deploy the Application**
   ```bash
   # Copy project files to XAMPP htdocs directory
   # Windows: C:\xampp\htdocs\Assignment_Web_Development_1111\
   # macOS: /Applications/XAMPP/htdocs/Assignment_Web_Development_1111/
   # Linux: /opt/lampp/htdocs/Assignment_Web_Development_1111/
   ```

3. **Set Permissions** (Linux/macOS)
   ```bash
   chmod 755 Assignment_Web_Development_1111/
   chmod 777 Assignment_Web_Development_1111/data/
   ```

4. **Access the Application**
   - Open your web browser
   - Navigate to: `http://localhost/Assignment_Web_Development_1111/`

## 🎯 Usage Guide

### For Users

1. **Homepage**: Browse the main page to learn about FoodExpress
2. **Registration**: Create a new account with your details
3. **Login**: Sign in to access your profile
4. **Profile**: View and manage your account information
5. **Contact**: Send messages or inquiries to the support team

### For Developers

1. **Customization**: Modify CSS variables in `css/style.css` for theming
2. **Functionality**: Add new features by extending JavaScript files
3. **Backend**: Enhance PHP handlers for additional functionality
4. **Database**: Replace file-based storage with MySQL for production

## 🔧 Configuration

### Theme Customization

Edit CSS custom properties in `css/style.css`:

```css
:root {
    --primary-color: #ff6b35;    /* Main brand color */
    --secondary-color: #2c3e50;  /* Secondary color */
    --accent-color: #f39c12;     /* Accent color */
    /* ... other variables */
}
```

### PHP Configuration

Modify settings in `php/config.php`:

```php
// Application settings
define('APP_NAME', 'FoodExpress');
define('SESSION_TIMEOUT', 3600); // 1 hour
define('PASSWORD_MIN_LENGTH', 8);
```

## 🔒 Security Features

- **Password Hashing**: Uses PHP's `password_hash()` function
- **Input Sanitization**: All user inputs are sanitized
- **Session Security**: Secure session management with timeout
- **CSRF Protection**: Cross-site request forgery prevention
- **Rate Limiting**: Login attempt limiting
- **File Protection**: Sensitive files protected via .htaccess
- **XSS Prevention**: Output escaping and content security policy

## 📱 Responsive Design

The application is fully responsive and tested on:

- **Desktop**: 1920x1080 and above
- **Tablet**: 768x1024 (iPad)
- **Mobile**: 375x667 (iPhone) and similar devices

### Breakpoints

- Large screens: 1200px and above
- Medium screens: 768px to 1199px
- Small screens: 767px and below

## 🧪 Testing

Comprehensive testing guide available in `TESTING_GUIDE.md`. Key testing areas:

- Form validation (client and server-side)
- User authentication flow
- Responsive design
- Cross-browser compatibility
- Security vulnerabilities
- Performance optimization

### Quick Test

1. Register a new user account
2. Login with the created account
3. Access the profile page
4. Submit a contact form
5. Test responsive design on different screen sizes

## 🚀 Deployment

### Development Environment

- Use XAMPP/WAMP for local development
- Enable error reporting in `php/config.php`
- Use browser developer tools for debugging

### Production Environment

1. **Web Server Setup**
   - Upload files to web hosting service
   - Ensure PHP 7.4+ support
   - Configure proper file permissions

2. **Security Hardening**
   - Disable error reporting
   - Enable HTTPS
   - Configure secure headers
   - Regular security updates

3. **Performance Optimization**
   - Enable gzip compression
   - Optimize images
   - Minify CSS/JavaScript
   - Use CDN for static assets

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

## 📄 License

This project is created for educational purposes as part of a web development assignment.

## 📞 Support

For technical support or questions:

- Email: support@foodexpress.com
- Phone: +1 (555) 123-4567

## 🔄 Version History

- **v1.0.0** - Initial release with core functionality
  - User registration and authentication
  - Responsive design
  - Contact form
  - Security features

## 🎨 Design Credits

- Icons: Font Awesome
- Fonts: System fonts (Segoe UI, etc.)
- Color scheme: Custom design
- Layout: CSS Grid and Flexbox

## 📊 Browser Support

- Chrome 90+
- Firefox 88+
- Safari 14+
- Edge 90+

## 🔮 Future Enhancements

- Database integration (MySQL)
- Email notifications
- Order management system
- Payment integration
- Admin dashboard
- API development
- Mobile app
- Real-time notifications

---

**Built with ❤️ for Web Development Assignment**
