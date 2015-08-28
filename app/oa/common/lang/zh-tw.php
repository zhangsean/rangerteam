<?php
/**
 * The zh-tw file of common module of RanZhi.
 *
 * @copyright   Copyright 2009-2015 青島易軟天創網絡科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv11.html)
 * @author      Chunsheng wang <chunsheng@cnezsoft.com>
 * @package     common 
 * @version     $Id$
 * @link        http://www.ranzhico.com
 */
$lang->app = new stdclass();
$lang->app->name = 'OA';

$lang->menu->oa = new stdclass();
$lang->menu->oa->dashboard = '我的地盤|dashboard|index|';
$lang->menu->oa->project   = '項目|project|index|';
$lang->menu->oa->announce  = '公告|announce|browse|';
$lang->menu->oa->doc       = '文檔|doc|browse|';
$lang->menu->oa->attend    = '考勤|attend|personal|';
$lang->menu->oa->leave     = '請假|leave|personal|';
$lang->menu->oa->trip      = '出差|trip|personal|';

$lang->dashboard = new stdclass();

$lang->project   = new stdclass();
$lang->project->menu = new stdclass();
$lang->project->menu->involved = '我參與的|project|index|status=involved';
$lang->project->menu->doing    = '進行中|project|index|status=doing';
$lang->project->menu->finished = '已完成|project|index|ststus=finished';
$lang->project->menu->suspend  = '已掛起|project|index|ststus=suspend';

$lang->announce = new stdclass();
$lang->announce->menu = new stdclass();
$lang->announce->menu->browse   = array('link' => '公告列表|announce|browse|', 'alias' => 'view');
$lang->announce->menu->category = '類目管理|tree|browse|type=announce|';

$lang->doc = new stdclass();
$lang->doc->menu = new stdclass();
$lang->doc->menu->create = '添加文檔庫|doc|createlib|';

$lang->attend = new stdclass();
$lang->attend->menu = new stdclass();
$lang->attend->menu->personal   = '我的考勤|attend|personal|';
$lang->attend->menu->department = '部門考勤|attend|department|';
$lang->attend->menu->company    = '公司考勤|attend|company|';
$lang->attend->menu->review     = '補錄審核|attend|browsereview|';
$lang->attend->menu->holiday    = '節假日|holiday|browse|';
$lang->attend->menu->settings   = '設置|attend|settings|';

$lang->holiday = new stdclass();
$lang->holiday->menu = $lang->attend->menu;
$lang->menuGroups->holiday = 'attend';

$lang->leave = new stdclass();
$lang->leave->menu = new stdclass();
$lang->leave->menu->personal   = '我的請假|leave|personal|';
$lang->leave->menu->department = '部門|leave|department|';
$lang->leave->menu->company    = '公司|leave|company|';

$lang->trip = new stdclass();
$lang->trip->menu = new stdclass();
$lang->trip->menu->personal   = '我的出差|trip|personal|';
$lang->trip->menu->department = '部門|trip|department|';
$lang->trip->menu->company    = '公司|trip|company|';
