<?php
/**
 * The zh-tw file of common module of RanZhi.
 *
 * @copyright   Copyright 2009-2016 青島易軟天創網絡科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv12.html)
 * @author      Chunsheng wang <chunsheng@cnezsoft.com>
 * @package     common 
 * @version     $Id$
 * @link        http://www.ranzhico.com
 */
$lang->app = new stdclass();
$lang->app->name = 'PROJ';

$lang->menu->proj = new stdclass();
$lang->menu->proj->dashboard = '首頁|dashboard|index|';
$lang->menu->proj->involved  = '我參與的|project|index|status=involved';
$lang->menu->proj->doing     = '進行中|project|index|status=doing';
$lang->menu->proj->finished  = '已完成|project|index|ststus=finished';
$lang->menu->proj->suspend   = '已掛起|project|index|ststus=suspend';

$lang->dashboard = new stdclass();

if(!isset($lang->project)) $lang->project = new stdclass();
$lang->project->menu = new stdclass();

include (dirname(__FILE__) . '/menuOrder.php');
