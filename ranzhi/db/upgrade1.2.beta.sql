DROP TABLE IF EXISTS oa_block;
CREATE TABLE `sys_block` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `account` char(30) NOT NULL,
  `app` varchar(20) NOT NULL,
  `title` varchar(100) NOT NULL,
  `source` varchar(20) NOT NULL,
  `block` varchar(20) NOT NULL,
  `params` text NOT NULL,
  `order` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `grid` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY account (`account`, `app`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

ALTER TABLE `sys_entry` ADD `buildin` tinyint(1) NOT NULL DEFAULT '0' AFTER `code`,
ADD `integration` tinyint(1) NOT NULL DEFAULT '1' AFTER `buildin`;
ALTER TABLE `sys_entry` ADD `abbr` char(2) COLLATE 'utf8_general_ci' NOT NULL AFTER `name`;

ALTER TABEL crm_contact ADD fax char(20) NOT NULL;
