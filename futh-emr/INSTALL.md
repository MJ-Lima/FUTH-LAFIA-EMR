# FUTH Lafia EMR — Installation Guide

## Requirements

- PHP 8.2 or higher (PHP 8.4 recommended)
- Composer 2.x
- MySQL 8.0+ or MariaDB 10.6+
- Nginx or Apache (for production)

### Required PHP Extensions
- pdo, pdo_mysql, mbstring, xml, curl, zip, gd, bcmath, intl, readline, fileinfo, openssl

## Installation Steps

### 1. Extract the ZIP
```bash
unzip futh-lafia-emr.zip
cd futh-emr
```

### 2. Install PHP dependencies
```bash
composer install --no-dev --optimize-autoloader
```

### 3. Configure environment
```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` and set your database credentials:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=futh_emr
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password
```

### 4. Create the database
```bash
mysql -u root -p -e "CREATE DATABASE futh_emr CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
mysql -u root -p -e "CREATE USER 'futh'@'localhost' IDENTIFIED BY 'your_password'; GRANT ALL ON futh_emr.* TO 'futh'@'localhost'; FLUSH PRIVILEGES;"
```

### 5. Run migrations & seeders

**Option A — Fresh install (empty database, run all migrations + seeders):**
```bash
php artisan migrate --force
php artisan db:seed --force
```

**Option B — Import the full demo database (includes all seeded demo data):**
```bash
mysql -u root -p futh_emr < database/seeders/futh_emr_full_dump.sql
```

### 6. Create storage symlink
```bash
php artisan storage:link
```

### 7. Start the development server
```bash
php artisan serve
```
Visit `http://localhost:8000/admin/login`

## Default Login Credentials

| Email                                  | Password     | Role                      |
|----------------------------------------|--------------|---------------------------|
| admin@futhlafia.gov.ng                 | Futh@2026    | Super Admin               |
| dr.okoro@futhlafia.gov.ng              | Futh@2026    | Doctor                    |
| dr.adebayo@futhlafia.gov.ng            | Futh@2026    | Doctor (OBGYN)            |
| nurse.john@futhlafia.gov.ng            | Futh@2026    | Nurse                     |
| pharm.musa@futhlafia.gov.ng            | Futh@2026    | Pharmacist                |
| lab.aisha@futhlafia.gov.ng             | Futh@2026    | Laboratory Scientist      |
| rad.tunde@futhlafia.gov.ng             | Futh@2026    | Radiographer              |
| records.hauwa@futhlafia.gov.ng         | Futh@2026    | Medical Records Officer   |
| accounts.david@futhlafia.gov.ng        | Futh@2026    | Accountant                |
| insurance.officer@futhlafia.gov.ng     | Futh@2026    | Insurance Officer         |

## Production Deployment

### 1. Optimize for production
```bash
composer install --no-dev --optimize-autoloader
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
php artisan filament:cache
```

### 2. Set permissions
```bash
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache
```

### 3. Nginx configuration example
```nginx
server {
    listen 80;
    server_name emr.futhlafia.gov.ng;
    root /var/www/futh-emr/public;
    index index.php;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

### 4. Set APP_ENV=production and APP_DEBUG=false in .env

### 5. Configure a queue worker (for background jobs)
```bash
php artisan queue:work --tries=3 --max-time=3600
```
Or set up a Supervisor process to keep it running.

### 6. Set up daily scheduled tasks via cron
```bash
* * * * * cd /var/www/futh-emr && php artisan schedule:run >> /dev/null 2>&1
```

## Modules included

### Clinical
Patients, Encounters, Appointments, Vitals, Clinical Notes (SOAP), Allergies, Diagnoses (ICD-10)

### Ward & Bed Management
Wards, Beds, Admissions (with bed auto-assignment), Bed Transfers, Discharge Summaries

### Duty & Staff Posting
Staff, Duty Rosters, Duty Postings (with unit-based access control)

### Insurance
Providers (NHIA + HMOs), Plans, Patient Policies, Claims with line items, Pre-Authorizations

### Pharmacy
Drugs, Drug Categories, Drug Batches, Prescriptions, Dispensing Points, Stock Movements, Suppliers, Purchases, Goods Received Notes (GRN), Drug Stock Levels

### Laboratory
Lab Panels (LOINC), Lab Tests (LOINC), Lab Orders with results, Blood Bank (Donors, Donations, Units, Requests, Crossmatches, Transfusions)

### Radiology
Modalities, Radiology Orders with results

### Procedures
Procedure Categories, Procedures (with ICD-10-PCS/CPT codes), Procedure Bookings, Procedure Sessions

### Store & Inventory
Store Categories, Locations, Items, Stocks, Movements, Requisitions, Stock Takes

### Schedule Configuration
Appointment Types, Clinic Schedules, Provider Schedules, Appointment Slots, Holidays, Leave Requests

### Billing & Finance
Service Categories, Services (NHIA-aligned tariffs), Invoices, Payments, Chart of Accounts, Journal Entries (double-entry), Budgets, Expense Claims, Petty Cash

### Administration
Hospitals, Departments, Clinics, Users, Roles & Permissions (via filament-shield)

## Total stats
- 65 Filament resources
- 296 admin routes
- 52 database migrations
- ~774 permissions across 10 roles
- International standards: ICD-10, LOINC, ATC, NHIA, ISO 3166

## Troubleshooting

### "Class PDO not found"
Install the php-pdo and php-mysql extensions:
```bash
sudo apt install php8.3-pdo php8.3-mysql
```

### "No application encryption key has been specified"
Run: `php artisan key:generate`

### Login redirects back to login page
Clear caches: `php artisan optimize:clear`
Check `SESSION_DRIVER` in .env (use `database` or `file`)

### 500 error on dashboard
Check `storage/logs/laravel.log` for details.
Ensure storage permissions: `chmod -R 775 storage bootstrap/cache`

## Support
For issues, contact the system administrator at FUTH Lafia.
