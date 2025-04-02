# Deployment Guide

## Preparation for Deployment

1. Make sure you have the following:
   - A web server with PHP 8.1+ support
   - MySQL or any supported database
   - Composer installed on your local machine

2. On your local machine, run these commands before deploying:
   ```bash
   # Clear all caches
   php artisan optimize:clear
   
   # Build assets for production
   npm run build
   ```

## Deployment Steps

1. **Upload files to your web host**
   - Upload all files to your hosting provider
   - Make sure the web server points to the `public` directory

2. **Set permissions** (if using Linux/Unix hosting)
   ```bash
   chmod -R 755 storage bootstrap/cache
   ```

3. **Copy .env file**
   - Create a `.env` file on the server
   - Update the database credentials and other settings
   - Set `APP_ENV=production` and `APP_DEBUG=false`

4. **Generate application key** (if not already set)
   ```bash
   php artisan key:generate
   ```

5. **Run migrations**
   ```bash
   php artisan migrate
   ```

6. **Seed the database** (for initial admin user)
   ```bash
   php artisan db:seed
   ```

## Default Login Credentials

- Email: admin@example.com
- Password: password

*Change these credentials after your first login!*

## Troubleshooting

- If images or uploads don't work, check that the `storage` directory is properly linked:
  ```bash
  php artisan storage:link
  ```

- If you see a blank page, check the permissions on the storage and bootstrap/cache directories.

- Make sure all PHP extensions required by Laravel are enabled on your server:
  - BCMath
  - Ctype
  - Fileinfo
  - JSON
  - Mbstring
  - OpenSSL
  - PDO
  - Tokenizer
  - XML 