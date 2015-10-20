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
}
