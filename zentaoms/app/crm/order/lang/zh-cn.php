<?php
/**
 * The order module zh-cn file of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     order
 * @version     $Id$
 * @link        http://www.zentao.net
 */
$lang->order->common = '订单维护';
$lang->order->effort = '日志';

$lang->order->statusList['normal']   = '正常';
$lang->order->statusList['assigned'] = '已指派';
$lang->order->statusList['signed']   = '已签约';
$lang->order->statusList['payed']    = '已付款';
$lang->order->statusList['closed']   = '已关闭';

$lang->order->closedReasonList['payed']     = '已付款';
$lang->order->closedReasonList['failed']    = '订单失败';
$lang->order->closedReasonList['postponed'] = '延期';

$lang->order->id            = '编号';
$lang->order->name          = '名称';
$lang->order->product       = '相关产品';
$lang->order->customer      = '所属客户';
$lang->order->contact       = '联系人';
$lang->order->team          = '团队';
$lang->order->plan          = '计划金额';
$lang->order->real          = '成交金额';
$lang->order->status        = '状态';
$lang->order->createdBy     = '由谁创建';
$lang->order->createdDate   = '创建时间';
$lang->order->assignedTo    = '指派给';
$lang->order->assignedBy    = '由谁指派';
$lang->order->assignedDate  = '指派时间';
$lang->order->signedBy      = '由谁签单';
$lang->order->signedDate    = '签单时间';
$lang->order->payedDate     = '付款时间';
$lang->order->closedBy      = '由谁关闭';
$lang->order->closedDate    = '关闭时间';
$lang->order->closedReason  = '关闭原因';
$lang->order->closedNote    = '备注';
$lang->order->activatedBy   = '由谁激活';
$lang->order->activatedDate = '激活时间';
$lang->order->contactedBy   = '由谁联系';
$lang->order->contactedDate = '联系时间';

$lang->order->fields = array();
$lang->order->fields['plan'] = new stdclass();
$lang->order->fields['plan']->field   = 'plan';
$lang->order->fields['plan']->control = 'input';

$lang->order->fields['real'] = new stdclass();
$lang->order->fields['real']->field   = 'real';
$lang->order->fields['real']->control = 'input';

$lang->order->fields['status'] = new stdclass();
$lang->order->fields['status']->field   = 'status';
$lang->order->fields['status']->control = 'select';
$lang->order->fields['status']->options = $lang->order->statusList;

$lang->order->fields['assignedTo'] = new stdclass();
$lang->order->fields['assignedTo']->field   = 'assignedTo';
$lang->order->fields['assignedTo']->control = 'input';

$lang->order->fields['assignedBy'] = new stdclass();
$lang->order->fields['assignedBy']->field   = 'assignedBy';
$lang->order->fields['assignedBy']->control = 'input';

$lang->order->fields['signedBy'] = new stdclass();
$lang->order->fields['signedBy']->field   = 'signedBy';
$lang->order->fields['signedBy']->control = 'input';

$lang->order->fields['signedDate'] = new stdclass();
$lang->order->fields['signedDate']->field   = 'signedDate';
$lang->order->fields['signedDate']->control = 'input';

$lang->order->fields['payedDate'] = new stdclass();
$lang->order->fields['payedDate']->field   = 'payedDate';
$lang->order->fields['payedDate']->control = 'input';

$lang->order->fields['closedBy'] = new stdclass();
$lang->order->fields['closedBy']->field   = 'closedBy';
$lang->order->fields['closedBy']->control = 'input';

$lang->order->fields['closedDate'] = new stdclass();
$lang->order->fields['closedDate']->field   = 'closedDate';
$lang->order->fields['closedDate']->control = 'input';

$lang->order->fields['closedReason'] = new stdclass();
$lang->order->fields['closedReason']->field   = 'closedReason';
$lang->order->fields['closedReason']->control = 'select';
$lang->order->fields['closedReason']->options = $lang->order->statusList;

$lang->order->fields['closedNote'] = new stdclass();
$lang->order->fields['closedNote']->field   = 'closedNote';
$lang->order->fields['closedNote']->control = 'input';

$lang->order->fields['activatedBy'] = new stdclass();
$lang->order->fields['activatedBy']->field   = 'activatedBy';
$lang->order->fields['activatedBy']->control = 'input';

$lang->order->fields['activatedDate'] = new stdclass();
$lang->order->fields['activatedDate']->field   = 'activatedDate';
$lang->order->fields['activatedDate']->control = 'input';

$lang->order->fields['contactedBy'] = new stdclass();
$lang->order->fields['contactedBy']->field   = 'contactedBy';
$lang->order->fields['contactedBy']->control = 'input';

$lang->order->fields['contactedDate'] = new stdclass();
$lang->order->fields['contactedDate']->field   = 'contactedDate';
$lang->order->fields['contactedDate']->control = 'input';

$lang->order->list          = '订单列表';
$lang->order->browse        = '维护订单';
$lang->order->create        = '创建订单';
$lang->order->edit          = '编辑订单';
$lang->order->view          = '订单详情';
$lang->order->close         = '关闭订单';
$lang->order->manageMembers = '团队管理';
$lang->order->sign          = '签约';
$lang->order->createTasks   = '创建任务';

$lang->team = new stdclass();
$lang->team->account = '用户';
$lang->team->role    = '角色';
$lang->team->join    = '加盟日';

$lang->order->operaterList = array();
$lang->order->operaterList['']       = '';
$lang->order->operaterList['equal']    = '等于';
$lang->order->operaterList['notequal'] = '不等于';
$lang->order->operaterList['gt']       = '大于';
$lang->order->operaterList['lt']       = '小于';
$lang->order->operaterList['before']   = '早于';
$lang->order->operaterList['after']    = '晚于';

$lang->order->created  = "<strong>%s</strong>于%s创建";
$lang->order->assigned = "<strong>%s</strong>于%s指派给%s";
$lang->order->signed   = "<strong>%s</strong>于%s签单";
