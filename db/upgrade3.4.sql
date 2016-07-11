ALTER TABLE oa_refund CHANGE `status` `status` enum('draft','wait','doing','pass','reject','finish') NOT NULL DEFAULT 'wait';
