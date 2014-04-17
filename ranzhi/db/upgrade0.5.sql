ALTER TABLE `sys_product` CHANGE `summary`  `desc` text NOT NULL;

ALTER TABLE `crm_customer` ADD `intension` text NOT NULL AFTER `level`, DROP `referType`, DROP `referID`;

ALTER TABLE `crm_order` add `nextDate` date NOT NULL;

ALTER TABLE `crm_contract`
ADD `deliveredBy` char(30) COLLATE 'utf8_general_ci' NOT NULL AFTER `signedDate`,
ADD `deliveredDate` datetime NOT NULL AFTER `deliveredBy`,
ADD `returnedBy` char(30) COLLATE 'utf8_general_ci' NOT NULL AFTER `deliveredDate`,
ADD `returnedDate` datetime NOT NULL AFTER `returnedBy`;
