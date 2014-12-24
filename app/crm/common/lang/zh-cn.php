<?php
/**
 * The zh-cn file of crm common module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     common 
 * @version     $Id$
 * @link        http://www.ranzhico.com
 */
$lang->app = new stdclass();
$lang->app->name = 'CRM';

$lang->menu->crm = new stdclass();
$lang->menu->crm->dashboard = '我的地盘|dashboard|index|';
$lang->menu->crm->order     = '订单|order|browse|';
$lang->menu->crm->contract  = '合同|contract|browse|';
$lang->menu->crm->customer  = '客户|customer|browse|';
$lang->menu->crm->contact   = '联系人|contact|browse|';
$lang->menu->crm->product   = '产品|product|browse|';
$lang->menu->crm->setting   = '设置|setting|lang|module=product&field=statusList';

/* Menu of customer module. */
$lang->customer = new stdclass();
$lang->customer->menu = new stdclass();
$lang->customer->menu->browse    = array('link' => '所有客户|customer|browse|mode=all', 'alias' => 'create,edit,view,record');
$lang->customer->menu->past      = array('link' => '亟需联系|customer|browse|mode=past');
$lang->customer->menu->today     = array('link' => '今天联系|customer|browse|mode=today');
$lang->customer->menu->tomorrow  = array('link' => '明天联系|customer|browse|mode=tomorrow');
$lang->customer->menu->thisweek  = array('link' => '一周内联系|customer|browse|mode=thisweek');
$lang->customer->menu->thismonth = array('link' => '一月内联系|customer|browse|mode=thismonth');
$lang->customer->menu->public    = array('link' => '公共客户|customer|browse|mode=public');

/* Menu of product module. */
$lang->product = new stdclass();
$lang->product->menu = new stdclass();
$lang->product->menu->browse     = array('link' => '所有产品|product|browse|mode=all');
$lang->product->menu->normal     = array('link' => '正常|product|browse|mode=normal');
$lang->product->menu->developing = array('link' => '研发中|product|browse|mode=developing');
$lang->product->menu->offline    = array('link' => '下线|product|browse|mode=offline');

/* Menu of order module. */
$lang->order = new stdclass();
$lang->order->menu = new stdclass();
$lang->order->menu->browse    = array('link' => '所有订单|order|browse|mode=all', 'alias' => 'create,edit,view,record');
$lang->order->menu->past      = array('link' => '亟需联系|order|browse|mode=past', 'alias' => 'create,edit,view,record');
$lang->order->menu->today     = array('link' => '今天联系|order|browse|mode=today', 'alias' => 'create,edit,view,record');
$lang->order->menu->tomorrow  = array('link' => '明天联系|order|browse|mode=tomorrow', 'alias' => 'create,edit,view,record');
$lang->order->menu->thisweek  = array('link' => '一周内联系|order|browse|mode=thisweek', 'alias' => 'create,edit,view,record');
$lang->order->menu->thismonth = array('link' => '一月内联系|order|browse|mode=thismonth', 'alias' => 'create,edit,view,record');
$lang->order->menu->public    = array('link' => '公共客户|order|browse|mode=public', 'alias' => 'create,edit,view,record');

/* Menu of contact module. */
$lang->contact = new stdclass();
$lang->contact->menu = new stdclass();
$lang->contact->menu->browse    = array('link' => '所有联系人|contact|browse|mode=all', 'alias' => 'create,edit,view,history');
$lang->contact->menu->past      = array('link' => '亟需联系|contact|browse|mode=past', 'alias' => 'create,edit,view,record');
$lang->contact->menu->today     = array('link' => '今天联系|contact|browse|mode=today', 'alias' => 'create,edit,view,record');
$lang->contact->menu->tomorrow  = array('link' => '明天联系|contact|browse|mode=tomorrow', 'alias' => 'create,edit,view,record');
$lang->contact->menu->thisweek  = array('link' => '一周内联系|contact|browse|mode=thisweek', 'alias' => 'create,edit,view,record');
$lang->contact->menu->thismonth = array('link' => '一月内联系|contact|browse|mode=thismonth', 'alias' => 'create,edit,view,record');

/* Menu of contract module. */
$lang->contract = new stdclass();
$lang->contract->menu = new stdclass();
$lang->contract->menu->browse       = array('link' => '所有合同|contract|browse|mode=all', 'alias' => 'create,edit,view');
$lang->contract->menu->unreceived   = array('link' => '未回款|contract|browse|mode=unreceived',   'alias' => 'create,edit,view,history');
$lang->contract->menu->undeliveried = array('link' => '未交付|contract|browse|mode=undeliveried', 'alias' => 'create,edit,view,history');
$lang->contract->menu->finished     = array('link' => '已完成|contract|browse|mode=finished',   'alias' => 'create,edit,view,history');
$lang->contract->menu->canceled     = array('link' => '已取消|contract|browse|mode=canceled',   'alias' => 'create,edit,view,history');
$lang->contract->menu->expired      = array('link' => '已过期|contract|browse|mode=expired',   'alias' => 'create,edit,view,history');
$lang->contract->menu->expire       = array('link' => '即将到期|contract|browse|mode=expire', 'alias' => 'create,edit,view,history');

/* Menu of setting module. */
$lang->setting = new stdclass();
$lang->setting->menu = new stdclass();
$lang->setting->menu->product       = '产品状态|setting|lang|module=product&field=statusList';
$lang->setting->menu->customerType  = '客户类型|setting|lang|module=customer&field=typeList';
$lang->setting->menu->customerSize  = '客户规模|setting|lang|module=customer&field=sizeNameList';
$lang->setting->menu->customerLevel = '客户等级|setting|lang|module=customer&field=levelNameList';
$lang->setting->menu->area          = '区域设置|tree|browse|type=area|';
$lang->setting->menu->industry      = '行业设置|tree|browse|type=industry|';
$lang->setting->menu->currency      = '货币设置|setting|lang|module=common&field=currencyList';

$lang->dashboard = new stdclass();
$lang->resume    = new stdclass();
$lang->address   = new stdclass();
