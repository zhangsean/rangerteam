<?php
/**
 * The control file of contact category of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     contact
 * @version     $Id$
 * @link        http://www.zentao.net
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
    public function browse($orderBy = 'id_desc', $recTotal = 0, $recPerPage = 20, $pageID = 1)
    {   
        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal, $recPerPage, $pageID);
        
        $contacts = $this->contact->getList($orderBy, $pager);

        $this->view->title    = $this->lang->contact->list;
        $this->view->contacts = $contacts;
        $this->view->pager    = $pager;
        $this->display();
    }   

    /**
     * Create a contact.
     * 
     * @access public
     * @return void
     */
    public function create()
    {
        if($_POST)
        {
            $contactID = $this->contact->create();       
            $this->contact->updateAvatar($contactID);
            if(dao::isError())  $this->send(array('result' => 'fail', 'message' => dao::geterror()));
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('browse')));
        }

        $this->view->title = $this->lang->contact->create;
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
        if($_POST)
        {
            $this->contact->update($contactID);
            $this->contact->updateAvatar($contactID);
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('browse')));
        }

        $contact = $this->contact->getByID($contactID);

        $this->view->title   = $this->lang->contact->edit;
        $this->view->contact = $contact;

        $this->display();
    }
}
