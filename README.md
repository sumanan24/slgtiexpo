# SLGTI 10-Year Impact Report (Plain PHP)

Web-based data collection system for SLGTI department impact reports (2016–2026).

**Technology:** Plain PHP 8.2+, MySQL, Bootstrap 5, Chart.js, DomPDF, PhpSpreadsheet

## Quick Start

1. Import `database/slgti_impact.sql`
2. Edit `config/config.php` with your MySQL credentials
3. Run `composer install` (for PDF/Excel export)
4. Open `http://localhost/slgti/`

See **[INSTALLATION.md](INSTALLATION.md)** for full setup.

## Admin Login

- URL: `/admin/login.php`
- Email: `admin@slgti.lk`
- Password: `admin123`

## Features

- Staff submission form (login required)
- Reference-number based updates
- Admin dashboard with Chart.js analytics
- Submission management with search/filter
- PDF and Excel report export
- SLGTI branded UI (#005BAC / #FFC107)
