ALTER TABLE `sys_task` add `team` VARCHAR(255) NOT NULL DEFAULT '' AFTER `desc`;
ALTER TABLE `sys_task` add `parent` mediumint(8) unsigned NOT NULL DEFAULT 0 AFTER `team`;
