<?php
/**
 * The config file of feedback module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     feedback 
 * @version     $Id$
 * @link        http://www.zentao.net
 */
$config->feedback->editor = new stdclass();
$config->feedback->editor->create   = array('id' => 'desc', 'tools' => 'full');
$config->feedback->editor->edit     = array('id' => 'desc', 'tools' => 'full');
$config->feedback->editor->view     = array('id' => 'reply,lastComment,doubt', 'tools' => 'simple');
$config->feedback->editor->close    = array('id' => 'comment', 'tools' => 'simple');
$config->feedback->editor->assignto = array('id' => 'comment', 'tools' => 'simple');

$config->feedback->require = new stdclass();
$config->feedback->require->create = 'product,customer,contact,title';
$config->feedback->require->edit   = 'product,customer,contact,title';
$config->feedback->require->close  = 'closedReason';
