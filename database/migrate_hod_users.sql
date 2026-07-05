-- Staff user accounts (multiple accounts per department)
USE slgti_impact;

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

ALTER TABLE `submissions`
    ADD COLUMN `hod_user_id` BIGINT UNSIGNED NULL AFTER `department_id`,
    ADD KEY `submissions_hod_user_id_foreign` (`hod_user_id`),
    ADD CONSTRAINT `submissions_hod_user_id_foreign` FOREIGN KEY (`hod_user_id`) REFERENCES `hod_users` (`id`) ON DELETE SET NULL;
