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
$lang->menu->oa->dashboard = 'Dashboard|dashboard|index|';
$lang->menu->oa->project   = 'Project|project|index|';
$lang->menu->oa->announce  = 'Announce|announce|index|';
$lang->menu->oa->doc       = 'Document|doc|index|';
$lang->menu->oa->attend    = 'Attendance|attend|personal|';
$lang->menu->oa->leave     = 'Leave|leave|browse|type=personal';
$lang->menu->oa->trip      = 'Trip|trip|browse|type=personal';

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

$lang->attend = new stdclass();
$lang->attend->menu = new stdclass();
$lang->attend->menu->personal   = 'My attendance|attend|personal|';
$lang->attend->menu->department = 'Department attendance|attend|department|';
$lang->attend->menu->company    = 'Company attendance|attend|department|date=&company=true';
$lang->attend->menu->review     = 'Review attendance|attend|browsereview|';
$lang->attend->menu->holiday    = 'Holiday|holiday|browse|';
$lang->attend->menu->settings   = 'Setting|attendance|settings|';

$lang->holiday = new stdclass();
$lang->holiday->menu = $lang->attend->menu;
$lang->menuGroups->holiday = 'attend';

$lang->leave = new stdclass();
$lang->leave->menu = new stdclass();
$lang->leave->menu->browsePersonal = 'My|leave|browse|type=personal';
$lang->leave->menu->browseDept     = 'Department|leave|browse|type=department';
$lang->leave->menu->browseCompany  = 'Company|leave|browse|type=company';

$lang->trip = new stdclass();
$lang->trip->menu = new stdclass();
$lang->trip->menu->browsePersonal = 'My|trip|browse|type=personal';
$lang->trip->menu->browseDept     = 'Department|trip|browse|type=department';
$lang->trip->menu->browseCompany  = 'Company|trip|browse|type=company';
