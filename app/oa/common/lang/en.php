<?php
/**
 * The en file of common module of RanZhi.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv11.html)
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     common 
 * @version     $Id$
 * @link        http://www.ranzhico.com
 */
$lang->app = new stdclass();
$lang->app->name = 'OA';

$lang->menu->oa = new stdclass();
$lang->menu->oa->dashboard  = 'Dashboard|dashboard|index|';
$lang->menu->oa->project    = 'Project|project|index|';
$lang->menu->oa->announce   = 'Announce|announce|index|';
$lang->menu->oa->doc        = 'Document|doc|index|';
$lang->menu->oa->attendance = 'Attendance|attendance|personal|';

$lang->dashboard = new stdclass();

$lang->project   = new stdclass();
$lang->project->menu = new stdclass();
$lang->project->menu->involved = 'Involved With Me|project|index|status=involved';
$lang->project->menu->doing    = 'Projects|project|index|status=doing';
$lang->project->menu->finished = 'Finished|project|index|ststus=finished';
$lang->project->menu->suspend  = 'Suspended|project|index|ststus=suspend';

$lang->announce = new stdclass();
$lang->announce->menu = new stdclass();
$lang->announce->menu->browse   = array('link' => 'Announce List|announce|browse|', 'alias' => 'view');
$lang->announce->menu->category = 'Category|tree|browse|type=announce|';

$lang->doc = new stdclass();
$lang->doc->menu = new stdclass();
$lang->doc->menu->create = 'Create Library|doc|createlib|';

$lang->attendance = new stdclass();
$lang->attendance->menu = new stdclass();
$lang->attendance->menu->personal   = 'My attendance|attendance|personal|';
$lang->attendance->menu->department = 'Department attendance|attendance|department|';
$lang->attendance->menu->company    = 'Company attendance|attendance|personal|';
$lang->attendance->menu->settings   = 'Setting|attendance|settings|';
