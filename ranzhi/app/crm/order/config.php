<?php
/**
 * The config file of order module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     feedback 
 * @version     $Id$
 * @link        http://www.zentao.net
 */
$config->order->require = new stdclass();
$config->order->require->create = 'product,customer';
$config->order->require->edit   = 'product,customer';

$config->order->editor = new stdclass();
$config->order->editor->close = array('id' => 'closedNote', 'tools' => 'simple');
