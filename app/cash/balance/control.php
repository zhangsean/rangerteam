<?php
/**
 * The control file of balance module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     balance
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
class balance extends control
{
    public function __construct()
    {
        parent::__construct();
        $this->lang->menuGroups->balance = 'depositor';
    }

    /**
     * Browse balance.
     * 
     * @param string $orderBy     the order by
     * @param int    $recTotal 
     * @param int    $recPerPage 
     * @param int    $pageID 
     * @access public
     * @return void
     */
    public function browse($depositor= 0, $orderBy = 'date_desc')
    {   
        $this->view->title     = $this->lang->balance->browse;
        $this->view->balances  = $this->balance->getList($depositor, $orderBy);
        $this->view->depositor = $depositor;
        $this->view->orderBy   = $orderBy;

        $this->view->depositorList = $this->loadModel('depositor')->getPairs();
        $this->view->users         = $this->loadModel('user')->getPairs();
        $this->view->currencyList  = $this->loadModel('order', 'crm')->setCurrencyList();

        if($depositor) $this->view->subtitle      = $this->view->depositorList[$depositor];

        $this->display();
    }   

    /**
     * Create a contact.
     * 
     * @param  int    $depositor 
     * @access public
     * @return void
     */
    public function create($depositor = 0)
    {
        if($_POST)
        {
            $balanceID = $this->balance->create(); 
            if(dao::isError())$this->send(array('result' => 'fail', 'message' => dao::getError()));

            $this->loadModel('action')->create('depositor', $this->post->depositor, 'createdBalance', $this->post->date . ':'  . $this->post->money . $this->post->currency);

            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => $this->server->http_referer));
        }

        $this->view->title            = $this->lang->balance->create;
        $this->view->currentDepositor = $depositor;
        $this->view->depositorList    = $this->loadModel('depositor')->getList();
        $this->view->currencyList     = $this->loadModel('order', 'crm')->setCurrencyList();

        $this->display();
    }

    /**
     * Edit a balance.
     * 
     * @param  int    $balanceID 
     * @access public
     * @return void
     */
    public function edit($balanceID)
    {
        $balance = $this->balance->getByID($balanceID);
        if(empty($balance)) die();
        if($_POST)
        {
            $changes = $this->balance->update($balanceID);
            if(dao::isError())$this->send(array('result' => 'fail', 'message' => dao::getError()));

            if($changes)
            {
                $actionID = $this->loadModel('action')->create('balance', $balanceID, 'Edited', '');
                $this->action->logHistory($actionID, $changes);
            }
            
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('browse')));
        }
       
        $this->view->title         = $this->lang->balance->edit;
        $this->view->balance       = $balance;
        $this->view->depositorList = $this->loadModel('depositor')->getList();
        $this->view->currencyList  = $this->loadModel('order', 'crm')->setCurrencyList();

        $this->display();
    }

    /**
     * Delete a balance.
     * 
     * @param  int      $balanceID 
     * @access public
     * @return void
     */
    public function delete($balanceID)
    {
        if($this->balance->delete($balanceID)) $this->send(array('result' => 'success'));
        $this->send(array('result' => 'fail', 'message' => dao::getError()));
    }
}
