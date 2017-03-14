
ALTER TABLE `jobContainer`
ADD CONSTRAINT `fk_jobContainer_type`
  FOREIGN KEY (`type_id`)
  REFERENCES `containerType` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
