ALTER TABLE `oa_todo` add `assignedTo` varchar(30) NOT NULL DEFAULT '' AFTER `private`;
ALTER TABLE `oa_todo` add `assignedBy` varchar(30) NOT NULL DEFAULT '' AFTER `assignedTo`;
ALTER TABLE `sys_entry` add `zentao` enum('0', '1') NOT NULL DEFAULT '0';
