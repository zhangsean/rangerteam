ALTER TABLE `sys_entry` CHANGE `login` `login` varchar(255) COLLATE 'utf8_general_ci' NOT NULL AFTER `logo`,
CHANGE `logout` `logout` varchar(255) COLLATE 'utf8_general_ci' NOT NULL AFTER `login`,
CHANGE `api` `blocks` varchar(255) COLLATE 'utf8_general_ci' NOT NULL AFTER `logout`;
