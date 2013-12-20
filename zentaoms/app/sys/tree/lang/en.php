<?php
/**
 * The tree category zh-cn file of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     tree
 * @version     $Id$
 * @link        http://www.chanzhi.org
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

/* Lang items for forum. */
$lang->board = new stdclass();
$lang->board->common     = 'Board';
$lang->board->name       = 'Board';
$lang->board->alias      = 'Alias';
$lang->board->parent     = 'Parent';
$lang->board->desc       = 'Description';
$lang->board->keywords   = 'Keyword';
$lang->board->children   = "Children";
$lang->board->readonly   = 'Readonly';
$lang->board->moderators = 'Moderators';

$lang->board->readonlyList[0] = 'Pulic';
$lang->board->readonlyList[1] = 'Readonly';
