<?php
/**
 * The zh-cn file of block module of Ranzhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     block 
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
$lang->block->common = '区块';
$lang->block->name   = '区块名称';

$lang->block->lblEntry = '应用';
$lang->block->lblBlock = '区块';
$lang->block->lblRss   = 'RSS地址';
$lang->block->lblNum   = '条数';
$lang->block->lblHtml  = 'HTML内容';

$lang->block->params = new stdclass();
$lang->block->params->name  = '参数名称';
$lang->block->params->value = '参数值';

$lang->block->default['oa']['b1']['name']    = '系统公告';
$lang->block->default['oa']['b1']['blockID'] = 'announce';
$lang->block->default['oa']['b1']['type']    = 'system';
$lang->block->default['oa']['b1']['params']['num'] = 15;

$lang->block->default['crm']['b1']['name']    = '我的订单';
$lang->block->default['crm']['b1']['blockID'] = 'order';
$lang->block->default['crm']['b1']['type']    = 'system';
$lang->block->default['crm']['b1']['params']['num']     = 15;
$lang->block->default['crm']['b1']['params']['orderBy'] = 'id_asc';
$lang->block->default['crm']['b1']['params']['status']  = array();

$lang->block->default['crm']['b2']['name']    = '我的合同';
$lang->block->default['crm']['b2']['blockID'] = 'contract';
$lang->block->default['crm']['b2']['type']    = 'system';
$lang->block->default['crm']['b2']['params']['num']     = 15;
$lang->block->default['crm']['b2']['params']['orderBy'] = 'id_asc';
$lang->block->default['crm']['b2']['params']['status']  = array();

$lang->block->default['crm']['b3']['name']    = '我的任务';
$lang->block->default['crm']['b3']['blockID'] = 'task';
$lang->block->default['crm']['b3']['type']    = 'system';
$lang->block->default['crm']['b3']['params']['num']     = 15;
$lang->block->default['crm']['b3']['params']['orderBy'] = 'id_asc';
$lang->block->default['crm']['b3']['params']['status']  = array();
