<?php
/**
 * The zh-cn file of block module of Ranzhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     block 
 * @version     $Id$
 * @link        http://www.zentao.net
 */
$lang->block->announce = '系统公告';

$lang->block->lblBlock = '区块';

$lang->block->num     = '数量';
$lang->block->orderBy = '排序';
$lang->block->status  = '状态';
$lang->block->asc     = '正序';
$lang->block->desc    = '倒序';
$lang->block->actions = '操作';

$lang->block->admin = '管理区块';

$lang->block->defaultBlocks['b1'] = new stdclass();
$lang->block->defaultBlocks['b1']->value = json_encode(array('name' => '系统公告', 'blockID' => 'announce', 'params' => array('num' => 15), 'type' => 'system'));
