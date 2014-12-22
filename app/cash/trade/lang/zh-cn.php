<?php
/**
 * The trade module zh-cn file of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     trade
 * @version     $Id$
 * @link        http://www.ranzhico.com
 */
if(!isset($lang->trade)) $lang->trade = new stdclass();
$lang->trade->common      = '记账';
$lang->trade->id          = '编号';
$lang->trade->depositor   = '账号';
$lang->trade->type        = '交易';
$lang->trade->currency    = '货币';
$lang->trade->trader      = '商户';
$lang->trade->customer    = '客户';
$lang->trade->money       = '金额';
$lang->trade->desc        = '说明';
$lang->trade->product     = '产品';
$lang->trade->order       = '订单';
$lang->trade->contract    = '合同';
$lang->trade->category    = '科目';
$lang->trade->date        = '时间';
$lang->trade->handlers    = '经办人';
$lang->trade->dept        = '部门';
$lang->trade->receipt     = '收款账户';
$lang->trade->payment     = '付款账户';
$lang->trade->fee         = '手续费';
$lang->trade->transferIn  = '转入金额';
$lang->trade->transferOut = '转出金额';
$lang->trade->schema      = '模板';
$lang->trade->importFile  = '导入文件';
$lang->trade->encode      = '编码';

$lang->trade->create      = '记账';
$lang->trade->in          = '收入';
$lang->trade->out         = '支出';
$lang->trade->createIn    = '记收入';
$lang->trade->createOut   = '记支出';
$lang->trade->transfer    = '记转账';
$lang->trade->edit        = '编辑账目';
$lang->trade->detail      = '明细';
$lang->trade->browse      = '账目列表';
$lang->trade->delete      = '删除记录';
$lang->trade->batchCreate = '批量记账';
$lang->trade->batchEdit   = '批量编辑';
$lang->trade->newTrader   = '新建';
$lang->trade->import      = '导入';
$lang->trade->showImport  = '导入确认';

$lang->trade->typeList['in']          = '收入';
$lang->trade->typeList['out']         = '支出';
$lang->trade->typeList['transferout'] = '转出';
$lang->trade->typeList['transferin']  = '转入';
$lang->trade->typeList['fee']         = '手续费';

$lang->trade->categoryList['transferin']  = '转入';
$lang->trade->categoryList['transferout'] = '转出';
$lang->trade->categoryList['fee']         = '手续费';

$lang->trade->objectTypeList['order']    = '订单支出';
$lang->trade->objectTypeList['contract'] = '合同支出';

$lang->trade->encodeList['gbk']  = 'GBK';
$lang->trade->encodeList['utf8'] = 'UTF-8';

$lang->trade->notEqual = '付款账号不能与收款账号相同。';
$lang->trade->feeDesc  = '%s %s 转入 %s';
$lang->trade->fileNode = '文件格式为csv';

$lang->trade->importedFields = array();
$lang->trade->importedFields['category'] = '项目';
$lang->trade->importedFields['type']     = '交易类型';
$lang->trade->importedFields['trader']   = '商户';
$lang->trade->importedFields['in']       = '收入';
$lang->trade->importedFields['out']      = '支出';
$lang->trade->importedFields['date']     = '时间';
$lang->trade->importedFields['category'] = '科目';
$lang->trade->importedFields['dept']     = '部门';
$lang->trade->importedFields['desc']     = '备注';
$lang->trade->importedFields['fee']      = '手续费';

$lang->trade->totalAmount = '%s收入%s，支出%s，%s；';
$lang->trade->profit      = '盈';
$lang->trade->loss        = '亏';
$lang->trade->balance     = '收支平衡';
