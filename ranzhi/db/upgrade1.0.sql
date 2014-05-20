ALTER TABLE `oa_article` change `addedDate` `createdDate` datetime NOT NULL;

ALTER TABLE `oa_doc` change `addedBy` `createdBy`  varchar(30) NOT NULL;
ALTER TABLE `oa_doc` change `addedDate` `createdDate` datetime NOT NULL;

ALTER TABLE `sys_file` change `addedBy` `createdBy`  varchar(30) NOT NULL;
ALTER TABLE `sys_file` change `addedDate` `createdDate` datetime NOT NULL;

CREATE TABLE `cash_depositor` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `abbr` char(60) NOT NULL,
  `provider` char(100) NOT NULL,
  `title` char(100) NOT NULL,
  `account` char(90) NOT NULL,
  `bankcode` varchar(30) NOT NULL,
  `public` enum('0','1') NOT NULL,
  `type` enum('cash','bank','online') NOT NULL,
  `currency` char(30) NOT NULL,
  `status` enum('normal','disable') NOT NULL DEFAULT 'normal',
  `createdBy` char(30) NOT NULL DEFAULT '',
  `createdDate` datetime NOT NULL,
  `editedBy` char(30) NOT NULL DEFAULT '',
  `editedDate` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `cash_balance` ( 
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `depositor` mediumint(8) NOT NULL,
  `date` date NOT NULL,
  `money` float(12,2) NOT NULL,
  `currency` char(30) NOT NULL,
  `createdBy` char(30) NOT NULL DEFAULT '',
  `createdDate` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `cash_trade` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT, 
  `depositor` mediumint(8) NOT NULL,
  `parent` text NOT NULL,
  `product` mediumint(8) NOT NULL,
  `trader` char(100) NOT NULL,
  `order` mediumint(8) NOT NULL,
  `contract` mediumint(8) NOT NULL,
  `dept` mediumint(8) unsigned NOT NULL,
  `type` enum('in', 'out') NOT NULL,
  `transfer` enum('0', '1') NOT NULL,
  `money` float(12,2) NOT NULL,
  `currency` varchar(30) NOT NULL,
  `date` datetime NOT NULL,
  `handler` char(30) NOT NULL,
  `category` mediumint(8) NOT NULL,
  `desc` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
