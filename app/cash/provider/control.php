<?php
/**
 * The control file of provider module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     customer 
 * @version     $Id$
 * @link        http://www.ranzhico.com
 */
class provider extends control
{
    public function __CONSTRUCT()
    {
        parent::__CONSTRUCT();
        $this->loadModel('customer', 'crm');
        $this->loadModel('contact', 'crm');
        $this->loadModel('resume', 'crm');
    }

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
     * Browse provider.
     * 
     * @param string    $orderBy     the order by
     * @param int       $recTotal 
     * @param int       $recPerPage 
     * @param int       $pageID 
     * @access public
     * @return void
     */
    public function browse($mode = 'all', $param = '', $orderBy = 'id_desc', $recTotal = 0, $recPerPage = 20, $pageID = 1)
    {   
        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal, $recPerPage, $pageID);

        $this->view->title      = $this->lang->provider->list;
        $this->view->mode       = $mode;
        $this->view->providers  = $this->customer->getList($mode = $mode, $param = $param, $relation = 'provider', $orderBy, $pager);
        $this->view->areas      = $this->loadModel('tree')->getOptionMenu('area');
        $this->view->industries = $this->tree->getOptionMenu('industry');
        $this->view->pager      = $pager;
        $this->view->orderBy    = $orderBy;
        $this->display();
    }   

    /**
     * Create a provider.
     * 
     * @access public
     * @return void
     */
    public function create()
    {
        if($_POST)
        {
            $providerID = $this->customer->create($provider = null, $relation = 'provider');
            if(dao::isError())  $this->send(array('result' => 'fail', 'message' => dao::getError()));
            $this->loadModel('action')->create('customer', $providerID, 'Created');
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('browse'), 'providerID' => $providerID));
        }

        $this->view->title      = $this->lang->provider->create;
        $this->view->areas      = $this->loadModel('tree')->getOptionMenu('area');
        $this->view->industries = $this->tree->getOptionMenu('industry');
        $this->display();
    }

    /**
     * Edit a provider.
     * 
     * @param  int    $providerID 
     * @access public
     * @return void
     */
    public function edit($providerID)
    {
        if($_POST)
        {
            $changes = $this->customer->update($providerID);
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));

            if($changes)
            {
                $actionID = $this->loadModel('action')->create('customer', $providerID, 'Edited');
                $this->action->logHistory($actionID, $changes);
            }

            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('view', "providerID=$providerID")));
        }

        $this->view->title      = $this->lang->provider->edit;
        $this->view->provider   = $this->customer->getByID($providerID);
        $this->view->areas      = $this->loadModel('tree')->getOptionMenu('area');
        $this->view->industries = $this->tree->getOptionMenu('industry');

        $this->display();
    }

    /**
     * View a provider.
     * 
     * @param  int    $providerID 
     * @access public
     * @return void
     */
    public function view($providerID)
    {
        if(!$this->session->contactList or $this->session->providerList == $this->session->contactList)
        {
            $this->session->set('contactList', $this->app->getURI(true));
        }

        $this->view->title      = $this->lang->provider->view;
        $this->view->provider   = $this->customer->getByID($providerID);
        $this->view->contacts   = $this->contact->getList($providerID);
        $this->view->actions    = $this->loadModel('action')->getList('customer', $providerID);
        $this->view->areas      = $this->loadModel('tree')->getPairs('', 'area');
        $this->view->industries = $this->tree->getPairs('', 'industry');
        $this->display();
    }

    /**
     * Browse contacts of the provider.
     * 
     * @param  int    $providerID 
     * @access public
     * @return void
     */
    public function contact($providerID)
    {
        $this->view->title      = $this->lang->provider->contact;
        $this->view->contacts   = $this->contact->getList($providerID, 'provider');
        $this->view->providerID = $providerID;
        $this->view->modalWidth = 'lg';
        $this->display();
    }

    /**
     * Link contact.
     * 
     * @param  int    $providerID 
     * @access public
     * @return void
     */
    public function linkContact($providerID)
    {
        $contacts = $this->contact->getPairs();

        if($_POST)
        {
            $this->customer->linkContact($providerID);
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));
            $this->loadModel('action')->create('customer', $providerID, 'linkContact', '', $this->post->createContact ? $this->post->realname : $contacts[$this->post->contact]);

            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess));
        }

        $this->view->title      = $this->lang->provider->linkContact;
        $this->view->contacts   = $contacts;
        $this->view->providerID = $providerID;
        $this->display();
    }

    /**
     * Delete a provider.
     *
     * @param  int    $providerID
     * @access public
     * @return void
     */
    public function delete($providerID)
    {
        $this->customer->delete(TABLE_CUSTOMER, $providerID);
        if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));
        $this->send(array('result' => 'success', 'locate' => inlink('browse')));
    }
}
