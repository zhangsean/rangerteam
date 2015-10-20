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
            $this->send(array('result' => 'success', 'message' => $lang->saveSuccess, 'locate' => inlink('browse')));
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
        $this->view->firstReviewer  = isset($this->config->refund->firstReviewer) ? $this->config->attend->firstReviewer : $deptManager;
        $this->view->secondReviewer = isset($this->config->refund->secondReviewer) ? $this->config->attend->secondReviewer : '';
        $this->view->users          = $this->loadModel('user')->getPairs();
        $this->display();
    }
}
