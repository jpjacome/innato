# Admin Dashboard Restoration Plan

This document provides a step-by-step implementation plan to restore all admin functionality to the dashboard, based on the previous features and current codebase structure.

---

## 1. Overview of Required Features

- Homepage & Content Editing (all sections)
- Destinations Management (list, create, edit)
- User Management (list, create, edit)
- Settings Management
- Maintenance Management (if still relevant)
- Stats (homepage, destinations, etc.)
- Footer, Header, Reviews Editing
- Dashboard Navigation/Menu

---

## 2. Preparation & Audit

1. **Audit Existing Code:**
   - Review all Blade files in `resources/views/admin/` and their controllers/models.
   - List all routes in `routes/web.php` related to admin functionality.
   - Identify missing or broken links, controllers, and views.
2. **Review CSS:**
   - Ensure all admin views link to `public/css/general.css` and any feature-specific CSS (e.g., `edit-destination.css`).
   - Extract inline styles into dedicated CSS files for maintainability.
3. **Database Check:**
   - Confirm all required tables exist (users, roles, home_settings, destinations, etc.).
   - Run migrations and seeders if needed.

---

## 3. Step-by-Step Implementation

### Step 1: Restore Dashboard Layout & Navigation
- Create/restore a main dashboard Blade view (`dashboard.blade.php`).
- Add a sidebar or top navigation with links to all admin features:
  - Pages Management
  - Destinations
  - Users
  - Settings
  - Maintenance
  - Stats
  - Components (footer, header, reviews)
- Ensure navigation uses correct route names and permissions.

### Step 2: Homepage & Content Editing
- Restore views:
  - `admin/pages/edit-home.blade.php`
  - `admin/pages/edit-about.blade.php`
  - `admin/pages/edit-contact.blade.php`
  - `admin/pages/edit-destinations.blade.php`
  - `admin/pages/edit-experience-center.blade.php`
- Link each to the dashboard navigation.
- Confirm controllers (e.g., `PagesController`) handle GET/POST requests and validation.
- Test image uploads and previews.

### Step 3: Destinations Management
- Restore views:
  - `admin/destinations/index.blade.php` (list)
  - `admin/destinations/create.blade.php` (create)
  - `admin/destinations/edit.blade.php` (edit)
- Link to dashboard navigation.
- Confirm controller logic for CRUD operations.
- Test image upload, preview, and validation.
- Ensure `edit-destination.css` is linked.

### Step 4: User Management
- Restore views:
  - `admin/users/index.blade.php` (list)
  - `admin/users/create.blade.php` (create)
  - `admin/users/edit.blade.php` (edit)
- Link to dashboard navigation.
- Confirm controller logic for CRUD operations and role assignment.
- Test user creation, editing, and role management.

### Step 5: Settings Management
- Restore view: `admin/settings/index.blade.php`.
- Link to dashboard navigation.
- Confirm controller logic for updating settings.
- Test all settings forms and validation.

### Step 6: Maintenance Management
- Restore views:
  - `admin/maintenance/index.blade.php` (list)
  - `admin/maintenance/create.blade.php` (create)
- Link to dashboard navigation (if feature is still relevant).
- Confirm controller logic for CRUD operations.
- Test image upload and preview.

### Step 7: Stats & Analytics
- Restore stats views:
  - `admin/pages/home-stats.blade.php`
  - `admin/pages/home-stats-disabled.blade.php`
- Link to dashboard navigation.
- Confirm controller logic for stats display.
- Integrate Google Analytics or Spatie Laravel Analytics if planned.

### Step 8: Footer, Header, Reviews Editing
- Restore views:
  - `admin/components/edit-footer.blade.php`
  - `admin/components/edit-header.blade.php`
  - `admin/components/edit-reviews.blade.php`
- Link to dashboard navigation.
- Confirm controller logic for updating content.
- Test image/logo upload and preview.

### Step 9: Permissions & Access Control
- Ensure all admin routes are protected by middleware (e.g., `auth`, `admin`).
- Test role-based access for all dashboard features.

### Step 10: Final Testing & Polish
- Test all dashboard features end-to-end.
- Check for broken links, missing assets, and UI consistency.
- Refactor and clean up code as needed.
- Document any new routes, controllers, or features in `APP_REFERENCE.md`.

---

## 4. Additional Recommendations
- Extract repeated inline styles into CSS files.
- Use Blade components for repeated UI elements.
- Add error handling and user feedback for all forms.
- Ensure responsive design for mobile and desktop.
- Set up monitoring (Pulse/Telescope) for admin actions.

---

## 5. Timeline & Task Breakdown
- **Day 1:** Audit, dashboard layout, navigation
- **Day 2:** Homepage/content editing, destinations management
- **Day 3:** User management, settings, maintenance
- **Day 4:** Stats, components, permissions
- **Day 5:** Testing, polish, documentation

---

# End of Plan
