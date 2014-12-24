<?php
/**
 * The control file for contract of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     contract
 * @version     $Id$
 * @link        http://www.ranzhico.com
 */
class contract extends control
{
    /**
     * Construct method.
     * 
     * @param  string $moduleName 
     * @param  string $methodName 
     * @param  string $appName 
     * @access public
     * @return void
     */
    public function __construct($moduleName = '', $methodName = '', $appName = '')
    {
        parent::__construct($moduleName, $methodName, $appName);
        $this->app->loadLang('order', 'crm');
    }

    /**
     * Contract index page. 
     * 
     * @access public
     * @return void
     */
    public function index()
    {
        $this->locate(inlink('browse'));
    }

    /**
     * Browse all contracts; 
     * 
     * @param  string $mode 
     * @param  string $orderBy 
     * @param  int    $recTotal 
     * @param  int    $recPerPage 
     * @param  int    $pageID 
     * @access public
     * @return void
     */
    public function browse($mode = 'all', $orderBy = 'id_desc', $recTotal = 0, $recPerPage = 20, $pageID = 1)
    {   
        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal, $recPerPage, $pageID);

        $contracts = $this->contract->getList(0, $mode, $orderBy, $pager);

        /* Set preAndNext condition. */
        $this->session->set('contractQueryCondition', $this->dao->get());

        /* Save session for return link. */
        $this->session->set('contractList', $this->app->getURI(true));

        /* Build search form. */
        $this->loadModel('search', 'sys');
        $this->config->contract->search['actionURL'] = $this->createLink('contract', 'browse', 'mode=bysearch');
        $this->search->setSearchParams($this->config->contract->search);

        $this->view->title        = $this->lang->contract->browse;
        $this->view->contracts    = $contracts;
        $this->view->customers    = $this->loadModel('customer')->getPairs('client');
        $this->view->pager        = $pager;
        $this->view->mode         = $mode;
        $this->view->orderBy      = $orderBy;
        $this->view->currencySign = $this->loadModel('common', 'sys')->getCurrencySign();
        $this->view->currencyList = $this->common->getCurrencyList();
        if($contracts) $this->view->totalAmount = $this->contract->countAmount($contracts);

        $this->display();
    }

    /**
     * Create contract. 
     * 
     * @param  int    $customerID
     * @param  int    $orderID 
     * @access public
     * @return void
     */
    public function create($customerID = 0, $orderID = 0)
    {
        if($_POST)
        {
            $contractID = $this->contract->create();
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));

            $this->loadModel('action')->create('contract', $contractID, 'Created');
            $this->loadModel('action')->create('customer', $this->post->customer, 'createContract', '', html::a($this->createLink('contract', 'view', "contractID=$contractID"), $this->post->name));

            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('browse')));
        }

        if($orderID && $customerID)
        {
            $this->view->customer     = $customerID;
            $this->view->currentOrder = $this->loadModel('order')->getByID($orderID);
            $this->view->orders       = $this->order->getList($mode = 'query', "customer={$customerID} and o.status = 'normal'");
        }

        unset($this->lang->contract->menu);
        $this->view->title        = $this->lang->contract->create;
        $this->view->orderID      = $orderID;
        $this->view->customers    = $this->loadModel('customer')->getPairs('client');
        $this->view->users        = $this->loadModel('user')->getPairs();
        $this->view->currencyList = $this->loadModel('common', 'sys')->getCurrencyList();
        $this->display();
    }

    /**
     * Edit contract.
     * 
     * @param  int    $contractID 
     * @access public
     * @return void
     */
    public function edit($contractID)
    {
        $contract = $this->contract->getByID($contractID);

        if($_POST)
        {
            $changes = $this->contract->update($contractID);
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));
            $files = $this->loadModel('file')->saveUpload('contract', $contractID);

            if($changes or $files)
            {
                $fileAction = '';
                if($files) $fileAction = $this->lang->addFiles . join(',', $files);

                $contractActionID = $this->loadModel('action')->create('contract', $contractID, 'Edited', $fileAction);
                if($changes) $this->action->logHistory($contractActionID, $changes);

                $customerActionID = $this->loadModel('action')->create('customer', $contract->customer, 'editContract', $fileAction, html::a($this->createLink('contract', 'view', "contractID=$contractID"), $contract->name));
                if($changes) $this->action->logHistory($customerActionID, $changes);

                if($contract->order)
                {
                    foreach($contract->order as $orderID)
                    {
                        $orderActionID = $this->loadModel('action')->create('order', $orderID, 'editContract', $fileAction, html::a($this->createLink('contract', 'view', "contractID=$contractID"), $contract->name));
                        if($changes) $this->action->logHistory($orderActionID, $changes);
                    }
                }
            }

            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('view', "contractID=$contractID")));
        }

        $this->view->title          = $this->lang->contract->edit;
        $this->view->contract       = $contract; 
        $this->view->contractOrders = $this->loadModel('order')->getByIdList($contract->order);
        $this->view->orders         = array('' => '') + $this->order->getList($mode = 'query', "customer={$contract->customer}");
        $this->view->customers      = $this->loadModel('customer')->getPairs('client');
        $this->view->contacts       = $this->loadModel('contact')->getPairs($contract->customer);
        $this->view->users          = $this->loadModel('user')->getPairs();
        $this->view->currencyList   = $this->loadModel('common', 'sys')->getCurrencyList();
        $this->display();
    }

    /**
     * The delivery of the contract.
     * 
     * @param  int    $contractID 
     * @access public
     * @return void
     */
    public function delivery($contractID)
    {
        $contract = $this->contract->getByID($contractID);
        if(!empty($_POST))
        {
            $this->contract->delivery($contractID);
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));

            if($this->post->finish)
            {
                $this->loadModel('action')->create('contract', $contractID, 'finishDelivered', $this->post->comment, '', $this->post->deliveredBy);
                $this->loadModel('action')->create('customer', $contract->customer, 'finishDeliverContract', $this->post->comment, html::a($this->createLink('contract', 'view', "contractID=$contractID"), $contract->name), $this->post->deliveredBy);
            }
            else
            {
                $this->loadModel('action')->create('contract', $contractID, 'Delivered', $this->post->comment, '', $this->post->deliveredBy);
                $this->loadModel('action')->create('customer', $contract->customer, 'deliverContract', $this->post->comment, html::a($this->createLink('contract', 'view', "contractID=$contractID"), $contract->name), $this->post->deliveredBy);
            }

            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => 'reload'));
        }

        $this->view->title      = $this->lang->contract->delivery;
        $this->view->contractID = $contractID;
        $this->view->users      = $this->loadModel('user')->getPairs();
        $this->display();
    }

    /**
     * Receive payments of the contract.
     * 
     * @param  int    $contractID 
     * @access public
     * @return void
     */
    public function receive($contractID)
    {
        $this->loadModel('trade', 'cash');
        $contract     = $this->contract->getByID($contractID);
        $currencySign = $this->loadModel('common', 'sys')->getCurrencySign();
        if(!empty($_POST))
        {
            $this->contract->receive($contractID);
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));

            $actionExtra = html::a($this->createLink('contract', 'view', "contractID=$contractID"), $contract->name) . $this->lang->contract->return . zget($currencySign, $contract->currency, '') . $this->post->amount;

            if($this->post->finish)
            {
                $this->loadModel('action')->create('contract', $contractID, 'finishReturned', $this->post->comment, zget($currencySign, $contract->currency, '') . $this->post->amount, $this->post->returnedBy);
                $this->loadModel('action')->create('customer', $contract->customer, 'finishReceiveContract', $this->post->comment, $actionExtra, $this->post->returnedBy);
            }
            else
            {
                $this->loadModel('action')->create('contract', $contractID, 'returned', $this->post->comment, zget($currencySign, $contract->currency, '') . $this->post->amount, $this->post->returnedBy);
                $this->loadModel('action')->create('customer', $contract->customer, 'receiveContract', $this->post->comment, $actionExtra, $this->post->returnedBy);
            }
            
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => 'reload'));
        }

        $this->view->title         = $this->lang->contract->return;
        $this->view->contractID    = $contractID;
        $this->view->users         = $this->loadModel('user')->getPairs();
        $this->view->depositorList = $this->loadModel('depositor', 'cash')->getPairs();
        $this->view->deptList      = $this->loadModel('tree')->getOptionMenu('dept', 0, $removeRoot = true);
        $this->view->categories    = $this->loadModel('tree')->getOptionMenu('in', 0);
        $this->display();
    }

    /**
     * Cancel contract.
     * 
     * @param  int    $contractID 
     * @access public
     * @return void
     */
    public function cancel($contractID)
    {
        $contract = $this->contract->getByID($contractID);
        if(!empty($_POST))
        {
            $this->contract->cancel($contractID);
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));

            $this->loadModel('action');
            $this->action->create('contract', $contractID, 'Canceled', $this->post->comment);
            $this->action->create('customer', $contract->customer, 'cancelContract', $this->post->comment, html::a($this->createLink('contract', 'view', "contractID=$contractID"), $contract->name));

            if($contract->order)
            {
                foreach($contract->order as $orderID)
                {
                    $this->action->create('order', $orderID, 'cancelContract', $this->post->comment, html::a($this->createLink('contract', 'view', "contractID=$contractID"), $contract->name));
                }
            }
            
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => 'reload'));
        }

        $this->view->title      = $this->lang->cancel;
        $this->view->contractID = $contractID;
        $this->display();
    }

    /**
     * Finish contract.
     * 
     * @param  int    $contractID 
     * @access public
     * @return void
     */
    public function finish($contractID)
    {
        $contract = $this->contract->getByID($contractID);
        if(!empty($_POST))
        {
            $this->contract->finish($contractID);
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));

            $this->loadModel('action')->create('contract', $contractID, 'Finished', $this->post->comment);
            $this->loadModel('action')->create('customer', $contract->customer, 'finishContract', $this->post->comment, html::a($this->createLink('contract', 'view', "contractID=$contractID"), $contract->name));

            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => 'reload'));
        }

        $this->view->title      = $this->lang->finish;
        $this->view->contractID = $contractID;
        $this->display();
    }

    /**
     * View contract. 
     * 
     * @param  int    $contractID 
     * @access public
     * @return void
     */
    public function view($contractID)
    {
        $contract = $this->contract->getByID($contractID);

        /* Save session for return link. */
        $uri = $this->app->getURI(true);
        $this->session->set('customerList', $uri);
        $this->session->set('contactList',  $uri);
        if(!$this->session->orderList) $this->session->set('orderList', $uri);

        $this->view->title        = $this->lang->contract->view;
        $this->view->orders       = $this->loadModel('order')->getByIdList($contract->order);
        $this->view->customers    = $this->loadModel('customer')->getPairs('client');
        $this->view->contacts     = $this->loadModel('contact')->getPairs($contract->customer);
        $this->view->products     = $this->loadModel('product')->getPairs();
        $this->view->users        = $this->loadModel('user')->getPairs();
        $this->view->contract     = $contract;
        $this->view->actions      = $this->loadModel('action')->getList('contract', $contractID);
        $this->view->currencySign = $this->loadModel('common', 'sys')->getCurrencySign();
        $this->view->preAndNext   = $this->common->getPreAndNextObject('contract', $contractID);

        $this->display();
    }

    /**
     * Delete contract. 
     * 
     * @param  int    $contractID 
     * @access public
     * @return void
     */
    public function delete($contractID)
    {
        $this->contract->delete(TABLE_CONTRACT, $contractID);
        if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));
        $this->send(array('result' => 'success', 'locate' => inlink('browse')));
    }

    /**
     * Get order.
     *
     * @param  int       $customerID
     * @param  string    $status
     * @access public
     * @return string
     */
    public function getOrder($customerID, $status = '')
    {
        $orders = $this->loadModel('order')->getOrderForCustomer($customerID, $status);

        $html = "<div class='form-group'><span class='col-sm-7'><select name='order[]' class='select-order form-control'>";

        foreach($orders as $order)
        {
            if(empty($order))
            {
                $html .= "<option value='' data-real='' data-currency=''></option>";
            }
            else
            {
                $html .= "<option value='{$order->id}' data-real='{$order->plan}' data-currency='{$order->currency}'>{$order->title}</option>";
            }
        }

        $html .= '</select></span>';
        $html .= "<span class='col-sm-4'><div class='input-group'><div class='input-group-addon order-currency'></div>" . html::input('real[]', '', "class='order-real form-control' placeholder='{$this->lang->contract->placeholder->real}'") . "</div></span>";
        $html .= "<span class='col-sm-1'>" . html::a('javascript:;', "<i class='icon-plus'></i>", "class='plus'") . html::a('javascript:;', "<i class='icon-minus'></i>", "class='minus'") . "</span></div>";

        echo $html;
    }

    /**
     * Get option menu.
     * 
     * @param  int    $customer 
     * @access public
     * @return void
     */
    public function getOptionMenu($customer)
    {
        $options = $this->contract->getPairs($customer);
        echo "<option value=''></option>";
        foreach($options as $value => $text) echo "<option value='{$value}'>{$text}</option>";
        exit;
    }
}
