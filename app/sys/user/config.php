<?php
/**
 * The config file of user module of RanZhi.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv11.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     user 
 * @version     $Id$
 * @link        http://www.ranzhico.com
 */
$config->user->require = new stdclass();
$config->user->require->create = 'account,realname,email,password1,role';
$config->user->require->edit   = 'realname,email,role';
