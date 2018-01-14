-- MySQL Workbench Synchronization
-- Generated: 2018-01-13 14:40
-- Model: New Model
-- Version: 1.0
-- Project: PPJK
-- Author: Fredy

ALTER TABLE `jobContainer` 
ADD COLUMN `deliveryOrder` VARCHAR(32) NOT NULL AFTER `shippingInstruction_id`,
ADD COLUMN `shipper_id` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `deliveryOrder`,
ADD COLUMN `shipping_id` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `shipper_id`,
ADD COLUMN `destination_id` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `shipping_id`,
ADD INDEX `idx_do` (`deliveryOrder` ASC),
ADD INDEX `idx_shipper` (`shipper_id` ASC),
ADD INDEX `idx_shipping` (`shipping_id` ASC),
ADD INDEX `idx_destination` (`destination_id` ASC);
