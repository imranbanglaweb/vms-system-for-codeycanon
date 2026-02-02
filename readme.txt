=================================================================
TRANSPORT & VEHICLE AUTOMATION
Smart Logistics. Better Operations.
=================================================================

VERSION: 1.0.0
AUTHOR: Your Name / Your Company
SUPPORT: Via CodeCanyon support system
LICENSE: Commercial (Regular or Extended)

=================================================================
TABLE OF CONTENTS
=================================================================

1. Description
2. Features
3. Requirements
4. Installation
5. Configuration
6. Default Login
7. Support
8. License

=================================================================
1. DESCRIPTION
=================================================================

A powerful Laravel-based fleet and transport management system
designed to streamline your organization's vehicle and transportation
operations. This all-in-one solution combines fleet management,
driver management, task assignments, and maintenance tracking.

Smart Logistics. Better Operations.

=================================================================
2. FEATURES
=================================================================

FLEET MANAGEMENT
- Complete vehicle fleet management
- Vehicle type categorization
- Real-time vehicle tracking
- Vehicle availability status
- Document management for vehicles

DRIVER MANAGEMENT
- Driver registration and profile management
- License type tracking
- Driver document management
- Driver availability status
- Performance tracking

TRANSPORT MANAGEMENT
- Transport requisition system with approval workflow
- Trip sheet creation and tracking
- Vehicle and driver assignment
- Transport notifications and alerts
- Passenger management for transport requisitions

TASK & PROJECT MANAGEMENT
- Create and assign tasks to employees
- Project-based task organization
- Task progress tracking and status updates
- File attachments for tasks
- Real-time notifications

MAINTENANCE SYSTEM
- Vehicle and equipment maintenance tracking
- Maintenance categories and schedules
- Maintenance requisition system
- Vendor management for maintenance
- Maintenance history and reporting

REQUISITION SYSTEM
- Multi-level approval workflow
- Requisition status tracking
- Requisition log history
- Email notifications at each stage
- Complete audit trail

ORGANIZATION MANAGEMENT
- Department management
- Employee management
- Role-based access control
- Unit and company management
- Location tracking

ADDITIONAL FEATURES
- Multi-language support (translation system)
- Email templates and logging
- PDF and Excel export functionality
- Real-time notifications (WebSocket support)
- Push notifications
- Role-based access control (RBAC)
- Activity logging and history
- Document approval workflow

=================================================================
3. REQUIREMENTS
=================================================================

SERVER REQUIREMENTS:
- PHP 8.0 or higher
- Laravel 8.x
- MySQL 5.7+ or MariaDB 10.2+
- Composer
- Node.js & NPM (for frontend assets)

PHP EXTENSIONS:
- OpenSSL PHP Extension
- PDO PHP Extension
- Mbstring PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension
- Ctype PHP Extension
- JSON PHP Extension
- BCMath PHP Extension
- Fileinfo Extension
- CURL Extension

=================================================================
4. INSTALLATION
=================================================================

STEP 1: Download and Extract
----------------------------
Download the package and extract it to your web server directory.

STEP 2: Install Dependencies
----------------------------
Run the following command in your terminal:

    composer install

STEP 3: Configure Environment
-----------------------------
Copy the example environment file:

    cp .env.example .env

Edit the .env file with your database credentials:

    APP_NAME="Transport & Vehicle Automation"
    APP_URL=http://yourdomain.com

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database
    DB_USERNAME=your_username
    DB_PASSWORD=your_password

    MAIL_MAILER=smtp
    MAIL_HOST=your_mail_host
    MAIL_PORT=587
    MAIL_USERNAME=your_email
    MAIL_PASSWORD=your_password

STEP 4: Generate Application Key
--------------------------------
    php artisan key:generate

STEP 5: Run Migrations
----------------------
    php artisan migrate --seed

STEP 6: Create Storage Link
---------------------------
    php artisan storage:link

STEP 7: Configure Permissions
-----------------------------
    chmod -R 775 storage/
    chmod -R 775 bootstrap/cache/

STEP 8: Access the Application
------------------------------
Open your browser and navigate to http://yourdomain.com

=================================================================
5. CONFIGURATION
=================================================================

EMAIL SETTINGS
--------------
Configure your mail settings in the .env file or through the
admin panel under Settings > Email.

LANGUAGE SETTINGS
-----------------
The application supports multiple languages. Configure languages
through the admin panel under Settings > Languages.

PAYMENT GATEWAY
---------------
For payment processing, configure your preferred gateway in the
admin panel under Settings > Payments.

=================================================================
6. DEFAULT LOGIN
=================================================================

After installation, you can login with:

Admin URL: /admin
Email: admin@example.com
Password: password

** IMPORTANT: Change these credentials immediately after first login! **

=================================================================
7. SUPPORT
=================================================================

For support, please contact us through the CodeCanyon support
system. Before contacting support, please:

1. Read this readme file completely
2. Check the online documentation
3. Check the FAQ section

We aim to respond to all support requests within 24-48 hours.

=================================================================
8. LICENSE
=================================================================

This is a commercial product. You are purchasing a license to
use this product according to the terms of the CodeCanyon
Regular or Extended License.

REGULAR LICENSE:
- Use in a single end product (free or paid)
- End users cannot be charged for the product

EXTENDED LICENSE:
- Use in a single end product that you plan to sell
- You can charge end users for accessing the product

For more details, please refer to the CodeCanyon license terms.

=================================================================
THIRD-PARTY PACKAGES
=================================================================

This project uses the following open-source packages:

- Laravel Framework 8.x
- Laravel UI 3.x
- Spatie Laravel Permission
- Maatwebsite Excel
- Barryvdh Laravel DomPDF
- Yajra DataTables
- Simple QRCode
- Google Translate PHP
- Pusher WebSockets
- And more...

=================================================================
CHANGELOG
=================================================================

Version 1.0.0 (Initial Release)
- All core features implemented
- Multi-language support
- Responsive admin panel
- Export functionality (PDF, Excel)
- Real-time notifications
- Fleet management
- Driver management
- Transport requisition system
- Maintenance tracking

=================================================================
UPGRADE GUIDE
=================================================================

To upgrade from a previous version:
1. Backup your database and files
2. Download the latest version
3. Replace the application files (keep your .env file)
4. Run migrations: php artisan migrate
5. Clear caches: php artisan optimize:clear

=================================================================
THANK YOU!
=================================================================

Thank you for purchasing Transport & Vehicle Automation.
We hope this product helps streamline your operations.

Smart Logistics. Better Operations.

=================================================================
