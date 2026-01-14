#!/bin/bash

echo "=========================================="
echo "  Hospital-Sys CodeIgniter 4 Setup"
echo "=========================================="
echo ""

# Check if PHP is installed
if ! command -v php &> /dev/null; then
    echo "❌ PHP is not installed. Please install PHP 8.1 or higher."
    exit 1
fi

# Check PHP version
PHP_VERSION=$(php -r "echo PHP_VERSION;")
echo "✓ PHP version: $PHP_VERSION"

# Check if Composer is installed
if ! command -v composer &> /dev/null; then
    echo "❌ Composer is not installed. Please install Composer."
    exit 1
fi

echo "✓ Composer is installed"
echo ""

# Check if CodeIgniter is already installed
if [ -d "app" ] && [ -f "spark" ]; then
    echo "✓ CodeIgniter structure detected. Running composer install..."
    composer install
else
    echo "📦 Installing CodeIgniter 4..."
    
    # Install CodeIgniter
    composer create-project codeigniter4/appstarter temp-ci4
    
    # Move files from temp directory to current directory
    echo "📁 Moving files..."
    shopt -s dotglob nullglob
    for file in temp-ci4/*; do
        if [ "$(basename "$file")" != "." ] && [ "$(basename "$file")" != ".." ]; then
            mv "$file" .
        fi
    done
    
    # Clean up
    rmdir temp-ci4 2>/dev/null || true
fi

# Preserve our custom .env if it exists
if [ -f ".env" ] && [ ! -f "env" ]; then
    echo "✓ Environment file already configured"
elif [ -f "env" ] && [ ! -f ".env" ]; then
    echo "📝 Creating .env from template..."
    cp env .env
fi

# Set proper permissions for writable directory
if [ -d "writable" ]; then
    echo "🔒 Setting permissions for writable directory..."
    chmod -R 755 writable
fi

# Generate encryption key if not set
if grep -q "^# encryption.key" .env 2>/dev/null; then
    echo "🔐 Generating encryption key..."
    php spark key:generate --force
fi

echo ""
echo "=========================================="
echo "✅ Installation Complete!"
echo "=========================================="
echo ""
echo "Next steps:"
echo "1. Configure your database in .env file"
echo "2. Run: php spark migrate (if you have migrations)"
echo "3. Start server: php spark serve"
echo ""
echo "The application will be available at:"
echo "http://localhost:8080"
echo ""
