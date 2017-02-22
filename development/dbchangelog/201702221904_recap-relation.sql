-- MySQL Workbench Synchronization
-- Generated: 2017-02-22 19:17
-- Model: New Model
-- Version: 1.0
-- Project: Name of the project
-- Author: Fredy

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

ALTER TABLE `daily_driving`
ADD INDEX `index2` (`driver_id` ASC);

ALTER TABLE `daily_shipper`
ADD INDEX `index2` (`shipper_id` ASC);

ALTER TABLE `daily_stuffingLocation`
ADD INDEX `index2` (`stuffingLocation_id` ASC);

ALTER TABLE `daily_truckSupervising`
ADD INDEX `index2` (`supervisor_id` ASC);

ALTER TABLE `monthly_shipper`
ADD INDEX `index2` (`shipper_id` ASC);

ALTER TABLE `monthly_destination`
ADD INDEX `index2` (`destination_id` ASC);

ALTER TABLE `monthly_driving`
ADD INDEX `index2` (`driver_id` ASC);

ALTER TABLE `monthly_truckSupervising`
ADD INDEX `index2` (`supervisor_id` ASC);

ALTER TABLE `monthly_stuffingLocation`
ADD INDEX `index2` (`stuffingLocation_id` ASC);

ALTER TABLE `daily_shipper`
ADD CONSTRAINT `fk_daily_shipper_1`
  FOREIGN KEY (`shipper_id`)
  REFERENCES `companyProfile` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `monthly_shipper`
ADD CONSTRAINT `fk_monthly_shipper_1`
  FOREIGN KEY (`shipper_id`)
  REFERENCES `companyProfile` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `monthly_destination`
ADD CONSTRAINT `fk_monthly_destination_1`
  FOREIGN KEY (`destination_id`)
  REFERENCES `containerPort` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `daily_driving`
ADD CONSTRAINT `fk_daily_driving_1`
  FOREIGN KEY (`driver_id`)
  REFERENCES `companyProfile` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `daily_truckSupervising`
ADD CONSTRAINT `fk_daily_truckSupervising_1`
  FOREIGN KEY (`supervisor_id`)
  REFERENCES `truckSupervisor` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `monthly_driving`
ADD CONSTRAINT `fk_monthly_driving_1`
  FOREIGN KEY (`driver_id`)
  REFERENCES `companyProfile` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `monthly_truckSupervising`
ADD CONSTRAINT `fk_monthly_truckSupervising_1`
  FOREIGN KEY (`supervisor_id`)
  REFERENCES `truckSupervisor` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `daily_stuffingLocation`
ADD CONSTRAINT `fk_daily_stuffingLocation_1`
  FOREIGN KEY (`stuffingLocation_id`)
  REFERENCES `stuffingLocation` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `monthly_stuffingLocation`
ADD CONSTRAINT `fk_monthly_stuffingLocation_1`
  FOREIGN KEY (`stuffingLocation_id`)
  REFERENCES `stuffingLocation` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
