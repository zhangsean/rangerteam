<?php
if(!isset($lang->refund)) $lang->refund = new stdclass();
$lang->refund->common      = '报销';
$lang->refund->create      = '申请报销';
$lang->refund->browse      = '报销列表';
$lang->refund->edit        = '编辑报销';
$lang->refund->review      = '报销审批';
$lang->refund->detail      = '详情';
$lang->refund->settings    = '设置';
$lang->refund->setCategory = '报销科目设置';

$lang->refund->id               = '编号';
$lang->refund->name             = '名称';
$lang->refund->category         = '科目';
$lang->refund->date             = '日期';
$lang->refund->money            = '金额';
$lang->refund->currency         = '货币';
$lang->refund->desc             = '描述';
$lang->refund->status           = '状态';
$lang->refund->createdBy        = '创建者';
$lang->refund->createdDate      = '创建日期';
$lang->refund->editedBy         = '编辑者';
$lang->refund->editedDate       = '编辑日期';
$lang->refund->firstReviewer    = '第一审批人';
$lang->refund->firstReviewDate  = '第一审批日期';
$lang->refund->secondReviewer   = '第二审批人';
$lang->refund->secondReviewDate = '第二审批日期';
$lang->refund->refundBy         = '经办人';
$lang->refund->refundDate       = '报销日期';

$lang->refund->statusList['wait']   = '等待审批';
$lang->refund->statusList['doing']  = '审批中';
$lang->refund->statusList['pass']   = '审批通过';
$lang->refund->statusList['refuse'] = '审批拒绝';
$lang->refund->statusList['finish'] = '已报销';
