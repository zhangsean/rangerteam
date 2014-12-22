<?php
/**
 * The zh-tw file of common module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青島易軟天創網絡科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Chunsheng wang <chunsheng@cnezsoft.com>
 * @package     common 
 * @version     $Id$
 * @link        http://www.ranzhico.com
 */
$lang->app = new stdclass();
$lang->app->name = 'CASH';

$lang->menu->cash = new stdclass();
$lang->menu->cash->dashboard = '我的地盤|dashboard|index|';
$lang->menu->cash->trade     = '記賬|trade|browse|';
$lang->menu->cash->check     = '對賬|depositor|check|';
$lang->menu->cash->depositor = '賬戶|depositor|browse|';
$lang->menu->cash->provider  = '供應商|provider|browse|';
$lang->menu->cash->setting   = '設置|tree|browse|type=in|';

/* Menu of depositor module. */
$lang->depositor = new stdclass();

/* Menu of trade module. */
$lang->trade = new stdclass();
$lang->trade->menu = new stdclass();
$lang->trade->menu->browse   = array('link' => '所有賬目|trade|browse|mode=all');
$lang->trade->menu->in       = array('link' => '收入|trade|browse|mode=in');
$lang->trade->menu->out      = array('link' => '支出|trade|browse|mode=out');
$lang->trade->menu->transfer = array('link' => '轉賬|trade|browse|mode=transfer');

/* Menu of trade module. */
$lang->provider = new stdclass();
$lang->provider->menu = new stdclass();
$lang->provider->menu->browse = array('link' => '供應商列表|provider|browse|', 'alias' => 'create,edit,view');

/* Menu of setting module. */
$lang->setting = new stdclass();
$lang->setting->menu = new stdclass();
$lang->setting->menu->income   = '收入科目|tree|browse|type=in|';
$lang->setting->menu->expend   = '支出科目|tree|browse|type=out|';
$lang->setting->menu->currency = '貨幣類型|setting|lang|module=order&field=currencyList&appName=crm';
$lang->setting->menu->schema   = '導入模板設置|schema|browse|';
