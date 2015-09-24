ALTER TABLE `sys_task` add `team` VARCHAR(255) NOT NULL DEFAULT '' AFTER `desc`;
ALTER TABLE `sys_task` add `parent` mediumint(8) unsigned NOT NULL DEFAULT 0 AFTER `team`;

-- DROP TABLE IF EXISTS `oa_todo`;
CREATE TABLE IF NOT EXISTS `oa_todo` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `account` char(30) NOT NULL,
  `date` date NOT NULL,
  `begin` smallint(4) unsigned zerofill NOT NULL,
  `end` smallint(4) unsigned zerofill NOT NULL,
  `type` char(10) NOT NULL,
  `idvalue` mediumint(8) unsigned NOT NULL default '0',
  `pri` tinyint(3) unsigned NOT NULL,
  `name` char(150) NOT NULL,
  `desc` text NOT NULL,
  `status`  enum('wait','doing','done') NOT NULL DEFAULT 'wait',
  `private` tinyint(1) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `user` (`account`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

ALTER TABLE `oa_project` add `acl` enum('open','private','custom') NOT NULL default 'open' AFTER `status`;
ALTER TABLE `oa_project` add `whitelist` varchar(255) NOT NULL AFTER `acl`;
ALTER TABLE `oa_project` add `viewList` varchar(255) NOT NULL AFTER `whitelist`;
ALTER TABLE `oa_project` add `editList` varchar(255) NOT NULL AFTER `viewList`;
