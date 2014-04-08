<?php
/**
 * The order module zh-cn file of Ranzhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     order
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
$lang->order->common = '订单维护';
$lang->order->effort = '日志';

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

$lang->order->list          = '订单列表';
$lang->order->browse        = '维护订单';
$lang->order->create        = '创建订单';
$lang->order->edit          = '编辑订单';
$lang->order->view          = '订单详情';
$lang->order->close         = '关闭订单';
$lang->order->manageMembers = '团队管理';
$lang->order->sign          = '签约';
$lang->order->createTasks   = '创建任务';

$lang->order->statusList['normal']   = '正常';
$lang->order->statusList['assigned'] = '已指派';
$lang->order->statusList['signed']   = '已签约';
$lang->order->statusList['payed']    = '已付款';
$lang->order->statusList['closed']   = '已关闭';

$lang->order->statusAccents['normal']   = '';
$lang->order->statusAccents['assigned'] = 'alert-warning';
$lang->order->statusAccents['signed']   = 'alert-info';
$lang->order->statusAccents['payed']    = 'alert-success';
$lang->order->statusAccents['closed']   = '';

$lang->order->closedReasonList['payed']     = '已付款';
$lang->order->closedReasonList['failed']    = '订单失败';
$lang->order->closedReasonList['postponed'] = '延期';

$lang->order->history  = '历史';
$lang->order->created  = "<strong>%s</strong> 创建了订单";
$lang->order->assigned = "由 <strong>%s</strong> 指派给 %s";
$lang->order->signed   = "由 <strong>%s</strong> 签单";
$lang->order->activated= "由 <strong>%s</strong> 激活";

$lang->team = new stdclass();
$lang->team->account = '用户';
$lang->team->role    = '角色';
$lang->team->join    = '加盟日';
