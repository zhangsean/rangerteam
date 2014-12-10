CREATE TABLE `crm_plan` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `amount` decimal(12,2) NOT NULL,
  `contract` mediumint(8) unsigned NOT NULL,
  `returnedBy` char(30) COLLATE 'utf8_general_ci' NOT NULL,
  `returnedDate` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
