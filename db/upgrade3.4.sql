ALTER TABLE oa_refund CHANGE `status` `status` enum('draft','wait','doing','pass','reject','finish') NOT NULL DEFAULT 'wait';
ALTER TABLE cash_trade CHANGE `type` `type` enum('in','out','transferin','transferout','invest','redeem') NOT NULL;
ALTER TABLE sys_category CHANGE `major` `major` enum('0','1','2','3','4') NOT NULL DEFAULT '0';
