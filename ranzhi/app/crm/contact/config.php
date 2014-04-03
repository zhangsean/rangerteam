<?php
/**
 * The config file of contact module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     contact 
 * @version     $Id$
 * @link        http://www.zentao.net
 */
$config->contact->require = new stdclass();
$config->contact->require->create = 'customer, realname, email';
$config->contact->require->edit   = 'customer, realname, email';
