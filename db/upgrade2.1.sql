ALTER TABLE `sys_category` ADD `rights` char(30) NOT NULL;
ALTER TABLE `sys_product` ADD `line` mediumint(8) unsigned NOT NULL AFTER `status`;
