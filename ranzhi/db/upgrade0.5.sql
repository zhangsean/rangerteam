ALTER TABLE `crm_customer` ADD `intension` text NOT NULL AFTER `level`;
ALTER TABLE `sys_product` CHANGE `summary`  `desc` text NOT NULL;
ALTER TABLE `crm_customer` DROP `referType`;
ALTER TABLE `crm_customer` DROP `referID`;
