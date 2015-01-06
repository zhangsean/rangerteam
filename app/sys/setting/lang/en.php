<?php
/**
 * The setting module english file of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     setting 
 * @version     $Id$
 * @link        http://www.ranzhico.com
 */
$lang->setting->common = 'Setting';
$lang->setting->reset  = 'Reset';
$lang->setting->key    = 'Key';
$lang->setting->value  = 'Value';

$lang->setting->lang   = 'Setting';

$lang->setting->module = new stdClass();
$lang->setting->module->user     = 'User role';
$lang->setting->module->product  = 'Product status';
$lang->setting->module->customer = 'Customer level';

$lang->setting->user = new stdClass();
$lang->setting->user->fields['roleList'] = 'Role list';

$lang->setting->product = new stdClass();
$lang->setting->product->fields['statusList'] = 'Product status';

$lang->setting->customer = new stdClass();
$lang->setting->customer->fields['typeList']      = 'Customer type';
$lang->setting->customer->fields['sizeNameList']  = 'Customer Size';
$lang->setting->customer->fields['levelNameList'] = 'Customer Level';

$lang->setting->system = new stdclass();
$lang->setting->system->setCurrency            = 'Set used currency';
$lang->setting->system->fields['currencyList'] = 'Currency list';

$lang->setting->allLang     = 'For all language';
$lang->setting->currentLang = 'For current language';

$lang->setting->placeholder = new stdclass();
$lang->setting->placeholder->key   = 'Key';
$lang->setting->placeholder->value = 'Translation';
$lang->setting->placeholder->info  = 'Description';

$lang->setting->placeholder->typeList = new stdclass();
$lang->setting->placeholder->typeList->key = 'Key should be 1~30 letters';

$lang->setting->placeholder->sizeNameList = new stdclass();
$lang->setting->placeholder->sizeNameList->key   = 'Key should be interger or letters';
$lang->setting->placeholder->sizeNameList->value = 'Brief description';
$lang->setting->placeholder->sizeNameList->info  = 'Detailed description';

$lang->setting->placeholder->levelNameList = new stdclass();
$lang->setting->placeholder->levelNameList->key   = 'Key should be interger or letters';
$lang->setting->placeholder->levelNameList->value = 'Brief description';
$lang->setting->placeholder->levelNameList->info  = 'Detailed description';
