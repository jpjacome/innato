# Copilot Instructions for DR Pixel CMS

## Project Overview
- **Framework:** Laravel (PHP)
- **Frontend:** Blade templates, Alpine.js, custom CSS
- **Database:** MySQL (local: SQLite supported)
- **Purpose:** Modern CMS with dynamic admin panel, theming, and user/role management

## Key Architecture & Patterns
- **MVC Structure:**
  - `app/Models/` — Eloquent models (e.g., `Plant.php`, `Role.php`)
  - `app/Http/Controllers/` — Route controllers
  - `resources/views/` — Blade templates (e.g., `single-page-destination.blade.php`)
  - `routes/web.php` — Main web routes
- **Settings:**
  - Settings for dashboard, theming, etc. are in `app/Models/*Setting.php`
- **Admin Panel:**
  - Role-based access (see `Role.php` and controllers)
  - Dynamic theming via settings models and Blade
- **Custom Commands:**
  - Artisan commands in `app/Console/Commands/`
- **Migrations/Seeders:**
  - `database/migrations/`, `database/seeders/`

## Developer Workflows
- **Install dependencies:** `composer install`
- **Environment setup:** Copy `.env.example` to `.env`, set DB, then run `php artisan key:generate`
- **Migrate/seed DB:** `php artisan migrate --seed`
- **Run dev server:** `php artisan serve`
- **Debug scripts:** See `debug_*.php` in root for manual testing
- **Testing:** PHPUnit config in `phpunit.xml`, tests in `tests/`

## Conventions & Tips
- **Settings Models:** All `*Setting.php` models are for site/admin config
- **Blade Views:** Use Blade for all UI; Alpine.js for interactivity
- **Custom CSS:** Located in `resources/assets/css/`
- **Deployment:** See `DEPLOYMENT_GUIDE.md` and `fixes/` for scripts
- **Manual Fixes:** `fixes/` contains scripts for DB/schema fixes
- **Debugging:** Use `debug_*.php` scripts for isolated feature testing

## Integration Points
- **External:** Minimal; mostly Laravel core, Alpine.js, and MySQL
- **Storage:** Public assets in `public/`, user uploads in `public/storage/`

## Examples
- To add a new admin setting: create a model in `app/Models/`, migration, and Blade form
- To add a debug script: create `debug_feature.php` in root, use Laravel bootstrap

---
For more, see `README.md`, `DEPLOYMENT_GUIDE.md`, and code comments in key files.
