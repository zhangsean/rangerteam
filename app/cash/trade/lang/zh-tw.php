<?php
/**
 * The trade module zh-tw file of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青島易軟天創網絡科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     trade
 * @version     $Id$
 * @link        http://www.ranzhico.com
 */
if(!isset($lang->trade)) $lang->trade = new stdclass();
$lang->trade->common      = '記賬';
$lang->trade->id          = '編號';
$lang->trade->depositor   = '賬號';
$lang->trade->type        = '交易';
$lang->trade->currency    = '貨幣';
$lang->trade->trader      = '商戶';
$lang->trade->customer    = '客戶';
$lang->trade->money       = '金額';
$lang->trade->desc        = '說明';
$lang->trade->product     = '產品';
$lang->trade->order       = '訂單';
$lang->trade->contract    = '合同';
$lang->trade->category    = '科目';
$lang->trade->date        = '時間';
$lang->trade->handlers    = '經辦人';
$lang->trade->dept        = '部門';
$lang->trade->receipt     = '收款賬戶';
$lang->trade->payment     = '付款賬戶';
$lang->trade->fee         = '手續費';
$lang->trade->transferIn  = '轉入金額';
$lang->trade->transferOut = '轉出金額';
$lang->trade->schema      = '模板';
$lang->trade->importFile  = '導入檔案';
$lang->trade->encode      = '編碼';

$lang->trade->create      = '記賬';
$lang->trade->in          = '收入';
$lang->trade->out         = '支出';
$lang->trade->createIn    = '記收入';
$lang->trade->createOut   = '記支出';
$lang->trade->transfer    = '記轉賬';
$lang->trade->edit        = '編輯賬目';
$lang->trade->detail      = '明細';
$lang->trade->browse      = '賬目列表';
$lang->trade->delete      = '刪除記錄';
$lang->trade->batchCreate = '批量記賬';
$lang->trade->batchEdit   = '批量編輯';
$lang->trade->newTrader   = '新建';
$lang->trade->import      = '導入';
$lang->trade->showImport  = '導入確認';

$lang->trade->typeList['in']          = '收入';
$lang->trade->typeList['out']         = '支出';
$lang->trade->typeList['transferout'] = '轉出';
$lang->trade->typeList['transferin']  = '轉入';
$lang->trade->typeList['fee']         = '手續費';

$lang->trade->categoryList['transferin']  = '轉入';
$lang->trade->categoryList['transferout'] = '轉出';
$lang->trade->categoryList['fee']         = '手續費';

$lang->trade->objectTypeList['order']    = '訂單支出';
$lang->trade->objectTypeList['contract'] = '合同支出';

$lang->trade->encodeList['gbk']  = 'GBK';
$lang->trade->encodeList['utf8'] = 'UTF-8';

$lang->trade->notEqual = '付款賬號不能與收款賬號相同。';
$lang->trade->feeDesc  = '%s %s 轉入 %s';
$lang->trade->fileNode = '檔案格式為csv';

$lang->trade->importedFields = array();
$lang->trade->importedFields['category'] = '項目';
$lang->trade->importedFields['type']     = '交易類型';
$lang->trade->importedFields['trader']   = '商戶';
$lang->trade->importedFields['in']       = '收入';
$lang->trade->importedFields['out']      = '支出';
$lang->trade->importedFields['date']     = '時間';
$lang->trade->importedFields['category'] = '科目';
$lang->trade->importedFields['dept']     = '部門';
$lang->trade->importedFields['desc']     = '備註';
$lang->trade->importedFields['fee']      = '手續費';

$lang->trade->totalAmount = '%s收入%s，支出%s，%s；';
$lang->trade->profit      = '盈';
$lang->trade->loss        = '虧';
$lang->trade->balance     = '收支平衡';
