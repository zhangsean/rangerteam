ALTER TABLE `sys_entry` CHANGE `login` `login` varchar(255) COLLATE 'utf8_general_ci' NOT NULL AFTER `logo`,
CHANGE `logout` `logout` varchar(255) COLLATE 'utf8_general_ci' NOT NULL AFTER `login`,
CHANGE `api` `blocks` varchar(255) COLLATE 'utf8_general_ci' NOT NULL AFTER `logout`;
ALTER TABLE `sys_entry` ADD `control` varchar(10) COLLATE 'utf8_general_ci' NOT NULL DEFAULT 'simple' AFTER `blocks`,
ADD `size` varchar(50) COLLATE 'utf8_general_ci' NOT NULL DEFAULT 'max' AFTER `control`,
ADD `position` varchar(10) COLLATE 'utf8_general_ci' NOT NULL DEFAULT 'default' AFTER `size`;
