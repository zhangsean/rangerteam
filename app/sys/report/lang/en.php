<?php
/**
 * The report module English file of RanZhi.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv11.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     report
 * @version     $Id: en.php 5080 2013-07-10 00:46:59Z wyd621@gmail.com $
 * @link        http://www.ranzhico.com
 */
if(!isset($lang->report)) $lang->report = new stdclass();
$lang->report->common     = 'Report';
$lang->report->browse     = 'View Report';
$lang->report->list       = 'Report list';
$lang->report->item       = 'Item';
$lang->report->value      = 'Value';
$lang->report->percent    = 'Percent';
$lang->report->undefined  = 'Undefined';
$lang->report->time       = 'Time';
$lang->report->select     = 'Pleace select reports';
$lang->report->create     = 'View reports';

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
$lang->report->options->graph->pieRadius        = 100; 
$lang->report->options->graph->showColumnShadow = 0; 
$lang->report->options->graph->caption          = 'DEFAULT'; 

$lang->report->customer = new stdclass();
$lang->report->customer->common = 'Customer Report';
$lang->report->customer->chartList['assignedTo'] = 'Assigned To';
$lang->report->customer->chartList['status']     = 'Status';
$lang->report->customer->chartList['level']      = 'Level';
$lang->report->customer->chartList['type']       = 'Type';
$lang->report->customer->chartList['size']       = 'Size';
$lang->report->customer->chartList['area']       = 'Area';

$lang->report->customer->item['assignedTo'] = 'User';
$lang->report->customer->item['status']     = 'Status';
$lang->report->customer->item['level']      = 'Level';
$lang->report->customer->item['type']       = 'Type';
$lang->report->customer->item['size']       = 'Size';
$lang->report->customer->item['area']       = 'Area';

$lang->report->customer->value['assignedTo'] = 'Customer';
$lang->report->customer->value['status']     = 'Customer';
$lang->report->customer->value['level']      = 'Customer';
$lang->report->customer->value['type']       = 'Customer';
$lang->report->customer->value['size']       = 'Customer';
$lang->report->customer->value['area']       = 'Customer';

/* order setting. */
$lang->report->order = new stdclass();
$lang->report->order->common = 'Order Report';
$lang->report->order->chartList['product']     = 'Product(Number)';
$lang->report->order->chartList['status']      = 'Status(Number)';
$lang->report->order->chartList['assignedTo']  = 'Assigned To(Number)';
$lang->report->order->chartList['createdBy']   = 'Created by(Number)';
$lang->report->order->chartList['customer']    = 'Customer(Number)';
$lang->report->order->chartList['productA']    = 'Product(Money)';
$lang->report->order->chartList['statusA']     = 'Status(Money)';
$lang->report->order->chartList['assignedToA'] = 'Assigned To(Money)';
$lang->report->order->chartList['createdByA']  = 'Created By(Money)';
$lang->report->order->chartList['customerA']   = 'Customer(Money)';

$lang->report->order->item['product']     = 'Product';
$lang->report->order->item['status']      = 'Status';
$lang->report->order->item['assignedTo']  = 'User';
$lang->report->order->item['createdBy']   = 'User';
$lang->report->order->item['customer']    = 'Customer';
$lang->report->order->item['productA']    = 'Product';
$lang->report->order->item['statusA']     = 'Status';
$lang->report->order->item['assignedToA'] = 'User';
$lang->report->order->item['createdByA']  = 'User';
$lang->report->order->item['customerA']   = 'Customer';

$lang->report->order->value['product']     = 'Order';
$lang->report->order->value['status']      = 'Order';
$lang->report->order->value['assignedTo']  = 'Order';
$lang->report->order->value['createdBy']   = 'Order';
$lang->report->order->value['customer']    = 'Order';
$lang->report->order->value['productA']    = 'Real money';
$lang->report->order->value['statusA']     = 'Real money';
$lang->report->order->value['assignedToA'] = 'Real money';
$lang->report->order->value['createdByA']  = 'Real money';
$lang->report->order->value['customerA']   = 'Real money';

$lang->report->contract = new stdclass();
$lang->report->contract->common = 'Contract Report';
$lang->report->contract->chartList['status']       = 'Status(Number)';
$lang->report->contract->chartList['delivery']     = 'Delivery(Number)';
$lang->report->contract->chartList['return']       = 'Return(Number)';
$lang->report->contract->chartList['createdBy']    = 'Created By(Number)';
$lang->report->contract->chartList['signedBy']     = 'Signed By(Number)';
$lang->report->contract->chartList['deliveredBy']  = 'Delivered By(Number)';
//$lang->report->contract->chartList['handlers']     = 'Handlers(Number)';
$lang->report->contract->chartList['contactedBy']  = 'Contacted By(Number)';
$lang->report->contract->chartList['customer']     = 'Customer(Number)';
$lang->report->contract->chartList['statusA']      = 'Status(Money)';
$lang->report->contract->chartList['deliveryA']    = 'Delivery(Money)';
$lang->report->contract->chartList['returnA']      = 'Return(Money)';
$lang->report->contract->chartList['createdByA']   = 'Created By(Money)';
$lang->report->contract->chartList['signedByA']    = 'Signed By(Money)';
$lang->report->contract->chartList['deliveredByA'] = 'Delivered By(Money)';
//$lang->report->contract->chartList['handlersA']    = 'Handlers(Money)';
$lang->report->contract->chartList['contactedByA'] = 'Contacted By(Money)';
$lang->report->contract->chartList['customerA']    = 'Customer(Money)';

$lang->report->contract->item['status']       = 'Stuatus';
$lang->report->contract->item['delivery']     = 'Delivery';
$lang->report->contract->item['return']       = 'Return';
$lang->report->contract->item['createdBy']    = 'User';
$lang->report->contract->item['signedBy']     = 'User';
$lang->report->contract->item['deliveredBy']  = 'User';
$lang->report->contract->item['handlers']     = 'User';
$lang->report->contract->item['contactedBy']  = 'User';
$lang->report->contract->item['customer']     = 'Customer';
$lang->report->contract->item['statusA']      = 'Status';
$lang->report->contract->item['deliveryA']    = 'Delivery';
$lang->report->contract->item['returnA']      = 'Return';
$lang->report->contract->item['createdByA']   = 'User';
$lang->report->contract->item['signedByA']    = 'User';
$lang->report->contract->item['deliveredByA'] = 'User';
$lang->report->contract->item['handlersA']    = 'User';
$lang->report->contract->item['contactedByA'] = 'User';
$lang->report->contract->item['customerA']    = 'Customer';

$lang->report->contract->value['status']       = 'Number';
$lang->report->contract->value['delivery']     = 'Number';
$lang->report->contract->value['return']       = 'Number';
$lang->report->contract->value['createdBy']    = 'Number';
$lang->report->contract->value['signedBy']     = 'Number';
$lang->report->contract->value['deliveredBy']  = 'Number';
$lang->report->contract->value['handlers']     = 'Number';
$lang->report->contract->value['contactedBy']  = 'Number';
$lang->report->contract->value['customer']     = 'Number';
$lang->report->contract->value['statusA']      = 'Money';
$lang->report->contract->value['deliveryA']    = 'Money';
$lang->report->contract->value['returnA']      = 'Money';
$lang->report->contract->value['createdByA']   = 'Money';
$lang->report->contract->value['signedByA']    = 'Money';
$lang->report->contract->value['deliveredByA'] = 'Money';
$lang->report->contract->value['handlersA']    = 'Money';
$lang->report->contract->value['contactedByA'] = 'Money';
$lang->report->contract->value['customerA']    = 'Money';

$lang->report->trade = new stdclass();
$lang->report->trade->common = 'Trade Report';
$lang->report->trade->chartList['depositor']  = 'Depositor(Number)';
$lang->report->trade->chartList['product']    = 'Product(Number)';
$lang->report->trade->chartList['trader']     = 'Trader(Number)';
$lang->report->trade->chartList['dept']       = 'Department(Number)';
$lang->report->trade->chartList['type']       = 'Type(Number)';
$lang->report->trade->chartList['date']       = 'Date(Number)';
//$lang->report->trade->chartList['handlers']   = 'Handlers(Number)';
$lang->report->trade->chartList['category']   = 'Category(Number)';
$lang->report->trade->chartList['depositorA'] = 'Depositor(Money)';
$lang->report->trade->chartList['productA']   = 'Product(Money)';
$lang->report->trade->chartList['traderA']    = 'Trader(Money)';
$lang->report->trade->chartList['deptA']      = 'Department(Money)';
$lang->report->trade->chartList['typeA']      = 'Type(Money)';
$lang->report->trade->chartList['dateA']      = 'Date(Money)';
//$lang->report->trade->chartList['handlersA']  = 'Handlers(Money)';
$lang->report->trade->chartList['categoryA']  = 'Category(Money)';

$lang->report->trade->item['depositor']  = 'Depositor';
$lang->report->trade->item['product']    = 'Product';
$lang->report->trade->item['trader']     = 'Trader';
$lang->report->trade->item['dept']       = 'Department';
$lang->report->trade->item['type']       = 'Type';
$lang->report->trade->item['date']       = 'Date';
$lang->report->trade->item['handlers']   = 'User';
$lang->report->trade->item['category']   = 'Category';
$lang->report->trade->item['depositorA'] = 'Depositor';
$lang->report->trade->item['productA']   = 'Product';
$lang->report->trade->item['traderA']    = 'Trader';
$lang->report->trade->item['deptA']      = 'Department';
$lang->report->trade->item['typeA']      = 'Type';
$lang->report->trade->item['dateA']      = 'Date';
$lang->report->trade->item['handlersA']  = 'User';
$lang->report->trade->item['categoryA']  = 'Category';

$lang->report->trade->value['depositor']  = 'Number';
$lang->report->trade->value['product']    = 'Number';
$lang->report->trade->value['trader']     = 'Number';
$lang->report->trade->value['dept']       = 'Number';
$lang->report->trade->value['type']       = 'Number';
$lang->report->trade->value['date']       = 'Number';
$lang->report->trade->value['handlers']   = 'Number';
$lang->report->trade->value['category']   = 'Number';
$lang->report->trade->value['depositorA'] = 'Money';
$lang->report->trade->value['productA']   = 'Money';
$lang->report->trade->value['traderA']    = 'Money';
$lang->report->trade->value['deptA']      = 'Money';
$lang->report->trade->value['typeA']      = 'Money';
$lang->report->trade->value['dateA']      = 'Money';
$lang->report->trade->value['handlersA']  = 'Money';
$lang->report->trade->value['categoryA']  = 'Money';

$lang->report->trade->swf['date']        = 'column2d';
$lang->report->trade->xAxisName['date']  = 'Date';
$lang->report->trade->swf['dateA']       = 'column2d';
$lang->report->trade->xAxisName['dateA'] = 'Date';
