<?php
/**
 * The trade module English file of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     trade
 * @version     $Id$
 * @link        http://www.ranzhico.com
 */
if(!isset($lang->trade)) $lang->trade = new stdclass();
$lang->trade->common      = 'Trade';
$lang->trade->id          = 'ID';
$lang->trade->depositor   = 'Despositor';
$lang->trade->type        = 'Type';
$lang->trade->currency    = 'Currency';
$lang->trade->trader      = 'Provider';
$lang->trade->customer    = 'Cusotmer';
$lang->trade->money       = 'Money';
$lang->trade->desc        = 'Desc';
$lang->trade->product     = 'Product';
$lang->trade->order       = 'Order';
$lang->trade->contract    = 'Contract';
$lang->trade->category    = 'Category';
$lang->trade->date        = 'Date';
$lang->trade->handlers    = 'Handler';
$lang->trade->dept        = 'Dept';
$lang->trade->receipt     = 'From';
$lang->trade->payment     = 'To';
$lang->trade->fee         = 'Fee';
$lang->trade->transferIn  = 'Amount';
$lang->trade->transferOut = 'Amount';
$lang->trade->schema      = 'Schema';
$lang->trade->importFile  = 'Import file';
$lang->trade->encode      = 'Encode';

$lang->trade->create      = 'Create Trade';
$lang->trade->in          = 'Income';
$lang->trade->out         = 'Expend';
$lang->trade->createIn    = 'Income';
$lang->trade->createOut   = 'Expend';
$lang->trade->transfer    = 'Transfer';
$lang->trade->edit        = 'Edit Trade';
$lang->trade->detail      = 'Detail';
$lang->trade->browse      = 'Bills';
$lang->trade->delete      = 'Delete Trade';
$lang->trade->batchCreate = 'Batch Create';
$lang->trade->batchEdit   = 'Batch Edit';
$lang->trade->newTrader   = 'Create Trader';
$lang->trade->import      = 'Import';
$lang->trade->showImport  = 'Show result';

$lang->trade->typeList['in']          = 'Income';
$lang->trade->typeList['out']         = 'Expend';
$lang->trade->typeList['transferout'] = 'Transfer out';
$lang->trade->typeList['transferin']  = 'Transfer in';
$lang->trade->typeList['fee']         = 'Fee';

$lang->trade->categoryList['transferin']  = 'Transfer In';
$lang->trade->categoryList['transferout'] = 'Transfer Out';
$lang->trade->categoryList['fee']         = 'Fee';

$lang->trade->objectTypeList['order']    = 'Order';
$lang->trade->objectTypeList['contract'] = 'Contract';

$lang->trade->encodeList['gbk']  = 'GBK';
$lang->trade->encodeList['utf8'] = 'UTF-8';

$lang->trade->notEqual = 'The two depositor can not be the same!';
$lang->trade->feeDesc  = '%s from %s to %s';
$lang->trade->fileNode = 'The format of file is csv';

$lang->trade->importedFields = array();
$lang->trade->importedFields['category'] = 'Category';
$lang->trade->importedFields['type']     = 'Type';
$lang->trade->importedFields['trader']   = 'Trader';
$lang->trade->importedFields['in']       = 'Income';
$lang->trade->importedFields['out']      = 'Expend';
$lang->trade->importedFields['date']     = 'Date';
$lang->trade->importedFields['category'] = 'Category';
$lang->trade->importedFields['dept']     = 'Department';
$lang->trade->importedFields['desc']     = 'Desc';
$lang->trade->importedFields['fee']      = 'Fee';

$lang->trade->totalAmount = '%s: income %s, expend %s，%s；';
$lang->trade->profit      = 'profit';
$lang->trade->loss        = 'loss';
$lang->trade->balance     = 'Income is equal to expenditure';
