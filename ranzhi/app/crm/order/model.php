<?php
/**
 * The model file of order module of Ranzhi.
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
           $orderPairs[$key] = $order->id .'_' . $customers[$order->customer] . '_' . $products[$order->product] . '_' . substr($order->createdDate, 0, 10); 
        }

        return $orderPairs;
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
     * Get team members. 
     * 
     * @param  int    $orderID 
     * @access public
     * @return array
     */
    public function getTeamMembers($orderID)
    {
        return $this->dao->select('t1.*, t2.realname')->from(TABLE_TEAM)->alias('t1')
            ->leftJoin(TABLE_USER)->alias('t2')->on('t1.account = t2.account')
            ->where('t1.order')->eq((int)$orderID)
            ->fetchAll('account');
    }

    /**
     * Get roles. 
     * 
     * @param  int    $orderID 
     * @access public
     * @return array
     */
    public function getRoleList($orderID)
    {
        return $this->dao->select('account, role')->from(TABLE_TEAM)
            ->where('`order`')->eq($orderID)
            ->fetchPairs('role', 'account');
    }

    /**
     * Manage team members.
     * 
     * @param  int    $orderID 
     * @access public
     * @return void
     */
    public function manageMembers($orderID)
    {
        extract($_POST);

        $accounts = fixer::input('post')->get('account');
        $roles    = fixer::input('post')->get('role');
        $this->dao->delete()->from(TABLE_TEAM)->where('`order`')->eq($orderID)->exec();
        foreach($accounts as $key => $account)
        {
            if(empty($account)) continue;

            $member = new stdclass();
            $member->role = $roles[$key];
            $member->order   = $orderID;
            $member->account = $account;
            $member->join    = helper::today();
            $this->dao->insert(TABLE_TEAM)->data($member)->exec();
        }
        return !dao::isError();
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
}
