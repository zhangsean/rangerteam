<?php
/**
 * The control file of resume module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     resume
 * @version     $Id$
 * @link        http://www.ranzhi.org
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
        $contact    = $this->loadModel('contact')->getByID($contactID);
        $actionLink = html::a(inlink('create', "contactID=$contactID"), $this->lang->resume->change, "class='loadInModal btn btn-primary btn-mini'");

        $this->view->title      = $contact->realname . $this->lang->minus . $this->lang->resume->common . $actionLink;
        $this->view->modalWidth = 800;
        $this->view->contact    = $this->loadModel('contact')->getByID($contactID);
        $this->view->resumes    = $this->resume->getList($contactID);
        $this->view->customers  = $this->loadModel('customer')->getPairs();

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
        $contact = $this->loadModel('contact')->getByID($contactID);
        if($_POST)
        {
            /* When customer is not change then goto update. */
            if($contact->customer and $this->post->customer == $contact->customer)
            {
                $resumeID = $this->dao->select('id')->from(TABLE_RESUME)->where('contact')->eq($contactID)->andWhere('customer')->eq($contact->customer)->orderBy('id_desc')->limit(1)->fetch('id');
                if($resumeID) return $this->edit($resumeID);
            }

            $this->resume->create($contactID);
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));
            $this->loadModel('action')->create('contact', $contactID, "changeResume");
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => 'reload'));
        }

        $this->view->title     = $this->lang->resume->change;
        $this->view->customers = $this->loadModel('customer')->getPairs();
        $this->view->contact   = $contact;
        $this->view->contactID = $contactID;
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
                $actionID = $this->loadModel('action')->create('contact', $resume->contact, 'editResume');
                $this->action->logHistory($actionID, $changes);
            }
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('browse', "contact=$resume->customer")));
        }

        $this->view->title  = $this->lang->resume->edit;
        $this->view->resume = $resume;
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
        $this->resume->delete($resumeID);
        if(dao::isError())$this->send(array('result' => 'fail', 'message' => dao::getError()));
        $this->send(array('result' => 'success'));
    }
}
