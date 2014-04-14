<?php
/**
 * The config file of product module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     product 
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
$config->product->require = new stdclass();
$config->product->require->create = 'name, code';
$config->product->require->edit   = 'name, code';

$config->product->action = new stdclass();

global $lang;
$config->product->action->common = new stdclass();
$config->product->action->common->createOrder = new stdclass();
$config->product->action->common->createOrder->condations = array();
$config->product->action->common->createOrder->inputs = array();
$orderInputs = array('customer' => array('rules' => 'require'));

$config->field = new stdclass();
$config->field->require = new stdclass();
$config->field->require->create = 'name, field, product, control';
$config->field->require->edit   = 'name, field, control';

$config->field->controlTypeList = array();
$config->field->controlTypeList['input']    = 'varchar(200)';
$config->field->controlTypeList['textarea'] = 'text';
$config->field->controlTypeList['date']     = 'date';
$config->field->controlTypeList['datetime'] = 'datetime';
$config->field->controlTypeList['select']   = 'varchar(200)';
$config->field->controlTypeList['radio']    = 'varchar(200)';
$config->field->controlTypeList['checkbox'] = 'varchar(200)';
$config->field->controlTypeList['user']     = 'varchar(200)';
$config->field->controlTypeList['contact']  = 'varchar(200)';
$config->field->controlTypeList['customer'] = 'varchar(200)';

$config->field->lengthList[10]  = ',date,';
$config->field->lengthList[19]  = ',datetime,';
$config->field->lengthList[200] = ',input,select,radio,checkbox,user,contact,customer,';

$config->action = new stdclass();
$config->action->require = new stdclass();
$config->action->require->create = 'name, action, product';
$config->action->require->edit   = 'name, action';
