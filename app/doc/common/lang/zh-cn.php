<?php
/**
 * The zh-cn file of common module of RanZhi.
 *
 * @copyright   Copyright 2009-2016 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv12.html)
 * @author      Chunsheng wang <chunsheng@cnezsoft.com>
 * @package     common 
 * @version     $Id$
 * @link        http://www.ranzhico.com
 */
$lang->app = new stdclass();
$lang->app->name = 'DOC';

$lang->menu->doc = new stdclass();
$lang->menu->doc->all       = '所有文档库|doc|index|type=all';
$lang->menu->doc->project   = '项目文档库|doc|index|type=project';
$lang->menu->doc->custom    = '自定义文档库|doc|index|type=custom';

$lang->dashboard = new stdclass();

include (dirname(__FILE__) . '/menuOrder.php');
