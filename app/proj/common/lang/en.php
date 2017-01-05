<?php
/**
 * The en file of common module of RanZhi.
 *
 * @copyright   Copyright 2009-2016 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv12.html)
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     common 
 * @version     $Id$
 * @link        http://www.ranzhico.com
 */
$lang->app = new stdclass();
$lang->app->name = 'PROJ';

$lang->menu->proj = new stdclass();
$lang->menu->proj->dashboard = 'Home|dashboard|index|';
$lang->menu->proj->involved  = 'My Involved|project|index|status=involved';
$lang->menu->proj->doing     = 'Projects|project|index|status=doing';
$lang->menu->proj->finished  = 'Finished|project|index|ststus=finished';
$lang->menu->proj->suspend   = 'Suspended|project|index|ststus=suspend';

$lang->dashboard = new stdclass();

if(!isset($lang->project)) $lang->project = new stdclass();
$lang->project->menu = new stdclass();

include (dirname(__FILE__) . '/menuOrder.php');
