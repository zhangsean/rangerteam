-- DROP TABLE IF EXISTS `oa_attendance`;
CREATE TABLE `oa_attendance` (
  `id` mediumint NOT NULL AUTO_INCREMENT,
  `sign` datetime NOT NULL,
  `quit` datetime NOT NULL,
  `date` date NOT NULL,
  `status` enum('unknown','normal','late','early','absenteeism','off','travel','holiday') NOT NULL DEFAULT 'unknown',
  `account` char(30) NOT NULL,
  `extra` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `account` (`account`),
  KEY `status` (`status`),
  KEY `date` (`date`),
  UNIQUE KEY `attendance` (`date`,`account`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- DROP TABLE IF EXISTS `oa_attendanceRepair`;
CREATE TABLE `oa_attendanceRepair` (
  `attendance` mediumint(8) NOT NULL,
  `sign` datetime NOT NULL,
  `quit` datetime NOT NULL,
  `desc` varchar(255) NOT NULL,
  `reason` enum('normal','off','travel') NOT NULL DEFAULT 'normal',
  `status` enum('normal','passed','rejected') NOT NULL DEFAULT 'normal',
  `createdBy` char(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  `editedBy` char(30) NOT NULL,
  `editedDate` datetime NOT NULL,
  KEY `attendance` (`attendance`),
  KEY `reason` (`reason`),
  KEY `status` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
