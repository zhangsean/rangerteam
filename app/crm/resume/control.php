<?php
/**
 * The control file of resume module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     resume
 * @version     $Id$
 * @link        http://www.ranzhico.com
 */
class resume extends control
{
    /**
     * Browse resume. 
     * 
     * @param  int    $contactID 
     * @access public
     * @return void
     */
    public function browse($contactID)
    {
        $contact = $this->loadModel('contact')->getByID($contactID);

        $this->view->title      = $contact->realname . $this->lang->minus . $this->lang->resume->common;
        $this->view->modalWidth = 800;
        $this->view->contact    = $this->loadModel('contact')->getByID($contactID);
        $this->view->resumes    = $this->resume->getList($contactID);
        $this->view->customers  = $this->loadModel('customer')->getPairs('client');

        $this->display();
    }

    /**
     * Change customer for contact.
     * 
     * @param  int    $contactID 
     * @access public
     * @return void
     */
    public function create($contactID)
    {
        $customers = $this->loadModel('customer')->getPairs('client');

        if($_POST)
        {
            $this->resume->create($contactID);
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));
            $this->loadModel('action')->create('contact', $contactID, "createdResume", '', $this->post->newCustomer ? $this->post->name : $customers[$this->post->customer]);
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess));
        }

        $this->app->loadLang('contact');

        $this->view->title     = $this->lang->resume->create;
        $this->view->customers = $customers;
        $this->view->contactID = $contactID;
        $this->view->sizeList  = $this->customer->combineSizeList();
        $this->view->levelList = $this->customer->combineLevelList();
        $this->display();
    }

    /**
     * Edit resume.
     * 
     * @param  int    $resumeID 
     * @access public
     * @return void
     */
    public function edit($resumeID)
    {
        $resume = $this->resume->getByID($resumeID);
        if($_POST)
        {
            $changes = $this->resume->update($resumeID);
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));

            if($changes)
            {
                $actionID = $this->loadModel('action')->create('contact', $resume->contact, 'editedResume');
                $this->action->logHistory($actionID, $changes);
            }
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('browse', "contact=$resume->customer")));
        }

        $this->view->title    = $this->lang->resume->edit;
        $this->view->resume   = $resume;
        $this->view->customer = $this->loadModel('customer')->getByID($resume->customer);
        $this->display();
    }

    /**
     * Delete resume.
     * 
     * @param  int    $resumeID 
     * @access public
     * @return void
     */
    public function delete($resumeID)
    {
        $resume = $this->resume->getByID($resumeID);
        $customers = $this->loadModel('customer')->getPairs('client');

        $this->resume->delete(TABLE_RESUME, $resumeID);
        if(dao::isError())$this->send(array('result' => 'fail', 'message' => dao::getError()));
        $this->loadModel('action')->create('contact', $resume->contact, "deleteResume", '', $customers[$resume->customer]);
        $this->send(array('result' => 'success'));
    }
}
