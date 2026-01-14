# Installation Guide - Hospital Management System

This guide provides multiple ways to install and set up the Hospital Management System built with CodeIgniter 4.

## Prerequisites

- **PHP** 8.1 or higher
- **Composer** (PHP dependency manager)
- **MySQL** 5.7+ or MariaDB 10.3+ (or PostgreSQL)
- **Git** (optional, for version control)

## Installation Methods

Choose one of the following methods:

### 🚀 Method 1: Automated Installation (Recommended)

This is the easiest method using the provided setup script.

```bash
# Make the setup script executable
chmod +x setup.sh

# Run the setup script
./setup.sh
```

The script will:
- Check PHP and Composer installation
- Install CodeIgniter 4
- Set up the environment file
- Configure permissions
- Generate encryption key

### 📦 Method 2: Using Makefile

If you have `make` installed:

```bash
# View all available commands
make help

# Complete installation
make install

# Or do everything at once (install + migrate + serve)
make dev
```

### 🐳 Method 3: Using Docker

If you prefer using Docker:

```bash
# Start all services (PHP, MySQL, phpMyAdmin)
docker-compose up -d

# Install CodeIgniter inside the container
docker-compose exec app composer create-project codeigniter4/appstarter temp
docker-compose exec app sh -c "mv temp/* . && rm -rf temp"

# Access the application
# App: http://localhost:8080
# phpMyAdmin: http://localhost:8081
```

### 🛠️ Method 4: Manual Installation

#### Step 1: Install CodeIgniter 4

```bash
# Create a temporary directory for CodeIgniter
composer create-project codeigniter4/appstarter temp-ci4

# Move all files to current directory
shopt -s dotglob
mv temp-ci4/* .
rm -rf temp-ci4

# Or if files already exist, just install dependencies
composer install
```

#### Step 2: Environment Configuration

```bash
# Copy the environment file
cp env .env

# Or if .env already exists, edit it directly
nano .env
```

Configure your database in `.env`:

```env
CI_ENVIRONMENT = development

database.default.hostname = localhost
database.default.database = hospital_sys
database.default.username = root
database.default.password = your_password
database.default.DBDriver = MySQLi
database.default.port = 3306
```

#### Step 3: Set Permissions

```bash
# Make spark executable
chmod +x spark

# Set writable directory permissions
chmod -R 755 writable
```

#### Step 4: Generate Encryption Key

```bash
php spark key:generate
```

## Database Setup

### Create Database

#### Using MySQL Command Line

```bash
mysql -u root -p
```

```sql
CREATE DATABASE hospital_sys CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
GRANT ALL PRIVILEGES ON hospital_sys.* TO 'hospital_user'@'localhost' IDENTIFIED BY 'your_password';
FLUSH PRIVILEGES;
EXIT;
```

#### Using phpMyAdmin

1. Open phpMyAdmin
2. Click "New" to create a new database
3. Name it `hospital_sys`
4. Choose `utf8mb4_unicode_ci` as collation
5. Click "Create"

#### Using Makefile (if available)

```bash
make setup-db
```

### Run Migrations

Once your database is created and configured:

```bash
# Run all migrations
php spark migrate

# Or using make
make migrate
```

## Running the Application

### Development Server

#### Using PHP Built-in Server

```bash
# Start on default port 8080
php spark serve

# Start on custom port
php spark serve --port=8081

# Start on all network interfaces
php spark serve --host=0.0.0.0
```

#### Using Makefile

```bash
make serve
```

#### Using Docker

```bash
docker-compose up -d
```

### Access the Application

Open your browser and visit:
- **Application**: http://localhost:8080
- **phpMyAdmin** (Docker only): http://localhost:8081

## Verification

### Check Installation

```bash
# List all routes
php spark routes

# Check environment info
php spark env

# Run a simple test
php spark list
```

### Expected Output

You should see:
- ✅ List of available routes
- ✅ Environment information
- ✅ List of Spark commands

## Troubleshooting

### Common Issues

#### 1. "composer: command not found"

Install Composer:
```bash
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
```

#### 2. Permission Denied Errors

Fix permissions:
```bash
sudo chmod -R 755 writable
sudo chown -R $USER:$USER .
```

#### 3. Database Connection Failed

Check your `.env` file:
- Verify database credentials
- Ensure MySQL service is running
- Test connection manually

```bash
# Test MySQL connection
mysql -u root -p hospital_sys
```

#### 4. "Class not found" Errors

Regenerate autoloader:
```bash
composer dump-autoload
```

#### 5. Encryption Key Error

Generate a new key:
```bash
php spark key:generate --force
```

#### 6. Port Already in Use

Use a different port:
```bash
php spark serve --port=8081
```

### Clear Cache

If you encounter strange behavior:

```bash
php spark cache:clear

# Or using make
make cache-clear
```

## Post-Installation Steps

### 1. Configure Your Application

Edit configuration files in `app/Config/`:
- `App.php` - General application settings
- `Database.php` - Database configuration
- `Routes.php` - URL routes
- `Filters.php` - Request/response filters

### 2. Create Your First Module

```bash
# Create a controller
php spark make:controller Patient

# Create a model
php spark make:model Patient

# Create a migration
php spark make:migration create_patients_table

# Create a seeder
php spark make:seeder PatientSeeder
```

### 3. Set Up Authentication (Optional)

Consider using:
- [Myth:Auth](https://github.com/lonnieezell/myth-auth) - Popular authentication library
- [CodeIgniter Shield](https://github.com/codeigniter4/shield) - Official authentication library

```bash
composer require codeigniter4/shield
php spark shield:setup
```

### 4. Install Frontend Dependencies (Optional)

If you plan to use frontend build tools:

```bash
# Initialize npm
npm init -y

# Install dependencies
npm install bootstrap jquery
```

## Quick Commands Reference

```bash
# Development
php spark serve                    # Start server
php spark routes                   # List routes
php spark cache:clear             # Clear cache

# Generators
php spark make:controller Name     # Create controller
php spark make:model Name         # Create model
php spark make:migration Name     # Create migration

# Database
php spark migrate                 # Run migrations
php spark migrate:rollback        # Rollback
php spark db:seed Seeder         # Run seeder

# Composer
composer install                  # Install dependencies
composer update                   # Update dependencies
composer dump-autoload           # Regenerate autoloader
```

## Using Makefile Commands

If you prefer using `make`:

```bash
make help              # Show all commands
make install           # Install CodeIgniter
make serve             # Start server
make migrate           # Run migrations
make cache-clear       # Clear cache
make controller NAME=Patient  # Create controller
make model NAME=Patient       # Create model
```

## Next Steps

1. ✅ Installation complete
2. 📖 Read [QUICKSTART.md](QUICKSTART.md) for development guide
3. 📖 Read [README.md](README.md) for project overview
4. 🎨 Start building your features!
5. 📚 Check [CodeIgniter Documentation](https://codeigniter.com/user_guide/)

## Support

If you encounter issues:

1. Check the [troubleshooting section](#troubleshooting)
2. Review CodeIgniter [documentation](https://codeigniter.com/user_guide/)
3. Search [CodeIgniter forum](https://forum.codeigniter.com/)
4. Check project issues on GitHub

## Security Notes

### Before Deployment

1. Change `CI_ENVIRONMENT` to `production` in `.env`
2. Generate a strong encryption key
3. Disable error display in production
4. Set up proper file permissions
5. Use HTTPS
6. Keep dependencies updated

```bash
# Update dependencies
composer update

# Check for security issues
composer audit
```

## Additional Resources

- [CodeIgniter 4 User Guide](https://codeigniter.com/user_guide/)
- [CodeIgniter 4 API Reference](https://codeigniter.com/api/)
- [CodeIgniter Forum](https://forum.codeigniter.com/)
- [GitHub Repository](https://github.com/codeigniter4/CodeIgniter4)

---

**Happy Coding! 🚀**
