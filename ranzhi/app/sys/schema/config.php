<?php
/**
 * The config file of schema module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     schema 
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
$config->schema->require = new stdclass();
$config->schema->require->create = 'money,type,date,customer';
$config->schema->require->edit   = 'money,type,date,customer';
