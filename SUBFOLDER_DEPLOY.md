# Subdirectory Deployment Guide

This application is configured to be deployed in the subdirectory `/laravel-test` at `http://orustravel.org/laravel-test`.

## Special Configuration for Subdirectory

The following files have been configured for subdirectory deployment:

1. `.env.production`
   - Sets `APP_URL=http://orustravel.org/laravel-test`
   - Sets `ASSET_URL=http://orustravel.org/laravel-test`

2. Root `.htaccess`
   - Added `RewriteBase /laravel-test/`
   - Updated error document path to `/laravel-test/index.php`

3. `public/.htaccess`
   - Already contains `RewriteBase /laravel-test/public/`

4. Root `index.php`
   - Added code to handle the subfolder in URI path

5. `config/app.php`
   - Added `asset_url` configuration to properly load assets

## Deployment Steps for Subdirectory

1. Upload all files to the `/laravel-test` directory on your web server
2. Rename `.env.production` to `.env`
3. Import the database schema from `database/schema.sql`
4. Visit `http://orustravel.org/laravel-test` to access your application

## Troubleshooting

If you experience issues:

1. **404 Errors**: Make sure your web server allows .htaccess files
2. **Asset Loading Issues**: Check if the ASSET_URL is correctly set
3. **Missing Images**: If images don't load, you may need to create a symlink:
   ```bash
   ln -s /path/to/laravel-test/storage/app/public /path/to/laravel-test/public/storage
   ```
   or manually copy the files

4. **Database Connection**: Double-check your database credentials in the `.env` file 