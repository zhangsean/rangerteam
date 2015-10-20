<?php
/**
 * The control file of refund of Ranzhi.
 *
 * @copyright   Copyright 2009-2015 QingDao Nature Easy Soft Network Technology Co,LTD (www.cnezsoft.com)
 * @license     ZPL 
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     refund
 * @version     $Id$
 * @link        http://www.ranzhico.com
 */
class refund extends control
{
    /**
     * create a refund.
     * 
     * @access public
     * @return void
     */
    public function create()
    {
        if($_POST)
        {
            $this->refund->create();
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('browse')));
        }

        $this->view->currencyList = $this->loadModel('common', 'sys')->getCurrencyList();
        $this->view->currencySign = $this->loadModel('common', 'sys')->getCurrencySign();
        $this->view->categories   = $this->loadModel('tree')->getOptionMenu('out', 0, $removeRoot = true);
        $this->display();
    }

    /**
     * view my refund 
     * 
     * @access public
     * @return void
     */
    public function personal()
    {
        $this->locate(inlink('browse'));
    }

    /**
     * browse refund.
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

        $refunds = array();

        $this->view->title = $this->lang->refund->browse;
        $this->view->refund = $refunds;
        $this->view->orderBy = $orderBy;
        $this->view->mode = $mode;
        $this->view->pager = $pager;
        $this->display();
    }

    /**
     * Set reviewer for refund. 
     * 
     * @access public
     * @return void
     */
    public function settings()
    {
        if($_POST)
        {
            $settings = fixer::input('post')->get();

            $this->loadModel('setting')->setItems('system.oa.refund', $settings);
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => 'reload'));
        }

        $dept = $this->loadModel('tree')->getByID($this->app->user->dept);
        $deptManager = trim($dept->moderators, ',');

        $this->view->title          = $this->lang->refund->settings; 
        $this->view->firstReviewer  = !empty($this->config->refund->firstReviewer) ? $this->config->refund->firstReviewer : $deptManager;
        $this->view->secondReviewer = !empty($this->config->refund->secondReviewer) ? $this->config->refund->secondReviewer : '';
        $this->view->users          = $this->loadModel('user')->getPairs();
        $this->display();
    }

    /**
     * browse review list.
     * 
     * @param  int    $dept 
     * @param  string $reviewStatus 
     * @access public
     * @return void
     */
    public function browseReview($dept = '', $reviewStatus = 'wait')
    {
        $refunds  = array();
        $newUsers = array();
        $users    = $this->loadModel('user')->getList($dept);
        foreach($users as $key => $user) $newUsers[$user->account] = $user;

        $this->view->title = $this->lang->refund->review;
        $this->view->users = $newUsers;

        if(!empty($this->config->refund->firstReviewer) or !empty($this->config->refund->secondReviewer))
        { 
            if($this->config->refund->firstReviewer == $this->app->user->account)
            {
                $deptList = $this->loadModel('tree')->getPairs('', 'dept');
                $refunds  = $this->refund->getByStatus('wait');

                $this->view->refunds  = $refunds;
                $this->view->deptList = $deptList;
            }

            if($this->config->refund->secondReviewer == $this->app->user->account)
            {
                $deptList = $this->loadModel('tree')->getPairs('', 'dept');
                $refunds  = $this->refund->getByStatus('doing');

                $this->view->refunds  = $refunds;
                $this->view->deptList = $deptList;
            }
        }
        else
        {
            $deptList = $this->loadModel('tree')->getDeptManagedByMe($this->app->user->account);
            if(!empty($deptList)) 
            {
                if($dept == '' or !isset($deptList[$dept])) $dept = current($deptList)->id;
                $refunds = $this->refund->getByDept($dept, $reviewStatus);
            }

            $this->view->refunds      = $refunds;
            $this->view->deptList     = $deptList;
            $this->view->reviewStatus = $reviewStatus;
            $this->view->currentDept  = $dept;
        }

        $this->display();
    }

    /**
     * Set category for refund.
     * 
     * @access public
     * @return void
     */
    public function setCategory()
    {
        $expenseList   = $this->loadModel('tree')->getPairs(0, 'out');
        $expenseIdList =  array_keys($expenseList);

        $refundCategories = $this->dao->select('*')->from(TABLE_CATEGORY)->where('type')->eq('out')->andWhere('refund')->eq(1)->fetchAll('id');
        $refundCategories = array_keys($refundCategories);
        $refundCategories = implode($refundCategories, ',');

        if($_POST)
        {
            $this->refund->setCategory($expenseIdList);
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess));
        }

        $this->view->expenseList      = $expenseList;
        $this->view->refundCategories = $refundCategories;
        $this->display();
    }
}
