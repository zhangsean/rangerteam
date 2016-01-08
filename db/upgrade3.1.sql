ALTER TABLE `crm_contact`
add `assignedTo` char(30) NOT NULL,
add `ignoredBy` char(30) NOT NULL;

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

-- DROP TABLE IF EXISTS `oa_salary`;
CREATE TABLE `oa_salary` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `month` char(10) NOT NULL DEFAULT '',
  `account` char(30) NOT NULL DEFAULT '',
  `dept` mediumint(8) NOT NULL DEFAULT 0,
  `basic` decimal(12,2) NOT NULL DEFAULT 0.00,
  `benefit` decimal(12,2) NOT NULL DEFAULT 0.00,
  `bonus` decimal(12,2) NOT NULL DEFAULT 0.00,
  `allowance` decimal(12,2) NOT NULL DEFAULT 0.00,
  `deduction` decimal(12,2) NOT NULL DEFAULT 0.00,
  `deserved` decimal(12,2) NOT NULL DEFAULT 0.00,
  `actual` decimal(12,2) NOT NULL DEFAULT 0.00,
  `companySSF` decimal(12,2) NOT NULL DEFAULT 0.00,
  `companyHPF` decimal(12,2) NOT NULL DEFAULT 0.00,
  `createdDate` datetime NOT NULL,
  `createdBy` char(30) NOT NULL DEFAULT '',
  `editedDate` datetime NOT NULL,
  `editedBy` char(30) NOT NULL DEFAULT '',
  `desc` text,
  `status` varchar(20) NOT NULL DEFAULT 'wait',
  PRIMARY KEY (`id`),
  KEY `month` (`month`),
  KEY `account` (`account`),
  KEY `dept` (`dept`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- DROP TABLE IF EXISTS `oa_salarydetail`;
CREATE TABLE `oa_salarydetail` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `salary` mediumint(8) NOT NULL DEFAULT 0,
  `item` enum('bonus', 'allowance', 'deduction') NOT NULL,
  `type` varchar(100) NOT NULL DEFAULT '',
  `amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `desc` text,
  PRIMARY KEY (`id`),
  KEY `salary` (`salary`),
  KEY `item` (`item`),
  KEY `type` (`type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- DROP TABLE IF EXISTS `oa_attendstat`;
CREATE TABLE `oa_attendstat` (
  `id` mediumint NOT NULL AUTO_INCREMENT,
  `account` char(30) NOT NULL,
  `month` char(10) NOT NULL DEFAULT '',
  `normal` decimal(12,1) NOT NULL DEFAULT 0.0,
  `late` decimal(12,1) NOT NULL DEFAULT 0.0,
  `early` decimal(12,1) NOT NULL DEFAULT 0.0,
  `absent` decimal(12,1) NOT NULL DEFAULT 0.0,
  `trip` decimal(12,1) NOT NULL DEFAULT 0.0,
  `paidLeave` decimal(12,1) NOT NULL DEFAULT 0.0,
  `unpaidLeave` decimal(12,1) NOT NULL DEFAULT 0.0,
  `timeOvertime` decimal(12,1) NOT NULL DEFAULT 0.0,
  `restOvertime` decimal(12,1) NOT NULL DEFAULT 0.0,
  `holidayOvertime` decimal(12,1) NOT NULL DEFAULT 0.0,
  `status` char(30) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `account` (`account`),
  KEY `month` (`month`),
  KEY `status` (`status`),
  UNIQUE KEY `attend` (`month`,`account`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
