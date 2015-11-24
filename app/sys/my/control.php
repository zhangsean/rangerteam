<?php
/**
 * The control file of my module of RanZhi.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv12.html)
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     my
 * @version     $Id$
 * @link        http://www.ranzhico.com
 */
class my extends control
{
    /**
     * Browse task list.
     * 
     * @param  string  $type 
     * @param  string  $orderBy 
     * @param  int     $recTotal 
     * @param  int     $recPerPage 
     * @param  int     $pageID 
     * @access public
     * @return void
     */
    public function task($type = 'assignedTo', $orderBy = 'id_desc', $recTotal = 0, $recPerPage = 20, $pageID = 1)
    {
        $this->session->set('taskList', "javascript:$.openEntry(\"dashboard\")");

        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal, $recPerPage, $pageID);

        $this->view->title   = $this->lang->my->task->$type;
        $this->view->type    = $type;
        $this->view->orderBy = $orderBy;
        $this->view->pager   = $pager;
        $this->view->tasks   = $this->loadModel('task')->getList(0, $type, $orderBy, $pager);
        $this->display();
    }
}
