ALTER TABLE `sys_config` ADD `app` varchar(30) COLLATE 'utf8_general_ci' NOT NULL DEFAULT 'sys' AFTER `owner`;
ALTER TABLE `sys_config` ADD UNIQUE `unique` (`owner`, `app`, `module`, `section`, `key`),
DROP INDEX `unique`;
