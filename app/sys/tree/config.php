<?php
/**
 * The config file of tree module of RanZhi.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv11.html)
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     tree 
 * @version     $Id$
 * @link        http://www.ranzhico.com
 */
$config->tree->require = new stdclass();
$config->tree->require->edit = 'name';

$config->tree->editor = new stdclass();
$config->tree->editor->edit = array('id' => 'desc', 'tools' => 'simple');

$config->tree->menuGroup = new stdclass();
$config->tree->menuGroup->setting  = ',forum,blog,area,industry,in,out,dept,';
$config->tree->menuGroup->category = ',announce,product,';
