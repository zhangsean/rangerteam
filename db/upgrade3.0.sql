ALTER TABLE `crm_contact`
add `origin` varchar(150) NOT NULL AFTER `resume`,
add `originID` mediumint(8) NOT NULL AFTER `origin`,
add `status` enum('normal','wait','ignore') NOT NULL DEFAULT 'wait' AFTER `origin`,
add `company` varchar(255) NOT NULL AFTER `phone`;
