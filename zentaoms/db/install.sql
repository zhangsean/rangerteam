-- DROP TABLE IF EXISTS `oa_article`;
CREATE TABLE IF NOT EXISTS `oa_article` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `title` varchar(150) NOT NULL,
  `alias` varchar(100) NOT NULL,
  `keywords` varchar(150) NOT NULL,
  `summary` text NOT NULL,
  `content` text NOT NULL,
  `original` enum('1','0') NOT NULL,
  `copySite` varchar(60) NOT NULL,
  `copyURL` varchar(255) NOT NULL,
  `author` varchar(60) NOT NULL,
  `editor` varchar(60) NOT NULL,
  `addedDate` datetime NOT NULL,
  `editedDate` datetime NOT NULL,
  `status` varchar(20) NOT NULL default 'normal',
  `type` varchar(30) NOT NULL,
  `views` mediumint(5) unsigned NOT NULL default '0',
  `sticky` enum('0','1','2','3') NOT NULL default '0',
  `order` smallint(5) unsigned NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `order` (`order`),
  KEY `views` (`views`),
  KEY `sticky` (`sticky`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- DROP TABLE IF EXISTS `oa_block`;
CREATE TABLE IF NOT EXISTS `oa_block` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `type` varchar(20) NOT NULL,
  `title` varchar(60) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
-- DROP TABLE IF EXISTS `oa_book`;
CREATE TABLE IF NOT EXISTS `oa_book` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `title` varchar(150) NOT NULL,
  `alias` varchar(100) NOT NULL,
  `keywords` varchar(150) NOT NULL,
  `summary` text NOT NULL,
  `content` text NOT NULL,
  `type` enum('book','chapter','article') NOT NULL,
  `parent` smallint(5) unsigned NOT NULL default '0',
  `path` char(255) NOT NULL default '',
  `grade` tinyint(3) unsigned NOT NULL default '0',
  `author` varchar(60) NOT NULL,
  `editor` varchar(60) NOT NULL,
  `addedDate` datetime NOT NULL,
  `editedDate` datetime NOT NULL,
  `views` mediumint(5) unsigned NOT NULL default '0',
  `order` smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `order` (`order`),
  KEY `parent` (`parent`),
  KEY `path` (`path`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- DROP TABLE IF EXISTS `oa_layout`;
CREATE TABLE IF NOT EXISTS `oa_layout` (
  `page` varchar(30) NOT NULL,
  `region` varchar(30) NOT NULL,
  `blocks` varchar(255) NOT NULL,
  UNIQUE KEY `layout` (`page`,`region`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- DROP TABLE IF EXISTS `oa_relation`;
CREATE TABLE IF NOT EXISTS `oa_relation` (
  `type` char(20) NOT NULL,
  `id` mediumint(9) NOT NULL,
  `category` smallint(5) NOT NULL,
  UNIQUE KEY `relation` (`type`,`id`,`category`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- DROP TABLE IF EXISTS `sns_message`;
CREATE TABLE IF NOT EXISTS `sns_message` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `type` char(20) NOT NULL,
  `objectType` varchar(30) NOT NULL default '',
  `objectID` mediumint(8) unsigned NOT NULL default '0',
  `from` char(30) NOT NULL,
  `to` char(30) NOT NULL,
  `phone` char(30) NOT NULL,
  `email` varchar(90) NOT NULL,
  `qq` char(30) NOT NULL,
  `date` datetime NOT NULL,
  `content` text NOT NULL,
  `link` varchar(100) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `status` char(20) NOT NULL,
  `public` enum('0','1') NOT NULL default '1',
  `readed` enum('0','1') NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `status` (`status`),
  KEY `object` (`objectType`,`objectID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- DROP TABLE IF EXISTS `sns_reply`;
CREATE TABLE IF NOT EXISTS `sns_reply` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `thread` mediumint(8) unsigned NOT NULL,
  `content` text NOT NULL,
  `author` char(30) NOT NULL,
  `editor` char(30) NOT NULL,
  `addedDate` datetime NOT NULL,
  `editedDate` datetime NOT NULL,
  `hidden` enum('0','1') NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `thread` (`thread`),
  KEY `author` (`author`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- DROP TABLE IF EXISTS `sns_tag`;
CREATE TABLE IF NOT EXISTS `sns_tag` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `tag` varchar(50) NOT NULL,
  `link` varchar(100) NOT NULL,
  `rank` smallint(5) unsigned NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `tag` (`tag`),
  KEY `rank` (`rank`),
  KEY `link` (`link`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- DROP TABLE IF EXISTS `sns_thread`;
CREATE TABLE IF NOT EXISTS `sns_thread` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `board` mediumint(9) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `author` varchar(60) NOT NULL,
  `editor` varchar(60) NOT NULL,
  `addedDate` datetime NOT NULL,
  `editedDate` datetime NOT NULL,
  `readonly` tinyint(1) NOT NULL default '0',
  `views` smallint(5) unsigned NOT NULL default '0',
  `stick` enum('0','1','2','3') NOT NULL default '0',
  `replies` smallint(6) NOT NULL,
  `repliedBy` varchar(30) NOT NULL,
  `repliedDate` datetime NOT NULL,
  `replyID` mediumint(8) unsigned NOT NULL,
  `hidden` enum('0','1') NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `category` (`board`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- DROP TABLE IF EXISTS `sys_category`;
CREATE TABLE IF NOT EXISTS `sys_category` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `name` char(30) NOT NULL default '',
  `alias` varchar(100) NOT NULL,
  `desc` varchar(150) NOT NULL,
  `keywords` varchar(150) NOT NULL,
  `parent` smallint(5) unsigned NOT NULL default '0',
  `path` char(255) NOT NULL default '',
  `grade` tinyint(3) unsigned NOT NULL default '0',
  `order` smallint(5) unsigned NOT NULL default '0',
  `type` char(30) NOT NULL,
  `readonly` enum('0','1') NOT NULL default '0',
  `moderators` varchar(255) NOT NULL,
  `threads` smallint(5) NOT NULL,
  `posts` smallint(5) NOT NULL,
  `postedBy` varchar(30) NOT NULL,
  `postedDate` datetime NOT NULL,
  `postID` mediumint(9) NOT NULL,
  `replyID` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `tree` (`type`),
  KEY `order` (`order`),
  KEY `parent` (`parent`),
  KEY `path` (`path`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- DROP TABLE IF EXISTS `sys_config`;
CREATE TABLE IF NOT EXISTS `sys_config` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `owner` char(30) NOT NULL default '',
  `module` varchar(30) NOT NULL,
  `section` char(30) NOT NULL default '',
  `key` char(30) default NULL,
  `value` text NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `unique` (`owner`,`module`,`section`,`key`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
-- DROP TABLE IF EXISTS `sys_entry`;
CREATE TABLE IF NOT EXISTS `sys_entry` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `name` varchar(50) NOT NULL,
  `code` varchar(20) NOT NULL,
  `open` varchar(20) NOT NULL,
  `key` char(32) NOT NULL,
  `ip` varchar(100) NOT NULL,
  `logo` varchar(100) NOT NULL,
  `login` varchar(100) NOT NULL,
  `logout` varchar(100) NOT NULL,
  `api` varchar(100) NOT NULL,
  `visible` tinyint(1) unsigned NOT NULL default '0',
  `order` tinyint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- DROP TABLE IF EXISTS `sys_file`;
CREATE TABLE IF NOT EXISTS `sys_file` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `pathname` char(50) NOT NULL,
  `title` char(90) NOT NULL,
  `extension` char(30) NOT NULL,
  `size` mediumint(8) unsigned NOT NULL default '0',
  `objectType` char(20) NOT NULL,
  `objectID` mediumint(9) NOT NULL,
  `addedBy` char(30) NOT NULL default '',
  `addedDate` datetime NOT NULL,
  `public` enum('1','0') NOT NULL default '1',
  `downloads` mediumint(8) unsigned NOT NULL default '0',
  `extra` varchar(255) NOT NULL,
  `primary` enum('1','0') default '0',
  `editor` enum('1','0') NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `object` (`objectType`,`objectID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- DROP TABLE IF EXISTS `sys_product`;
CREATE TABLE IF NOT EXISTS `sys_product` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `code` varchar(30) NOT NULL,
  `order` tinyint(3) NOT NULL,
  `type` varchar(10) NOT NULL,
  `status` varchar(10) NOT NULL,
  `summary` text NOT NULL,
  `createdBy` varchar(60) NOT NULL,
  `createdDate` datetime NOT NULL,
  `editedBy` varchar(60) NOT NULL,
  `editedDate` datetime NOT NULL,
  `deleted` enum('0','1') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- DROP TABLE IF EXISTS `sys_sso`;
CREATE TABLE IF NOT EXISTS `sys_sso` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `sid` char(32) NOT NULL,
  `entry` mediumint(8) unsigned NOT NULL,
  `token` char(32) NOT NULL,
  `createdTime` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- DROP TABLE IF EXISTS `sys_user`;
CREATE TABLE IF NOT EXISTS `sys_user` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `dept` mediumint(8) unsigned NOT NULL,
  `account` char(30) NOT NULL default '',
  `password` char(32) NOT NULL default '',
  `realname` char(30) NOT NULL default '',
  `role` char(20) NOT NULL,
  `nickname` char(60) NOT NULL default '',
  `admin` enum('no','common','super') NOT NULL default 'no',
  `avatar` char(30) NOT NULL default '',
  `birthday` date NOT NULL,
  `gender` enum('f','m','u') NOT NULL default 'u',
  `email` char(90) NOT NULL default '',
  `skype` char(90) NOT NULL,
  `qq` char(20) NOT NULL default '',
  `yahoo` char(90) NOT NULL default '',
  `gtalk` char(90) NOT NULL default '',
  `wangwang` char(90) NOT NULL default '',
  `site` varchar(100) NOT NULL,
  `mobile` char(11) NOT NULL default '',
  `phone` char(20) NOT NULL default '',
  `company` varchar(255) NOT NULL,
  `address` char(120) NOT NULL default '',
  `zipcode` char(10) NOT NULL default '',
  `visits` mediumint(8) unsigned NOT NULL default '0',
  `ip` char(15) NOT NULL default '',
  `last` datetime NOT NULL,
  `fails` tinyint(3) unsigned NOT NULL default '0',
  `referer` varchar(255) NOT NULL,
  `join` datetime NOT NULL,
  `locked` datetime NOT NULL,
  `deleted` enum('0','1') NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `admin` (`admin`),
  KEY `account` (`account`,`password`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

INSERT INTO `sys_entry` (`name`, `code`, `open`, `key`, `ip`, `logo`, `login`, `logout`, `api`, `visible`, `order`)
VALUES ('pms', 'pms', 'iframe', '119563c21065b09b8388c59752c0bc27', '*', '/theme/default/images/ips/app-pms.png', 'http://pms.zentao.net', '', '', '1', '0');
INSERT INTO `sys_entry` (`name`, `code`, `open`, `key`, `ip`, `logo`, `login`, `logout`, `api`, `visible`, `order`)
VALUES ('crm', 'crm', 'iframe', 'epet8b8ae1g89rxzquf4ubv37ul5tite', '*', '/theme/default/images/ips/app-crm.png', '../crm/', '', '', '1', '0');
INSERT INTO `sys_entry` (`name`, `code`, `open`, `key`, `ip`, `logo`, `login`, `logout`, `api`, `visible`, `order`)
VALUES ('oa', 'oa', 'iframe', '1a673c4c3c85fadcf0333e0a4596d220', '*', '/theme/default/images/ips/app-oa.png', '../oa/', '', '', '1', '1');
INSERT INTO `sys_entry` (`name`, `code`, `open`, `key`, `ip`, `logo`, `login`, `logout`, `api`, `visible`, `order`)
VALUES ('cash', 'cash', 'iframe', '2byct4z7oy8r5hp3s82wuas7n0gonlof', '*', '/theme/default/images/ips/app-cash.png', '../cash/', '', '', '1', '2');
INSERT INTO `sys_entry` (`name`, `code`, `open`, `key`, `ip`, `logo`, `login`, `logout`, `api`, `visible`, `order`)
VALUES ('sns', 'sns', 'iframe', '9ce6ixdutohnbregapp8f123bvyqmyp2', '*', '/theme/default/images/ips/app-sns.png', '../sns/', '', '', '1', '3');
