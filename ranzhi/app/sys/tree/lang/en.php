<?php
/**
 * The tree category zh-cn file of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     tree
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
$lang->tree->add         = "Add";
$lang->tree->edit        = "Edit";
$lang->tree->addChild    = "Add child";
$lang->tree->delete      = "Delete";
$lang->tree->browse      = "Manage";
$lang->tree->manage      = "Manage";
$lang->tree->fix         = "Fix data";

$lang->tree->noCategories  = 'No category yet, add one first.';
$lang->tree->aliasRepeat   = 'Alias: %s already exists。';
$lang->tree->aliasConflict = 'Alias: %s  conflicts with system modules';
$lang->tree->hasChildren   = "The board has children, can't be deleted.";
$lang->tree->confirmDelete = "Are you sure to delete it?";
$lang->tree->successFixed  = "Successfully fixed.";

/* Lang items for article, products. */
$lang->category = new stdclass();
$lang->category->common   = 'Category';
$lang->category->name     = 'Name';
$lang->category->alias    = 'Alias';
$lang->category->parent   = 'Parent';
$lang->category->desc     = 'Description';
$lang->category->keywords = 'Keyword';
$lang->category->children = "Children";

/* Lang items for area. */
$lang->area = new stdclass();
$lang->area->common   = '区域';
$lang->area->name     = '名称';
$lang->area->alias    = '别名';
$lang->area->parent   = '上级区域';
$lang->area->desc     = '描述';
$lang->area->keywords = '关键词';
$lang->area->children = "子区域";

/* Lang items for industry. */
$lang->industry = new stdclass();
$lang->industry->common   = '行业';
$lang->industry->name     = '名称';
$lang->industry->alias    = '别名';
$lang->industry->parent   = '上级行业';
$lang->industry->desc     = '描述';
$lang->industry->keywords = '关键词';
$lang->industry->children = "子行业";

$lang->board->readonlyList[0] = 'Pulic';
$lang->board->readonlyList[1] = 'Readonly';
