<?php
/**
 * The tree category zh-tw file of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青島息壤網絡信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     tree
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
$lang->tree->add         = "添加";
$lang->tree->edit        = "編輯";
$lang->tree->addChild    = "添加子類目";
$lang->tree->delete      = "刪除類目";
$lang->tree->browse      = "類目維護";
$lang->tree->manage      = "維護類目";
$lang->tree->fix         = "修復數據";

$lang->tree->noCategories  = '您還沒有添加類目，請添加類目。';
$lang->tree->aliasRepeat   = '別名: %s 已經存在,不能重複添加。';
$lang->tree->aliasConflict = '別名: %s 與系統模組衝突，不能添加。';
$lang->tree->hasChildren   = '該板塊存在子版塊，不能刪除。';
$lang->tree->confirmDelete = "您確定刪除該類目嗎？";
$lang->tree->successFixed  = "成功修復";

/* Lang items for article, products. */
$lang->category = new stdclass();
$lang->category->common   = '類目';
$lang->category->name     = '類目名稱';
$lang->category->alias    = '別名';
$lang->category->parent   = '上級類目';
$lang->category->desc     = '描述';
$lang->category->keywords = '關鍵詞';
$lang->category->children = "子類目";

/* Lang items for forum. */
$lang->board = new stdclass();
$lang->board->common     = '版塊';
$lang->board->name       = '版塊';
$lang->board->alias      = '別名';
$lang->board->parent     = '上級版塊';
$lang->board->desc       = '描述';
$lang->board->keywords   = '關鍵詞';
$lang->board->children   = "子版塊";
$lang->board->readonly   = '訪問權限';
$lang->board->moderators = '版主';

$lang->board->readonlyList[0] = '開放';
$lang->board->readonlyList[1] = '只讀';
