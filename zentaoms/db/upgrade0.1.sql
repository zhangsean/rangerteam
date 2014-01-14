ALTER TABLE `sys_config` ADD `app` varchar(30) COLLATE 'utf8_general_ci' NOT NULL DEFAULT 'sys' AFTER `owner`;
ALTER TABLE `sys_config` ADD UNIQUE `unique` (`owner`, `app`, `module`, `section`, `key`),
DROP INDEX `unique`;

CREATE TABLE IF NOT EXISTS `crm_product` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `code` varchar(30) NOT NULL,
  `type` varchar(10) NOT NULL,
  `status` varchar(10) NOT NULL,
  `summary` text NOT NULL,
  `createdBy` varchar(60) NOT NULL,
  `createDate` datetime NOT NULL,
  `editedBy` varchar(60) NOT NULL,
  `editedDate` datetime NOT NULL,
  `deleted` enum('0','1') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `crm_order` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `product` mediumint(8) unsigned NOT NULL,
  `customer` mediumint(8) unsigned NOT NULL,
  `plan` float(12,2) NOT NULL,
  `real` float(12,2) NOT NULL,
  `status` varchar(50) NOT NULL,
  `creatededBy` varchar(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  `assignedTo` varchar(30) NOT NULL,
  `assignedBy` varchar(30) NOT NULL,
  `assignedDate` datetime NOT NULL,
  `signedBy` varchar(50) NOT NULL,
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
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `sys_action` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `objectType` varchar(30) NOT NULL DEFAULT '',
  `objectID` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `product` mediumint(8) NOT NULL,
  `actor` varchar(30) NOT NULL DEFAULT '',
  `action` varchar(30) NOT NULL DEFAULT '',
  `date` datetime NOT NULL,
  `comment` text NOT NULL,
  `extra` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `date` (`date`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `crm_team` (
  `order` mediumint(8) unsigned NOT NULL,
  `account` char(30) NOT NULL,
  `role` char(30) NOT NULL,
  `join` date NOT NULL,
  PRIMARY KEY  (`order`,`account`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
