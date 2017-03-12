
ALTER TABLE `companyType`
ADD COLUMN `recordStatus` ENUM('active', 'deleted') NULL DEFAULT 'active' AFTER `name`,
ADD COLUMN `created_at` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `recordStatus`,
ADD COLUMN `created_by` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `created_at`,
ADD COLUMN `updated_at` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `created_by`,
ADD COLUMN `updated_by` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `updated_at`,
ADD COLUMN `deleted_at` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `updated_by`,
ADD COLUMN `deleted_by` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `deleted_at`;
