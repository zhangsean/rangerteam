ALTER TABLE oa_refund CHANGE `status` `status` enum('draft','wait','doing','pass','reject','finish') NOT NULL DEFAULT 'wait';
ALTER TABLE cash_trade CHANGE `type` `type` enum('in','out','transferin','transferout','invest','redeem') NOT NULL;
