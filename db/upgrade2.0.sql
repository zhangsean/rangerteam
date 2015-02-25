ALTER TABLE `oa_doc` CHANGE `lib` `lib` mediumint(8) unsigned NOT NULL AFTER `project`,
CHANGE `module` `module` mediumint(8) unsigned NOT NULL AFTER `lib`;

ALTER TABLE `oa_relation` RENAME TO `sys_relation`;
