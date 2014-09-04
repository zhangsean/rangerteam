<?php
/**
 * The control file of task module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     task 
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
class task extends control
{
    /**
     * Construct function. 
     * 
     * @access public
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->lang->menuGroups->task = 'project';
    }
    /** 
     * The index page, locate to browse.
     * 
     * @access public
     * @return void
     */
    public function index()
    {   
        $this->locate(inlink('browse'));
    }   

    /**
     * Browse task. 
     * 
     * @param  int    $projectID 
     * @param  string $orderBy 
     * @param  int    $recTotal 
     * @param  int    $recPerPage 
     * @param  int    $pageID 
     * @access public
     * @return void
     */
    public function browse($projectID = 0, $mode = null, $orderBy = 'id_desc', $recTotal = 0, $recPerPage = 20, $pageID = 1)
    {
        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal, $recPerPage, $pageID);

        /* Check project deleted. */
        if($projectID)
        {
            $project = $this->loadModel('project')->getByID($projectID);
            if($project->deleted) $this->locate($this->createLink('project'));
        }

        $this->session->set('taskList', $this->app->getURI(true));

        $this->view->title      = $this->lang->task->browse;
        if($projectID) $this->view->title = $project->name . $this->lang->minus . $this->view->title;

        $this->view->tasks     = $this->task->getList($projectID, $mode, $orderBy, $pager);
        $this->view->pager     = $pager;
        $this->view->orderBy   = $orderBy;
        $this->view->projectID = $projectID;
        $this->view->projects  = $this->loadModel('project')->getPairs();
        $this->view->users     = $this->loadModel('user')->getPairs();
        $this->display();
    }

    /**
     * Create a task.
     * 
     * @access public
     * @return void
     */
    public function create($projectID)
    {
        if($_POST)
        {
            $taskID = $this->task->create();
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));

            $this->loadModel('action')->create('task', $taskID, 'Created');

            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('browse', "projectID=$projectID")));
        }

        $this->view->title     = $this->lang->task->create;
        $this->view->projectID = $projectID;
        $this->view->projects  = $this->project->getPairs();
        $this->view->users     = $this->loadModel('user')->getPairs();
        $this->display();
    }

    /**
     * Batch create task.
     * 
     * @param  int    $projectID 
     * @access public
     * @return void
     */
    public function batchCreate($projectID)
    {
        if($_POST)
        {
            $taskIDList = $this->task->batchCreate($projectID);

            $this->loadModel('action');
            foreach($taskIDList as $taskID) $this->action->create('task', $taskID, 'Created');

            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('browse', "projectID=$projectID")));
        }

        $this->view->projectID = $projectID;
        $this->view->projects  = $this->loadModel('project')->getPairs();
        $this->view->users     = $this->loadModel('user')->getPairs();
        $this->display();
    }

    /**
     * Edit a task.
     * 
     * @param  int    $taskID 
     * @access public
     * @return void
     */
    public function edit($taskID)
    {
        if($_POST)
        {
            $changes = $this->task->update($taskID);
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));
            $files = $this->loadModel('file')->saveUpload('task', $taskID);

            if(!empty($changes) or !empty($files))
            {
                $fileAction = '';
                if($files) $fileAction = $this->lang->addFiles . join(',', $files);

                $actionID = $this->loadModel('action')->create('task', $taskID, 'Edited', $fileAction);
                if($changes) $this->action->logHistory($actionID, $changes);
            }

            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('view', "taskID=$taskID")));
        }

        $this->view->title      = $this->lang->task->edit;
        $this->view->task       = $this->task->getByID($taskID);
        $this->view->projectID  = $this->view->task->project;
        $this->view->projects   = $this->loadModel('project')->getPairs();
        $this->view->users      = $this->loadModel('user')->getPairs();
        $this->display();
    }

    /**
     * View task. 
     * 
     * @param  int    $taskID 
     * @access public
     * @return void
     */
    public function view($taskID)
    {
        $task = $this->task->getByID($taskID);

        $this->view->title     = $this->lang->task->view . $task->name;
        $this->view->task      = $task;
        $this->view->projectID = $task->project;
        $this->view->projects  = $this->loadModel('project')->getPairs();
        $this->view->users     = $this->loadModel('user')->getPairs();

        $this->display();
    }

    /**
     * Finish task.
     * 
     * @param  int    $taskID 
     * @access public
     * @return void
     */
    public function finish($taskID) 
    {
        if($_POST)
        {
            $changes = $this->task->finish($taskID);
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));

            if($changes)
            {
                $actionID = $this->loadModel('action')->create('task', $taskID, 'Finished', $this->post->comment);
                $this->action->logHistory($actionID, $changes);
            }

            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => 'reload'));
        }

        $task = $this->task->getByID($taskID);

        $this->view->title  = $task->name;
        $this->view->taskID = $taskID;
        $this->view->task   = $task;
        $this->view->users  = $this->loadModel('user')->getPairs();
        $this->display();
    }

    /**
     * Start a task.
     * 
     * @param  int    $taskID 
     * @access public
     * @return void
     */
    public function start($taskID)
    {
        if(!empty($_POST))
        {
            if($this->post->doStart != 'yes')
            {
                if((int) $this->post->left == '0') $this->send(array('result' => 'fail', 'confirm' => $this->lang->task->confirmFinish));
            }

            $this->loadModel('action');
            $changes = $this->task->start($taskID);
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));

            if($this->post->comment != '' or !empty($changes))
            {
                $act = $this->post->left == 0 ? 'Finished' : 'Started';
                $actionID = $this->action->create('task', $taskID, $act, $this->post->comment);
                $this->action->logHistory($actionID, $changes);
            }

            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => 'reload'));
        }

        $this->view->taskID = $taskID; 
        $this->view->task   = $this->loadModel('task')->getByID($taskID);
        $this->view->title  = $this->view->task->name . $this->lang->minus . $this->lang->start;
        $this->display();
    }
    
    /**
     * Update assign of task.
     *
     * @param  int    $taskID
     * @access public
     * @return void
     */
    public function assignTo($taskID)
    {
        if($_POST)
        {
            $changes = $this->task->assign($taskID);
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));

            if($changes)
            {
                $actionID = $this->loadModel('action')->create('task', $taskID, 'Assigned', $this->post->comment, $this->post->assignedTo);
                $this->action->logHistory($actionID, $changes);
            }
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => 'reload'));
        }

        $task = $this->task->getByID($taskID);

        $this->view->title  = $task->name;
        $this->view->taskID = $taskID;
        $this->view->task   = $task;
        $this->view->users  = $this->loadModel('user')->getPairs();
        $this->display();
    }

    /**
     * Activate task. 
     * 
     * @param  int    $taskID 
     * @access public
     * @return void
     */
    public function activate($taskID)
    {
        if($_POST)
        {
            $changes = $this->task->activate($taskID);
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));

            if($changes)
            {
                $actionID = $this->loadModel('action')->create('task', $taskID, 'Activated', $this->post->comment);
                $this->action->logHistory($actionID, $changes);
            }
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => 'reload'));
        }
        $this->view->title = $this->lang->task->activate;
        $this->view->task  = $this->task->getByID($taskID);
        $this->view->users = $this->loadModel('user')->getPairs();
        $this->display();
    }

    /**
     * Cancel task. 
     * 
     * @param  int    $taskID 
     * @access public
     * @return void
     */
    public function cancel($taskID)
    {
        if($_POST)
        {
            $changes = $this->task->cancel($taskID);
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));

            if($changes)
            {
                $actionID = $this->loadModel('action')->create('task', $taskID, 'Canceled', $this->post->comment);
                $this->action->logHistory($actionID, $changes);
            }
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => 'reload'));
        }

        $this->view->title  = $this->lang->task->cancel;
        $this->view->taskID = $taskID;
        $this->display();
    }

    /**
     * Close task. 
     * 
     * @param  int    $taskID 
     * @access public
     * @return void
     */
    public function close($taskID)
    {
        if($_POST)
        {
            $changes = $this->task->close($taskID);
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));

            if($changes)
            {
                $task     = $this->task->getByID($taskID);
                $actionID = $this->loadModel('action')->create('task', $taskID, 'Closed', $this->post->comment, $this->lang->task->reasonList[$task->closedReason]);
                $this->action->logHistory($actionID, $changes);
            }
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => 'reload'));
        }
        $this->view->title  = $this->lang->task->close;
        $this->view->taskID = $taskID;
        $this->display();
    }

    /**
     * Delete task 
     * 
     * @param  int    $taskID 
     * @access public
     * @return void
     */
    public function delete($taskID)
    {
        $this->task->delete(TABLE_TASK, $taskID);
        if(dao::isError()) $this->send(array('result' => 'fail', 'massage' => dao::getError()));

        $link = $this->session->taskList ? $this->session->taskList : inlink('browse');
        $this->send(array('result' => 'success', 'locate' => $link));
    }

    /**
     * View task as kanban 
     * 
     * @param  int    $taskID 
     * @access public
     * @return void
     */
    public function kanban($projectID = 0)
    {
        /* Check project deleted. */
        if($projectID)
        {
            $project = $this->loadModel('project')->getByID($projectID);
            if($project->deleted) $this->locate($this->createLink('project'));
        }

        $this->view->tasks     = $this->task->getList($projectID);
        $this->view->title     = $this->lang->task->browse;
        $this->view->projectID = $projectID;
        $this->view->projects  = $this->project->getPairs();
        $this->display();
    }

    /**
     * Browse tasks with mindmap.
     * 
     * @param  int    $projectID 
     * @param  string $groupBy    the field to group by
     * @access public
     * @return void
     */
    public function mind($projectID = 0, $groupBy = 'status')
    {
        if($_POST)
        {
            if($this->post->changes)
            {
                $changes = json_decode($this->post->changes);
                if(!empty($changes)) $this->task->saveMind($changes);
            }

            if($this->post->projectName)
            {
                $project = array('projectName' => $this->post->projectName);
                $this->loadModel('project', 'oa')->update($this->post->projectID, $project);
            }
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess));
        }

        /* Check project deleted. */
        if($projectID)
        {
            $project = $this->loadModel('project')->getByID($projectID);
            if($project->deleted) $this->locate($this->createLink('project'));
        }

        /* Get tasks and group them. */
        $tasks       = $this->task->getList($projectID);
        $groupBy     = strtolower(str_replace('`', '', $groupBy));
        $taskLang    = $this->lang->task;
        $groupByList = array();
        $groupTasks  = array();

        if(empty($groupBy)) $groupBy = 'status';
        if($groupBy == 'status')
        {
            foreach ($taskLang->statusList as $key => $value) 
            {
                if(empty($key)) continue;
                $groupTasks[$key] = array();
            }
        }

        /* Get users. */
        $users = $this->loadModel('user')->getPairs();
        foreach($tasks as $task)
        {
            if($groupBy == 'status')
            {
                $groupTasks[$task->status][] = $task;
            }
            elseif($groupBy == 'assignedto')
            {
                $groupTasks[$users[$task->assignedTo]][] = $task;
            }
            elseif($groupBy == 'createdby')
            {
                $groupTasks[$users[$task->createdBy]][] = $task;
            }
            elseif($groupBy == 'finishedby')
            {
                $groupTasks[$users[$task->finishedBy]][] = $task;
            }
            elseif($groupBy == 'closedby')
            {
                $groupTasks[$users[$task->closedBy]][] = $task;
            }
            else
            {
                $groupTasks[$task->$groupBy][] = $task;
            }
        }

        $this->view->tasks       = $groupTasks;
        $this->view->groupByList = $groupByList;
        $this->view->groupBy     = $groupBy;
        $this->view->orderBy     = $groupBy;
        $this->view->projectID   = $projectID;
        $this->view->projects    = $this->project->getPairs();
        $this->view->projectName = $project->name;
        $this->view->users       = $users;
        $this->display();
    }

     /**
     * Browse tasks in outline.
     * 
     * @param  int    $projectID 
     * @param  string $groupBy    the field to group by
     * @access public
     * @return void
     */
    public function outline($projectID = 0, $groupBy = 'status')
    {
        /* Check project deleted. */
        if($projectID)
        {
            $project = $this->loadModel('project')->getByID($projectID);
            if($project->deleted) $this->locate($this->createLink('project'));
        }

        /* Get tasks and group them. */
        $tasks       = $this->task->getList($projectID);
        $groupBy     = strtolower(str_replace('`', '', $groupBy));
        $taskLang    = $this->lang->task;
        $groupByList = array();
        $groupTasks  = array();

        /* Get users. */
        $users = $this->loadModel('user')->getPairs();
        foreach($tasks as $task)
        {
            if($groupBy == '' or $groupBy == 'status')
            {
                $groupTasks[$taskLang->statusList[$task->status]][] = $task;
            }
            elseif($groupBy == 'assignedto')
            {
                $groupTasks[$users[$task->assignedTo]][] = $task;
            }
            elseif($groupBy == 'createdby')
            {
                $groupTasks[$users[$task->createdBy]][] = $task;
            }
            elseif($groupBy == 'finishedby')
            {
                $groupTasks[$users[$task->finishedBy]][] = $task;
            }
            elseif($groupBy == 'closedby')
            {
                $groupTasks[$users[$task->closedBy]][] = $task;
            }
            else
            {
                $groupTasks[$task->$groupBy][] = $task;
            }
        }

        $this->view->tasks       = $groupTasks;
        $this->view->groupByList = $groupByList;
        $this->view->groupBy     = $groupBy;
        $this->view->orderBy     = $groupBy;
        $this->view->projectID   = $projectID;
        $this->view->projects    = $this->project->getPairs();
        $this->view->users       = $users;
        $this->display();
    }
}
