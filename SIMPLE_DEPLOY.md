# Simple Deployment Guide

This guide is for deploying DR Pixel CMS to a standard shared hosting environment with minimal configuration.

## Subdirectory Deployment

**Important**: This application is configured to run in a subdirectory at `http://orustravel.org/laravel-test`. 
See `SUBFOLDER_DEPLOY.md` for detailed subdirectory deployment information.

## Step 1: Prepare Your Files

We've already optimized the application for easy deployment. The following files are in place:
- Root `.htaccess` for Apache servers
- Root `index.php` to redirect to the public folder
- All assets built and ready to use
- Optimized autoloading

## Step 2: Upload Files to Your Hosting

1. Upload the entire project directory to your hosting server
   - You can use FTP, SFTP, or any file upload method your host provides
   - No need to upload to a specific directory like "public_html" - upload the whole project

## Step 3: Configure Database

1. Create a new database on your hosting server
2. Create a user with permissions to access that database
3. Update the `.env` file on your server with:
   ```
   DB_CONNECTION=mysql
   DB_HOST=localhost
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_database_username
   DB_PASSWORD=your_database_password
   ```

## Step 4: Generate Application Key

1. Connect to your server via SSH (if available) and run:
   ```
   php artisan key:generate
   ```

   OR

2. If you don't have SSH access, manually update the `.env` file with a key:
   - Generate a base64 key (32 characters) using an online tool
   - Add it to your `.env` file: `APP_KEY=base64:YourGeneratedKey`

## Step 5: Run Migrations

1. Via SSH (if available):
   ```
   php artisan migrate --seed
   ```

   OR

2. If your hosting has a database management tool like phpMyAdmin:
   - Import the database schema file `database/schema.sql` through the phpMyAdmin interface
   - This SQL file contains all necessary tables and default values

## Step 6: Verify Installation

1. Visit your website URL
2. Log in with the default credentials:
   - Email: admin@example.com
   - Password: password

3. Change the default admin password immediately!

## Troubleshooting

- If you see a 500 error, check your hosting's error logs
- Make sure your hosting supports PHP 8.1+ and all required extensions
- Ensure the `.env` file has proper permissions (644)
- Some hosts may require you to add specific server configuration files - check your hosting documentation 