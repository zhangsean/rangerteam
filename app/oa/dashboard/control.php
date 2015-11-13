<?php
/**
 * The control file of dashboard module of RanZhi.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv12.html)
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     dashboard
 * @version     $Id$
 * @link        http://www.ranzhico.com
 */
class dashboard extends control
{
    /**
     * Dsahboard Index page.
     * 
     * @access public
     * @return void
     */
    public function index()
    {
        $appName = $this->app->getAppName();
        $entry   = $this->loadModel('entry', 'sys')->getByCode($appName);

        $this->view->title   = $entry->name;
        $this->view->appName = $appName;
        $this->display();
    }

    /**
     * Browse unclosed and assignedTo task. 
     * 
     * @param  string $orderBy 
     * @param  int    $recTotal 
     * @param  int    $recPerPage 
     * @param  int    $pageID 
     * @access public
     * @return void
     */
    public function task($orderBy = 'status', $recTotal = 0, $recPerPage = 20, $pageID = 1)
    {
        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal, $recPerPage, $pageID);
        $this->session->set('taskList', $this->app->getURI(true));
        $this->loadModel('task');

        $taskList = $this->dao->select("*")->from(TABLE_TASK)
            ->where('deleted')->eq(0)
            ->andWhere('assignedTo')->eq($this->app->user->account)
            ->andWhere('status')->ne('closed')
            ->orderBy($orderBy)
            ->page($pager)
            ->fetchAll('id');
        
        /* Save query condition for export and pre/next button. */
        $this->session->set('taskQueryCondition', $this->dao->get());

        /* Process multiple user task. */
        $teams = $this->dao->select('*')->from(TABLE_TEAM)->where('type')->eq('task')->andWhere('id')->in(array_keys($taskList))->orderBy('order_desc')->fetchGroup('id', 'account');
        foreach($teams as $key => $team) $teams[$key] = array_reverse($team);
        foreach($taskList as $key => $task) $task->team = isset($teams[$key]) ? $teams[$key] : array();

        /* Process childen task. */
        foreach($taskList as $key => $task)
        {
            if(!isset($task->children)) $task->children = array();
            if($task->parent != 0 and isset($taskList[$task->parent])) 
            {
                $taskList[$task->parent]->children[$key] = $task;
                unset($taskList[$key]);
            }
        }

        $this->view->title     = $this->lang->task->browse;
        $this->view->tasks     = $taskList;
        $this->view->pager     = $pager;
        $this->view->orderBy   = $orderBy;
        $this->view->projects  = $this->loadModel('project', 'oa')->getPairs();
        $this->view->users     = $this->loadModel('user')->getPairs();
        $this->display();
    }

    /**
     * Browse not finished todos owner by user. 
     * 
     * @param  string $orderBy 
     * @param  int    $recTotal 
     * @param  int    $recPerPage 
     * @param  int    $pageID 
     * @access public
     * @return void
     */
    public function todo($orderBy = 'date', $recTotal = 0, $recPerPage = 20, $pageID = 1)
    {
        $this->loadModel('todo');
        $this->app->loadClass('date');
        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal, $recPerPage, $pageID);

        $account = $this->app->user->account;
        $todos   = array();

        $stmt = $this->dao->select('*')->from(TABLE_TODO)
            ->where('status')->ne('closed')
            ->andWhere()->markLeft(1)->where('assignedTo')->eq($account)->orWhere()->markLeft(1)->where('account')->eq($account)->andWhere('assignedTo')->eq('')->markRight(2)
            ->orderBy($orderBy)
            ->page($pager)
            ->query();
        
        while($todo = $stmt->fetch())
        {
            if($todo->type == 'task') $todo->name = $this->dao->findById($todo->idvalue)->from(TABLE_TASK)->fetch('name');
            if($todo->type == 'customer') $todo->name = $this->dao->findById($todo->idvalue)->from(TABLE_CUSTOMER)->fetch('name'); 
            if($todo->type == 'order') 
            {
                $order = $this->dao->select('c.name, o.createdDate')->from(TABLE_ORDER)->alias('o')->leftJoin(TABLE_CUSTOMER)->alias('c')->on('o.customer=c.id')->where('o.id')->eq($todo->idvalue)->fetch(); 
                $todo->name = $order->name . '|' . date('Y-m-d', strtotime($order->createdDate));
            }

            $todo->begin = date::formatTime($todo->begin);
            $todo->end   = date::formatTime($todo->end);

            /* If is private, change the title to private. */
            if($todo->private and $this->app->user->account != $todo->account) $todo->name = $this->lang->todo->thisIsPrivate;
            $todos[] = $todo;
        }

        $this->view->title     = $this->lang->todo->browse;
        $this->view->todos     = $todos;
        $this->view->pager     = $pager;
        $this->view->orderBy   = $orderBy;
        $this->view->users     = $this->loadModel('user')->getPairs();
        $this->display();
    }
}
