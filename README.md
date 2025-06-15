# Gourmet Bakery Website

A full-featured e-commerce website for a gourmet bakery business, built with PHP and MySQL. This platform allows customers to browse and purchase various bakery products while providing administrators with tools to manage products and orders.

## 🌟 Features

### Customer Features
- User registration and authentication
- Product browsing and searching
- Shopping cart functionality
- Secure checkout process
- Order tracking and history
- Product categories and featured items
- Responsive design for all devices

### Admin Features
- Product management (add, edit, delete)
- Order management and tracking
- User management
- Inventory control
- Sales monitoring

## 🛠️ Technology Stack

- **Backend**: PHP
- **Database**: MySQL
- **Frontend**: HTML, CSS, JavaScript
- **Additional Libraries**: 
  - OracleDB (for database connectivity)
  - Custom CSS framework
  - JavaScript libraries for enhanced functionality

## 📋 Prerequisites

- PHP 7.4 or higher
- MySQL Server
- Web server (Apache/Nginx)
- Node.js (for package management)

## 🚀 Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/yourusername/gourmet-bakery.git
   ```

2. Set up the database:
   - Create a new MySQL database
   - Import the `database_setup.sql` file to set up the required tables and initial data

3. Configure the database connection:
   - Open `config.php`
   - Update the database credentials with your local settings

4. Install dependencies:
   ```bash
   npm install
   ```

5. Configure your web server to point to the project directory

## 🔧 Configuration

The main configuration file (`config.php`) contains settings for:
- Database connection
- Site settings
- Email configuration
- Security settings

## 📁 Project Structure

```
gourmet-bakery/
├── admin/              # Admin panel files
├── images/            # Product and site images
├── node_modules/      # Node.js dependencies
├── *.php             # Main application files
├── styles.css        # Main stylesheet
├── main.js           # Main JavaScript file
└── database_setup.sql # Database schema and initial data
```

## 🔐 Security Features

- Password hashing
- SQL injection prevention
- XSS protection
- CSRF protection
- Secure session management

## 🛍️ Shopping Features

- Product catalog with categories
- Shopping cart functionality
- Secure checkout process
- Order tracking
- User account management

## 👥 User Roles

1. **Customers**
   - Browse products
   - Place orders
   - Track orders
   - Manage profile

2. **Administrators**
   - Manage products
   - Process orders
   - Manage users
   - View reports

## 📝 License

This project is licensed under the MIT License.
