ALTER TABLE `crm_contact`
add `assignedTo` char(30) NOT NULL,
add `ignoredBy` char(30) NOT NULL;

ALTER TABLE `crm_contact` change `originID` `originAccount` varchar(255) NOT NULL;

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
  `status` varchar(20) NOT NULL DEFAULT 'normal',
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
  `type` varchar(30) NOT NULL DEFAULT '',
  `amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `desc` text,
  PRIMARY KEY (`id`),
  KEY `salary` (`salary`),
  KEY `item` (`item`),
  KEY `type` (`type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
