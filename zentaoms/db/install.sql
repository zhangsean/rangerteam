-- DROP TABLE IF EXISTS `cash_invocie`;
CREATE TABLE `cash_invocie` (
  `id` mediumint(8) unsigned NOT NULL,
  `customer` smallint(5) unsigned NOT NULL,
  `contract` mediumint(9) NOT NULL,
  `order` mediumint(9) NOT NULL,
  `contact` mediumint(9) NOT NULL,
  `title` char(100) NOT NULL,
  `content` char(100) NOT NULL,
  `type` char(10) NOT NULL,
  `amount` float(12,2) NOT NULL,
  `point` float(4,2) NOT NULL,
  `operator` char(30) NOT NULL,
  `time` datetime NOT NULL,
  `express` char(30) NOT NULL,
  `ticket` char(30) NOT NULL,
  KEY `customer` (`customer`),
  KEY `contract` (`contract`),
  KEY `order` (`order`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- DROP TABLE IF EXISTS `crm_address`;
CREATE TABLE `crm_address` (
  `id` mediumint(8) unsigned NOT NULL,
  `objectType` char(30) NOT NULL,
  `objectID` mediumint(8) unsigned NOT NULL,
  `country` char(30) NOT NULL,
  `province` char(50) NOT NULL,
  `city` char(50) NOT NULL,
  `location` varchar(255) NOT NULL,
  KEY `objectType` (`objectType`,`objectID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- DROP TABLE IF EXISTS `crm_contact`;
CREATE TABLE `crm_contact` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `realname` char(30) NOT NULL default '',
  `nickname` char(30) NOT NULL,
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
  `weibo` char(50) NOT NULL,
  `weixin` char(50) NOT NULL,
  `desc` text NOT NULL,
  `createdBy` char(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  `editedBy` char(30) NOT NULL,
  `editedDate` datetime NOT NULL,
  `contactedBy` char(30) NOT NULL,
  `contactedDate` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `realname` (`realname`),
  KEY `nickname` (`nickname`),
  KEY `birthday` (`birthday`),
  KEY `createdBy` (`createdBy`),
  KEY `contactedBy` (`contactedBy`),
  KEY `contactedDate` (`contactedDate`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
-- DROP TABLE IF EXISTS `crm_contract`;
CREATE TABLE `crm_contract` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `customer` smallint(5) unsigned NOT NULL,
  `name` char(100) NOT NULL,
  `code` char(30) NOT NULL,
  `amount` float(12,2) NOT NULL,
  `items` text NOT NULL,
  `begin` date NOT NULL,
  `end` date NOT NULL,
  `status` char(30) NOT NULL,
  `contact` mediumint(8) unsigned NOT NULL,
  `signedBy` char(30) NOT NULL,
  `signedDate` datetime NOT NULL,
  `finishedBy` char(30) NOT NULL,
  `finishedDate` datetime NOT NULL,
  `canceledBy` char(30) NOT NULL,
  `canceledDate` datetime NOT NULL,
  PRIMARY KEY  (`id`),
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
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `name` char(30) NOT NULL,
  `type` char(30) NOT NULL,
  `size` tinyint(3) unsigned NOT NULL,
  `industry` mediumint(8) unsigned NOT NULL,
  `area` mediumint(8) unsigned NOT NULL,
  `status` char(30) NOT NULL,
  `level` tinyint(3) unsigned NOT NULL,
  `site` varchar(100) NOT NULL,
  `weibo` char(50) NOT NULL,
  `weixin` char(50) NOT NULL,
  `desc` text NOT NULL,
  `referType` char(30) NOT NULL,
  `referID` smallint(5) unsigned NOT NULL,
  `createdBy` char(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  `editedBy` char(30) NOT NULL,
  `editedDate` datetime NOT NULL,
  `contactedBy` char(30) NOT NULL,
  `contactedDate` datetime NOT NULL,
  `nextDate` date NOT NULL,
  `nextContact` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY  (`id`),
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
-- DROP TABLE IF EXISTS `crm_order`;
CREATE TABLE `crm_order` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
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
  PRIMARY KEY  (`id`),
  KEY `product` (`product`),
  KEY `customer` (`customer`),
  KEY `status` (`status`),
  KEY `createdBy` (`createdBy`),
  KEY `assignedTo` (`assignedTo`),
  KEY `closedBy` (`closedBy`),
  KEY `closedReason` (`closedReason`),
  KEY `contactedBy` (`contactedBy`),
  KEY `contactedDate` (`contactedDate`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- DROP TABLE IF EXISTS `crm_orderAction`;
CREATE TABLE `crm_orderAction` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `product` smallint(5) unsigned NOT NULL,
  `action` char(30) NOT NULL,
  `name` char(100) NOT NULL,
  `conditions` text NOT NULL,
  `inputs` text NOT NULL,
  `results` text NOT NULL,
  `tasks` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `product` (`product`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- DROP TABLE IF EXISTS `crm_orderField`;
CREATE TABLE `crm_orderField` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `product` mediumint(8) unsigned NOT NULL,
  `field` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `order` tinyint(3) NOT NULL,
  `control` varchar(10) NOT NULL,
  `options` varchar(255) NOT NULL,
  `default` varchar(100) NOT NULL,
  `rules` varchar(255) NOT NULL,
  `placeholder` varchar(100) NOT NULL,
  `desc` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `product` (`product`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- DROP TABLE IF EXISTS `crm_plan`;
CREATE TABLE `crm_plan` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `customer` mediumint(8) unsigned NOT NULL,
  `contract` mediumint(8) unsigned NOT NULL,
  `type` char(30) NOT NULL,
  `batch` tinyint(3) unsigned NOT NULL,
  `amount` float(12,2) NOT NULL,
  `deadline` date NOT NULL,
  `status` char(30) NOT NULL,
  `assignedTo` char(30) NOT NULL,
  `assignedBy` char(30) NOT NULL,
  `assignedDate` datetime NOT NULL,
  `createdBy` char(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  `finishedBy` char(30) NOT NULL,
  `finishedDate` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `customer` (`customer`,`contract`,`type`,`deadline`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- DROP TABLE IF EXISTS `crm_relation`;
CREATE TABLE `crm_relation` (
  `contact` mediumint(8) unsigned NOT NULL,
  `customer` mediumint(8) unsigned NOT NULL,
  `dept` char(100) NOT NULL,
  `titile` char(100) NOT NULL,
  `address` mediumint(8) unsigned NOT NULL,
  `join` date NOT NULL,
  `left` date NOT NULL,
  KEY `contact` (`contact`),
  KEY `customer` (`customer`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- DROP TABLE IF EXISTS `crm_request`;
CREATE TABLE `crm_request` (
  `id` mediumint(8) unsigned NOT NULL,
  `customer` mediumint(8) NOT NULL,
  `product` mediumint(8) unsigned NOT NULL,
  `contact` char(30) NOT NULL,
  `category` mediumint(8) unsigned NOT NULL,
  `pri` tinyint(3) unsigned default NULL,
  `title` char(150) NOT NULL,
  `desc` text NOT NULL,
  `status` char(30) NOT NULL,
  `createdBy` char(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  `assignedTo` char(30) NOT NULL,
  `assignedBy` char(30) NOT NULL,
  `assignedDate` datetime NOT NULL,
  `viewedBy` char(30) NOT NULL,
  `viewedDate` datetime NOT NULL,
  `repliedBy` char(30) NOT NULL,
  `repliedDate` datetime NOT NULL,
  `transferedBy` char(30) NOT NULL,
  `transferedDate` datetime NOT NULL,
  `editedBy` char(30) NOT NULL,
  `editedDate` datetime NOT NULL,
  `closedBy` char(30) NOT NULL,
  `closedReason` char(30) NOT NULL,
  `closedDate` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `customer` (`customer`),
  KEY `product` (`product`),
  KEY `category` (`category`),
  KEY `pri` (`pri`),
  KEY `status` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- DROP TABLE IF EXISTS `crm_team`;
CREATE TABLE `crm_team` (
  `order` mediumint(8) unsigned NOT NULL,
  `account` char(30) NOT NULL,
  `role` char(30) NOT NULL,
  `join` date NOT NULL,
  PRIMARY KEY  (`order`,`account`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- DROP TABLE IF EXISTS `oa_article`;
CREATE TABLE `oa_article` (
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
CREATE TABLE `oa_block` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `type` varchar(20) NOT NULL,
  `title` varchar(60) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- DROP TABLE IF EXISTS `oa_book`;
CREATE TABLE `oa_book` (
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
CREATE TABLE `oa_layout` (
  `page` varchar(30) NOT NULL,
  `region` varchar(30) NOT NULL,
  `blocks` varchar(255) NOT NULL,
  UNIQUE KEY `layout` (`page`,`region`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- DROP TABLE IF EXISTS `oa_relation`;
CREATE TABLE `oa_relation` (
  `type` char(20) NOT NULL,
  `id` mediumint(9) NOT NULL,
  `category` smallint(5) NOT NULL,
  UNIQUE KEY `relation` (`type`,`id`,`category`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- DROP TABLE IF EXISTS `sns_message`;
CREATE TABLE `sns_message` (
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
CREATE TABLE `sns_reply` (
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
CREATE TABLE `sns_tag` (
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
CREATE TABLE `sns_thread` (
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
-- DROP TABLE IF EXISTS `sys_action`;
CREATE TABLE `sys_action` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `objectType` varchar(30) NOT NULL default '',
  `objectID` mediumint(8) unsigned NOT NULL default '0',
  `product` varchar(255) NOT NULL,
  `actor` varchar(30) NOT NULL default '',
  `action` varchar(30) NOT NULL default '',
  `date` datetime NOT NULL,
  `comment` text NOT NULL,
  `extra` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `date` (`date`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- DROP TABLE IF EXISTS `sys_category`;
CREATE TABLE `sys_category` (
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
CREATE TABLE `sys_config` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `owner` char(30) NOT NULL default '',
  `app` varchar(30) NOT NULL default 'sys',
  `module` varchar(30) NOT NULL,
  `section` char(30) NOT NULL default '',
  `key` char(30) default NULL,
  `value` text NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `unique` (`owner`,`app`,`module`,`section`,`key`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
-- DROP TABLE IF EXISTS `sys_entry`;
CREATE TABLE `sys_entry` (
  `id` smallint(8) unsigned NOT NULL auto_increment,
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
-- DROP TABLE IF EXISTS `sys_file`;
CREATE TABLE `sys_file` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `pathname` char(50) NOT NULL,
  `title` char(90) NOT NULL,
  `extension` char(30) NOT NULL,
  `size` mediumint(8) unsigned NOT NULL default '0',
  `objectType` char(20) NOT NULL,
  `objectID` mediumint(9) NOT NULL,
  `addedBy` char(30) NOT NULL default '',
  `addedDate` datetime NOT NULL,
  `editor` enum('1','0') NOT NULL default '0',
  `primary` enum('1','0') default '0',
  `public` enum('1','0') NOT NULL default '1',
  `downloads` mediumint(8) unsigned NOT NULL default '0',
  `extra` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `object` (`objectType`,`objectID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- DROP TABLE IF EXISTS `sys_group`;
CREATE TABLE `sys_group` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `name` char(30) NOT NULL,
  `role` char(30) NOT NULL default '',
  `desc` char(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
-- DROP TABLE IF EXISTS `sys_groupPriv`;
CREATE TABLE `sys_groupPriv` (
  `group` mediumint(8) unsigned NOT NULL default '0',
  `module` char(30) NOT NULL default '',
  `method` char(30) NOT NULL default '',
  UNIQUE KEY `group` (`group`,`module`,`method`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- DROP TABLE IF EXISTS `sys_history`;
CREATE TABLE `sys_history` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `action` mediumint(8) unsigned NOT NULL default '0',
  `field` varchar(30) NOT NULL default '',
  `old` text NOT NULL,
  `new` text NOT NULL,
  `diff` mediumtext NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- DROP TABLE IF EXISTS `sys_product`;
CREATE TABLE `sys_product` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `name` varchar(150) NOT NULL,
  `code` varchar(30) NOT NULL,
  `type` varchar(10) NOT NULL,
  `status` varchar(10) NOT NULL,
  `summary` text NOT NULL,
  `createdBy` varchar(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  `editedBy` varchar(30) NOT NULL,
  `editedDate` datetime NOT NULL,
  `deleted` enum('0','1') NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
-- DROP TABLE IF EXISTS `sys_sso`;
CREATE TABLE `sys_sso` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `sid` char(32) NOT NULL,
  `entry` mediumint(8) unsigned NOT NULL,
  `token` char(32) NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
-- DROP TABLE IF EXISTS `sys_task`;
CREATE TABLE `sys_task` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `project` mediumint(8) unsigned NOT NULL default '0',
  `customer` mediumint(8) unsigned NOT NULL,
  `order` mediumint(8) unsigned NOT NULL,
  `category` mediumint(8) unsigned NOT NULL default '0',
  `name` varchar(255) NOT NULL,
  `type` varchar(20) NOT NULL,
  `pri` tinyint(3) unsigned NOT NULL default '0',
  `estimate` float unsigned NOT NULL,
  `consumed` float unsigned NOT NULL,
  `left` float unsigned NOT NULL,
  `deadline` date NOT NULL,
  `status` enum('wait','doing','done','cancel','closed') NOT NULL default 'wait',
  `statusCustom` tinyint(3) unsigned NOT NULL,
  `mailto` varchar(255) NOT NULL default '',
  `desc` text NOT NULL,
  `openedBy` varchar(30) NOT NULL,
  `openedDate` datetime NOT NULL,
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
  `lastEditedBy` varchar(30) NOT NULL,
  `lastEditedDate` datetime NOT NULL,
  `deleted` enum('0','1') NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `statusOrder` (`statusCustom`),
  KEY `type` (`type`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
-- DROP TABLE IF EXISTS `sys_user`;
CREATE TABLE `sys_user` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `dept` smallint(8) unsigned NOT NULL,
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
  `address` char(120) NOT NULL default '',
  `zipcode` char(10) NOT NULL default '',
  `visits` mediumint(8) unsigned NOT NULL default '0',
  `ip` char(15) NOT NULL default '',
  `last` datetime NOT NULL,
  `fails` tinyint(3) unsigned NOT NULL default '0',
  `join` datetime NOT NULL,
  `locked` datetime NOT NULL,
  `deleted` enum('0','1') NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `admin` (`admin`),
  KEY `account` (`account`,`password`),
  KEY `dept` (`dept`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
-- DROP TABLE IF EXISTS `sys_userGroup`;
CREATE TABLE `sys_userGroup` (
  `account` char(30) NOT NULL default '',
  `group` mediumint(8) unsigned NOT NULL default '0',
  UNIQUE KEY `account` (`account`,`group`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `sys_entry` (`name`, `code`, `open`, `key`, `ip`, `logo`, `login`, `logout`, `api`, `visible`, `order`) VALUES ('pms', 'pms', 'iframe', '119563c21065b09b8388c59752c0bc27', '*', '/theme/default/images/ips/app-pms.png', 'http://pms.zentao.net', '', '', '1', '0');
INSERT INTO `sys_entry` (`name`, `code`, `open`, `key`, `ip`, `logo`, `login`, `logout`, `api`, `visible`, `order`) VALUES ('crm', 'crm', 'iframe', 'epet8b8ae1g89rxzquf4ubv37ul5tite', '*', '/theme/default/images/ips/app-crm.png', '../crm/', '', '', '1', '0');
INSERT INTO `sys_entry` (`name`, `code`, `open`, `key`, `ip`, `logo`, `login`, `logout`, `api`, `visible`, `order`) VALUES ('oa', 'oa', 'iframe', '1a673c4c3c85fadcf0333e0a4596d220', '*', '/theme/default/images/ips/app-oa.png', '../oa/', '', '', '1', '1');
INSERT INTO `sys_entry` (`name`, `code`, `open`, `key`, `ip`, `logo`, `login`, `logout`, `api`, `visible`, `order`) VALUES ('cash', 'cash', 'iframe', '2byct4z7oy8r5hp3s82wuas7n0gonlof', '*', '/theme/default/images/ips/app-cash.png', '../cash/', '', '', '1', '2');
INSERT INTO `sys_entry` (`name`, `code`, `open`, `key`, `ip`, `logo`, `login`, `logout`, `api`, `visible`, `order`) VALUES ('sns', 'sns', 'iframe', '9ce6ixdutohnbregapp8f123bvyqmyp2', '*', '/theme/default/images/ips/app-sns.png', '../sns/', '', '', '1', '3');
