<?php
/**
 * The config file of user module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     user 
 * @version     $Id: config.php 2605 2013-12-23 09:12:58Z wwccss $
 * @link        http://www.zentao.net
 */
$config->user->register = new stdclass();
$config->user->register->requiredFields = 'account,realname,email,password1,role';

$config->user->edit = new stdclass();
$config->user->edit->requiredFields = 'realname,email,role';

$config->user->create = new stdclass();
$config->user->create->requiredFields = $config->user->register->requiredFields;

$config->user->default = new stdclass();
$config->user->default->module = RUN_MODE == 'front' ? 'index' : 'admin';
$config->user->default->method = RUN_MODE == 'front' ? 'index' : 'index';
