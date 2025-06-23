# Laravel Application Deployment Guide

## Quick Deployment Steps

1. **Backup your database and files**
2. **Upload all new code files to your server**
3. **Access the deployment helper script: https://orustravel.org/laravel-test/fixes/deployment_helper.php**
4. **Test your application**

## Detailed Deployment Instructions

### 1. Pre-Deployment

- **Always make a backup** before deploying:
  ```bash
  # Database backup
  mysqldump -u your_username -p your_database > backup-$(date +%Y-%m-%d).sql
  
  # Files backup (either through your hosting panel or using zip)
  zip -r website-backup-$(date +%Y-%m-%d).zip /path/to/your/website
  ```

- **Check development vs. production differences**:
  - Database structure
  - Environment variables (.env)
  - Third-party services configuration

### 2. File Upload

- **Upload all new code files** to your server:
  - Use SFTP, Git, or your hosting control panel
  - Make sure to preserve your `.env` file and storage directory contents

- **Critical files never to replace**:
  - `.env` (contains your production database credentials)
  - `storage/app/*` (user uploads and application files)
  - `storage/logs/*` (important for debugging)

### 3. Run the Deployment Helper

- **Access the deployment helper script** in your browser:
  ```
  https://orustravel.org/laravel-test/fixes/deployment_helper.php
  ```

- This script will automatically:
  - Create missing database tables
  - Add required columns to existing tables
  - Fix migration records
  - Set correct file permissions
  - Clear all Laravel caches
  - Verify required components

### 4. Testing

- **Test your application thoroughly**:
  - Visit the homepage
  - Login functionality
  - Critical features
  - Any new features in this deployment

- **If issues persist**:
  - Check your error logs: `storage/logs/laravel.log`
  - Run the debug script: `https://orustravel.org/laravel-test/fixes/debug.php`

## Maintaining the Deployment Helper

As your application evolves, you'll need to update the deployment helper script:

### When to Update the Helper Script

- When adding new database tables
- When adding new columns to existing tables
- When adding new Telescope or package components

### How to Update the Helper Script

1. Add new tables to the `$requiredTables` array:
```php
$requiredTables = [
    'plants' => "CREATE TABLE IF NOT EXISTS...",
    'your_new_table' => "CREATE TABLE IF NOT EXISTS...",
];
```

2. Add new columns to the `$requiredColumns` array:
```php
$requiredColumns = [
    'dashboard_settings' => [
        'existing_column' => "VARCHAR(255) DEFAULT 'value'",
        'new_column' => "VARCHAR(255) DEFAULT 'new_value'",
    ],
];
```

3. Add new migrations to the `$coreMigrations` array:
```php
$coreMigrations = [
    // Existing migrations...
    'YYYY_MM_DD_HHMMSS_create_your_new_table',
];
```

## Common Deployment Issues and Solutions

### Database Connection Issues

- Check your `.env` file database credentials
- Make sure your MySQL user has proper permissions
- Confirm database host is correctly specified

### Blank Pages or 500 Errors

- Check Laravel logs: `storage/logs/laravel.log`
- Run the debug script to identify issues
- Clear caches: Access `https://orustravel.org/laravel-test/fixes/deployment_helper.php`

### Telescope Errors

The deployment helper automatically creates Telescope tables if they don't exist.

### Migration Errors

The deployment helper automatically marks migrations as completed without running them.

### Storage/Upload Issues

- Check permissions on the storage directory
- Verify the symlink exists between storage and public

## Important Notes

- **Always add new database columns to the deployment helper script** when you create them in development
- **Keep your deployment documentation up to date**
- **Consider using a staging environment** for testing before deploying to production
- **Maintain backups** for quick rollback if needed

## Support

If you encounter issues not addressed by the deployment helper:

1. Check the Laravel application logs: `storage/logs/laravel.log`
2. Run the debug script: `https://orustravel.org/laravel-test/fixes/debug.php`
3. Make sure all caches are cleared
4. Contact the development team with specific error messages 