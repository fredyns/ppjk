
ALTER TABLE `companyProfile`
ADD INDEX `index2` (`companyType_id` ASC);

ALTER TABLE `companyProfile`
ADD CONSTRAINT `fk_companyProfile_1`
  FOREIGN KEY (`companyType_id`)
  REFERENCES `companyType` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
