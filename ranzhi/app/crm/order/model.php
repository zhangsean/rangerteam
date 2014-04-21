<?php
/**
 * The model file of order module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     order
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
class orderModel extends model
{
    /**
     * Get order by id.
     * 
     * @param  int    $id 
     * @access public
     * @return object|bool
     */
    public function getByID($id)
    {
       $order   = $this->dao->select('*')->from(TABLE_ORDER)->where('id')->eq($id)->fetch();
       if(!$order) return false;

       $product = $this->loadModel('product')->getByID($order->product);
       if(!$product) return false;

       return $order;
    }

    /** 
     * Get order list.
     * 
     * @param  string  $orderBy 
     * @param  object  $pager 
     * @access public
     * @return array
     */
    public function getList($orderBy = 'id_desc', $pager = null)
    {
        $orders = $this->dao->select('*')->from(TABLE_ORDER)->orderBy($orderBy)->page($pager)->fetchAll('id');

        $contacts = $this->dao->select('t1.id, t2.customer, t2.id AS contact')
            ->from(TABLE_CONTACT)->alias('t2')
            ->leftJoin(TABLE_CUSTOMER)->alias('t1')->on('t1.id = t2.customer')
            ->fetchGroup('customer', 'contact');

        $contracts = $this->dao->select('*')->from(TABLE_CONTRACTORDER)->fetchPairs('order', 'contract');

        foreach($orders as $order) $order->contact = !empty($contacts[$order->customer]) ? $contacts[$order->customer] : '';

        foreach($orders as $order) $order->contract = !empty($contracts[$order->id]) ? $contracts[$order->id] : '';

        return $orders;
    }

    /**
     * Get order pairs.
     * 
     * @param  int    $customerID 
     * @access public
     * @return array
     */
    public function getPairs($customerID = 0)
    {
        $orders = $this->dao->select('id, customer, product, createdDate')->from(TABLE_ORDER)
            ->beginIF($customerID)->where('customer')->eq($customerID)->fi()
            ->fetchAll('id');

        $customers = $this->loadModel('customer')->getPairs();
        $products  = $this->loadModel('product')->getPairs();

        $orderPairs = array();
        foreach($orders as $key => $order)
        {
           $orderPairs[$key] = sprintf($this->lang->order->titleLBL, $order->id, $customers[$order->customer], $products[$order->product], substr($order->createdDate, 0, 10)); 
        }

        return $orderPairs;
    }

    /**
     * Get orders of the customer for create contract.
     * 
     * @param  int    $customerID 
     * @access public
     * @return array
     */
    public function getOrderForCustomer($customerID)
    {
        $orders = $this->dao->select('id, `plan`, customer, product, createdDate')->from(TABLE_ORDER)
            ->beginIF($customerID)->where('customer')->eq($customerID)->fi()
            ->fetchAll('id');

        $customers = $this->loadModel('customer')->getPairs();
        $products  = $this->loadModel('product')->getPairs();

        foreach($orders as $order)
        {
           $order->title = sprintf($this->lang->order->titleLBL, $order->id, $customers[$order->customer], $products[$order->product], substr($order->createdDate, 0, 10)); 
        }

        return array('0' => '') + $orders;
    }

    /**
     * Get amount.
     * 
     * @param  int|string|array    $idList 
     * @access public
     * @return float
     */
    public function getAmount($idList)
    {
        $orders = $this->dao->select('*')->from(TABLE_ORDER)->where('id')->in($idList)->fetchAll();

        $amount = 0;
        foreach($orders as $order)
        {
            $amount += $order->real == '0.00' ? $order->plan : $order->real;
        }

        return $amount;
    }

    /**
     * Create an order.
     * 
     * @access public
     * @return int
     */
    public function create()
    {
        $now = helper::now();
        $order = fixer::input('post')
            ->add('createdBy', $this->app->user->account)
            ->add('createdDate', $now)
            ->setDefault('status', 'assigned')
            ->setDefault('assignedBy', $this->app->user->account)
            ->setDefault('assignedTo', $this->app->user->account)
            ->setDefault('assignedDate', $now)
            ->get();

        $this->dao->insert(TABLE_ORDER)
            ->data($order)
            ->autoCheck()
            ->batchCheck($this->config->order->require->create, 'notempty')
            ->exec();

        $orderID = $this->dao->lastInsertID();

        $member = new stdclass();
        $member->order   = $orderID;
        $member->account = $this->app->user->account;
        $member->role    = $this->app->user->role;
        $member->join    = helper::today();

        $this->dao->insert(TABLE_TEAM)->data($member)->exec();

        return $orderID;
    }

    /**
     * Update an order.
     * 
     * @param  int $orderID 
     * @access public
     * @return void
     */
    public function update($orderID)
    {
        $oldOrder = $this->getByID($orderID);
        $order    = fixer::input('post')->get();

        $this->dao->update(TABLE_ORDER)
            ->data($order)
            ->autoCheck()
            ->batchCheck($this->config->order->require->edit, 'notempty')
            ->where('id')->eq($orderID)
            ->exec();

        if(dao::isError()) return false;

        return commonModel::createChanges($oldOrder, $order);
    }

    /**
     * Close an order.
     * 
     * @param  int    $orderID 
     * @access public
     * @return bool
     */
    public function close($orderID)
    {
        $now   = helper::now();
        $order = fixer::input('post')
            ->add('closedDate', $now)
            ->add('closedBy', $this->app->user->account)
            ->add('status', 'closed')
            ->get();

        $this->dao->update(TABLE_ORDER)->data($order, $skip = 'uid')
            ->autoCheck()
            ->where('id')->eq($orderID)->exec();

        return !dao::isError();
    }

    /**
     * Activate an order.
     * 
     * @param  int    $orderID 
     * @access public
     * @return bool
     */
    public function activate($orderID)
    {
        $order = $this->getByID($orderID);
        $now   = helper::now();
        $order = fixer::input('post')
            ->add('activatedDate', $now)
            ->add('activatedBy', $this->app->user->account)
            ->setDefault('status', 'normal')
            ->setIF($order->assignedTo != '', 'status', 'assigned')
            ->get();

        $this->dao->update(TABLE_ORDER)->data($order)->autoCheck()->where('id')->eq($orderID)->exec();

        return !dao::isError();
    }

    /**
     * Save a record of an order.
     * 
     * @param  object    $order 
     * @access public
     * @return void
     */
    public function createRecord($order)
    {
        $extra = new stdclass();
        $extra->customer = $order->customer;
        $extra->contract = $this->dao->select('contract')->from(TABLE_CONTRACTORDER)->where('`order`')->eq($order->id)->fetch('contract');
        $extra->extra  = $this->post->contact;

        return $this->loadModel('action')->create($objectType = 'order', $order->id, $action = 'orderrecord', $this->post->comment, $extra);
    }

    /**
     * Assign an order to a member again.
     * 
     * @param  int    $orderID 
     * @access public
     * @return void
     */
    public function assign($orderID)
    {
        $now = helper::now();
        $order = fixer::input('post')
            ->setDefault('assignedBy', $this->app->user->account)
            ->setDefault('assignedDate', $now)
            ->get();

        $this->dao->update(TABLE_ORDER)
            ->data($order, $skip = 'uid, comment')
            ->autoCheck()
            ->where('id')->eq($orderID)
            ->exec();

        return !dao::isError();
    }

    /**
     * Build operate menu of an order.
     * 
     * @param  object    $order 
     * @access public
     * @return string
     */
    public function buildOperateMenu($order)
    {
        $menu = '';
        $menu .= html::a(inlink('edit',   "orderID=$order->id"), $this->lang->edit);
        $menu .= html::a(inlink('assignTo', "orderID=$order->id"), $this->lang->assign, "data-toggle='modal'");
        $menu .= html::a(inlink('browserecord', "orderID=$order->id"), $this->lang->order->effort);

        if(empty($order->contract))
        {
            $menu .=html::a(helper::createLink('contract', 'create', "orderID=$order->id"), $this->lang->order->sign);
        }
        else
        {
            $menu .="<a href='###' disabled='disabled' class='disabled'>" . $this->lang->order->sign . '</a> ';
        }

        $menu .="<div class='dropdown'><a data-toggle='dropdown' href='javascript:;'>" . $this->lang->more . "<span class='caret'></span> </a><ul class='dropdown-menu pull-right'>";

        if($order->status != 'closed')
        {
            $menu .='<li>' . html::a(inlink('close', "orderID=$order->id"), $this->lang->close, "data-toggle='modal'") . '</li>';
        }
        elseif($order->closedReason != 'payed') 
        {
            $menu .='<li>' . html::a(inlink('activate', "orderID=$order->id"), $this->lang->activate, "class='reload'") . '</li>';
        }

        if(!empty($order->contact))
        {
            $menu .='<li>' . html::a(inlink('contact', "orderID=$order->id"), $this->lang->order->contact) . '</li>';
        }
        else
        {
            $menu .='<li>' . html::a(helper::createLink('contact', 'create', "customerID=$order->customer"), $this->lang->order->contact) . '</li>';
        }

        $menu .='</ul></div>';
        return $menu;
    }
}
