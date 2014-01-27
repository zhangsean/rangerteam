<?php
/**
 * The control file for contract of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     contract
 * @version     $Id$
 * @link        http://www.zentao.net
 */
class contract extends control
{
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

        $this->view->contracts = $this->contract->getList($orderBy, $pager);
        $this->view->customers = $this->loadModel('customer')->getPairs();
        $this->view->pager     = $pager;

        $this->display();
    }

    /**
     * Create contract. 
     * 
     * @param  string    $orderID 
     * @access public
     * @return void
     */
    public function create($orderID = 0)
    {
        if($_POST)
        {
            $createID = $this->contract->create();
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));
            $this->send(array('result' => 'success', 'locate' => inlink('browse')));
        }

        $orderID = explode(',', $orderID);

        $this->view->orders    = $this->loadModel('order')->getPairs();
        $this->view->customers = $this->loadModel('customer')->getPairs();
        $this->view->contacts  = $this->loadModel('contact')->getPairs();
        $this->view->users     = $this->loadModel('user')->getPairs();
        $this->view->order     = $this->order->getByID($orderID[0]);
        $this->view->amount    = $this->order->getAmount($orderID);
        $this->view->orderID   = $orderID;
        $this->display();
    }
}

