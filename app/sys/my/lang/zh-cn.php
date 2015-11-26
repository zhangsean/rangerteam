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

$lang->my->order = new stdclass();
$lang->my->order->menu = new stdclass();
$lang->my->order->menu->past     = '亟需联系|my|order|type=past';
$lang->my->order->menu->today    = '今天联系|my|order|type=today';
$lang->my->order->menu->tomorrow = '明天联系|my|order|type=tomorrow';
$lang->my->order->menu->all      = '所有|my|order|type=all';

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

$lang->my->dynamic = new stdclass();
$lang->my->dynamic->common = '我的动态';

$lang->my->dynamic->menu = new stdclass();
$lang->my->dynamic->menu->today      = '今天|my|dynamic|period=today';
$lang->my->dynamic->menu->yesterday  = '昨天|my|dynamic|period=yesterday';
$lang->my->dynamic->menu->twodaysago = '前天|my|dynamic|period=twodaysago';
$lang->my->dynamic->menu->thisweek   = '本周|my|dynamic|period=thisweek';
$lang->my->dynamic->menu->lastweek   = '上周|my|dynamic|period=lastweek';
$lang->my->dynamic->menu->thismonth  = '本月|my|dynamic|period=thismonth';
$lang->my->dynamic->menu->lastmonth  = '上月|my|dynamic|period=lastmonth';
$lang->my->dynamic->menu->all        = '所有|my|dynamic|period=all';
