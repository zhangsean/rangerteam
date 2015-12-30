ALTER TABLE `crm_contact` add `assignedTo` char(30) NOT NULL;
ALTER TABLE `crm_contact` change `originID` `originAccount` varchar(255) NOT NULL;
