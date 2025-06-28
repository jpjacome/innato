# Application Reference: Innato Platform

## Overview
This document provides a comprehensive reference for the Innato Laravel application, including all custom logic, routes, controllers, models, views, migrations, and vital features. It is intended as a single source of truth for future development and maintenance.

---

## 1. Directory Structure (Key Custom Folders)

- `app/Http/Controllers/` — All main controllers (admin, user, settings, etc.)
- `app/Models/` — Eloquent models for all main entities
- `resources/views/` — Blade templates for all user/admin pages
- `routes/` — Route definitions (web, api, etc.)
- `database/migrations/` — All database schema migrations
- `database/seeders/` — Seeders for initial data
- `public/` — Public assets, entry point, and static files
- `config/` — Application configuration files

---

## 2. Routes

### Web Routes (`routes/web.php`)
- Main entry points for the web application, including homepage, authentication, and admin dashboard.
- Custom routes for:
  - Homepage (`/home`)
  - Admin dashboard and pages management
  - Authentication (login, register, etc.)
  - Profile and user management

### API Routes (`routes/api.php`)
- (If present) Used for RESTful endpoints, likely for AJAX or external integrations.

### Auth & Console Routes
- `routes/auth.php` — Authentication scaffolding
- `routes/console.php` — For Laravel Artisan commands

---

## 3. Controllers

### Main Controllers (`app/Http/Controllers/`)
- `PagesController.php` — Handles admin page management, including editing homepage content and settings.
- `ProfileController.php` — User profile management.
- `SettingsController.php` — Application and user settings.
- `HeroSettingsController.php` — Manages hero section settings.
- `StyleController.php` — UI and theme customization.
- `UserManagementController.php` — Admin user management.
- `WelcomeController.php` — Likely handles the public welcome page.

### Admin Controllers (`app/Http/Controllers/Admin/`)


### Auth Controllers (`app/Http/Controllers/Auth/`)
- Standard Laravel Breeze/Fortify controllers for authentication, password reset, registration, etc.

---

## 4. Models (`app/Models/`)
- `HomeSetting.php` — Stores homepage content/settings (hero, headline, destinations, etc.).
- `HeroSetting.php` — Hero section configuration.
- `DashboardSettings.php` — Admin dashboard UI settings.
- `Role.php` — User roles and permissions.
- `User.php` — Main user model.

---

## 5. Views (`resources/views/`)

### Main Pages
- `home.blade.php` — Public homepage, dynamic content from `HomeSetting`.
- `dashboard.blade.php` — User/admin dashboard.
- `contact.blade.php`, `about.blade.php`, `destinations.blade.php`, etc. — Informational pages.

### Admin Views (`resources/views/admin/`)
- `pages/index.blade.php` — Admin dashboard for managing pages.
- `pages/edit-home.blade.php` — Admin form for editing homepage content (hero, headline, destinations, etc.).
- `settings/index.blade.php` — Admin settings UI.
- `users/` — User management (create, edit, list).

### Layouts & Components
- `layouts/` — Shared Blade layouts.
- `components/` — Reusable Blade components.

---

## 6. Migrations (`database/migrations/`)
- `create_home_settings_table.php` — Defines the `home_settings` table for homepage content.
- `add_headline_images_to_home_settings_table.php` — Adds image fields to homepage settings.
- `add_destinations_footer_text_to_home_settings_table.php` — Adds editable footer text for destinations section.
- `create_users_table.php`, `create_roles_table.php` — User and role management.
- `create_dashboard_settings_table.php` — Admin dashboard settings.
- `create_hero_settings_table.php` — Hero section settings.
- `create_pulse_tables.php`, `create_telescope_entries_table.php` — For Laravel Pulse/Telescope (monitoring/debugging).
- (Other migrations for legacy maintenance features.)

---

## 7. Seeders (`database/seeders/`)
- `UserSeeder.php`, `RoleSeeder.php` — Initial user and role data.
- `DashboardSettingsSeeder.php`, `HeroSettingSeeder.php` — Default settings for dashboard/hero.

---

## 8. Public Assets (`public/`)
- `index.php` — Laravel entry point.
- `assets/`, `css/`, `build/` — Static assets (CSS, JS, images).
- `favicon.ico`, `phpinfo.php` — Miscellaneous public files.

---

## 9. Configuration (`config/`)
- `app.php`, `auth.php`, `database.php`, etc. — Standard Laravel config files.
- `pulse.php`, `telescope.php` — Monitoring/debugging tools.

---

## 10. Tests (`tests/`)
- `Feature/` — Feature tests for main app logic.
- `Unit/` — Unit tests for models, services, etc.
- `TestCase.php` — Base test class.

---

## 11. Custom Features & Logic

### Homepage Editing
- Admins can edit all homepage content (hero, headline, destinations, footer text) via a dedicated form.
- All homepage content is stored in the `home_settings` table and loaded dynamically.

### User & Role Management
- Admins can manage users and assign roles.
- Roles are stored in the `roles` table and linked to users.


### Theming & UI Customization
- Dashboard and homepage support color, theme, and layout customization via settings.

### Monitoring & Debugging
- Laravel Pulse and Telescope are set up for monitoring requests, jobs, and debugging.

---

## 12. Legacy/Deprecated Features
- Plant management and maintenance log features have been removed. Some code or migrations may remain but are not active in the UI.

---

## 13. Third-Party Integrations
- (Planned) Google Analytics integration for homepage stats in the admin dashboard.
- (Optional) Spatie Laravel Analytics package for advanced stats.

---

## 14. How Everything Works (Summary)
- The homepage is fully dynamic, editable by admins, and all content is stored in the database.
- Admin dashboard provides UI for managing all content, users, and settings.
- All routes, controllers, and views are organized by feature and follow Laravel best practices.
- Monitoring and debugging are available via Pulse/Telescope.
- The app is ready for further integrations (e.g., analytics, new features) and is structured for maintainability.

---

# End of Reference
