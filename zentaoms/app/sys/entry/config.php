<?php
/**
 * The config file of entry module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     entry 
 * @version     $Id: config.php 2605 2013-12-23 09:12:58Z wwccss $
 * @link        http://www.zentao.net
 */
$config->entry                         = new stdclass();
$config->entry->create                 = new stdclass();
$config->entry->create->requiredFields = 'name,code,openMode,key,ip,login';
$config->entry->edit                   = new stdclass();
$config->entry->edit->requiredFields   = 'name,openMode,key,ip,login';
