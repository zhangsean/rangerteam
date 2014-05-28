<?php
/**
 * The en file of common module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     common 
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
$lang->app = new stdclass();
$lang->app->name = 'CASH';

$lang->menu->cash = new stdclass();
$lang->menu->cash->dashboard = 'Dashboard|dashboard|index|';
$lang->menu->cash->trade     = 'Bookkeeping|trade|index|';
$lang->menu->cash->invocie   = 'Invocie|invocie|index|';
$lang->menu->cash->claim     = 'Expenses Claim|claim|index|';
$lang->menu->cash->report    = 'Report|report|index|';
$lang->menu->cash->depositor = 'Depositor|depositor|index|';
$lang->menu->cash->setting   = 'Settings|tree|browse|type=income|';

/* Menu of depositor module. */
$lang->depositor = new stdclass();
$lang->depositor->menu = new stdclass();
$lang->depositor->menu->browse = array('link' => '<i class="icon-th-list"></i> Depositor List|depositor|browse|', 'alias' => 'create,edit,view');

/* Menu of trade module. */
$lang->trade = new stdclass();
$lang->trade->menu = new stdclass();
$lang->trade->menu->browse   = array('link' => '<i class="icon-th-list"></i> Trade List|trade|browse|', 'alias' => 'create,edit,view');
$lang->trade->menu->transfer = 'Transfer|trade|transfer|';
$lang->trade->menu->expense  = 'Expense|tree|browse|type=expense|';
$lang->trade->menu->income   = 'Income|tree|browse|type=income|';

/* Menu of setting module. */
$lang->setting = new stdclass();
$lang->setting->menu = new stdclass();
$lang->setting->menu->income   = 'Income|tree|browse|type=income|';
$lang->setting->menu->expense  = 'Expense|tree|browse|type=expense|';
$lang->setting->menu->currency = 'Currency|setting|lang|module=depositor&field=currencyList';
