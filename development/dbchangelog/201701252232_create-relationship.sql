-- MySQL Workbench Synchronization
-- Generated: 2017-01-25 22:32
-- Model: New Model
-- Version: 1.0
-- Project: Name of the project
-- Author: Fredy

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

ALTER TABLE `ppjk`.`profile` 
ADD CONSTRAINT `fk_profile_user`
  FOREIGN KEY (`user_id`)
  REFERENCES `ppjk`.`user` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_profile_picture`
  FOREIGN KEY (`picture_id`)
  REFERENCES `ppjk`.`uploaded_file` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `ppjk`.`social_account` 
ADD CONSTRAINT `fk_social_account_user`
  FOREIGN KEY (`user_id`)
  REFERENCES `ppjk`.`user` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `ppjk`.`token` 
ADD CONSTRAINT `fk_token_user`
  FOREIGN KEY (`user_id`)
  REFERENCES `ppjk`.`user` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `ppjk`.`shippingInstruction` 
ADD CONSTRAINT `fk_shippingInstruction_1`
  FOREIGN KEY (`shipper_id`)
  REFERENCES `ppjk`.`companyProfile` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_shippingInstruction_2`
  FOREIGN KEY (`shipping_id`)
  REFERENCES `ppjk`.`shipping` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_shippingInstruction_3`
  FOREIGN KEY (`destination_id`)
  REFERENCES `ppjk`.`containerPort` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `ppjk`.`personel` 
ADD CONSTRAINT `fk_personel_1`
  FOREIGN KEY (`companyProfile_id`)
  REFERENCES `ppjk`.`companyProfile` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `ppjk`.`jobContainer` 
ADD CONSTRAINT `fk_jobContainer_1`
  FOREIGN KEY (`shippingInstruction_id`)
  REFERENCES `ppjk`.`shippingInstruction` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_jobContainer_2`
  FOREIGN KEY (`stuffingLocation_id`)
  REFERENCES `ppjk`.`stuffingLocation` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_jobContainer_4`
  FOREIGN KEY (`supervisor_id`)
  REFERENCES `ppjk`.`truckSupervisor` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
