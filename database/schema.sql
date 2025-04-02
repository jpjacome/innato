-- Basic schema for DR Pixel CMS
-- For manual import if you don't have command line access

-- Create users table
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `role` enum('admin','editor','regular') NOT NULL DEFAULT 'regular',
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create password_reset_tokens table
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create failed_jobs table
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create dashboard_settings table
CREATE TABLE IF NOT EXISTS `dashboard_settings` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `primary_color` varchar(255) NOT NULL DEFAULT '#4F46E5',
  `secondary_color` varchar(255) NOT NULL DEFAULT '#818CF8',
  `accent_color` varchar(255) NOT NULL DEFAULT '#6366f1',
  `dashboard_title` varchar(255) NOT NULL DEFAULT 'Dashboard',
  `logo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create hero_settings table
CREATE TABLE IF NOT EXISTS `hero_settings` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title_text` varchar(255) NOT NULL DEFAULT 'WELCOME',
  `title_color` varchar(255) NOT NULL DEFAULT '#FFFFFF',
  `title_size` varchar(255) NOT NULL DEFAULT '4rem',
  `title_font` varchar(255) NOT NULL DEFAULT 'Playfair Display',
  `background_color` varchar(255) NOT NULL DEFAULT '#6366f1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert default admin user
INSERT INTO `users` (`name`, `email`, `password`, `role`, `is_admin`, `created_at`, `updated_at`)
VALUES ('Admin', 'admin@example.com', '$2y$12$6c.8ZlEy/zVN93b2LtF6quVu.nrsj7TFVBqJdHZL/bZOD/k.zpjIS', 'admin', 1, NOW(), NOW());

-- Insert default hero settings
INSERT INTO `hero_settings` (`title_text`, `title_color`, `title_size`, `title_font`, `background_color`, `created_at`, `updated_at`)
VALUES ('WELCOME', '#FFFFFF', '4rem', 'Playfair Display', '#6366f1', NOW(), NOW());

-- Insert default dashboard settings
INSERT INTO `dashboard_settings` (`primary_color`, `secondary_color`, `accent_color`, `dashboard_title`, `created_at`, `updated_at`)
VALUES ('#4F46E5', '#818CF8', '#6366f1', 'Dashboard', NOW(), NOW()); 