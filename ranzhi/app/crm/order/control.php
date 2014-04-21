<?php
/**
 * The control file of order module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     order
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
class order extends control
{
    /** 
     * The index page, locate to browse.
     * 
     * @access public
     * @return void
     */
    public function index()
    {   
        $this->locate(inlink('browse'));
    }   

    /**
     * Browse order.
     * 
     * @param string $orderBy     the order by
     * @param int    $recTotal 
     * @param int    $recPerPage 
     * @param int    $pageID 
     * @access public
     * @return void
     */
    public function browse($orderBy = 'id_desc', $recTotal = 0, $recPerPage = 20, $pageID = 1)
    {   
        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal, $recPerPage, $pageID);

        $this->view->title     = $this->lang->order->browse;
        $this->view->orders    = $this->order->getList($orderBy, $pager);
        $this->view->products  = $this->loadModel('product')->getPairs();
        $this->view->customers = $this->loadModel('customer')->getList();
        $this->view->users     = $this->loadModel('user')->getPairs();
        $this->view->pager     = $pager;
        $this->view->orderBy   = $orderBy;
        $this->display();
    }

    /**
     * Create an order.
     * 
     * @access public
     * @return viod
     */
    public function create()
    {
        if($_POST)
        {
            $orderID = $this->order->create();
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));

            $this->loadModel('action')->create('order', $orderID, 'Created', '');
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('browse')));
        }

        $products = $this->loadModel('product')->getPairs();
        $this->view->products  = array( 0 => '') + $products;
        $this->view->customers = $this->loadModel('customer')->getPairs();
        $this->view->title     = $this->lang->order->create;

        $this->display();
    }

    /**
     * Edit an order.
     * 
     * @param  int $orderID 
     * @access public
     * @return void
     */
    public function edit($orderID)
    {
        if($_POST)
        {
            $changes = $this->order->update($orderID);
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));
            if(!empty($changes))
            {   
                $actionID = $this->loadModel('action')->create('order', $orderID, 'Edited');
                $this->action->logHistory($actionID, $changes);
            }   
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('browse')));
        }

        $this->view->title     = $this->lang->order->edit;
        $this->view->order     = $this->order->getByID($orderID);
        $this->view->products  = $this->loadModel('product')->getPairs();
        $this->view->customers = $this->loadModel('customer')->getPairs();
        $this->view->actions   = $this->loadModel('action')->getList('order', $orderID);

        $this->display();
    }

    /**
     * View an order.
     * 
     * @param  int $orderID 
     * @access public
     * @return void
     */

    public function view($orderID)
    {
        $order    = $this->order->getByID($orderID);
        $product  = $this->loadModel('product')->getByID($order->product);
        $customer = $this->loadModel('customer')->getByID($order->customer);
    
        $this->view->order      = $order;
        $this->view->product    = $product;
        $this->view->customer   = $customer;
        $this->view->efforts    = $this->loadModel('effort')->getByObject('order', $orderID);
        $this->view->actionList = $this->loadModel('action')->getList('order', $orderID);
    
        $this->display();
    }
    
    /**
     * Close an order.
     * 
     * @param  int    $orderID 
     * @access public
     * @return void
     */
    public function close($orderID) 
    {
        if(!empty($_POST))
        {
            $this->order->close($orderID);
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));
            $this->loadModel('action')->create('order', $orderID, 'Closed', $this->post->closedNote);
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('browse')));
        }

        $this->view->title   = $this->lang->order->close;
        $this->view->orderID = $orderID;
        $this->display();
    }

    /**
     * Activate an order.
     * 
     * @param  int    $orderID 
     * @access public
     * @return void
     */
    public function activate($orderID) 
    {
        $this->order->activate($orderID);
        if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));
        $this->loadModel('action')->create('order', $orderID, 'Activated', '');
        $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess));
    }

    /**
     * Browse records of and order.
     * 
     * @param  int    $orderID 
     * @param  int    $recTotal 
     * @param  int    $recPerPage 
     * @param  int    $pageID 
     * @access public
     * @return void
     */
    public function browseRecord($orderID, $recTotal = 0, $recPerPage = 20, $pageID = 1)
    {
        $order = $this->order->getByID($orderID);

        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal, $recPerPage, $pageID);


        $this->view->order    = $order;
        $this->view->records  = $this->loadModel('action')->getList('order', $orderID, 'orderrecord', $pager);
        $this->view->contacts = $this->loadModel('contact')->getOptionMenu($order->customer);
        $this->view->customer = $this->loadModel('customer')->getByID($order->customer);
        $this->view->users    = $this->loadModel('user')->getPairs();
        $this->view->pager    = $pager;
        $this->display();
    }

    /**
     * Manage records of an order.
     * 
     * @param  int    $orderID 
     * @access public
     * @return void
     */
    public function createRecord($orderID)
    {
        $order = $this->order->getByID($orderID);

        if($_POST)
        {
            $this->order->createRecord($order);
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('browserecord', "orderID={$orderID}")));
        }

        $this->view->order    = $order;
        $this->view->customer = $this->loadModel('customer')->getByID($order->customer);
        $this->view->contacts = $this->loadModel('contact')->getOptionMenu($order->customer);
        $this->display();
    }

    /**
     * Get contact of an customer.
     *
     * @param  int    $order
     * @param  string $orderBy     the order by
     * @param  int    $recTotal 
     * @param  int    $recPerPage 
     * @param  int    $pageID 
     * @access public
     * @return void
     */
    public function contact($order, $orderBy = 'id_desc', $recTotal = 0, $recPerPage = 20, $pageID = 1)
    {
        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal, $recPerPage, $pageID);

        $order = $this->order->getByID($order);
        $contacts = $this->loadModel('contact')->getList($order->customer, $orderBy, $pager);

        $this->view->title    = $this->lang->order->contact;
        $this->view->contacts = $contacts;
        $this->view->pager    = $pager;
        $this->view->orderBy  = $orderBy;

        $this->display();
    }

    /**
     * Update assign of order.
     *
     * @param  int    $orderID
     * @access public
     * @return void
     */
    public function assignTo($orderID)
    {
        if($_POST)
        {
            $this->order->assign($orderID);
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));
            if($this->post->assignedTo) $this->loadModel('action')->create('order', $orderID, 'Assigned', $this->post->comment, $this->post->assignedTo);
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('browse')));
        }

        $this->view->title   = $this->lang->order->assignedTo;
        $this->view->orderID = $orderID;
        $this->view->order   = $this->order->getByID($orderID);
        $this->view->members = $this->loadModel('user')->getPairs('noclosed, nodeleted, devfirst');
        $this->display();
    }
}
