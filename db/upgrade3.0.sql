ALTER TABLE `crm_contact`
add `origin` varchar(150) NOT NULL AFTER `resume`,
add `status` enum('normal','unknown','ignore') NOT NULL AFTER `origin`,
add `company` varchar(255) NOT NULL AFTER `phone`;
