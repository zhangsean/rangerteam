ALTER TABLE `cash_trade` ADD INDEX `depositor` (`depositor`);
ALTER TABLE `cash_trade` ADD INDEX `parent` (`parent`);
ALTER TABLE `cash_trade` ADD INDEX `product` (`product`);
ALTER TABLE `cash_trade` ADD INDEX `trader` (`trader`);
ALTER TABLE `cash_trade` ADD INDEX `order` (`order`);
ALTER TABLE `cash_trade` ADD INDEX `contract` (`contract`);
ALTER TABLE `cash_trade` ADD INDEX `investID` (`investID`);
ALTER TABLE `cash_trade` ADD INDEX `loanID` (`loanID`);
ALTER TABLE `cash_trade` ADD INDEX `dept` (`dept`);

DELETE FROM `sys_grouppriv` WHERE `module`='leave' AND `method`='reviewBack';
