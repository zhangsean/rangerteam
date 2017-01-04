ALTER TABLE `cash_trade` ADD INDEX `depositor` (`depositor`);
ALTER TABLE `cash_trade` ADD INDEX `parent` (`parent`);
ALTER TABLE `cash_trade` ADD INDEX `product` (`product`);
ALTER TABLE `cash_trade` ADD INDEX `trader` (`trader`);
ALTER TABLE `cash_trade` ADD INDEX `order` (`order`);
ALTER TABLE `cash_trade` ADD INDEX `contract` (`contract`);
ALTER TABLE `cash_trade` ADD INDEX `investID` (`investID`);
ALTER TABLE `cash_trade` ADD INDEX `loanID` (`loanID`);
ALTER TABLE `cash_trade` ADD INDEX `dept` (`dept`);

UPDATE `sys_lang` SET `app`='sys' WHERE `app`='crm' AND `module`='product';
UPDATE `sys_lang` SET `app`='sys' WHERE `app`='crm' AND `module`='customer';

DELETE FROM `sys_grouppriv` WHERE `module`='leave' AND `method`='reviewBack';

INSERT INTO `sys_entry` (`name`, `abbr`, `code`, `buildin`, `integration`, `open`, `key`, `ip`, `logo`, `login`, `control`, `size`, `position`, `visible`, `order`) VALUES
('文档', '文档', 'doc', 1, 1, 'iframe', '76ff605479df34f1d239730efa68d562', '*', 'theme/default/images/ips/app-doc.png', '../doc', 'simple', 'max', 'default', 1, 26);
