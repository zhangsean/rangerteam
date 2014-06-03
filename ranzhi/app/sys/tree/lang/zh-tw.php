<?php
/**
 * The tree module zh-tw file of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青島易軟天創網絡科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     tree
 * @version     $Id$
 * @link        http://www.ranzhi.org
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

/* Lang items for area. */
$lang->area = new stdclass();
$lang->area->common   = '區域';
$lang->area->name     = '名稱';
$lang->area->alias    = '別名';
$lang->area->parent   = '上級區域';
$lang->area->desc     = '描述';
$lang->area->keywords = '關鍵詞';
$lang->area->children = "子區域";

/* Lang items for industry. */
$lang->industry = new stdclass();
$lang->industry->common   = '行業';
$lang->industry->name     = '名稱';
$lang->industry->alias    = '別名';
$lang->industry->parent   = '上級行業';
$lang->industry->desc     = '描述';
$lang->industry->keywords = '關鍵詞';
$lang->industry->children = "子行業";

/* Lang items for income. */
$lang->income = new stdclass();
$lang->income->common   = '收入科目';
$lang->income->name     = '名稱';
$lang->income->alias    = '別名';
$lang->income->parent   = '上級科目';
$lang->income->desc     = '描述';
$lang->income->keywords = '關鍵詞';
$lang->income->children = '子科目';

/* Lang items for expense. */
$lang->expense = new stdclass();
$lang->expense->common   = '支出科目';
$lang->expense->name     = '名稱';
$lang->expense->alias    = '別名';
$lang->expense->parent   = '上級科目';
$lang->expense->desc     = '描述';
$lang->expense->keywords = '關鍵詞';
$lang->expense->children = '子科目';

$lang->board->readonlyList[0] = '開放';
$lang->board->readonlyList[1] = '只讀';
