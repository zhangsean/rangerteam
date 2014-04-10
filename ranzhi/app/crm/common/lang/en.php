<?php
/**
 * The en file of crm common module of Ranzhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     common 
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
$lang->app = new stdclass();
$lang->app->name = 'CRM';

$lang->menu->crm = new stdclass();
$lang->menu->crm->dashboard = 'Dashboard|dashboard|index|';
$lang->menu->crm->order     = 'Orders|order|index|';
$lang->menu->crm->task      = 'Tasks|task|index|';
$lang->menu->crm->customer  = 'Customers|customer|index|';
$lang->menu->crm->contract  = 'Contracts|contract|index|';
$lang->menu->crm->product   = 'Products|product|index|';
$lang->menu->crm->contact   = 'Contact|contact|index|';
$lang->menu->crm->setting   = 'Setting|setting|lang|module=user&field=roleList';

/* Menu of customer module. */
$lang->customer = new stdclass();
$lang->customer->menu = new stdclass();
$lang->customer->menu->browse = array('link' => '<i class="icon-group"></i> Customer List|customer|browse|', 'alias' => 'edit');
$lang->customer->menu->create = '<i class="icon-plus"></i> Create Customer|customer|create|';

/* Menu of product module. */
$lang->product = new stdclass();
$lang->product->menu = new stdclass();
$lang->product->menu->browse = array('link' => '<i class="icon-th"></i> Product List|product|browse|', 'alias' => 'edit');
$lang->product->menu->create = '<i class="icon-plus"></i> Create Product|product|create|';

/* Menu of order module. */
$lang->order = new stdclass();
$lang->order->menu = new stdclass();
$lang->order->menu->browse = array('link' => '<i class="icon-th-list"></i> Order List|order|browse|', 'alias' => 'edit, team, managemembers');
$lang->order->menu->create = '<i class="icon-plus"></i> Create Order|order|create|';

/* Menu of contact module. */
$lang->contact = new stdclass();
$lang->contact->menu = new stdclass();
$lang->contact->menu->browse = array('link' => '<i class="icon-th-list"></i> Contacts List|contact|browse|', 'alias' => 'edit');
$lang->contact->menu->create = '<i class="icon-plus"></i> Add Contact|contact|create|';

/* Menu of task module. */
$lang->task = new stdclass();
$lang->task->menu = new stdclass();
$lang->task->menu->browse = array('link' => '<i class="icon-th-list"></i> Task List|task|browse|', 'alias' => 'edit');
$lang->task->menu->create = '<i class="icon-plus"></i> Create Task|task|create|';

/* Menu of contract module. */
$lang->contract = new stdclass();
$lang->contract->menu = new stdclass();
$lang->contract->menu->browse = array('link' => '<i class="icon-th-list"></i> Contract List|contract|browse|', 'alias' => 'edit,view');
$lang->contract->menu->create = '<i class="icon-plus"></i> Create Contract|contract|create|';
$lang->contract->menu->setting = '<i class="icon-wrench"></i> Configure|contract|setting|';

/* Menu of setting module. */
$lang->setting = new stdclass();
$lang->setting->menu = new stdclass();
$lang->setting->menu->user     = 'Roles|setting|lang|module=user&field=roleList';
$lang->setting->menu->product  = 'Product Status|setting|lang|module=product&field=statusList';
$lang->setting->menu->customer = 'Customer Status|setting|lang|module=customer&field=typeList';

$lang->dashboard = new stdclass();
