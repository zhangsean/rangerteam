<?php
/**
 * The config file of task module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     task 
 * @version     $Id$
 * @link        http://www.zentao.net
 */
$config->task->require = new stdclass();
$config->task->require->create = 'name, customer, order';
$config->task->require->edit   = 'name, customer, order';

$config->task->editor = new stdclass();
$config->task->editor->create   = array('id' => 'desc', 'tools' => 'simple');
$config->task->editor->edit     = array('id' => 'desc', 'tools' => 'simple');
$config->task->editor->assignto = array('id' => 'comment', 'tools' => 'simple');
$config->task->editor->finish   = array('id' => 'comment', 'tools' => 'simple');
