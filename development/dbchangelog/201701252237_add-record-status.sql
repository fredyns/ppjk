-- MySQL Workbench Synchronization
-- Generated: 2017-01-25 22:37
-- Model: New Model
-- Version: 1.0
-- Project: Name of the project
-- Author: Fredy

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

ALTER TABLE `ppjk`.`shippingInstruction` 
ADD COLUMN `recordStatus` ENUM('active', 'deleted') NULL DEFAULT 'active' AFTER `destination_id`,
ADD COLUMN `created_at` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `recordStatus`,
ADD COLUMN `created_by` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `created_at`,
ADD COLUMN `updated_at` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `created_by`,
ADD COLUMN `updated_by` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `updated_at`,
ADD COLUMN `deleted_at` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `updated_by`,
ADD COLUMN `deleted_by` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `deleted_at`;

ALTER TABLE `ppjk`.`shipping` 
ADD COLUMN `recordStatus` ENUM('active', 'deleted') NULL DEFAULT 'active' AFTER `name`,
ADD COLUMN `created_at` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `recordStatus`,
ADD COLUMN `created_by` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `created_at`,
ADD COLUMN `updated_at` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `created_by`,
ADD COLUMN `updated_by` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `updated_at`,
ADD COLUMN `deleted_at` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `updated_by`,
ADD COLUMN `deleted_by` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `deleted_at`;

ALTER TABLE `ppjk`.`containerPort` 
ADD COLUMN `recordStatus` ENUM('active', 'deleted') NULL DEFAULT 'active' AFTER `name`,
ADD COLUMN `created_at` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `recordStatus`,
ADD COLUMN `created_by` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `created_at`,
ADD COLUMN `updated_at` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `created_by`,
ADD COLUMN `updated_by` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `updated_at`,
ADD COLUMN `deleted_at` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `updated_by`,
ADD COLUMN `deleted_by` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `deleted_at`;

ALTER TABLE `ppjk`.`companyProfile` 
ADD COLUMN `recordStatus` ENUM('active', 'deleted') NULL DEFAULT 'active' AFTER `npwp`,
ADD COLUMN `created_at` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `recordStatus`,
ADD COLUMN `created_by` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `created_at`,
ADD COLUMN `updated_at` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `created_by`,
ADD COLUMN `updated_by` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `updated_at`,
ADD COLUMN `deleted_at` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `updated_by`,
ADD COLUMN `deleted_by` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `deleted_at`;

ALTER TABLE `ppjk`.`personel` 
ADD COLUMN `recordStatus` ENUM('active', 'deleted') NULL DEFAULT 'active' AFTER `title`,
ADD COLUMN `created_at` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `recordStatus`,
ADD COLUMN `created_by` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `created_at`,
ADD COLUMN `updated_at` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `created_by`,
ADD COLUMN `updated_by` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `updated_at`,
ADD COLUMN `deleted_at` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `updated_by`,
ADD COLUMN `deleted_by` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `deleted_at`;

ALTER TABLE `ppjk`.`jobContainer` 
ADD COLUMN `recordStatus` ENUM('active', 'deleted') NULL DEFAULT 'active' AFTER `supervisor_id`,
ADD COLUMN `created_at` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `recordStatus`,
ADD COLUMN `created_by` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `created_at`,
ADD COLUMN `updated_at` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `created_by`,
ADD COLUMN `updated_by` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `updated_at`,
ADD COLUMN `deleted_at` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `updated_by`,
ADD COLUMN `deleted_by` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `deleted_at`;

ALTER TABLE `ppjk`.`stuffingLocation` 
ADD COLUMN `recordStatus` ENUM('active', 'deleted') NULL DEFAULT 'active' AFTER `name`,
ADD COLUMN `created_at` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `recordStatus`,
ADD COLUMN `created_by` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `created_at`,
ADD COLUMN `updated_at` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `created_by`,
ADD COLUMN `updated_by` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `updated_at`,
ADD COLUMN `deleted_at` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `updated_by`,
ADD COLUMN `deleted_by` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `deleted_at`;

ALTER TABLE `ppjk`.`truckSupervisor` 
ADD COLUMN `recordStatus` ENUM('active', 'deleted') NULL DEFAULT 'active' AFTER `name`,
ADD COLUMN `created_at` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `recordStatus`,
ADD COLUMN `created_by` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `created_at`,
ADD COLUMN `updated_at` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `created_by`,
ADD COLUMN `updated_by` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `updated_at`,
ADD COLUMN `deleted_at` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `updated_by`,
ADD COLUMN `deleted_by` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `deleted_at`;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
