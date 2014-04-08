<?php
/**
 * The config file of effort module of Ranzhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     effort 
 * @version     $Id$
 * @link        http://www.ranzhi.co
 */
$config->effort->create = new stdclass();
$config->effort->edit   = new stdclass();
$config->effort->times  = new stdclass();
$config->effort->list   = new stdclass();

$config->effort->create->requiredFields = 'work';
$config->effort->edit->requiredFields   = 'work';
$config->effort->times->delta           = 10;

$config->effort->list->exportFields = 'id, account, date, consumed, objectType, work'; 

$config->effort->objectTables['task']     = TABLE_TASK;
$config->effort->objectTables['order']    = TABLE_ORDER;
$config->effort->objectTables['contract'] = TABLE_CONTRACT;
