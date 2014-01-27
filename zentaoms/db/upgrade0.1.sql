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
