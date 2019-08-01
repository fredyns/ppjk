
ALTER TABLE `jobContainer`
ADD INDEX `idx_si` (`shippingInstruction_id` ASC),
ADD INDEX `idx_cnum` (`containerNumber` ASC),
ADD INDEX `idx_cdepo` (`containerDepo_id` ASC),
ADD INDEX `idx_sloc` (`stuffingLocation_id` ASC),
ADD INDEX `idx_spv` (`supervisor_id` ASC),
ADD INDEX `idx_tvendor` (`truckVendor_id` ASC);
