# Quick Start Guide for Hospital-Sys

## Setup CodeIgniter 4

### Method 1: Using the Setup Script (Easiest)

```bash
chmod +x setup.sh
./setup.sh
```

### Method 2: Manual Installation

```bash
# Install CodeIgniter 4
composer create-project codeigniter4/appstarter temp-ci4

# Move files to current directory
shopt -s dotglob
mv temp-ci4/* .
rmdir temp-ci4

# Install dependencies
composer install

# Copy environment file
cp env .env

# Set permissions
chmod -R 755 writable

# Generate encryption key
php spark key:generate
```

### Method 3: Using Composer Install (If composer.json already exists)

```bash
composer install
php spark key:generate
```

## Configuration

### 1. Database Setup

Edit `.env` file and configure your database:

```env
CI_ENVIRONMENT = development

database.default.hostname = localhost
database.default.database = hospital_sys
database.default.username = root
database.default.password = your_password
database.default.DBDriver = MySQLi
database.default.port = 3306
```

### 2. Create Database

```sql
CREATE DATABASE hospital_sys CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 3. Run Migrations (when you have them)

```bash
php spark migrate
```

## Run the Application

### Start Development Server

```bash
php spark serve
```

Open your browser and visit: http://localhost:8080

### Start on Custom Port

```bash
php spark serve --port=8081
```

### Start on All Network Interfaces

```bash
php spark serve --host=0.0.0.0 --port=8080
```

## Common CodeIgniter Commands

### Generators

```bash
# Create a controller
php spark make:controller Patient

# Create a model
php spark make:model Patient

# Create a migration
php spark make:migration create_patients_table

# Create a seeder
php spark make:seeder PatientSeeder

# Create a filter
php spark make:filter AuthFilter

# Create an entity
php spark make:entity Patient
```

### Database

```bash
# Run migrations
php spark migrate

# Rollback migrations
php spark migrate:rollback

# Refresh migrations (rollback all and re-run)
php spark migrate:refresh

# Check migration status
php spark migrate:status

# Run seeders
php spark db:seed PatientSeeder
```

### Cache Management

```bash
# Clear all cache
php spark cache:clear

# Clear specific cache
php spark cache:clear --driver=file
```

### Routes

```bash
# List all routes
php spark routes

# List routes for a specific method
php spark routes --GET
```

### Other Utilities

```bash
# List all commands
php spark list

# Show environment info
php spark env

# Clear logs
php spark logs:clear
```

## Project Structure Overview

```
Hospital-Sys/
├── app/
│   ├── Config/           # Application configuration
│   ├── Controllers/      # Request handlers
│   ├── Models/          # Database models
│   ├── Views/           # HTML templates
│   ├── Database/        # Migrations & seeds
│   ├── Filters/         # Before/after filters
│   ├── Helpers/         # Helper functions
│   └── Libraries/       # Custom libraries
├── public/              # Document root
│   ├── index.php       # Front controller
│   ├── css/            # Stylesheets
│   ├── js/             # JavaScript files
│   └── images/         # Image files
├── writable/            # Writable directories
│   ├── cache/          # Cache files
│   ├── logs/           # Log files
│   ├── session/        # Session files
│   └── uploads/        # Uploaded files
├── tests/               # Test files
├── vendor/              # Composer dependencies
├── .env                 # Environment configuration
├── composer.json        # PHP dependencies
├── phpunit.xml         # PHPUnit configuration
└── spark               # CLI tool
```

## Creating Your First Module

### 1. Create a Controller

```bash
php spark make:controller Dashboard
```

Edit `app/Controllers/Dashboard.php`:

```php
<?php
namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        return view('dashboard/index');
    }
}
```

### 2. Create a View

Create `app/Views/dashboard/index.php`:

```php
<!DOCTYPE html>
<html>
<head>
    <title>Hospital Dashboard</title>
</head>
<body>
    <h1>Welcome to Hospital Management System</h1>
</body>
</html>
```

### 3. Add a Route

Edit `app/Config/Routes.php`:

```php
$routes->get('/dashboard', 'Dashboard::index');
```

### 4. Test

Visit: http://localhost:8080/dashboard

## Troubleshooting

### Permission Issues

```bash
chmod -R 755 writable
chmod +x spark
```

### Clear Cache

```bash
php spark cache:clear
```

### Composer Issues

```bash
composer dump-autoload
composer update
```

### Check System Requirements

```bash
php spark env
```

## Next Steps

1. ✅ Install CodeIgniter
2. ✅ Configure database
3. 📝 Create your first controller
4. 📝 Create your first model
5. 📝 Create your first view
6. 📝 Set up authentication
7. 📝 Create database tables (migrations)
8. 📝 Build your features

## Resources

- [CodeIgniter 4 Documentation](https://codeigniter.com/user_guide/)
- [CodeIgniter 4 Forum](https://forum.codeigniter.com/)
- [CodeIgniter 4 GitHub](https://github.com/codeigniter4/CodeIgniter4)
