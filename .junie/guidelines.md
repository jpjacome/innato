# Innato Project Guidelines

## Project Overview

Innato is a Laravel-based web platform designed to empower small Ecuadorian communities to showcase their unique tourism experiences. The platform allows community leaders to create dedicated pages for their local tourism projects, and travelers can discover, learn about, and reserve these authentic experiences directly.

### Key Features

- **Community Showcase**: Communities can create custom pages with images, descriptions, and highlights
- **Tourist Reservation System**: Visitors can browse and reserve experiences
- **Admin Panel & CMS**: Role-based access for administrators and community leaders
- **Responsive Design**: Mobile-first and accessible interface
- **Security & Privacy**: Secure authentication and role-based permissions

## Project Structure

The project follows Laravel's standard directory structure with some custom organization:

### Core Directories

- `app/Models/` — Eloquent models (Destination, User, Reservation, etc.)
- `app/Http/Controllers/` — Route controllers organized by functionality
  - `Admin/` — Controllers for admin-specific functionality
  - `Editor/` — Controllers for community leader functionality
- `app/Http/Middleware/` — Custom middleware including role-based access control
- `resources/views/` — Blade templates organized by section
  - `admin/` — Admin panel views
  - `editor/` — Community leader views
  - `layouts/` — Layout templates
  - `components/` — Reusable UI components
- `public/` — Public assets (CSS, JavaScript, images)
- `routes/web.php` — Main web routes
- `database/migrations/` — Database schema definitions
- `database/seeders/` — Initial and demo data

### Key Models

1. **Destination**: Represents a community tourism destination with details like location, activities, services, etc.
2. **User**: Represents system users with different roles (admin, editor, regular)
3. **Reservation**: Represents bookings made by tourists for specific destinations

### User Roles

- **Admin**: Full access to all system features and content
- **Editor (Community Leader)**: Can manage their assigned destination's content and reservations
- **Regular User**: Can browse destinations and make reservations

## Development Guidelines

### Setting Up the Development Environment

1. Clone the repository:
   ```bash
   git clone https://github.com/jpjacome/innato.git
   cd innato
   ```

2. Install dependencies:
   ```bash
   composer install
   ```

3. Set up environment:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. Configure your database in `.env`

5. Run migrations and seeders:
   ```bash
   php artisan migrate --seed
   ```

6. Start the development server:
   ```bash
   php artisan serve
   ```

### Testing

The project uses PHPUnit for testing. Tests are organized into:

- **Unit Tests**: Located in `tests/Unit/` for testing individual components
- **Feature Tests**: Located in `tests/Feature/` for testing complete features

To run tests:

```bash
php artisan test
```

or

```bash
vendor/bin/phpunit
```

When implementing new features or fixing bugs, ensure that:
1. Existing tests pass
2. New functionality is covered by appropriate tests

### Coding Standards

The project follows Laravel's coding standards and PSR-12:

1. Use meaningful variable and function names
2. Add appropriate docblocks to classes and methods
3. Follow Laravel naming conventions:
   - Controllers: Singular, PascalCase, suffixed with "Controller" (e.g., `UserController`)
   - Models: Singular, PascalCase (e.g., `Destination`)
   - Database tables: Plural, snake_case (e.g., `destinations`)
   - Routes: Plural, kebab-case (e.g., `/destinations`)

4. Organize code logically:
   - Keep controllers thin, move business logic to services or models
   - Use Laravel's form requests for validation
   - Use Laravel's policies for authorization

### Git Workflow

1. Create feature branches from `main` with descriptive names
2. Make small, focused commits with clear messages
3. Submit pull requests for review before merging
4. Keep the `main` branch deployable at all times

## Deployment

The application can be deployed to any server that meets Laravel's requirements:

1. PHP >= 8.1
2. MySQL or compatible database
3. Composer
4. Required PHP extensions (BCMath, Ctype, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML)

Deployment steps:

1. Set up the production environment
2. Clone the repository
3. Install dependencies (`composer install --no-dev`)
4. Configure environment variables
5. Run migrations
6. Set up appropriate server configurations (Nginx/Apache)
7. Set up SSL certificates for secure connections

## Maintenance and Updates

1. Regularly update Laravel and dependencies
2. Monitor logs for errors and issues
3. Perform regular database backups
4. Keep track of security advisories for Laravel and used packages

## Contact

For questions or issues, contact:
- Juan Pablo Jacome — [@jpjacome](https://github.com/jpjacome)
- Website: [https://drpixel.it.nf/](https://drpixel.it.nf/)
- Project Link: [https://github.com/jpjacome/innato](https://github.com/jpjacome/innato)
