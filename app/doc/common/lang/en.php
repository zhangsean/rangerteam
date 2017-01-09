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
$lang->app->name = 'DOC';

$lang->menu->doc = new stdclass();
$lang->menu->doc->index = 'Document|doc|index|';

$lang->dashboard = new stdclass();

if(!isset($lang->doc)) $lang->doc = new stdclass();
$lang->doc->menu = new stdclass();
$lang->doc->menu->all     = 'All|doc|index|';
$lang->doc->menu->project = 'Project|doc|alllibs|type=project';
$lang->doc->menu->custom  = 'Custom|doc|alllibs|type=custom';

include (dirname(__FILE__) . '/menuOrder.php');
