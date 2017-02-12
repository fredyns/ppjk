-- MySQL Workbench Synchronization
-- Generated: 2017-01-25 20:30
-- Model: New Model
-- Version: 1.0
-- Project: Name of the project
-- Author: Fredy

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE TABLE IF NOT EXISTS `migration` (
  `version` VARCHAR(180) NOT NULL,
  `apply_time` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`version`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `profile` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT(10) UNSIGNED NULL DEFAULT NULL,
  `name` VARCHAR(255) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `public_email` VARCHAR(255) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `gravatar_email` VARCHAR(255) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `gravatar_id` VARCHAR(32) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `location` VARCHAR(255) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `website` VARCHAR(255) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `bio` TEXT CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `timezone` VARCHAR(40) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `picture_id` BIGINT(19) UNSIGNED NULL DEFAULT NULL,
  INDEX `user_id` (`user_id` ASC),
  INDEX `picture_id` (`picture_id` ASC),
  PRIMARY KEY (`id`),
  UNIQUE INDEX `user_id_UNIQUE` (`user_id` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `social_account` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT(10) UNSIGNED NULL DEFAULT NULL,
  `provider` VARCHAR(255) CHARACTER SET 'utf8' NOT NULL,
  `client_id` VARCHAR(255) CHARACTER SET 'utf8' NOT NULL,
  `data` TEXT CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `code` VARCHAR(32) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `created_at` INT(10) UNSIGNED NULL DEFAULT NULL,
  `email` VARCHAR(255) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `username` VARCHAR(255) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `account_unique` (`provider` ASC, `client_id` ASC),
  UNIQUE INDEX `account_unique_code` (`code` ASC),
  INDEX `user_id` (`user_id` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `token` (
  `user_id` INT(10) UNSIGNED NOT NULL,
  `code` VARCHAR(32) CHARACTER SET 'utf8' NOT NULL,
  `created_at` INT(10) UNSIGNED NOT NULL,
  `type` SMALLINT(6) NOT NULL,
  INDEX `user_id` (`user_id` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `uploaded_file` (
  `id` BIGINT(19) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NULL DEFAULT NULL,
  `filename` TEXT NULL DEFAULT NULL,
  `size` INT(11) NULL DEFAULT NULL,
  `type` VARCHAR(64) NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `user` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(255) CHARACTER SET 'utf8' NOT NULL,
  `email` VARCHAR(255) CHARACTER SET 'utf8' NOT NULL,
  `password_hash` VARCHAR(60) CHARACTER SET 'utf8' NOT NULL,
  `auth_key` VARCHAR(32) CHARACTER SET 'utf8' NOT NULL,
  `confirmed_at` INT(11) NULL DEFAULT NULL,
  `unconfirmed_email` VARCHAR(255) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `blocked_at` INT(11) NULL DEFAULT NULL,
  `registration_ip` VARCHAR(45) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `created_at` INT(10) UNSIGNED NOT NULL,
  `updated_at` INT(10) UNSIGNED NOT NULL,
  `flags` INT(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE INDEX `user_unique_email` (`email` ASC),
  UNIQUE INDEX `user_unique_username` (`username` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `yii_session` (
  `id` CHAR(64) CHARACTER SET 'utf8' NOT NULL,
  `expire` INT(10) UNSIGNED NULL DEFAULT NULL,
  `data` LONGBLOB NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `shippingInstruction` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `number` INT(10) UNSIGNED NOT NULL,
  `shipper_id` INT(10) UNSIGNED NULL DEFAULT NULL,
  `shipping_id` INT(10) UNSIGNED NULL DEFAULT NULL,
  `destination_id` INT(10) UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `index2` (`number` ASC),
  INDEX `index3` (`shipper_id` ASC),
  INDEX `index4` (`shipping_id` ASC),
  INDEX `index5` (`destination_id` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `shipping` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `containerPort` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `companyProfile` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NULL DEFAULT NULL,
  `address` TEXT NULL DEFAULT NULL,
  `phone` VARCHAR(255) NULL DEFAULT NULL,
  `email` VARCHAR(64) NULL DEFAULT NULL,
  `npwp` VARCHAR(32) NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `personel` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `companyProfile_id` INT(10) UNSIGNED NOT NULL,
  `profile_id` INT(10) UNSIGNED NOT NULL,
  `title` VARCHAR(64) NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `index2` (`companyProfile_id` ASC),
  INDEX `index3` (`profile_id` ASC),
  CONSTRAINT `fk_personel_2`
    FOREIGN KEY (`profile_id`)
    REFERENCES `profile` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `jobContainer` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `shippingInstruction_id` INT(10) UNSIGNED NULL DEFAULT NULL,
  `containerNumber` VARCHAR(32) NULL DEFAULT NULL,
  `sealNumber` VARCHAR(64) NULL DEFAULT NULL,
  `stuffingDate` DATE NULL DEFAULT NULL,
  `stuffingLocation_id` INT(10) UNSIGNED NULL DEFAULT NULL,
  `driver_id` INT(10) UNSIGNED NULL DEFAULT NULL,
  `supervisor_id` INT(10) UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `index2` (`shippingInstruction_id` ASC),
  INDEX `index3` (`containerNumber` ASC),
  INDEX `index4` (`stuffingLocation_id` ASC),
  INDEX `index5` (`driver_id` ASC),
  INDEX `index6` (`supervisor_id` ASC),
  CONSTRAINT `fk_jobContainer_3`
    FOREIGN KEY (`driver_id`)
    REFERENCES `profile` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `stuffingLocation` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `truckSupervisor` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;