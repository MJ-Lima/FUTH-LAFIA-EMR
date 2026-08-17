#!/bin/bash
# FUTH Lafia EMR — Setup Script
# Run this after extracting the ZIP on your server
# Usage: bash setup.sh

set -e

echo "=========================================="
echo "  FUTH Lafia EMR - Setup"
echo "=========================================="

# 1. Check PHP version
if ! command -v php &> /dev/null; then
    echo "ERROR: PHP is not installed. Install PHP 8.2+ first."
    exit 1
fi
PHP_VERSION=$(php -v | head -1 | cut -d' ' -f2 | cut -d'.' -f1,2)
echo "PHP version: $PHP_VERSION"

# 2. Install Composer dependencies
echo ""
echo "Installing Composer dependencies..."
composer install --no-dev --optimize-autoloader

# 3. Setup environment
echo ""
echo "Setting up environment..."
[ ! -f .env ] && cp .env.example .env
php artisan key:generate

# 4. Configure database
echo ""
echo "Configure your database in .env file:"
echo "  DB_CONNECTION=mysql"
echo "  DB_HOST=127.0.0.1"
echo "  DB_PORT=3306"
echo "  DB_DATABASE=futh_emr"
echo "  DB_USERNAME=your_user"
echo "  DB_PASSWORD=your_password"
echo ""
read -p "Have you configured the .env database settings? (y/N): " confirm
if [ "$confirm" != "y" ] && [ "$confirm" != "Y" ]; then
    echo "Please edit .env and run this script again."
    exit 1
fi

# 5. Run migrations
echo ""
echo "Running migrations..."
php artisan migrate --force

# 6. Run seeders
echo ""
echo "Seeding database..."
php artisan db:seed --force

# 7. Create storage symlink
echo ""
echo "Creating storage symlink..."
php artisan storage:link

# 8. Clear caches
echo ""
echo "Clearing caches..."
php artisan optimize:clear

echo ""
echo "=========================================="
echo "  Setup complete!"
echo "=========================================="
echo ""
echo "Login URL: http://your-server/admin/login"
echo "Default credentials:"
echo "  Email: admin@futhlafia.gov.ng"
echo "  Password: Futh@2026"
echo ""
echo "To start the dev server: php artisan serve"
echo "For production: configure Nginx/Apache with document root = public/"
