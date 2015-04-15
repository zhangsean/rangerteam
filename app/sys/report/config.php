<?php
/* Open report modules.*/
$config->report = new stdclass();
$config->report->moduleList['customer'] = TABLE_CUSTOMER;
$config->report->moduleList['order']    = TABLE_ORDER;
$config->report->moduleList['contract'] = TABLE_CONTRACT;
$config->report->moduleList['trade']    = TABLE_TRADE;

$config->report->customer = new stdclass();
/* select conditions, groupBy|(count field default is same as groupby)|(count|sum default is count). */
$config->report->customer->chartList['assignedTo'] = 'assignedTo||';
$config->report->customer->chartList['status']     = 'status||';
$config->report->customer->chartList['level']      = 'level||';
$config->report->customer->chartList['type']       = 'type||';
$config->report->customer->chartList['size']       = 'size||';
$config->report->customer->chartList['area']       = 'area||';

/* type list name. */
$config->report->customer->listName['assignedTo'] = 'USERS';
$config->report->customer->listName['status']     = 'statusList';
$config->report->customer->listName['level']      = 'levelNameList';
$config->report->customer->listName['type']       = 'typeList';
$config->report->customer->listName['size']       = 'sizeNameList';
$config->report->customer->listName['area']       = 'AREA';

/* order setting. */
$config->report->order = new stdclass();
$config->report->order->chartList['product']     = 'product_multi||';
$config->report->order->chartList['customer']    = 'customer||';
$config->report->order->chartList['status']      = 'status||';
$config->report->order->chartList['createdBy']   = 'createdBy||';
$config->report->order->chartList['assignedTo']  = 'assignedTo||';
$config->report->order->chartList['productA']    = 'product_multi|`real`|sum';
$config->report->order->chartList['customerA']   = 'customer|`real`|sum';
$config->report->order->chartList['statusA']     = 'status|`real`|sum';
$config->report->order->chartList['createdByA']  = 'createdBy|`real`|sum';
$config->report->order->chartList['assignedToA'] = 'assignedTo|`real`|sum';

$config->report->order->listName['product']     = 'PRODUCTS';
$config->report->order->listName['customer']    = 'CUSTOMERS';
$config->report->order->listName['status']      = 'statusList';
$config->report->order->listName['createdBy']   = 'USERS';
$config->report->order->listName['assignedTo']  = 'USERS';
$config->report->order->listName['productA']    = 'PRODUCTS';
$config->report->order->listName['customerA']   = 'CUSTOMERS';
$config->report->order->listName['statusA']     = 'statusList';
$config->report->order->listName['createdByA']  = 'USERS';
$config->report->order->listName['assignedToA'] = 'USERS';

/* contract setting. */
$config->report->contract = new stdclass();
$config->report->contract->chartList['status']       = 'status||';
$config->report->contract->chartList['delivery']     = 'delivery||';
$config->report->contract->chartList['return']       = '`return`||';
$config->report->contract->chartList['createdBy']    = 'createdBy||';
$config->report->contract->chartList['signedBy']     = 'signedBy||';
$config->report->contract->chartList['deliveredBy']  = 'deliveredBy||';
$config->report->contract->chartList['handlers']     = 'handlers_multi||';
$config->report->contract->chartList['contactedBy']  = 'createdBy||';
$config->report->contract->chartList['customer']     = 'customer||';
$config->report->contract->chartList['statusA']      = 'status|amount|sum';
$config->report->contract->chartList['deliveryA']    = 'delivery|amount|sum';
$config->report->contract->chartList['returnA']      = '`return`|amount|sum';
$config->report->contract->chartList['createdByA']   = 'createdBy|amount|sum';
$config->report->contract->chartList['signedByA']    = 'signedBy|amount|sum';
$config->report->contract->chartList['deliveredByA'] = 'deliveredBy|amount|sum';
$config->report->contract->chartList['handlersA']    = 'handlers_multi|amount|sum';
$config->report->contract->chartList['contactedByA'] = 'createdBy|amount|sum';
$config->report->contract->chartList['customerA']    = 'customer|amount|sum';

$config->report->contract->listName['status']       = 'statusList';
$config->report->contract->listName['delivery']     = 'deliveryList';
$config->report->contract->listName['return']       = 'returnList';
$config->report->contract->listName['createdBy']    = 'USERS';
$config->report->contract->listName['signedBy']     = 'USERS';
$config->report->contract->listName['deliveredBy']  = 'USERS';
$config->report->contract->listName['handlers']     = 'USERS';
$config->report->contract->listName['contactedBy']  = 'USERS';
$config->report->contract->listName['customer']     = 'CUSTOMERS';
$config->report->contract->listName['statusA']      = 'statusList';
$config->report->contract->listName['deliveryA']    = 'deliveryList';
$config->report->contract->listName['returnA']      = 'returnList';
$config->report->contract->listName['createdByA']   = 'USERS';
$config->report->contract->listName['signedByA']    = 'USERS';
$config->report->contract->listName['deliveredByA'] = 'USERS';
$config->report->contract->listName['handlersA']    = 'USERS';
$config->report->contract->listName['contactedByA'] = 'USERS';
$config->report->contract->listName['customerA']    = 'CUSTOMERS';

/* trade setting. */
$config->report->trade = new stdclass();
$config->report->trade->chartList['depositor'] = 'depositor||';
$config->report->trade->chartList['product']   = 'product||';
$config->report->trade->chartList['trader']    = 'trader||';
$config->report->trade->chartList['dept']      = 'dept||';
$config->report->trade->chartList['type']      = 'type||';
$config->report->trade->chartList['date']      = 'date||';
$config->report->trade->chartList['handlers']  = 'handlers_multi||';
$config->report->trade->chartList['category']  = 'category||';
$config->report->trade->chartList['depositorA'] = 'depositor|money|sum';
$config->report->trade->chartList['productA']   = 'product|money|sum';
$config->report->trade->chartList['traderA']    = 'trader|money|sum';
$config->report->trade->chartList['deptA']      = 'dept|money|sum';
$config->report->trade->chartList['typeA']      = 'type|money|sum';
$config->report->trade->chartList['dateA']      = 'date|money|sum';
$config->report->trade->chartList['handlersA']  = 'handlers_multi|money|sum';
$config->report->trade->chartList['categoryA']  = 'category|money|sum';

$config->report->trade->listName['depositor']  = 'DEPOSITORS';
$config->report->trade->listName['product']    = 'PRODUCTS';
$config->report->trade->listName['trader']     = 'CUSTOMERS';
$config->report->trade->listName['dept']       = 'DEPTS';
$config->report->trade->listName['type']       = 'typeList';
$config->report->trade->listName['date']       = null;
$config->report->trade->listName['handlers']   = 'USERS';
$config->report->trade->listName['category']   = 'categoryList';
$config->report->trade->listName['depositorA'] = 'DEPOSITORS';
$config->report->trade->listName['productA']   = 'PRODUCTS';
$config->report->trade->listName['traderA']    = 'CUSTOMERS';
$config->report->trade->listName['deptA']      = 'DEPTS';
$config->report->trade->listName['typeA']      = 'typeList';
$config->report->trade->listName['dateA']      = null;
$config->report->trade->listName['handlersA']  = 'USERS';
$config->report->trade->listName['categoryA']  = 'categoryList';
