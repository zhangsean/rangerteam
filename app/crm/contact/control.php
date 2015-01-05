<?php
/**
 * The control file of contact module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     contact
 * @version     $Id$
 * @link        http://www.ranzhico.com
 */
class contact extends control
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
     * Browse contact.
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

        $contacts = $this->contact->getList($customer = '', $relation = 'client',  $mode, $orderBy, $pager);
        $this->session->set('contactQueryCondition', $this->dao->get());
        $this->session->set('contactList', $this->app->getURI(true));
        $this->session->set('customerList', $this->app->getURI(true));

        $customers = $this->loadModel('customer')->getPairs();

        /* Build search form. */
        $this->loadModel('search', 'sys');
        $this->config->contact->search['actionURL'] = $this->createLink('contact', 'browse', 'mode=bysearch');
        $this->config->contact->search['params']['t2.customer']['values'] = $customers;
        $this->search->setSearchParams($this->config->contact->search);

        $this->view->title     = $this->lang->contact->list;
        $this->view->mode      = $mode;
        $this->view->contacts  = $contacts;
        $this->view->customers = $customers;
        $this->view->pager     = $pager;
        $this->view->orderBy   = $orderBy;
        $this->display();
    }   

    /**
     * Create a contact.
     * 
     * @param  int    $customer
     * @access public
     * @return void
     */
    public function create($customer = 0)
    {
        if($_POST)
        {
            $return = $this->contact->create(); 
            $this->send($return);
        }

        $this->app->loadLang('resume');

        unset($this->lang->contact->menu);
        $this->view->title     = $this->lang->contact->create;
        $this->view->customer  = $customer;
        $this->view->customers = $this->loadModel('customer')->getPairs('client');
        $this->view->sizeList  = $this->customer->combineSizeList();
        $this->view->levelList = $this->customer->combineLevelList();
        $this->display();
    }

    /**
     * Edit a contact.
     * 
     * @param  int    $contactID 
     * @access public
     * @return void
     */
    public function edit($contactID)
    {
        $contact = $this->contact->getByID($contactID);
        if(empty($contact)) $this->loadModel('common', 'sys')->checkPrivByCustomer('0');

        if($_POST)
        {
            $return = $this->contact->update($contactID);
            $this->send($return);
        }

        $this->app->loadLang('resume');

        $this->view->title     = $this->lang->contact->edit;
        $this->view->customers = $this->loadModel('customer')->getPairs('client');
        $this->view->contact   = $contact;

        $this->display();
    }

    /**
     * View contact. 
     * 
     * @param  int    $contactID 
     * @access public
     * @return void
     */
    public function view($contactID)
    {
        if($this->session->customerList == $this->session->contactList) $this->session->set('customerList', $this->app->getURI(true));

        $this->view->title      = $this->lang->contact->view;
        $this->view->contact    = $this->contact->getByID($contactID);
        $this->view->addresses  = $this->loadModel('address')->getList('contact', $contactID);
        $this->view->resumes    = $this->loadModel('resume')->getList($contactID);
        $this->view->customers  = $this->loadModel('customer')->getPairs('client');
        $this->view->preAndNext = $this->loadModel('common', 'sys')->getPreAndNextObject('contact', $contactID); 

        $this->display();
    }

    /**
     * Contact history.
     * 
     * @param  int    $customer 
     * @access public
     * @return void
     */
    public function block($customer)
    {
        $this->view->contacts = $this->contact->getList($customer);
        $this->display();
    }

    /**
     * Delete a contact.
     *
     * @param  int    $contactID
     * @access public
     * @return void
     */
    public function delete($contactID)
    {
        $contact = $this->contact->getByID($contactID);
        if(empty($contact)) $this->loadModel('common', 'sys')->checkPrivByCustomer('0');

        $this->contact->delete(TABLE_CONTACT, $contactID);
        if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));
        $this->send(array('result' => 'success', 'locate' => inlink('browse')));
    }

    /**
     * Get option menu.
     * 
     * @param  int    $customer 
     * @param  int    $current 
     * @access public
     * @return void
     */
    public function getOptionMenu($customer, $current = 0)
    {
        $options = $this->contact->getPairs($customer);
        foreach($options as $value => $text)
        {
            $selected = $value == $current ? 'selected' : '';
            echo "<option value='{$value}' {$selected}>{$text}</option>";
        }
        exit;
    }

    /**
     * vcard of a contact.
     * 
     * @param  int    $contactID 
     * @access public
     * @return void
     */
    public function vcard($contactID)
    {
        $contact = $this->contact->getByID($contactID);
        $customer = $this->loadModel('customer')->getByID($contact->customer);
        $addresses = $this->loadModel('address')->getList('contact', $contactID);

        $fullAddress = '';
        foreach($addresses as $address) $fullAddress .= $address->fullLocation . ';';

        $vcard = "BEGIN:VCARD 
N:{$contact->realname}
ORG:{$customer->name}
TITLE:{$contact->dept} {$contact->title}
TEL;TYPE=WORK:{$contact->phone}
TEL;TYPE=CELL:{$contact->mobile}
ADR;TYPE=HOME:{$fullAddress}
EMAIL;TYPE=PREF,INTERNET:{$contact->email}
END:VCARD";

        $this->app->loadClass('qrcode');
        QRcode::png($vcard, false, 4, 6); 
    }
}
