<?php
if(!isset($lang->refund)) $lang->refund = new stdclass();
$lang->refund->common      = 'Reimbursement';
$lang->refund->create      = 'Create';
$lang->refund->browse      = 'Browse List';
$lang->refund->personal    = 'My Reimbursement';
$lang->refund->company     = 'All Reimbursement';
$lang->refund->edit        = 'Edit reimbursement';
$lang->refund->view        = 'View';
$lang->refund->review      = 'Review';
$lang->refund->detail      = 'Detail';
$lang->refund->settings    = 'Settings';
$lang->refund->setCategory = 'Set Category';

$lang->refund->id               = 'ID';
$lang->refund->name             = 'Name';
$lang->refund->category         = 'Category';
$lang->refund->date             = 'Date';
$lang->refund->money            = 'Money';
$lang->refund->reviewMoney      = 'Approval Amount';
$lang->refund->currency         = 'Currency';
$lang->refund->desc             = 'Description';
$lang->refund->status           = 'Status';
$lang->refund->createdBy        = 'Created By';
$lang->refund->createdDate      = 'Created Date';
$lang->refund->editedBy         = 'Edited By';
$lang->refund->editedDate       = 'Edited Date';
$lang->refund->firstReviewer    = 'First reviewer';
$lang->refund->firstReviewDate  = 'First review Date';
$lang->refund->secondReviewer   = 'Second reviewer';
$lang->refund->secondReviewDate = 'Second review Date';
$lang->refund->refundBy         = 'Reimbursed By';
$lang->refund->refundDate       = 'Reimbursec Date';
$lang->refund->baseInfo         = 'Base Info';
$lang->refund->reason           = 'Reason';

$lang->refund->statusList['wait']   = 'Wait';
$lang->refund->statusList['doing']  = 'Doing';
$lang->refund->statusList['pass']   = 'Pass';
$lang->refund->statusList['refuse'] = 'Refuse';
$lang->refund->statusList['finish'] = 'Finish';

$lang->refund->reviewStatusList['pass']   = 'Pass';
$lang->refund->reviewStatusList['reject'] = 'Reject';

$lang->refund->uniqueReviewer = 'The first reviewer and the second reviewer can not be the same.';
$lang->refund->firstNotEmpty  = 'The first reviewer can not be empty.';
