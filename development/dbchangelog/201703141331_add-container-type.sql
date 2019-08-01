
ALTER TABLE `jobContainer`
ADD COLUMN `type_id` SMALLINT(5) UNSIGNED NULL DEFAULT NULL AFTER `size`,
ADD INDEX `idx_type` (`type_id` ASC);
