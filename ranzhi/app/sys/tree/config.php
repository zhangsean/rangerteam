<?php
/**
 * The config file of tree module of Ranzhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     tree 
 * @version     $Id$
 * @link        http://www.ranzhi.co
 */
$config->tree->require = new stdclass();
$config->tree->require->edit = 'name';

$config->tree->editor = new stdclass();
$config->tree->editor->edit = array('id' => 'desc', 'tools' => 'simple');

$config->tree->systemModules  = ',admin,block,book,company,file,index,message,';
$config->tree->systemModules .= 'product,rss,thread,user,article,blog,';
$config->tree->systemModules .= 'common,error,forum,install,mail,misc,reply,setting,upgrade,';
