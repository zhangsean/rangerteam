-- DROP TABLE IF EXISTS `crm_address`;
CREATE TABLE `crm_address` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `objectType` char(30) NOT NULL,
  `objectID` mediumint(8) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `country` char(30) NOT NULL,
  `province` char(50) NOT NULL,
  `city` char(50) NOT NULL,
  `location` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `objectType` (`objectType`,`objectID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- DROP TABLE IF EXISTS `crm_contact`;
CREATE TABLE `crm_contact` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `customer` mediumint(8) NOT NULL,
  `maker` enum('0','1') COLLATE 'utf8_general_ci' NOT NULL DEFAULT '0',
  `realname` char(30) NOT NULL DEFAULT '',
  `nickname` char(30) NOT NULL,
  `avatar` char(100) NOT NULL,
  `birthday` date NOT NULL,
  `gender` enum('f','m','u') NOT NULL DEFAULT 'u',
  `email` char(90) NOT NULL DEFAULT '',
  `skype` char(90) NOT NULL,
  `qq` char(20) NOT NULL DEFAULT '',
  `yahoo` char(90) NOT NULL DEFAULT '',
  `gtalk` char(90) NOT NULL DEFAULT '',
  `wangwang` char(90) NOT NULL DEFAULT '',
  `site` varchar(100) NOT NULL,
  `mobile` char(11) NOT NULL DEFAULT '',
  `phone` char(20) NOT NULL DEFAULT '',
  `weibo` char(50) NOT NULL,
  `weixin` char(50) NOT NULL,
  `desc` text NOT NULL,
  `createdBy` char(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  `editedBy` char(30) NOT NULL,
  `editedDate` datetime NOT NULL,
  `contactedBy` char(30) NOT NULL,
  `contactedDate` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `realname` (`realname`),
  KEY `nickname` (`nickname`),
  KEY `birthday` (`birthday`),
  KEY `createdBy` (`createdBy`),
  KEY `contactedBy` (`contactedBy`),
  KEY `contactedDate` (`contactedDate`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- DROP TABLE IF EXISTS `crm_contract`;
CREATE TABLE `crm_contract` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `customer` smallint(5) unsigned NOT NULL,
  `name` char(100) NOT NULL,
  `code` char(30) NOT NULL,
  `amount` float(12,2) NOT NULL,
  `items` text NOT NULL,
  `begin` date NOT NULL,
  `end` date NOT NULL,
  `delivery` char(30) NOT NULL,
  `return` char(30) NOT NULL,
  `status` char(30) NOT NULL,
  `contact` mediumint(8) unsigned NOT NULL,
  `signedBy` char(30) NOT NULL,
  `signedDate` datetime NOT NULL,
  `finishedBy` char(30) NOT NULL,
  `finishedDate` datetime NOT NULL,
  `canceledBy` char(30) NOT NULL,
  `canceledDate` datetime NOT NULL,
  `createdBy` char(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  `editedBy` char(30) NOT NULL,
  `editedDate` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `customer` (`customer`),
  KEY `begin` (`begin`),
  KEY `end` (`end`),
  KEY `status` (`status`),
  KEY `finishedBy` (`finishedBy`),
  KEY `canceledBy` (`canceledBy`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- DROP TABLE IF EXISTS `crm_contractOrder`;
CREATE TABLE `crm_contractOrder` (
  `contract` mediumint(8) unsigned NOT NULL,
  `order` mediumint(8) unsigned NOT NULL,
  UNIQUE KEY `contract` (`contract`,`order`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- DROP TABLE IF EXISTS `crm_customer`;
CREATE TABLE `crm_customer` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(30) NOT NULL,
  `type` char(30) NOT NULL,
  `size` tinyint(3) unsigned NOT NULL,
  `industry` mediumint(8) unsigned NOT NULL,
  `area` mediumint(8) unsigned NOT NULL,
  `status` char(30) NOT NULL,
  `level` tinyint(3) unsigned NOT NULL,
  `intension` text NOT NULL,
  `site` varchar(100) NOT NULL,
  `weibo` char(50) NOT NULL,
  `weixin` char(50) NOT NULL,
  `desc` text NOT NULL,
  `createdBy` char(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  `editedBy` char(30) NOT NULL,
  `editedDate` datetime NOT NULL,
  `contactedBy` char(30) NOT NULL,
  `contactedDate` datetime NOT NULL,
  `nextDate` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `industry` (`industry`),
  KEY `size` (`size`),
  KEY `name` (`name`),
  KEY `type` (`type`),
  KEY `area` (`area`),
  KEY `status` (`status`),
  KEY `level` (`level`),
  KEY `createdBy` (`createdBy`),
  KEY `contactedBy` (`contactedBy`),
  KEY `contactedDate` (`contactedDate`),
  KEY `nextDate` (`nextDate`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- DROP TABLE IF EXISTS `crm_order`;
CREATE TABLE `crm_order` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `product` smallint(5) unsigned NOT NULL,
  `customer` mediumint(8) unsigned NOT NULL,
  `plan` float(12,2) NOT NULL,
  `real` float(12,2) NOT NULL,
  `status` char(50) NOT NULL,
  `createdBy` char(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  `assignedTo` char(30) NOT NULL,
  `assignedBy` char(30) NOT NULL,
  `assignedDate` datetime NOT NULL,
  `signedBy` char(30) NOT NULL,
  `signedDate` datetime NOT NULL,
  `payedDate` datetime NOT NULL,
  `closedBy` char(30) NOT NULL,
  `closedDate` datetime NOT NULL,
  `closedReason` char(10) NOT NULL,
  `closedNote` text NOT NULL,
  `activatedBy` char(30) NOT NULL,
  `activatedDate` datetime NOT NULL,
  `contactedBy` char(30) NOT NULL,
  `contactedDate` datetime NOT NULL,
  `nextDate` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product` (`product`),
  KEY `customer` (`customer`),
  KEY `status` (`status`),
  KEY `createdBy` (`createdBy`),
  KEY `assignedTo` (`assignedTo`),
  KEY `closedBy` (`closedBy`),
  KEY `closedReason` (`closedReason`),
  KEY `contactedBy` (`contactedBy`),
  KEY `contactedDate` (`contactedDate`),
  KEY `nextDate` (`nextDate`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- DROP TABLE IF EXISTS `crm_resume`;
CREATE TABLE `crm_resume` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `contact` mediumint(8) unsigned NOT NULL,
  `customer` mediumint(8) unsigned NOT NULL,
  `dept` char(100) NOT NULL,
  `title` char(100) NOT NULL,
  `address` mediumint(8) unsigned NOT NULL,
  `join` date NOT NULL,
  `left` date NOT NULL,
  `createdBy` char(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `contact` (`contact`),
  KEY `customer` (`customer`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- DROP TABLE IF EXISTS `crm_service`;
CREATE TABLE `crm_service` (
  `customer` smallint(8) NOT NULL,
  `product` mediumint(8) NOT NULL,
  `expire` date NOT NULL,
  UNIQUE KEY `customer` (`customer`,`product`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- DROP TABLE IF EXISTS `oa_article`;
CREATE TABLE `oa_article` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
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
  `status` varchar(20) NOT NULL DEFAULT 'normal',
  `type` varchar(30) NOT NULL,
  `views` mediumint(5) unsigned NOT NULL DEFAULT '0',
  `sticky` enum('0','1','2','3') NOT NULL DEFAULT '0',
  `order` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order` (`order`),
  KEY `views` (`views`),
  KEY `sticky` (`sticky`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- DROP TABLE IF EXISTS `oa_block`;
CREATE TABLE `oa_block` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(20) NOT NULL,
  `title` varchar(60) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- DROP TABLE IF EXISTS `oa_doc`;
CREATE TABLE `oa_doc` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `product` mediumint(8) unsigned NOT NULL,
  `project` mediumint(8) unsigned NOT NULL,
  `lib` varchar(30) NOT NULL,
  `module` varchar(30) NOT NULL,
  `title` varchar(255) NOT NULL,
  `digest` varchar(255) NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `type` varchar(30) NOT NULL,
  `content` text NOT NULL,
  `url` varchar(255) NOT NULL,
  `views` smallint(5) unsigned NOT NULL,
  `addedBy` varchar(30) NOT NULL,
  `addedDate` datetime NOT NULL,
  `editedBy` varchar(30) NOT NULL,
  `editedDate` datetime NOT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- DROP TABLE IF EXISTS `oa_docLib`;
CREATE TABLE `oa_docLib` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- DROP TABLE IF EXISTS `oa_relation`;
CREATE TABLE `oa_relation` (
  `type` char(20) NOT NULL,
  `id` mediumint(9) NOT NULL,
  `category` smallint(5) NOT NULL,
  UNIQUE KEY `relation` (`type`,`id`,`category`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- DROP TABLE IF EXISTS `sys_action`;
CREATE TABLE `sys_action` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `customer` mediumint(8) unsigned DEFAULT NULL,
  `contact` mediumint(8) unsigned DEFAULT NULL,
  `contract` mediumint(8) unsigned DEFAULT NULL,
  `product` mediumint(8) unsigned DEFAULT NULL,
  `objectType` varchar(30) NOT NULL DEFAULT '',
  `objectID` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `actor` varchar(30) NOT NULL DEFAULT '',
  `action` varchar(30) NOT NULL DEFAULT '',
  `date` datetime NOT NULL,
  `comment` text NOT NULL,
  `extra` varchar(255) NOT NULL,
  `efforted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `customer` (`customer`),
  KEY `contact` (`contact`),
  KEY `contract` (`contract`),
  KEY `product` (`product`),
  KEY `date` (`date`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- DROP TABLE IF EXISTS `sys_category`;
CREATE TABLE `sys_category` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(30) NOT NULL DEFAULT '',
  `alias` varchar(100) NOT NULL,
  `desc` varchar(150) NOT NULL,
  `keywords` varchar(150) NOT NULL,
  `root` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `parent` smallint(5) unsigned NOT NULL DEFAULT '0',
  `path` char(255) NOT NULL DEFAULT '',
  `grade` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `order` smallint(5) unsigned NOT NULL DEFAULT '0',
  `type` char(30) NOT NULL,
  `readonly` enum('0','1') NOT NULL DEFAULT '0',
  `moderators` varchar(255) NOT NULL,
  `threads` smallint(5) NOT NULL,
  `posts` smallint(5) NOT NULL,
  `postedBy` varchar(30) NOT NULL,
  `postedDate` datetime NOT NULL,
  `postID` mediumint(9) NOT NULL,
  `replyID` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tree` (`type`),
  KEY `order` (`order`),
  KEY `parent` (`parent`),
  KEY `path` (`path`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- DROP TABLE IF EXISTS `sys_config`;
CREATE TABLE `sys_config` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `owner` char(30) NOT NULL DEFAULT '',
  `app` varchar(30) NOT NULL DEFAULT 'sys',
  `module` varchar(30) NOT NULL,
  `section` char(30) NOT NULL DEFAULT '',
  `key` char(30) DEFAULT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique` (`owner`,`app`,`module`,`section`,`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- DROP TABLE IF EXISTS `sys_entry`;
CREATE TABLE `sys_entry` (
  `id` smallint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `code` varchar(20) NOT NULL,
  `open` varchar(20) NOT NULL,
  `key` char(32) NOT NULL,
  `ip` varchar(100) NOT NULL,
  `logo` varchar(100) NOT NULL,
  `login` varchar(255) NOT NULL,
  `logout` varchar(255) NOT NULL,
  `block` varchar(255) NOT NULL,
  `control` varchar(10) NOT NULL DEFAULT 'simple',
  `size` varchar(50) NOT NULL DEFAULT 'max',
  `position` varchar(10) NOT NULL DEFAULT 'default',
  `visible` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `order` tinyint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- DROP TABLE IF EXISTS `sys_file`;
CREATE TABLE `sys_file` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `pathname` char(50) NOT NULL,
  `title` char(90) NOT NULL,
  `extension` char(30) NOT NULL,
  `size` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `objectType` char(20) NOT NULL,
  `objectID` mediumint(9) NOT NULL,
  `addedBy` char(30) NOT NULL DEFAULT '',
  `addedDate` datetime NOT NULL,
  `editor` enum('1','0') NOT NULL DEFAULT '0',
  `primary` enum('1','0') DEFAULT '0',
  `public` enum('1','0') NOT NULL DEFAULT '1',
  `downloads` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `extra` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `object` (`objectType`,`objectID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- DROP TABLE IF EXISTS `sys_history`;
CREATE TABLE `sys_history` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `action` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `field` varchar(30) NOT NULL DEFAULT '',
  `old` text NOT NULL,
  `new` text NOT NULL,
  `diff` mediumtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- DROP TABLE IF EXISTS `sys_lang`;
CREATE TABLE `sys_lang` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `lang` varchar(30) NOT NULL,
  `app` varchar(30) NOT NULL DEFAULT 'sys',
  `module` varchar(30) NOT NULL,
  `section` varchar(30) NOT NULL,
  `key` varchar(60) NOT NULL,
  `value` text NOT NULL,
  `system` enum('0','1') NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `lang` (`app`,`lang`,`module`,`section`,`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- DROP TABLE IF EXISTS `sys_product`;
CREATE TABLE `sys_product` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `type` varchar(10) NOT NULL,
  `status` varchar(10) NOT NULL,
  `desc` text NOT NULL,
  `createdBy` varchar(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  `editedBy` varchar(30) NOT NULL,
  `editedDate` datetime NOT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- DROP TABLE IF EXISTS `sys_sso`;
CREATE TABLE `sys_sso` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `sid` char(32) NOT NULL,
  `entry` mediumint(8) unsigned NOT NULL,
  `token` char(32) NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- DROP TABLE IF EXISTS `sys_task`;
CREATE TABLE `sys_task` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `project` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `customer` mediumint(8) unsigned NOT NULL,
  `order` mediumint(8) unsigned NOT NULL,
  `category` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL,
  `type` varchar(20) NOT NULL,
  `pri` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `estimate` float unsigned NOT NULL,
  `consumed` float unsigned NOT NULL,
  `left` float unsigned NOT NULL,
  `deadline` date NOT NULL,
  `status` enum('wait','doing','done','cancel','closed') NOT NULL DEFAULT 'wait',
  `statusCustom` tinyint(3) unsigned NOT NULL,
  `mailto` varchar(255) NOT NULL DEFAULT '',
  `desc` text NOT NULL,
  `createdBy` varchar(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  `assignedTo` varchar(30) NOT NULL,
  `assignedDate` datetime NOT NULL,
  `estStarted` date NOT NULL,
  `realStarted` date NOT NULL,
  `finishedBy` varchar(30) NOT NULL,
  `finishedDate` datetime NOT NULL,
  `canceledBy` varchar(30) NOT NULL,
  `canceledDate` datetime NOT NULL,
  `closedBy` varchar(30) NOT NULL,
  `closedDate` datetime NOT NULL,
  `closedReason` varchar(30) NOT NULL,
  `editedBy` varchar(30) NOT NULL,
  `editedDate` datetime NOT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `statusOrder` (`statusCustom`),
  KEY `type` (`type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- DROP TABLE IF EXISTS `sys_user`;
CREATE TABLE `sys_user` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `dept` smallint(8) unsigned NOT NULL,
  `account` char(30) NOT NULL DEFAULT '',
  `password` char(32) NOT NULL DEFAULT '',
  `realname` char(30) NOT NULL DEFAULT '',
  `role` char(20) NOT NULL,
  `nickname` char(60) NOT NULL DEFAULT '',
  `admin` enum('no','common','super') NOT NULL DEFAULT 'no',
  `avatar` char(30) NOT NULL DEFAULT '',
  `birthday` date NOT NULL,
  `gender` enum('f','m','u') NOT NULL DEFAULT 'u',
  `email` char(90) NOT NULL DEFAULT '',
  `skype` char(90) NOT NULL,
  `qq` char(20) NOT NULL DEFAULT '',
  `yahoo` char(90) NOT NULL DEFAULT '',
  `gtalk` char(90) NOT NULL DEFAULT '',
  `wangwang` char(90) NOT NULL DEFAULT '',
  `site` varchar(100) NOT NULL,
  `mobile` char(11) NOT NULL DEFAULT '',
  `phone` char(20) NOT NULL DEFAULT '',
  `address` char(120) NOT NULL DEFAULT '',
  `zipcode` char(10) NOT NULL DEFAULT '',
  `visits` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `ip` char(15) NOT NULL DEFAULT '',
  `last` datetime NOT NULL,
  `fails` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `join` datetime NOT NULL,
  `locked` datetime NOT NULL,
  `deleted` enum('0','1') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `admin` (`admin`),
  KEY `account` (`account`,`password`),
  KEY `dept` (`dept`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
