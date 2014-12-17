<?php
/**
 * The customer module config file of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     customer
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
$config->customer->require = new stdclass();
$config->customer->require->create = 'contact';
$config->customer->require->edit   = 'name';

$config->customer->editor = new stdclass();
$config->customer->editor->create = array('id' => 'desc', 'tools' => 'simple');
$config->customer->editor->edit   = array('id' => 'desc', 'tools' => 'simple');
$config->customer->editor->assign = array('id' => 'comment', 'tools' => 'simple');

global $lang;
$config->customer->search['module'] = 'customer';

$config->customer->search['fields']['id']            = $lang->customer->id;
$config->customer->search['fields']['name']          = $lang->customer->name;
$config->customer->search['fields']['level']         = $lang->customer->level;
$config->customer->search['fields']['contactedDate'] = $lang->customer->contactDate;
$config->customer->search['fields']['nextDate']      = $lang->customer->nextDate;

$config->customer->search['params']['id']            = array('operator' => '=',  'control' => 'input',  'values' => '');
$config->customer->search['params']['name']          = array('operator' => '=',  'control' => 'input',  'values' => '');
$config->customer->search['params']['level']         = array('operator' => '=',  'control' => 'select', 'values' => $lang->customer->levelNameList);
$config->customer->search['params']['contactedDate'] = array('operator' => '>=', 'control' => 'input',  'values' => '', 'class' => 'date');
$config->customer->search['params']['nextDate']      = array('operator' => '>=', 'control' => 'input',  'values' => '', 'class' => 'date');
