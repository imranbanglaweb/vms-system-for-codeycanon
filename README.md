# InayaFleet360 – Fleet & Transport Management System (Laravel)

## Smart Logistics. Better Operations.

A comprehensive Laravel-based transport management system designed to streamline your organization's vehicle and transportation operations. This all-in-one solution combines fleet management, driver management, requisition workflows, maintenance tracking, and multi-language support.

![License](https://img.shields.io/badge/license-Proprietary-green)
![Laravel](https://img.shields.io/badge/Laravel-9.x%20|%2010.x-orange)
![PHP](https://img.shields.io/badge/PHP-8.0%2B-blue)

## 🚗 About InayaFleet360

InayaFleet360 is a powerful, feature-rich fleet and transport automation system built with Laravel framework. It provides complete control over your fleet operations, from vehicle tracking to driver management, requisition workflows to maintenance scheduling.

## ✨ Key Features

### Fleet Management
- Complete vehicle fleet management with detailed records
- Vehicle type categorization and classification
- Real-time vehicle availability tracking
- Vehicle document management (insurance, registration, etc.)
- Vehicle maintenance history and records

### Driver Management
- Comprehensive driver profiles and documentation
- License type tracking and expiry alerts
- Driver availability status management
- Performance tracking and evaluation
- Driver-document management

### Transport Requisition System
- Online requisition submission with approval workflow
- Multi-level approval process
- Trip sheet creation and tracking
- Vehicle and driver assignment
- Passenger management for transport requisitions
- Real-time status tracking

### Maintenance Management
- Scheduled maintenance planning
- Maintenance requisition system
- Maintenance vendor management
- Complete maintenance history
- Cost tracking and reporting

### Organization Management
- Department and unit management
- Employee management
- Role-based access control (RBAC)
- Multi-company support
- Location tracking

### HR Module - Employee Management
- Comprehensive employee management with detailed profiles
- Department management and organizational hierarchy
- Designation and position tracking
- Department Head assignment for approval workflows
- Employee-Transport linking for requisition system
- Employee self-service portal

### Notification System
- **Push Notifications**: Real-time alerts for requisition status, approvals, trip assignments
- **Email Templates**: Customizable templates for requisitions, approvals, driver assignments
- **Email Log History**: Complete audit trail of all sent emails
- **Notification Settings**: Configure channels, recipients, and preferences
- **Push Subscribers Management**: Track and manage notification subscriptions

### Multi-Level Approval System
- **Employee Login**: Submit requisitions, view status, track trips
- **Driver Login**: View assigned trips, manage availability, log fuel
- **Department Head Login**: Approve/reject department requisitions (first approval level)
- **Transport Admin Login**: Final approval authority, vehicle/driver assignment
- Complete audit trail and approval history

### Additional Features
- 📋 Multi-language support (translation system)
- 📧 Email templates and logging
- 📊 PDF and Excel export
- 🔔 Real-time notifications (WebSocket support)
- 📱 Push notifications
- 📝 Activity logging and audit trail
- 📄 Document approval workflow
- 📈 Reporting and analytics

## 👥 User Roles & Access Levels

| Role | Access Level | Approval Authority |
|------|-------------|-------------------|
| Admin | Full System Access | Complete Control |
| Employee | Submit requisitions, view status | Submit only |
| Driver | View assigned trips, availability | View only |
| Department Head | Department management | First Approval Level |
| Transport Admin | Fleet oversight | Final Approval Level |

## 🛠️ Technology Stack

- **Backend:** Laravel 9.x / 10.x
- **Frontend:** Bootstrap 5, jQuery, DataTables
- **Database:** MySQL 8.0+ / MariaDB 10.2+
- **Authentication:** Laravel Sanctum, JWT
- **Real-time:** Pusher / WebSockets
- **PDF Generation:** DomPDF
- **Excel Export:** Maatwebsite Excel
- **QR Codes:** Simple QRCode
- **Translation:** Google Translate PHP

## 📋 Requirements

- PHP 8.0 or higher
- Laravel 9.x or 10.x
- MySQL 8.0+ or MariaDB 10.2+
- Composer 2.0+
- Node.js & NPM (for frontend assets)
- OpenSSL PHP Extension
- PDO PHP Extension
- Mbstring PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension
- Ctype PHP Extension
- JSON Extension
- BCMath Extension
- Fileinfo Extension
- CURL Extension

## 🚀 Installation

### Step 1: Clone and Install
```bash
git clone https://github.com/codeaycanon/tms.git
cd tms-for-codeaycanon-update
composer install
npm install
```

### Step 2: Environment Configuration
```bash
cp .env.example .env
php artisan key:generate
```

Update your `.env` file with database credentials:
```env
APP_NAME="InayaFleet360 – Fleet & Transport Management System"
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
```

### Step 3: Database Setup
```bash
php artisan migrate --seed
```

### Step 4: Storage Link
```bash
php artisan storage:link
```

### Step 5: Permissions
```bash
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/
```

### Step 6: Queue Worker (for background jobs)
```bash
php artisan queue:work
```

### Step 7: Start Development Server
```bash
php artisan serve
```

## 📖 Default Access

After installation, access the admin panel:

| Role | URL | Email | Password |
|------|-----|-------|----------|
| Admin | /admin | admin@codeaycanon.com | password |
| Employee | /employee/login | employee@codeaycanon.com | password |
| Driver | /driver/login | driver@codeaycanon.com | password |
| Dept Head | /department-head/login | depthead@codeaycanon.com | password |
| Transport Admin | /transport-admin/login | transport@codeaycanon.com | password |

> ⚠️ **Security Note:** Change these credentials immediately after first login.

## 📁 Project Structure

```
codeaycanon-tms/
├── app/
│   ├── Console/
│   ├── Exceptions/
│   ├── Http/
│   ├── Models/
│   ├── Providers/
│   ├── Services/
│   └── Traits/
├── bootstrap/
├── config/
├── database/
│   ├── migrations/
│   └── seeders/
├── public/
│   └── frontend_resource/
├── resources/
│   └── views/
├── routes/
├── storage/
└── tests/
```

## ⚙️ Configuration

### Email Settings
Configure via `.env` file or admin panel:
```
Settings > Email Configuration
```

### Language Settings
Multi-language support available:
```
Settings > Language Settings
```

### Notification Settings
Configure WebSocket and push notifications:
```
Settings > Notifications
```

### Approval Workflow Settings
Configure department heads and approval levels:
```
Settings > Approval Workflow
```

## 📊 Database Schema

Key tables include:
- `users` - User authentication and profiles
- `vehicles` - Vehicle fleet management
- `drivers` - Driver records
- `requisitions` - Transport requisitions
- `trip_sheets` - Trip documentation
- `maintenance_records` - Vehicle maintenance
- `departments` - Organization structure
- `employees` - HR module employee records
- `email_logs` - Email notification history
- `settings` - System configuration

## 🔌 API Endpoints

The system provides RESTful APIs for:
- Vehicle management
- Driver management
- Requisition workflows
- Trip sheet operations
- Maintenance tracking
- Employee management
- Notification management

## 🎨 Customization

### Theme Customization
Edit CSS files in:
```
public/frontend_resource/css/
```

### Menu Configuration
Modify menus via:
```
Database > MenuSeeder
```

### Email Templates
Customize templates in:
```
resources/views/emails/
```

## 📈 Performance Optimization

```bash
# Cache configuration
php artisan config:cache
php artisan route:cache
php artisan view:clear

# Optimize autoloader
composer dump-autoload --optimize
```

## 🧪 Testing

```bash
# Run unit tests
php artisan test

# Run feature tests
php artisan test --features
```

## 📝 License

This is a proprietary software. You are purchasing a license according to the terms of your purchase agreement.

- **Regular License:** Use in a single end product
- **Extended License:** Use in a single end product for sale

## 🤝 Support

For technical support:
- Email: support@codeaycanon.com
- Documentation: https://docs.codeaycanon.com
- Issues: https://github.com/codeaycanon/tms/issues

## 🙏 Acknowledgments

Built with:
- [Laravel](https://laravel.com) - The PHP Framework for Web Artisans
- [Bootstrap](https://getbootstrap.com) - Bootstrap 5
- [FontAwesome](https://fontawesome.com) - Icons
- [DataTables](https://datatables.net) - Interactive tables
- And many more open-source packages...

## 📄 Changelog

### Version 1.0.0
- Initial release
- Core fleet management features
- Driver management module
- Transport requisition workflow
- Maintenance tracking system
- HR Module for employee management
- Multi-Level Approval System
- Notification System (Push & Email)
- Multi-language support
- Responsive admin dashboard
- Export functionality (PDF, Excel)
- Real-time notifications

---

**InayaFleet360** – Fleet & Transport Management System (Laravel)

Smart Logistics. Better Operations.

© 2025 InayaFleet360. All rights reserved.
