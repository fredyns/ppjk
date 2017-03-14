
ALTER TABLE `jobContainer`
ADD COLUMN `containerDepo_id` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `stuffingDate`,
ADD INDEX `index8` (`containerDepo_id` ASC);
