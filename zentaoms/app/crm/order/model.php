<?php
/**
 * The model file of order category of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     order
 * @version     $Id$
 * @link        http://www.zentao.net
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
       $order = $this->dao->select('*')->from(TABLE_ORDER)->where('id')->eq($id)->fetch();

       if(!$order) return false;

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

        if(!$orders) return array();

        return $orders;
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
            ->setDefault('status', 'normal')
            ->setIF($this->post->assignedTo != '', 'assignedBy', $this->app->user->account)
            ->setIF($this->post->assignedTo != '', 'assignedDate', $now)
            ->setIF($this->post->assignedTo != '', 'status', 'assigned')
            ->get();

        $this->dao->insert(TABLE_ORDER)
            ->data($order)
            ->autoCheck()
            ->batchCheck($this->config->order->require->create, 'notempty')
            ->exec();

        $orderID = $this->dao->lastInsertID();

        if(dao::isError()) return false;

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
        $order = fixer::input('post')->get();

        $this->dao->update(TABLE_ORDER)
            ->data($order)
            ->autoCheck()
            ->batchCheck($this->config->order->require->edit, 'notempty')
            ->where('id')->eq($orderID)
            ->exec();

        if(dao::isError()) return false;

        return !dao::isError();
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
}
