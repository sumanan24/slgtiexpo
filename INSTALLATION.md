# SLGTI 10-Year Impact Report - Installation Guide (Plain PHP)

## Requirements

- PHP 8.2+
- MySQL 8.0+
- Apache (WAMP/XAMPP)
- Composer (for PDF/Excel export only)

## Installation Steps

### 1. Place files in web root

```
C:\wamp64\www\slgti\
```

### 2. Configure database

Edit `config/config.php`:

```php
'db_host' => '127.0.0.1',
'db_name' => 'slgti_impact',
'db_user' => 'root',
'db_pass' => '',
```

### 3. Import database

In phpMyAdmin or MySQL CLI:

```bash
mysql -u root -p < database/slgti_impact.sql
```

### 4. Install export libraries (optional, for PDF/Excel)

```bash
cd C:\wamp64\www\slgti
C:\wamp64\bin\php\php8.2.0\php.exe composer.phar install
```

### 5. Set folder permissions

Ensure `uploads/` is writable by the web server.

### 6. Access the application

```
http://localhost/slgti/
```

## Default Admin Login

| Field    | Value            |
|----------|------------------|
| URL      | `/admin/login.php` |
| Email    | `admin@slgti.lk` |
| Password | `admin123`       |

## Application Structure

```
slgti/
├── index.php              # Home page
├── config/config.php      # Database settings
├── includes/              # Core PHP classes & helpers
├── submit/                # Staff submission forms
├── admin/                 # Admin panel
├── assets/css/            # Stylesheets
├── uploads/               # Uploaded documents
└── database/              # SQL schema file
```

## Public URLs

| Page              | URL                        |
|-------------------|----------------------------|
| Home              | `/index.php`               |
| Submit Data       | `/submit/index.php`        |
| Update Submission | `/submit/update.php`       |
| Admin Login       | `/admin/login.php`         |
| Dashboard         | `/admin/dashboard.php`     |

## Notes

- No Laravel framework required — pure PHP with PDO
- Uses sessions for admin authentication
- CSRF protection on all forms
- Password hashing with `password_hash()` / `password_verify()`
