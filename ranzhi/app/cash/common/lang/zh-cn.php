<?php
/**
 * The zh-cn file of common module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Chunsheng wang <chunsheng@cnezsoft.com>
 * @package     common 
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
$lang->app = new stdclass();
$lang->app->name = 'CASH';

$lang->menu->cash = new stdclass();
$lang->menu->cash->dashboard = '概览|index|index|';
$lang->menu->cash->trade     = '记账|trade|index|';
$lang->menu->cash->invocie   = '发票|invocie|index|';
$lang->menu->cash->claim     = '报销|claim|index|';
$lang->menu->cash->report    = '报表|report|index|';
$lang->menu->cash->depositor = '账户|depositor|index|';
$lang->menu->cash->setting   = '设置|tree|browse|type=income|';

/* Menu of depositor module. */
$lang->depositor = new stdclass();
$lang->depositor->menu = new stdclass();
$lang->depositor->menu->browse = array('link' => '<i class="icon-th-list"></i> 帐号列表|depositor|browse|', 'alias' => 'create,edit,view');

/* Menu of setting module. */
$lang->setting = new stdclass();
$lang->setting->menu = new stdclass();
$lang->setting->menu->income  = '收入科目设置|tree|browse|type=income|';
$lang->setting->menu->expense = '支出科目设置|tree|browse|type=expense|';
