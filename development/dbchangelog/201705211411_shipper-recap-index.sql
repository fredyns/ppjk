
ALTER TABLE `daily_shipper`
DROP INDEX `index2` ,
ADD UNIQUE INDEX `cycle` (`shipper_id` ASC, `date` ASC);

ALTER TABLE `monthly_shipper` 
DROP INDEX `index2` ,
ADD UNIQUE INDEX `cycle` (`shipper_id` ASC, `date` ASC);
