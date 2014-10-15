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
    public function browse($mode = 'all', $orderBy = 'id_desc', $recTotal = 0, $recPerPage = 20, $pageID = 1)
    {   
        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal, $recPerPage, $pageID);

        $this->session->set('orderList',    $this->app->getURI(true));
        $this->session->set('contractList', '');

        $this->view->title        = $this->lang->order->browse;
        $this->view->orders       = $this->order->getList($mode, '', $orderBy, $pager);
        $this->view->customers    = $this->loadModel('customer')->getList('client');
        $this->view->users        = $this->loadModel('user')->getPairs();
        $this->view->pager        = $pager;
        $this->view->mode         = $mode;
        $this->view->orderBy      = $orderBy;
        $this->view->currencySign = $this->order->setCurrencySign();
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
            $this->loadModel('action')->create('customer', $this->post->customer, 'createOrder', '', html::a($this->createLink('order', 'view', "orderID=$orderID"), $orderID));
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('browse')));
        }

        $products = $this->loadModel('product')->getPairs();
        $this->view->products     = array( 0 => '') + $products;
        $this->view->customers    = $this->loadModel('customer')->getPairs('client');
        $this->view->title        = $this->lang->order->create;
        $this->view->currencyList = $this->order->setCurrencyList();

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
        $order = $this->order->getByID($orderID);
        if(empty($order)) $this->loadModel('common', 'sys')->checkPrivByCustomer($order->customer);

        if($_POST)
        {
            $changes = $this->order->update($orderID);
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));

            if(!empty($changes))
            {   
                $orderActionID = $this->loadModel('action')->create('order', $orderID, 'Edited');
                $this->action->logHistory($orderActionID, $changes);

                $customerActionID = $this->loadModel('action')->create('customer', $order->customer, 'editOrder', '', html::a($this->createLink('order', 'view', "orderID=$order->id"), $order->id));
                $this->action->logHistory($customerActionID, $changes);
            }

            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('view', "orderID=$orderID")));
        }

        $this->view->title        = $this->lang->order->edit;
        $this->view->order        = $order;
        $this->view->products     = $this->loadModel('product')->getPairs();
        $this->view->customers    = $this->loadModel('customer')->getPairs('client');
        $this->view->users        = $this->loadModel('user')->getPairs();
        $this->view->currencyList = $this->order->setCurrencyList();

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
        $order = $this->order->getByID($orderID);
        if(empty($order)) $this->loadModel('common', 'sys')->checkPrivByCustomer($order->customer);

        $this->app->loadLang('resume');
        $this->app->loadLang('contract');

        $uri = $this->app->getURI(true);
        $this->session->set('customerList', $uri);
        $this->session->set('productList',  $uri);
        $this->session->set('contactList',  $uri);
        if(!$this->session->contractList) $this->session->set('contractList', $uri);
    
        $this->view->order        = $order;
        $this->view->title        = $this->lang->order->view;
        $this->view->product      = $this->loadModel('product')->getByID($order->product);
        $this->view->customer     = $this->loadModel('customer')->getByID($order->customer);
        $this->view->contract     = $this->order->getContract($orderID);
        $this->view->users        = $this->loadModel('user')->getPairs();
        $this->view->currencyList = $this->order->setCurrencyList();
    
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
        $order = $this->order->getByID($orderID);
        if(!empty($_POST))
        {
            $this->order->close($orderID);
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));

            $this->loadModel('action')->create('order', $orderID, 'Closed', $this->post->closedNote, $this->lang->order->closedReasonList[$this->post->closedReason]);
            $this->loadModel('action')->create('customer', $order->customer, 'closeOrder', $this->lang->order->closedReason . $this->lang->order->closedReasonList[$this->post->closedReason] . '<br />' . $this->post->closedNote, html::a($this->createLink('order', 'view', "orderID=$orderID"), $orderID));

            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => $this->server->http_referer));
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
        $order = $this->order->getByID($orderID); 
        if(!empty($_POST))
        {
            $this->order->activate($orderID);
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));
            $this->loadModel('action')->create('order', $orderID, 'Activated', $this->post->comment);
            $this->loadModel('action')->create('customer', $order->customer, 'activateOrder', $this->post->comment, html::a($this->createLink('order', 'view', "orderID=$orderID"), $orderID));
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => $this->server->http_referer));
        }

        $this->view->title   = $this->lang->order->activate;
        $this->view->orderID = $orderID;
        $this->view->users   = $this->loadModel('user')->getPairs();
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
        $contacts = $this->loadModel('contact')->getList($order->customer, 'client', $orderBy, $pager);

        $this->view->title    = $this->lang->order->contact;
        $this->view->contacts = $contacts;
        $this->view->pager    = $pager;
        $this->view->orderBy  = $orderBy;

        $this->display();
    }

    /**
     * Assign an order function.
     *
     * @param  int    $orderID
     * @param  null   $table  
     * @access public
     * @return void
     */
    public function assign($orderID, $table = null)
    {
        $order   = $this->order->getByID($orderID);
        $members = $this->loadModel('user')->getPairs('noclosed, nodeleted, devfirst');

        if($_POST)
        {
            $this->order->assign($orderID);
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));

            if($this->post->assignedTo) $this->loadModel('action')->create('order', $orderID, 'Assigned', $this->post->comment, $this->post->assignedTo);
            if($this->post->assignedTo) $this->loadModel('action')->create('customer', $order->customer, 'assignOrder',  $this->lang->order->assignedTo . $members[$this->post->assignedTo] . '<br />' . $this->post->comment, html::a($this->createLink('order', 'view', "orderID=$orderID"), $orderID));

            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => $this->server->http_referer));
        }

        $this->view->title   = $this->lang->order->assignedTo;
        $this->view->orderID = $orderID;
        $this->view->order   = $order;
        $this->view->members = $members;
        $this->display();
    }
}
