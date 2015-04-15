<?php
/**
 * The report module zh-cn file of RanZhi.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv11.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     report
 * @version     $Id: zh-cn.php 5080 2013-07-10 00:46:59Z wyd621@gmail.com $
 * @link        http://www.ranzhico.com
 */
if(!isset($lang->report)) $lang->report = new stdclass();
$lang->report->common     = '统计视图';
$lang->report->index      = '统计首页';
$lang->report->list       = '统计报表';
$lang->report->item       = '条目';
$lang->report->value      = '值';
$lang->report->percent    = '百分比';
$lang->report->undefined  = '未设定';
$lang->report->time       = '时间';
$lang->report->select     = '请选择报表类型';
$lang->report->create     = '生成报表';

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
$lang->report->options->graph->pieRadius        = 100; // 饼图直径。
$lang->report->options->graph->showColumnShadow = 0;   // 是否显示柱状图阴影。
$lang->report->options->graph->caption          = 'DEFAULT';   // 是否显示柱状图阴影。

$lang->report->customer = new stdclass();
$lang->report->customer->common = '客户报表';
$lang->report->customer->chartList['assignedTo'] = '按指派给统计';
$lang->report->customer->chartList['status']     = '按状态统计';
$lang->report->customer->chartList['level']      = '按级别统计';
$lang->report->customer->chartList['type']       = '按类型统计';
$lang->report->customer->chartList['size']       = '按规模统计';
$lang->report->customer->chartList['area']       = '按地区统计';

$lang->report->customer->item['assignedTo'] = '用户';
$lang->report->customer->item['status']     = '状态';
$lang->report->customer->item['level']      = '级别';
$lang->report->customer->item['type']       = '类型';
$lang->report->customer->item['size']       = '规模';
$lang->report->customer->item['area']       = '地区';

$lang->report->customer->value['assignedTo'] = '客户数';
$lang->report->customer->value['status']     = '客户数';
$lang->report->customer->value['level']      = '客户数';
$lang->report->customer->value['type']       = '客户数';
$lang->report->customer->value['size']       = '客户数';
$lang->report->customer->value['area']       = '客户数';

/* order setting. */
$lang->report->order = new stdclass();
$lang->report->order->common = '订单报表';
$lang->report->order->chartList['product']     = '按产品统计（数量）';
$lang->report->order->chartList['status']      = '按状态统计（数量）';
$lang->report->order->chartList['assignedTo']  = '按指派给统计（数量）';
$lang->report->order->chartList['createdBy']   = '按创建者统计（数量）';
$lang->report->order->chartList['customer']    = '按客户统计（数量）';
$lang->report->order->chartList['productA']    = '按产品统计（金额）';
$lang->report->order->chartList['statusA']     = '按状态统计（金额）';
$lang->report->order->chartList['assignedToA'] = '按指派给统计（金额）';
$lang->report->order->chartList['createdByA']  = '按创建者统计（金额）';
$lang->report->order->chartList['customerA']   = '按客户统计（金额）';

$lang->report->order->item['product']     = '产品';
$lang->report->order->item['status']      = '状态';
$lang->report->order->item['assignedTo']  = '指派给';
$lang->report->order->item['createdBy']   = '创建者';
$lang->report->order->item['customer']    = '客户';
$lang->report->order->item['productA']    = '产品';
$lang->report->order->item['statusA']     = '状态';
$lang->report->order->item['assignedToA'] = '指派给';
$lang->report->order->item['createdByA']  = '创建者';
$lang->report->order->item['customerA']   = '客户';

$lang->report->order->value['product']     = '订单数';
$lang->report->order->value['status']      = '订单数';
$lang->report->order->value['assignedTo']  = '订单数';
$lang->report->order->value['createdBy']   = '订单数';
$lang->report->order->value['customer']    = '订单数';
$lang->report->order->value['productA']    = '成交金额';
$lang->report->order->value['statusA']     = '成交金额';
$lang->report->order->value['assignedToA'] = '成交金额';
$lang->report->order->value['createdByA']  = '成交金额';
$lang->report->order->value['customerA']   = '成交金额';

$lang->report->contract = new stdclass();
$lang->report->contract->common = '合同报表';
$lang->report->contract->chartList['status']       = '按合同状态统计（数量）';
$lang->report->contract->chartList['delivery']     = '按交付状态统计（数量）';
$lang->report->contract->chartList['return']       = '按回款状态统计（数量）';
$lang->report->contract->chartList['createdBy']    = '按创建人统计（数量）';
$lang->report->contract->chartList['signedBy']     = '按指派给统计（数量）';
$lang->report->contract->chartList['deliveredBy']  = '按交付人统计（数量）';
$lang->report->contract->chartList['handlers']     = '按经手人统计（数量）';
$lang->report->contract->chartList['contactedBy']  = '按联系人统计（数量）';
$lang->report->contract->chartList['customer']     = '按客户统计（数量）';
$lang->report->contract->chartList['statusA']      = '按合同状态统计（金额）';
$lang->report->contract->chartList['deliveryA']    = '按交付状态统计（金额）';
$lang->report->contract->chartList['returnA']      = '按回款状态统计（金额）';
$lang->report->contract->chartList['createdByA']   = '按创建人统计（金额）';
$lang->report->contract->chartList['signedByA']    = '按指派给统计（金额）';
$lang->report->contract->chartList['deliveredByA'] = '按交付人统计（金额）';
$lang->report->contract->chartList['handlersA']    = '按经手人统计（金额）';
$lang->report->contract->chartList['contactedByA'] = '按联系人统计（金额）';
$lang->report->contract->chartList['customerA']    = '按客户统计（金额）';

$lang->report->contract->item['status']       = '合同状态';
$lang->report->contract->item['delivery']     = '交付状态';
$lang->report->contract->item['return']       = '回款状态';
$lang->report->contract->item['createdBy']    = '创建人';
$lang->report->contract->item['signedBy']     = '用户';
$lang->report->contract->item['deliveredBy']  = '交付人';
$lang->report->contract->item['handlers']     = '经手人';
$lang->report->contract->item['contactedBy']  = '联系人';
$lang->report->contract->item['customer']     = '客户';
$lang->report->contract->item['statusA']      = '订单状态';
$lang->report->contract->item['deliveryA']    = '交付状态';
$lang->report->contract->item['returnA']      = '回款状态';
$lang->report->contract->item['createdByA']   = '创建人';
$lang->report->contract->item['signedByA']    = '用户';
$lang->report->contract->item['deliveredByA'] = '交付人';
$lang->report->contract->item['handlersA']    = '经手人';
$lang->report->contract->item['contactedByA'] = '联系人';
$lang->report->contract->item['customerA']    = '客户';

$lang->report->contract->value['status']       = '合同数';
$lang->report->contract->value['delivery']     = '合同数';
$lang->report->contract->value['return']       = '合同数';
$lang->report->contract->value['createdBy']    = '合同数';
$lang->report->contract->value['signedBy']     = '合同数';
$lang->report->contract->value['deliveredBy']  = '合同数';
$lang->report->contract->value['handlers']     = '合同数';
$lang->report->contract->value['contactedBy']  = '合同数';
$lang->report->contract->value['customer']     = '合同数';
$lang->report->contract->value['statusA']      = '合同金额';
$lang->report->contract->value['deliveryA']    = '合同金额';
$lang->report->contract->value['returnA']      = '合同金额';
$lang->report->contract->value['createdByA']   = '合同金额';
$lang->report->contract->value['signedByA']    = '合同金额';
$lang->report->contract->value['deliveredByA'] = '合同金额';
$lang->report->contract->value['handlersA']    = '合同金额';
$lang->report->contract->value['contactedByA'] = '合同金额';
$lang->report->contract->value['customerA']    = '合同金额';

$lang->report->trade = new stdclass();
$lang->report->trade->common = '记账报表';
$lang->report->trade->chartList['depositor']  = '按账户统计（数量）';
$lang->report->trade->chartList['product']    = '按产品统计（数量）';
$lang->report->trade->chartList['trader']     = '按商户统计（数量）';
$lang->report->trade->chartList['dept']       = '按部门统计（数量）';
$lang->report->trade->chartList['type']       = '按类型统计（数量）';
$lang->report->trade->chartList['date']       = '按日期统计（数量）';
$lang->report->trade->chartList['handlers']   = '按经办人统计（数量）';
$lang->report->trade->chartList['category']   = '按科目统计（数量）';
$lang->report->trade->chartList['depositorA'] = '按账户统计（金额）';
$lang->report->trade->chartList['productA']   = '按产品统计（金额）';
$lang->report->trade->chartList['traderA']    = '按商户统计（金额）';
$lang->report->trade->chartList['deptA']      = '按部门统计（金额）';
$lang->report->trade->chartList['typeA']      = '按类型统计（金额）';
$lang->report->trade->chartList['dateA']      = '按日期统计（金额）';
$lang->report->trade->chartList['handlersA']  = '按经办人统计（金额）';
$lang->report->trade->chartList['categoryA']  = '按科目统计（金额）';

$lang->report->trade->item['depositor']  = '账户';
$lang->report->trade->item['product']    = '产品';
$lang->report->trade->item['trader']     = '商户';
$lang->report->trade->item['dept']       = '部门';
$lang->report->trade->item['type']       = '类型';
$lang->report->trade->item['date']       = '日期';
$lang->report->trade->item['handlers']   = '经办人';
$lang->report->trade->item['category']   = '科目';
$lang->report->trade->item['depositorA'] = '账户';
$lang->report->trade->item['productA']   = '产品';
$lang->report->trade->item['traderA']    = '商户';
$lang->report->trade->item['deptA']      = '部门';
$lang->report->trade->item['typeA']      = '类型';
$lang->report->trade->item['dateA']      = '日期';
$lang->report->trade->item['handlersA']  = '经办人';
$lang->report->trade->item['categoryA']  = '科目';

$lang->report->trade->value['depositor']  = '记账数';
$lang->report->trade->value['product']    = '记账数';
$lang->report->trade->value['trader']     = '记账数';
$lang->report->trade->value['dept']       = '记账数';
$lang->report->trade->value['type']       = '记账数';
$lang->report->trade->value['date']       = '记账数';
$lang->report->trade->value['handlers']   = '记账数';
$lang->report->trade->value['category']   = '记账数';
$lang->report->trade->value['depositorA'] = '金额';
$lang->report->trade->value['productA']   = '金额';
$lang->report->trade->value['traderA']    = '金额';
$lang->report->trade->value['deptA']      = '金额';
$lang->report->trade->value['typeA']      = '金额';
$lang->report->trade->value['dateA']      = '金额';
$lang->report->trade->value['handlersA']  = '金额';
$lang->report->trade->value['categoryA']  = '金额';

$lang->report->trade->swf['date']        = 'column2d';
$lang->report->trade->xAxisName['date']  = '日期';
$lang->report->trade->swf['dateA']       = 'column2d';
$lang->report->trade->xAxisName['dateA'] = '日期';
