<?php
/**
 * The control file of customer module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     customer 
 * @version     $Id$
 * @link        http://www.ranzhico.com
 */
class customer extends control
{
    /** 
     * The index page, locate to the browse page.
     * 
     * @access public
     * @return void
     */
    public function index()
    {
        $this->locate(inlink('browse'));
    }

    /**
     * Browse customer.
     * 
     * @param string $orderBy     the order by
     * @param int    $recTotal 
     * @param int    $recPerPage 
     * @param int    $pageID 
     * @access public
     * @return void
     */
    public function browse($mode = 'all', $param = '', $orderBy = 'id_desc', $recTotal = 0, $recPerPage = 20, $pageID = 1)
    {   
        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal, $recPerPage, $pageID);

        $this->session->set('customerList', $this->app->getURI(true));
        $this->session->set('contactList',  '');

        /* Build search form. */
        $this->loadModel('search', 'sys');
        $this->config->customer->search['actionURL'] = $this->createLink('customer', 'browse', 'mode=bysearch');
        $this->config->customer->search['params']['industry']['values'] = $this->loadModel('tree')->getOptionMenu('industry');
        $this->search->setSearchParams($this->config->customer->search);
        
        $this->view->title     = $this->lang->customer->list;
        $this->view->mode      = $mode;
        $this->view->customers = $this->customer->getList($mode = $mode, $param = $param, $relation = 'client', $orderBy, $pager);
        $this->view->pager     = $pager;
        $this->view->orderBy   = $orderBy;

        $this->session->set('customerQueryCondition', $this->dao->get());

        $this->display();
    }   

    /**
     * Get option menu.
     * 
     * @param  int    $current 
     * @access public
     * @return void
     */
    public function getOptionMenu($current = 0)
    {
        $options = $this->customer->getPairs('client');
        foreach($options as $value => $text)
        {
            $selected = $value == $current ? 'selected' : '';
            echo "<option value='{$value}' {$selected}>{$text}</option>";
        }
        exit;
    }

    /**
     * Create a customer.
     * 
     * @access public
     * @return void
     */
    public function create()
    {
        if($_POST)
        {
            $result = $this->customer->create();
            return $this->send($result);
        }

        unset($this->lang->customer->menu);
        $this->view->title     = $this->lang->customer->create;
        $this->view->sizeList  = $this->customer->combineSizeList();
        $this->view->levelList = $this->customer->combineLevelList();
        $this->display();
    }

    /**
     * Edit a customer.
     * 
     * @param  int    $customerID 
     * @access public
     * @return void
     */
    public function edit($customerID)
    {
        $customer = $this->customer->getByID($customerID);
        if(!$customer) $this->loadModel('common', 'sys')->checkPrivByCustomer('0');

        if($_POST)
        {
            $return = $this->customer->update($customerID);
            $this->send($return);
        }

        $this->view->title        = $this->lang->customer->edit;
        $this->view->customer     = $customer;
        $this->view->areaList     = $this->loadModel('tree')->getOptionMenu('area');
        $this->view->industryList = $this->tree->getOptionMenu('industry');
        $this->view->sizeList     = $this->customer->combineSizeList();
        $this->view->levelList    = $this->customer->combineLevelList();

        $this->display();
    }

    /**
     * View a customer.
     * 
     * @param  int    $customerID 
     * @access public
     * @return void
     */
    public function view($customerID)
    {
        $customer = $this->customer->getByID($customerID);
        if(!$customer) $this->loadModel('common', 'sys')->checkPrivByCustomer('0');

        $uri = $this->app->getURI(true);
        $this->session->set('orderList',    $uri);
        $this->session->set('contractList', $uri);
        $this->session->set('contactList',  $uri);
        if(!$this->session->contactList or $this->session->customerList == $this->session->contactList) $this->session->set('contactList', $this->app->getURI(true));

        $this->app->loadLang('resume');

        $this->view->title        = $this->lang->customer->view;
        $this->view->customer     = $customer;
        $this->view->orders       = $this->loadModel('order')->getList($mode = 'query', "customer=$customerID");
        $this->view->contacts     = $this->loadModel('contact')->getList($customerID);
        $this->view->contracts    = $this->loadModel('contract')->getList($customerID);
        $this->view->addresses    = $this->loadModel('address')->getList('customer', $customerID);
        $this->view->actions      = $this->loadModel('action')->getList('customer', $customerID);
        $this->view->products     = $this->loadModel('product')->getPairs();
        $this->view->users        = $this->loadModel('user')->getPairs();
        $this->view->areaList     = $this->loadModel('tree')->getPairs('', 'area');
        $this->view->industryList = $this->tree->getPairs('', 'industry');
        $this->view->currencySign = $this->loadModel('common', 'sys')->getCurrencySign();
        $this->view->preAndNext   = $this->common->getPreAndNextObject('customer', $customerID);
        $this->display();
    }

    /**
     * Assign an customer function.
     *
     * @param  int    $customerID
     * @param  null   $table  
     * @access public
     * @return void
     */
    public function assign($customerID, $table = null)
    {
        if($_POST)
        {
            $this->customer->assign($customerID);
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));

            if($this->post->assignedTo) $this->loadModel('action')->create('customer', $customerID, 'Assigned', $this->post->comment, $this->post->assignedTo);

            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => $this->server->http_referer));
        }

        $this->view->title      = $this->lang->customer->assignedTo;
        $this->view->customerID = $customerID;
        $this->view->customer   = $this->customer->getByID($customerID);
        $this->view->members    = $this->loadModel('user')->getPairs('noclosed, nodeleted, devfirst');
        $this->display();
    }

    /**
     * Browse orders of the customer.
     * 
     * @param  int    $customerID 
     * @access public
     * @return void
     */
    public function order($customerID)
    {
        $this->view->title      = $this->lang->customer->order;
        $this->view->modalWidth = 'lg';
        $this->view->orders     = $this->loadModel('order')->getList($mode = 'query', "customer=$customerID");
        $this->view->products   = $this->loadModel('product')->getPairs();
        $this->display();
    }

    /**
     * Browse contacts of the customer.
     * 
     * @param  int    $customerID 
     * @access public
     * @return void
     */
    public function contact($customerID)
    {
        $this->app->loadLang('resume');

        $this->view->title      = $this->lang->customer->contact;
        $this->view->modalWidth = 'lg';
        $this->view->contacts   = $this->loadModel('contact')->getList($customerID);
        $this->view->customerID = $customerID;
        $this->display();
    }

    /**
     * Link contact.
     * 
     * @param  int    $customerID 
     * @access public
     * @return void
     */
    public function linkContact($customerID)
    {
        if($_POST)
        {
            $return = $this->customer->linkContact($customerID);
            $this->send($return);
        }

        $this->view->title      = $this->lang->customer->linkContact;
        $this->view->contacts   = $this->loadModel('contact')->getPairs();
        $this->view->customerID = $customerID;
        $this->display();
    }

    /**
     * Browse contracts of the customer.
     * 
     * @param  int    $customerID 
     * @access public
     * @return void
     */
    public function contract($customerID)
    {
        $this->view->title      = $this->lang->customer->contract;
        $this->view->contracts  = $this->loadModel('contract')->getList($customerID);
        $this->view->modalWidth = 'lg';
        $this->display();
    }

    /**
     * Delete a customer.
     *
     * @param  int    $customerID
     * @access public
     * @return void
     */
    public function delete($customerID)
    {
        $customer = $this->customer->getByID($customerID);
        if(!$customer) $this->loadModel('common', 'sys')->checkPrivByCustomer('0');

        $this->customer->delete(TABLE_CUSTOMER, $customerID);
        if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));
        $this->send(array('result' => 'success', 'locate' => inlink('browse')));
    }
}
