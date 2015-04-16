<?php
/**
 * The report module zh-tw file of RanZhi.
 *
 * @copyright   Copyright 2009-2015 青島易軟天創網絡科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv11.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     report
 * @version     $Id: zh-tw.php 5080 2013-07-10 00:46:59Z wyd621@gmail.com $
 * @link        http://www.ranzhico.com
 */
if(!isset($lang->report)) $lang->report = new stdclass();
$lang->report->common     = '報表';
$lang->report->browse     = '查看報表';
$lang->report->list       = '統計報表';
$lang->report->item       = '條目';
$lang->report->value      = '值';
$lang->report->percent    = '百分比';
$lang->report->undefined  = '未設定';
$lang->report->time       = '時間';
$lang->report->select     = '請選擇報表類型';
$lang->report->create     = '生成報表';

$lang->report->colors[]   = 'AFD8F8';
$lang->report->colors[]   = 'F6BD0F';
$lang->report->colors[]   = '8BBA00';
$lang->report->colors[]   = 'FF8E46';
$lang->report->colors[]   = '008E8E';
$lang->report->colors[]   = 'D64646';
$lang->report->colors[]   = '8E468E';
$lang->report->colors[]   = '588526';
$lang->report->colors[]   = 'B3AA00';
$lang->report->colors[]   = '008ED6';
$lang->report->colors[]   = '9D080D';
$lang->report->colors[]   = 'A186BE';

$lang->report->singleColor[] = 'F6BD0F';

$lang->report->options = new stdclass();
$lang->report->options->graph = new stdclass();
$lang->report->options->swf                     = 'pie2d';
$lang->report->options->width                   = 'auto';
$lang->report->options->height                  = 300;
$lang->report->options->graph->baseFontSize     = 12;
$lang->report->options->graph->showNames        = 1;
$lang->report->options->graph->formatNumber     = 1;
$lang->report->options->graph->decimalPrecision = 0;
$lang->report->options->graph->animation        = 0;
$lang->report->options->graph->rotateNames      = 0;
$lang->report->options->graph->yAxisName        = 'COUNT';
$lang->report->options->graph->xAxisName        = 'DEFAULT';
$lang->report->options->graph->pieRadius        = 100; // 餅圖直徑。
$lang->report->options->graph->showColumnShadow = 0;   // 是否顯示柱狀圖陰影。
$lang->report->options->graph->caption          = 'DEFAULT';   // 是否顯示柱狀圖陰影。

$lang->report->customer = new stdclass();
$lang->report->customer->common = '客戶報表';
$lang->report->customer->chartList['assignedTo'] = '按指派給統計';
$lang->report->customer->chartList['status']     = '按狀態統計';
$lang->report->customer->chartList['level']      = '按級別統計';
$lang->report->customer->chartList['type']       = '按類型統計';
$lang->report->customer->chartList['size']       = '按規模統計';
$lang->report->customer->chartList['area']       = '按地區統計';

$lang->report->customer->item['assignedTo'] = '用戶';
$lang->report->customer->item['status']     = '狀態';
$lang->report->customer->item['level']      = '級別';
$lang->report->customer->item['type']       = '類型';
$lang->report->customer->item['size']       = '規模';
$lang->report->customer->item['area']       = '地區';

$lang->report->customer->value['assignedTo'] = '客戶數';
$lang->report->customer->value['status']     = '客戶數';
$lang->report->customer->value['level']      = '客戶數';
$lang->report->customer->value['type']       = '客戶數';
$lang->report->customer->value['size']       = '客戶數';
$lang->report->customer->value['area']       = '客戶數';

/* order setting. */
$lang->report->order = new stdclass();
$lang->report->order->common = '訂單報表';
$lang->report->order->chartList['product']     = '按產品統計（數量）';
$lang->report->order->chartList['status']      = '按狀態統計（數量）';
$lang->report->order->chartList['assignedTo']  = '按指派給統計（數量）';
$lang->report->order->chartList['createdBy']   = '按創建者統計（數量）';
$lang->report->order->chartList['customer']    = '按客戶統計（數量）';
$lang->report->order->chartList['productA']    = '按產品統計（金額）';
$lang->report->order->chartList['statusA']     = '按狀態統計（金額）';
$lang->report->order->chartList['assignedToA'] = '按指派給統計（金額）';
$lang->report->order->chartList['createdByA']  = '按創建者統計（金額）';
$lang->report->order->chartList['customerA']   = '按客戶統計（金額）';

$lang->report->order->item['product']     = '產品';
$lang->report->order->item['status']      = '狀態';
$lang->report->order->item['assignedTo']  = '指派給';
$lang->report->order->item['createdBy']   = '創建者';
$lang->report->order->item['customer']    = '客戶';
$lang->report->order->item['productA']    = '產品';
$lang->report->order->item['statusA']     = '狀態';
$lang->report->order->item['assignedToA'] = '指派給';
$lang->report->order->item['createdByA']  = '創建者';
$lang->report->order->item['customerA']   = '客戶';

$lang->report->order->value['product']     = '訂單數';
$lang->report->order->value['status']      = '訂單數';
$lang->report->order->value['assignedTo']  = '訂單數';
$lang->report->order->value['createdBy']   = '訂單數';
$lang->report->order->value['customer']    = '訂單數';
$lang->report->order->value['productA']    = '成交金額';
$lang->report->order->value['statusA']     = '成交金額';
$lang->report->order->value['assignedToA'] = '成交金額';
$lang->report->order->value['createdByA']  = '成交金額';
$lang->report->order->value['customerA']   = '成交金額';

$lang->report->contract = new stdclass();
$lang->report->contract->common = '合同報表';
$lang->report->contract->chartList['status']       = '按合同狀態統計（數量）';
$lang->report->contract->chartList['delivery']     = '按交付狀態統計（數量）';
$lang->report->contract->chartList['return']       = '按回款狀態統計（數量）';
$lang->report->contract->chartList['createdBy']    = '按創建人統計（數量）';
$lang->report->contract->chartList['signedBy']     = '按指派給統計（數量）';
$lang->report->contract->chartList['deliveredBy']  = '按交付人統計（數量）';
$lang->report->contract->chartList['handlers']     = '按經手人統計（數量）';
$lang->report->contract->chartList['contactedBy']  = '按聯繫人統計（數量）';
$lang->report->contract->chartList['customer']     = '按客戶統計（數量）';
$lang->report->contract->chartList['statusA']      = '按合同狀態統計（金額）';
$lang->report->contract->chartList['deliveryA']    = '按交付狀態統計（金額）';
$lang->report->contract->chartList['returnA']      = '按回款狀態統計（金額）';
$lang->report->contract->chartList['createdByA']   = '按創建人統計（金額）';
$lang->report->contract->chartList['signedByA']    = '按指派給統計（金額）';
$lang->report->contract->chartList['deliveredByA'] = '按交付人統計（金額）';
$lang->report->contract->chartList['handlersA']    = '按經手人統計（金額）';
$lang->report->contract->chartList['contactedByA'] = '按聯繫人統計（金額）';
$lang->report->contract->chartList['customerA']    = '按客戶統計（金額）';

$lang->report->contract->item['status']       = '合同狀態';
$lang->report->contract->item['delivery']     = '交付狀態';
$lang->report->contract->item['return']       = '回款狀態';
$lang->report->contract->item['createdBy']    = '創建人';
$lang->report->contract->item['signedBy']     = '用戶';
$lang->report->contract->item['deliveredBy']  = '交付人';
$lang->report->contract->item['handlers']     = '經手人';
$lang->report->contract->item['contactedBy']  = '聯繫人';
$lang->report->contract->item['customer']     = '客戶';
$lang->report->contract->item['statusA']      = '訂單狀態';
$lang->report->contract->item['deliveryA']    = '交付狀態';
$lang->report->contract->item['returnA']      = '回款狀態';
$lang->report->contract->item['createdByA']   = '創建人';
$lang->report->contract->item['signedByA']    = '用戶';
$lang->report->contract->item['deliveredByA'] = '交付人';
$lang->report->contract->item['handlersA']    = '經手人';
$lang->report->contract->item['contactedByA'] = '聯繫人';
$lang->report->contract->item['customerA']    = '客戶';

$lang->report->contract->value['status']       = '合同數';
$lang->report->contract->value['delivery']     = '合同數';
$lang->report->contract->value['return']       = '合同數';
$lang->report->contract->value['createdBy']    = '合同數';
$lang->report->contract->value['signedBy']     = '合同數';
$lang->report->contract->value['deliveredBy']  = '合同數';
$lang->report->contract->value['handlers']     = '合同數';
$lang->report->contract->value['contactedBy']  = '合同數';
$lang->report->contract->value['customer']     = '合同數';
$lang->report->contract->value['statusA']      = '合同金額';
$lang->report->contract->value['deliveryA']    = '合同金額';
$lang->report->contract->value['returnA']      = '合同金額';
$lang->report->contract->value['createdByA']   = '合同金額';
$lang->report->contract->value['signedByA']    = '合同金額';
$lang->report->contract->value['deliveredByA'] = '合同金額';
$lang->report->contract->value['handlersA']    = '合同金額';
$lang->report->contract->value['contactedByA'] = '合同金額';
$lang->report->contract->value['customerA']    = '合同金額';

$lang->report->trade = new stdclass();
$lang->report->trade->common = '記賬報表';
$lang->report->trade->chartList['depositor']  = '按賬戶統計（數量）';
$lang->report->trade->chartList['product']    = '按產品統計（數量）';
$lang->report->trade->chartList['trader']     = '按商戶統計（數量）';
$lang->report->trade->chartList['dept']       = '按部門統計（數量）';
$lang->report->trade->chartList['type']       = '按類型統計（數量）';
$lang->report->trade->chartList['date']       = '按日期統計（數量）';
$lang->report->trade->chartList['handlers']   = '按經辦人統計（數量）';
$lang->report->trade->chartList['category']   = '按科目統計（數量）';
$lang->report->trade->chartList['depositorA'] = '按賬戶統計（金額）';
$lang->report->trade->chartList['productA']   = '按產品統計（金額）';
$lang->report->trade->chartList['traderA']    = '按商戶統計（金額）';
$lang->report->trade->chartList['deptA']      = '按部門統計（金額）';
$lang->report->trade->chartList['typeA']      = '按類型統計（金額）';
$lang->report->trade->chartList['dateA']      = '按日期統計（金額）';
$lang->report->trade->chartList['handlersA']  = '按經辦人統計（金額）';
$lang->report->trade->chartList['categoryA']  = '按科目統計（金額）';

$lang->report->trade->item['depositor']  = '賬戶';
$lang->report->trade->item['product']    = '產品';
$lang->report->trade->item['trader']     = '商戶';
$lang->report->trade->item['dept']       = '部門';
$lang->report->trade->item['type']       = '類型';
$lang->report->trade->item['date']       = '日期';
$lang->report->trade->item['handlers']   = '經辦人';
$lang->report->trade->item['category']   = '科目';
$lang->report->trade->item['depositorA'] = '賬戶';
$lang->report->trade->item['productA']   = '產品';
$lang->report->trade->item['traderA']    = '商戶';
$lang->report->trade->item['deptA']      = '部門';
$lang->report->trade->item['typeA']      = '類型';
$lang->report->trade->item['dateA']      = '日期';
$lang->report->trade->item['handlersA']  = '經辦人';
$lang->report->trade->item['categoryA']  = '科目';

$lang->report->trade->value['depositor']  = '記賬數';
$lang->report->trade->value['product']    = '記賬數';
$lang->report->trade->value['trader']     = '記賬數';
$lang->report->trade->value['dept']       = '記賬數';
$lang->report->trade->value['type']       = '記賬數';
$lang->report->trade->value['date']       = '記賬數';
$lang->report->trade->value['handlers']   = '記賬數';
$lang->report->trade->value['category']   = '記賬數';
$lang->report->trade->value['depositorA'] = '金額';
$lang->report->trade->value['productA']   = '金額';
$lang->report->trade->value['traderA']    = '金額';
$lang->report->trade->value['deptA']      = '金額';
$lang->report->trade->value['typeA']      = '金額';
$lang->report->trade->value['dateA']      = '金額';
$lang->report->trade->value['handlersA']  = '金額';
$lang->report->trade->value['categoryA']  = '金額';

$lang->report->trade->swf['date']        = 'column2d';
$lang->report->trade->xAxisName['date']  = '日期';
$lang->report->trade->swf['dateA']       = 'column2d';
$lang->report->trade->xAxisName['dateA'] = '日期';
