
ALTER TABLE `jobContainer`
ADD CONSTRAINT `fk_jobContainer_si`
  FOREIGN KEY (`shippingInstruction_id`)
  REFERENCES `shippingInstruction` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_jobContainer_depo`
  FOREIGN KEY (`containerDepo_id`)
  REFERENCES `companyProfile` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_jobContainer_loc`
  FOREIGN KEY (`stuffingLocation_id`)
  REFERENCES `stuffingLocation` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_jobContainer_spv`
  FOREIGN KEY (`supervisor_id`)
  REFERENCES `truckSupervisor` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_jobContainer_vndor`
  FOREIGN KEY (`truckVendor_id`)
  REFERENCES `companyProfile` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
