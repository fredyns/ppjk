
ALTER TABLE `jobContainer`
DROP COLUMN `notes`,
ADD COLUMN `notes` TEXT NULL DEFAULT NULL AFTER `policenumber`,
ADD INDEX `index7` (`truckVendor_id` ASC);

ALTER TABLE `jobContainer` 
ADD CONSTRAINT `fk_jobContainer_5`
  FOREIGN KEY (`truckVendor_id`)
  REFERENCES `companyProfile` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
