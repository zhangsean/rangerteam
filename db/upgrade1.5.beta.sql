CREATE TABLE `crm_plan` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `amount` decimal(12,2) NOT NULL,
  `contract` mediumint(8) unsigned NOT NULL,
  `returnedBy` char(30) COLLATE 'utf8_general_ci' NOT NULL,
  `returnedDate` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `crm_delivery` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `contract` mediumint(8) unsigned NOT NULL,
  `deliveredBy` char(30) COLLATE 'utf8_general_ci' NOT NULL,
  `deliveredDate` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

ALTER TABLE `sys_schema` ADD `dept` char(10) NOT NULL AFTER `fee`;
