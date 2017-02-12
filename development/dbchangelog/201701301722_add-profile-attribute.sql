-- MySQL Workbench Synchronization
-- Generated: 2017-01-30 17:21
-- Model: New Model
-- Version: 1.0
-- Project: Name of the project
-- Author: Fredy

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

ALTER TABLE `profile` 
ADD COLUMN `phone` VARCHAR(64) NULL DEFAULT NULL AFTER `picture_id`,
ADD COLUMN `address` TEXT NULL DEFAULT NULL AFTER `phone`,
ADD COLUMN `recordStatus` ENUM('active', 'deleted') NULL DEFAULT 'active' AFTER `address`,
ADD COLUMN `created_at` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `recordStatus`,
ADD COLUMN `created_by` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `created_at`,
ADD COLUMN `updated_at` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `created_by`,
ADD COLUMN `updated_by` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `updated_at`,
ADD COLUMN `deleted_at` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `updated_by`,
ADD COLUMN `deleted_by` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `deleted_at`;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;