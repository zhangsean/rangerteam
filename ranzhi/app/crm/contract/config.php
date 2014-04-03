<?php
/**
 * The config file of contract module of Ranzhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     contract 
 * @version     $Id$
 * @link        http://www.zentao.net
 */
$config->contract->editor = new stdclass();
$config->contract->editor->create = array('id' => 'items', 'tools' => 'full');
$config->contract->editor->edit   = array('id' => 'items', 'tools' => 'full');

$config->contract->codeFormat = array('ss_', 'Y', 'm', 'd', 'input');
