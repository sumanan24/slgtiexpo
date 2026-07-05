-- SLGTI 10-Year Impact Report Database Schema
-- MySQL 8.0+

CREATE DATABASE IF NOT EXISTS slgti_impact CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE slgti_impact;

-- --------------------------------------------------------
-- Table: departments
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `departments` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `department_name` VARCHAR(255) NOT NULL,
    `staff_name` VARCHAR(255) NOT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table: admins
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `admins` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `remember_token` VARCHAR(100) DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `admins_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table: hod_users (multiple staff accounts per department)
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `hod_users` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `department_id` BIGINT UNSIGNED NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `phone` VARCHAR(255) DEFAULT NULL,
    `designation` VARCHAR(255) DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `hod_users_email_unique` (`email`),
    KEY `hod_users_department_id_index` (`department_id`),
    CONSTRAINT `hod_users_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table: submissions
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `submissions` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `reference_number` VARCHAR(255) NOT NULL,
    `department_id` BIGINT UNSIGNED NOT NULL,
    `hod_user_id` BIGINT UNSIGNED DEFAULT NULL,
    `staff_name` VARCHAR(255) NOT NULL,
    `submitted_by` VARCHAR(255) NOT NULL,
    `designation` VARCHAR(255) DEFAULT NULL,
    `email` VARCHAR(255) NOT NULL,
    `phone` VARCHAR(255) NOT NULL,
    `student_growth` JSON NOT NULL,
    `department_growth` JSON NOT NULL,
    `special_achievements` JSON NOT NULL,
    `events_conducted` JSON NOT NULL,
    `income_generation` JSON NOT NULL,
    `industry_partnerships` JSON NOT NULL,
    `research_innovations` JSON NOT NULL,
    `staff_development` JSON NOT NULL,
    `infrastructure_development` TEXT DEFAULT NULL,
    `community_services` JSON NOT NULL,
    `future_plans` JSON NOT NULL,
    `supporting_documents` VARCHAR(255) DEFAULT NULL,
    `google_drive_link` VARCHAR(500) DEFAULT NULL,
    `submission_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `status` ENUM('pending', 'completed') NOT NULL DEFAULT 'pending',
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `submissions_reference_number_unique` (`reference_number`),
    KEY `submissions_department_id_foreign` (`department_id`),
    KEY `submissions_hod_user_id_foreign` (`hod_user_id`),
    CONSTRAINT `submissions_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE,
    CONSTRAINT `submissions_hod_user_id_foreign` FOREIGN KEY (`hod_user_id`) REFERENCES `hod_users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Seed Data: Departments
-- --------------------------------------------------------
INSERT INTO `departments` (`department_name`, `staff_name`, `created_at`, `updated_at`) VALUES
('Information & Communication Technology (ICT)', 'Mr. N. Sivakumar', NOW(), NOW()),
('Automotive Technology', 'Mr. T. Rajendran', NOW(), NOW()),
('Electrical & Electronic Technology', 'Mr. K. Muralitharan', NOW(), NOW()),
('Mechanical Technology', 'Mr. P. Suresh', NOW(), NOW()),
('Construction Technology', 'Mr. A. Ganesan', NOW(), NOW()),
('Food Technology', 'Mrs. S. Priya', NOW(), NOW());

-- --------------------------------------------------------
-- Seed Data: Default Admin (password: admin123)
-- --------------------------------------------------------
INSERT INTO `admins` (`name`, `email`, `password`, `created_at`, `updated_at`) VALUES
('SLGTI Administrator', 'admin@slgti.lk', '$2y$10$eQXCBLxRxSPeIO5osOWR3uUWXhgfxTpCV66aSe1V.yb2xWKKUlZzm', NOW(), NOW());

-- Note: Default admin password is 'admin123'. Change immediately after installation.
