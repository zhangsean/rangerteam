<?php
/**
 * The config file of user module of Ranzhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     user 
 * @version     $Id$
 * @link        http://www.zentao.net
 */
$config->user->require = new stdclass();
$config->user->require->register = 'account,realname,email,password1,role';
$config->user->require->edit     = 'realname,email,role';
$config->user->require->create   = $config->user->require->register;

$config->user->default = new stdclass();
$config->user->default->module = RUN_MODE == 'front' ? 'index' : 'admin';
$config->user->default->method = RUN_MODE == 'front' ? 'index' : 'index';
