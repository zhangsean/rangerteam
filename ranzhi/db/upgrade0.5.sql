ALTER TABLE `sys_product` CHANGE `summary`  `desc` text NOT NULL,
DROP `code`;

ALTER TABLE `crm_customer` ADD `intension` text NOT NULL AFTER `level`, DROP `referType`, DROP `referID`;

ALTER TABLE `crm_order` add `nextDate` date NOT NULL;

ALTER TABLE `crm_contract`
ADD `deliveredBy` char(30) COLLATE 'utf8_general_ci' NOT NULL AFTER `signedDate`,
ADD `deliveredDate` datetime NOT NULL AFTER `deliveredBy`,
ADD `returnedBy` char(30) COLLATE 'utf8_general_ci' NOT NULL AFTER `deliveredDate`,
ADD `returnedDate` datetime NOT NULL AFTER `returnedBy`,
ADD `handlers` varchar(255) NOT NULL AFTER `contact`;

ALTER TABLE sys_action ADD customer mediumint(8) UNSIGNED AFTER id,
ADD contact mediumint(8) UNSIGNED AFTER customer,
ADD contract mediumint(8) UNSIGNED AFTER contact,
CHANGE `product` `product`  mediumint(8) UNSIGNED AFTER contract;

ALTER TABLE `crm_contact` ADD `maker` enum('0','1') COLLATE 'utf8_general_ci' NOT NULL DEFAULT '0' AFTER `customer`;
ALTER TABLE `crm_relation` RENAME TO `crm_resume`;

ALTER TABLE `crm_resume` ADD `id` mediumint unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST;
ALTER TABLE `crm_resume` CHANGE `titile` `title` char(100) COLLATE 'utf8_general_ci' NOT NULL AFTER `dept`;

ALTER TABLE `crm_address` ADD `title` varchar(255) COLLATE 'utf8_general_ci' NOT NULL AFTER `objectID`;
ALTER TABLE `crm_address` CHANGE `id` `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST;

ALTER TABLE sys_category CHANGE id id mediumint(8) unsigned NOT NULL AUTO_INCREMENT;
ALTER TABLE sys_category CHANGE parent parent mediumint(8) unsigned NOT NULL AUTO_INCREMENT;
