
ALTER TABLE `shippingInstruction`
ADD CONSTRAINT `fk_shippingInstruction_shpr`
  FOREIGN KEY (`shipper_id`)
  REFERENCES `companyProfile` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_shippingInstruction_shpn`
  FOREIGN KEY (`shipping_id`)
  REFERENCES `companyProfile` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_shippingInstruction_dest`
  FOREIGN KEY (`destination_id`)
  REFERENCES `containerPort` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
