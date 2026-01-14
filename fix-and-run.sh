#!/bin/bash

echo "Fixing PHP intl extension..."

# Remove the invalid intl.so line
sudo sed -i '/extension=intl.so/d' /usr/local/php/8.3.14/ini/php.ini

# Try to install intl extension
echo "Installing php-intl..."
sudo apt-get update
sudo apt-get install -y php8.3-intl libicu-dev

# Find the intl.so file
INTL_SO=$(find /usr -name "intl.so" 2>/dev/null | head -n 1)

if [ -n "$INTL_SO" ]; then
    echo "Found intl.so at: $INTL_SO"
    # Create extension directory if it doesn't exist
    sudo mkdir -p /usr/local/php/8.3.14/extensions
    # Copy or link the extension
    sudo cp "$INTL_SO" /usr/local/php/8.3.14/extensions/
    # Enable it in php.ini
    echo "extension=intl.so" | sudo tee -a /usr/local/php/8.3.14/ini/php.ini
else
    echo "intl.so not found, trying alternative approach..."
    # Try to compile it
    sudo apt-get install -y php-pear php8.3-dev
    sudo pecl install intl
fi

echo "Verification:"
php -m | grep intl

echo ""
echo "Starting CodeIgniter server..."
php spark serve
