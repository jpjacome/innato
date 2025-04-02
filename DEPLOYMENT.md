# Deployment Checklist

## 1. Local Preparation
- [ ] Run `composer install --optimize-autoloader --no-dev`
- [ ] Run `php artisan config:cache`
- [ ] Run `php artisan route:cache`
- [ ] Run `php artisan view:cache`
- [ ] Update `.env.production` with your actual values
- [ ] Generate new app key: `php artisan key:generate`

## 2. Database Setup
- [ ] Create new database on hosting
- [ ] Update `.env.production` with database credentials
- [ ] Run migrations: `php artisan migrate`
- [ ] Run seeders: `php artisan db:seed`

## 3. File Upload
- [ ] Upload all files to hosting via FTP
- [ ] Make sure `.env.production` is uploaded as `.env`
- [ ] Set proper permissions:
  - Directories: 755
  - Files: 644
  - Storage directory: 775
  - Bootstrap/cache: 775

## 4. Server Configuration
- [ ] Point web server to `public` directory
- [ ] Configure URL rewriting
- [ ] Set up SSL certificate if needed

## 5. Post-Deployment
- [ ] Clear all caches: `php artisan cache:clear`
- [ ] Clear config: `php artisan config:clear`
- [ ] Clear routes: `php artisan route:clear`
- [ ] Clear views: `php artisan view:clear`
- [ ] Test all functionality 