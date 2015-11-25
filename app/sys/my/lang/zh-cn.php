<?php
/**
 * The zh-cn file of my module of RanZhi.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv12.html)
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     my 
 * @version     $Id$
 * @link        http://www.ranzhico.com
 */
$lang->my = new stdclass();

$lang->my->todo = new stdclass();
$lang->my->todo->menu = new stdclass();
$lang->my->todo->menu->today           = '今天|my|todo|type=today';
$lang->my->todo->menu->assignedToOther = '指派他人|my|todo|type=assignedToOther';
$lang->my->todo->menu->assignedToMe    = '指派给我|my|todo|type=assignedToMe';
$lang->my->todo->menu->future          = '待定|my|todo|type=future';
$lang->my->todo->menu->all             = '所有|my|todo|type=all';

$lang->my->review = new stdclass();
$lang->my->review->menu = new stdclass();
$lang->my->review->menu->attend = '考勤|my|review|type=attend';
$lang->my->review->menu->leave  = '请假|my|review|type=leave';
$lang->my->review->menu->refund = '报销|my|review|type=refund';

$lang->my->task = new stdclass();
$lang->my->task->common     = '我的任务';
$lang->my->task->assignedTo = '指派给我';
$lang->my->task->createdBy  = '由我创建';
$lang->my->task->finishedBy = '由我完成';
$lang->my->task->canceledBy = '由我取消';

$lang->my->task->menu = new stdclass();
$lang->my->task->menu->assignedToMe = '指派给我|my|task|type=assignedTo';
$lang->my->task->menu->createdByMe  = '由我创建|my|task|type=createdBy';
$lang->my->task->menu->fineshedByMe = '由我完成|my|task|type=finishedBy';
$lang->my->task->menu->canceledByMe = '由我取消|my|task|type=canceledBy';

$lang->my->project = new stdclass();
$lang->my->project->common = '我的项目';
