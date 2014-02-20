<?php
/**
 * The control file of feedback of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     feedback
 * @version     $Id$
 * @link        http://www.zentao.net
 */
class feedback extends control
{
    /**
     * Index page. 
     * 
     * @access public
     * @return void
     */
    public function index()
    {
        $this->locate(inlink('browse'));
    }

    /**
     * Browse issue 
     * 
     * @param  string $orderBy 
     * @param  int    $recTotal 
     * @param  int    $recPerPage 
     * @param  int    $pageID 
     * @access public
     * @return void
     */
    public function browse($orderBy = 'id_desc', $recTotal = 0, $recPerPage = 20, $pageID = 1)
    {
        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal, $recPerPage, $pageID);

        $this->view->issues    = $this->feedback->getList($orderBy, $pager);
        $this->view->products  = $this->loadModel('product')->getPairs();
        $this->view->customers = $this->loadModel('customer')->getPairs();
        $this->view->contacts  = $this->loadModel('contact')->getPairs();
        $this->view->users     = $this->loadModel('user')->getPairs();
        $this->view->pager     = $pager;
        $this->view->orderBy   = $orderBy;
        $this->display();
    }

    /**
     * Create issue. 
     * 
     * @access public
     * @return void
     */
    public function create()
    {
        if($_POST)
        {
            $issueID = $this->feedback->create();
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));

            $this->loadModel('action')->create('feedback', $issueID, 'Created');
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('browse')));
        }

        $this->view->products  = array(0 => '') + $this->loadModel('product')->getPairs();
        $this->view->customers = $this->loadModel('customer')->getPairs();
        $this->view->contacts  = $this->loadModel('contact')->getPairs();
        $this->view->users     = $this->loadModel('user')->getPairs();
        $this->display();
    }

    /**
     * Edit issue. 
     * 
     * @param  int    $issueID 
     * @access public
     * @return void
     */
    public function edit($issueID)
    {
        if($_POST)
        {
            $this->feedback->update($issueID);
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::isError()));

            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('browse')));
        }

        $this->view->issue     = $this->feedback->getByID($issueID);
        $this->view->products  = array(0 => '') + $this->loadModel('product')->getPairs();
        $this->view->customers = $this->loadModel('customer')->getPairs();
        $this->view->contacts  = $this->loadModel('contact')->getPairs();
        $this->view->users     = $this->loadModel('user')->getPairs();
        $this->display();
    }

    /**
     * View issue. 
     * 
     * @param  int    $issueID 
     * @access public
     * @return void
     */
    public function view($issueID)
    {
        $issue = $this->feedback->getByID($issueID);

        if(!$issue) $this->locate(inlink('browse'));

        /* Change viewed date. */
        if($this->app->user->account != $issue->addedBy and $issue->viewedDate == '0000-00-00 00:00:00')
        {
            $this->dao->update(TABLE_ISSUE)->set('viewedDate')->eq(helper::now())->where('id')->eq($issueID)->exec();
        }

        $this->view->products  = $this->loadModel('product')->getPairs();
        $this->view->customers = $this->loadModel('customer')->getPairs();
        $this->view->contacts  = $this->loadModel('contact')->getPairs();
        $this->view->users     = $this->loadModel('user')->getPairs();
        $this->view->actions   = $this->loadModel('action')->getList('feedback', $issueID);
        $this->view->issue     = $issue;
        $this->display();
    }

    /**
     * Reply issue. 
     * 
     * @param  int    $issueID 
     * @access public
     * @return void
     */
    public function reply($issueID)
    {
        if($_POST)
        {
            $result = $this->feedback->reply($issueID);
            if($result) $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('view', "issueID=$issueID")));

            $this->send(array('result' => 'fail', 'message' => dao::getError()));
        }
    }

    /**
     * Doubt issue. 
     * 
     * @param  int    $issueID 
     * @access public
     * @return void
     */
    public function doubt($issueID)
    {
        if($_POST)
        {
            $result = $this->feedback->doubt($issueID);
            if($result) $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('view', "issueID=$issueID")));

            $this->send(array('result' => 'fail', 'message' => dao::getError()));
        }
    }

    /**
     * Transfer issue. 
     * 
     * @param  int    $issueID 
     * @access public
     * @return void
     */
    public function transfer($issueID)
    {
        $data = new stdclass();
        $data->status         = 'transfered';
        $data->transferedBy   = $this->app->user->account;
        $data->transferedDate = helper::now();

        $this->dao->update(TABLE_ISSUE)->data($data)->where('id')->eq($issueID)->exec();
        $this->loadModel('action')->create('feedback', $issueID, 'Transfered');

        $this->locate(inlink('view', "issueID=$issueID"));
    }

    /**
     * Assign issue. 
     * 
     * @param  int    $issueID 
     * @access public
     * @return void
     */
    public function assignTo($issueID)
    {
        if($_POST)
        {
            $this->feedback->assignTo($issueID);
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));

            if($this->post->assignedTo) $this->loadModel('action')->create('feedback', $issueID, 'Assigned', $this->post->comment, $this->post->assignedTo);
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('view', "issueID=$issueID")));
        }

        $this->view->users = $this->loadModel('user')->getPairs();
        $this->display();
    }

    /**
     * Close issue. 
     * 
     * @param  int    $issueID 
     * @access public
     * @return void
     */
    public function close($issueID)
    {
        if($_POST)
        {
            $this->feedback->close($issueID);
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));

            $this->loadModel('action')->create('feedback', $issueID, 'Closed', $this->post->comment);
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('view', "issueID=$issueID")));
        }

        $this->display();
    }

    /**
     * Delete issue. 
     * 
     * @param  int    $issueID 
     * @access public
     * @return void
     */
    public function delete($issueID)
    {
        $this->feedback->delete($issueID);
        if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));

        $this->send(array('result' => 'success'));
    }
}
