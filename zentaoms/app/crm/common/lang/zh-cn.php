<?php
/**
 * The zh-cn file of crm common module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     common 
 * @version     $Id$
 * @link        http://www.zentao.net
 */
$lang->app = new stdclass();
$lang->app->name = 'CRM';

$lang->menu->crm = new stdclass();
$lang->menu->crm->dashboard = '我的地盘|dashboard|index|';
$lang->menu->crm->order     = '订单|order|index|';
$lang->menu->crm->task      = '任务|task|index|';
$lang->menu->crm->customer  = '客户|customer|index|';
$lang->menu->crm->contract  = '合同|contract|index|';
$lang->menu->crm->product   = '产品|product|index|';
$lang->menu->crm->contact   = '联系人|contact|index|';
$lang->menu->crm->feedback  = '售后|feedback|index|';
$lang->menu->crm->setting   = '设置|setting|lang|module=user&field=roleList';

/* Menu of customer module. */
$lang->customer = new stdclass();
$lang->customer->menu = new stdclass();
$lang->customer->menu->browse = array('link' => '客户列表|customer|browse|', 'alias' => 'edit');
$lang->customer->menu->create = '添加客户|customer|create|';

/* Menu of product module. */
$lang->product = new stdclass();
$lang->product->menu = new stdclass();
$lang->product->menu->browse = array('link' => '产品列表|product|browse|', 'alias' => 'edit');
$lang->product->menu->create = '发布产品|product|create|';

/* Menu of order module. */
$lang->order = new stdclass();
$lang->order->menu = new stdclass();
$lang->order->menu->browse = array('link' => '订单列表|order|browse|', 'alias' => 'edit, team, managemembers');
$lang->order->menu->create = '创建订单|order|create|';

/* Menu of contact module. */
$lang->contact = new stdclass();
$lang->contact->menu = new stdclass();
$lang->contact->menu->browse = array('link' => '联系人列表|contact|browse|', 'alias' => 'edit');
$lang->contact->menu->create = '添加联系人|contact|create|';

/* Menu of product module. */
$lang->task = new stdclass();
$lang->task->menu = new stdclass();
$lang->task->menu->browse = array('link' => '任务列表|task|browse|', 'alias' => 'edit');
$lang->task->menu->create = '添加任务|task|create|';

/* Menu of contact module. */
$lang->contract = new stdclass();
$lang->contract->menu = new stdclass();
$lang->contract->menu->browse = array('link' => '合同列表|contract|browse|', 'alias' => 'edit');
$lang->contract->menu->create = '添加合同|contract|create|';

$lang->setting = new stdclass();
$lang->setting->menu = new stdclass();
$lang->setting->menu->user     = '员工角色|setting|lang|module=user&field=roleList';
$lang->setting->menu->product  = '产品状态|setting|lang|module=product&field=statusList';
$lang->setting->menu->customer = '客户级别|setting|lang|module=customer&field=typeList';
