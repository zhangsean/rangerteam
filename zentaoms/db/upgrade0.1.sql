ALTER TABLE `sys_entry` CHANGE `login` `login` varchar(255) COLLATE 'utf8_general_ci' NOT NULL AFTER `logo`,
CHANGE `logout` `logout` varchar(255) COLLATE 'utf8_general_ci' NOT NULL AFTER `login`,
CHANGE `api` `block` varchar(255) COLLATE 'utf8_general_ci' NOT NULL AFTER `logout`;
ALTER TABLE `sys_entry` ADD `control` varchar(10) COLLATE 'utf8_general_ci' NOT NULL DEFAULT 'simple' AFTER `block`,
ADD `size` varchar(50) COLLATE 'utf8_general_ci' NOT NULL DEFAULT 'max' AFTER `control`,
ADD `position` varchar(10) COLLATE 'utf8_general_ci' NOT NULL DEFAULT 'default' AFTER `size`;
ALTER TABLE sys_task CHANGE openedBy createdBy char(30) NOT NULL;
ALTER TABLE sys_task CHANGE openedDate createdDate datetime NOT NULL;

ALTER TABLE `crm_contract`
ADD `delivery` char(30) COLLATE 'utf8_general_ci' NOT NULL AFTER `end`,
ADD `return` char(30) COLLATE 'utf8_general_ci' NOT NULL AFTER `delivery`,
ADD `createdBy` char(30) COLLATE 'utf8_general_ci' NOT NULL,
ADD `createdDate` datetime NOT NULL AFTER `createdBy`,
ADD `editedBy` char(30) COLLATE 'utf8_general_ci' NOT NULL AFTER `createdDate`,
ADD `editedDate` datetime NOT NULL AFTER `editedBy`;

ALTER TABLE `crm_contact` ADD `customer` MEDIUMINT( 8 ) NOT NULL AFTER `id`;
CREATE TABLE IF NOT EXISTS `oa_effort` (
  `id` MEDIUMINT( 8 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
  `objectType` VARCHAR( 30 ) NOT NULL ,
  `objectID` SMALLINT( 8 ) UNSIGNED NOT NULL ,
  `product` VARCHAR( 255 ) NOT NULL ,
  `account` VARCHAR( 30 ) NOT NULL ,
  `work` VARCHAR( 255 ) NOT NULL ,
  `date` DATE NOT NULL ,
  `left` float NOT NULL,
  `consumed` float NOT NULL,
  `begin` SMALLINT( 4 ) UNSIGNED ZEROFILL NOT NULL ,
  `end` SMALLINT( 4 ) UNSIGNED ZEROFILL NOT NULL
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci ;
ALTER TABLE `sys_action` ADD `efforted` tinyint(1) NOT NULL DEFAULT '0';
