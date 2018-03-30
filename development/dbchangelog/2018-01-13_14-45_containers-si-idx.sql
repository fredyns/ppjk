-- MySQL Workbench Synchronization
-- Generated: 2018-01-13 14:44
-- Model: New Model
-- Version: 1.0
-- Project: PPJK
-- Author: Fredy

ALTER TABLE `jobContainer` 
ADD CONSTRAINT `fk_jobContainer_shipr`
  FOREIGN KEY (`shipper_id`)
  REFERENCES `companyProfile` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_jobContainer_shipn`
  FOREIGN KEY (`shipping_id`)
  REFERENCES `companyProfile` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_jobContainer_dest`
  FOREIGN KEY (`destination_id`)
  REFERENCES `containerPort` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
