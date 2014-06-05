CREATE TABLE `team_thread` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `board` mediumint(9) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `author` varchar(60) NOT NULL,
  `editor` varchar(60) NOT NULL,
  `addedDate` datetime NOT NULL,
  `editedDate` datetime NOT NULL,
  `readonly` tinyint(1) NOT NULL DEFAULT '0',
  `views` smallint(5) unsigned NOT NULL DEFAULT '0',
  `stick` enum('0','1','2','3') NOT NULL DEFAULT '0',
  `replies` smallint(6) NOT NULL,
  `repliedBy` varchar(30) NOT NULL,
  `repliedDate` datetime NOT NULL,
  `replyID` mediumint(8) unsigned NOT NULL,
  `hidden` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `category` (`board`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `team_reply` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `thread` mediumint(8) unsigned NOT NULL,
  `content` text NOT NULL,
  `author` char(30) NOT NULL,
  `editor` char(30) NOT NULL,
  `addedDate` datetime NOT NULL,
  `editedDate` datetime NOT NULL,
  `hidden` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `thread` (`thread`),
  KEY `author` (`author`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `sys_message` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `type` char(20) NOT NULL,
  `objectType` varchar(30) NOT NULL DEFAULT '',
  `objectID` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `account` char(30) DEFAULT NULL,
  `from` char(30) NOT NULL,
  `to` char(30) NOT NULL,
  `date` datetime NOT NULL,
  `content` text NOT NULL,
  `status` char(20) NOT NULL,
  `readed` enum('0','1') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `status` (`status`),
  KEY `object` (`objectType`,`objectID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

RENAME TABLE oa_article TO sys_article;
