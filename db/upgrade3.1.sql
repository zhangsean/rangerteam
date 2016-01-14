ALTER TABLE `crm_contact`
add `assignedTo` char(30) NOT NULL AFTER `nextDate`,
add `ignoredBy` char(30) NOT NULL AFTER `assignedTo`;

ALTER TABLE `crm_contact` change `originID` `originAccount` varchar(255) NOT NULL;

-- DROP TABLE IF EXISTS `oa_overtime`;
CREATE TABLE `oa_overtime` (
  `id` mediumint NOT NULL AUTO_INCREMENT,
  `year` char(4) NOT NULL,
  `begin` date NOT NULL,
  `end` date NOT NULL,
  `start` time NOT NULL,
  `finish` time NOT NULL,
  `hours` float(4,1) unsigned NOT NULL DEFAULT '0.0',
  `type` varchar(30) NOT NULL DEFAULT '',
  `desc` text NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT '',
  `createdBy` char(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  `reviewedBy` char(30) NOT NULL,
  `reviewedDate` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `year` (`year`),
  KEY `type` (`type`),
  KEY `status` (`status`),
  KEY `createdBy` (`createdBy`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- DROP TABLE IF EXISTS `oa_attendstat`;
CREATE TABLE `oa_attendstat` (
  `id` mediumint NOT NULL AUTO_INCREMENT,
  `account` char(30) NOT NULL,
  `month` char(10) NOT NULL DEFAULT '',
  `normal` decimal(12,2) NOT NULL DEFAULT 0.00,
  `late` decimal(12,2) NOT NULL DEFAULT 0.00,
  `early` decimal(12,2) NOT NULL DEFAULT 0.00,
  `absent` decimal(12,2) NOT NULL DEFAULT 0.00,
  `trip` decimal(12,2) NOT NULL DEFAULT 0.00,
  `paidLeave` decimal(12,2) NOT NULL DEFAULT 0.00,
  `unpaidLeave` decimal(12,2) NOT NULL DEFAULT 0.00,
  `timeOvertime` decimal(12,2) NOT NULL DEFAULT 0.00,
  `restOvertime` decimal(12,2) NOT NULL DEFAULT 0.00,
  `holidayOvertime` decimal(12,2) NOT NULL DEFAULT 0.00,
  `deserve` decimal(12,2) NOT NULL DEFAULT 0.00,
  `actual` decimal(12,2) NOT NULL DEFAULT 0.00,
  `status` char(30) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `account` (`account`),
  KEY `month` (`month`),
  KEY `status` (`status`),
  UNIQUE KEY `attend` (`month`,`account`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

ALTER TABLE `cash_trade` add `base` decimal(12,2) NOT NULL DEFAULT 0.00;

-- DROP TABLE IF EXISTS `cash_commission`;
CREATE TABLE `cash_commission` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `trade` mediumint(8) NOT NULL DEFAULT 0,
  `account` char(30) NOT NULL,
  `rate` decimal(12,2) NOT NULL DEFAULT 0.00,
  `amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `desc` text,
  `createdBy` char(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `account` (`account`),
  KEY `trade` (`trade`),
  UNIQUE KEY `commission` (`trade`,`account`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
