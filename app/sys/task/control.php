<?php
/**
 * The control file of task module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     task 
 * @version     $Id$
 * @link        http://www.ranzhico.com
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
        setCookie('taskListType', 'browse', time() + 60 * 60 * 24 * 10);

        /* Build search form. */
        $this->loadModel('search', 'sys');
        $this->config->task->search['actionURL'] = $this->createLink('task', 'browse', "projectID=$projectID&mode=bysearch");
        $this->config->task->search['params']['assignedTo']['values'] = $this->loadModel('project')->getMemberPairs($projectID);
        $this->search->setSearchParams($this->config->task->search);

        $this->view->title = $this->lang->task->browse;
        if($projectID) $this->view->title = $project->name . $this->lang->minus . $this->view->title;

        $tasks = $this->task->getList($projectID, $mode, $orderBy, $pager);
        $this->session->set('taskQueryCondition', $this->dao->get());

        $this->view->tasks     = $tasks;
        $this->view->pager     = $pager;
        $this->view->mode      = $mode;
        $this->view->orderBy   = $orderBy;
        $this->view->project   = $project;
        $this->view->projectID = $projectID;
        $this->view->projects  = $this->loadModel('project')->getPairs();
        $this->view->users     = $this->loadModel('project')->getMemberPairs($projectID);
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

            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => $this->post->referer));
        }

        $this->view->projectID = $projectID;
        $this->view->projects  = $this->loadModel('project')->getPairs();
        $this->view->users     = $this->loadModel('project')->getMemberPairs($projectID);
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

            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => $this->post->referer));
        }

        $this->view->title     = $this->lang->task->edit;
        $this->view->task      = $this->task->getByID($taskID);
        $this->view->projectID = $this->view->task->project;
        $this->view->projects  = $this->loadModel('project')->getPairs();
        $this->view->members   = $this->loadModel('project')->getMemberPairs($this->view->task->project);
        $this->view->users     = $this->loadModel('user')->getPairs();
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

        $this->view->title      = $this->lang->task->view . $task->name;
        $this->view->task       = $task;
        $this->view->projectID  = $task->project;
        $this->view->projects   = $this->loadModel('project')->getPairs();
        $this->view->members    = $this->loadModel('project')->getMemberPairs($task->project);
        $this->view->users      = $this->loadModel('user')->getPairs();
        $this->view->preAndNext = $this->loadModel('common', 'sys')->getPreAndNextObject('task', $taskID);

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

            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => 'reload', 'closeModal' => true, 'callback' => 'reloadDataTable'));
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

            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => 'reload', 'closeModal' => true, 'callback' => 'reloadDataTable'));
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
                $this->sendmail($taskID, $actionID);
            }

            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => 'reload', 'closeModal' => true, 'callback' => 'reloadDataTable'));
        }

        $task = $this->task->getByID($taskID);

        $this->view->title  = $task->name;
        $this->view->taskID = $taskID;
        $this->view->task   = $task;
        $this->view->users  = $this->loadModel('project')->getMemberPairs($task->project);
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
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => 'reload', 'closeModal' => true, 'callback' => 'reloadDataTable'));
        }
        $this->view->title = $this->lang->task->activate;
        $this->view->task  = $this->task->getByID($taskID);
        $this->view->users = $this->loadModel('user')->getPairs('noclosed');
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
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => 'reload', 'closeModal' => true, 'callback' => 'reloadDataTable'));
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
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => 'reload', 'closeModal' => true, 'callback' => 'reloadDataTable'));
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
     * @param  string $groupBy    the field to group by
     * @access public
     * @return void
     */
    public function kanban($projectID = 0, $groupBy = 'status')
    {
        if($_POST)
        {
            $task = $this->dao->select('*')->from(TABLE_TASK)->where('id')->eq($this->post->id)->fetch();
            unset($task->canceledDate);
            unset($task->canceledBy);
            unset($task->finishedDate);
            unset($task->finishedBy);
            unset($task->closedDate);
            unset($task->closedBy);
            $task->{$this->post->field} = $this->post->value;

            $changes = $this->task->update($this->post->id, $task);
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));

            if(!empty($changes))
            {
                $actionID = $this->loadModel('action')->create('task', $task->id, 'Edited');
                if($changes) $this->action->logHistory($actionID, $changes);
            }

            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess));
        }

        /* Check project deleted. */
        if($projectID)
        {
            $project = $this->loadModel('project')->getByID($projectID);
            if($project->deleted) $this->locate($this->createLink('project'));
        }

        $this->session->set('taskList', $this->app->getURI(true));
        setCookie('taskListType', 'kanban', time() + 60 * 60 * 24 * 10);

        $orderBy = 'id_desc';
        if($groupBy == 'status') $orderBy = 'pri';
        if($groupBy == 'assignedTo' or $groupBy == 'createdBy') $orderBy = 'status';

        $tasks = $this->task->getList($projectID, $mode = null, $orderBy, $pager = null, $groupBy);
        $tasks = $this->task->fixTaskGroups($project, $tasks, $groupBy); 

        $this->view->tasks       = $tasks;
        $this->view->groupBy     = $groupBy;
        $this->view->orderBy     = $orderBy;
        $this->view->projectID   = $projectID;
        $this->view->projects    = $this->project->getPairs();
        $this->view->project     = $project;
        $this->view->users       = $this->loadModel('user')->getPairs();
        $this->view->colWidth    = 100/min(6, max(2, count($tasks)));
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
    public function outline($projectID = 0, $groupBy = 'status', $orderBy = 'id_desc')
    {
        /* Check project deleted. */
        if($projectID)
        {
            $project = $this->loadModel('project')->getByID($projectID);
            if($project->deleted) $this->locate($this->createLink('project'));
        }

        $this->session->set('taskList', $this->app->getURI(true));
        setCookie('taskListType', 'outline', time() + 60 * 60 * 24 * 10);

        $orderBy = 'id_desc';
        if($groupBy == 'status') $orderBy = 'pri';
        if($groupBy == 'assignedTo' or $groupBy == 'createdBy') $orderBy = 'status';

        /* Get tasks and group them. */
        $tasks = $this->task->getList($projectID, $mode = null, $orderBy, $pager = null, $groupBy);
        $tasks = $this->task->fixTaskGroups($project, $tasks, $groupBy); 

        $this->view->tasks     = $tasks;
        $this->view->groupBy   = $groupBy;
        $this->view->orderBy   = $groupBy;
        $this->view->projectID = $projectID;
        $this->view->projects  = $this->project->getPairs();
        $this->view->project   = $project;
        $this->view->users     = $this->loadModel('user')->getPairs();
        $this->display();
    }

    /**
     * Send email.
     * 
     * @param  int    $taskID 
     * @param  int    $actionID 
     * @access public
     * @return void
     */
    public function sendmail($taskID, $actionID)
    {
        /* Reset $this->output. */
        $this->clear();

        /* Set toList and ccList. */
        $task        = $this->task->getById($taskID);
        $projectName = $this->loadModel('project', 'oa')->getById($task->project)->name;
        $users       = $this->loadModel('user')->getPairs('noletter');
        $toList      = $task->assignedTo;
        $ccList      = trim($task->mailto, ',');

        if($toList == '')
        {
            if($ccList == '') return;
            if(strpos($ccList, ',') === false)
            {
                $toList = $ccList;
                $ccList = '';
            }
            else
            {
                $commaPos = strpos($ccList, ',');
                $toList = substr($ccList, 0, $commaPos);
                $ccList = substr($ccList, $commaPos + 1);
            }
        }
        elseif(strtolower($toList) == 'closed')
        {
            $toList = $task->finishedBy;
        }

        /* Get action info. */
        $action          = $this->loadModel('action')->getById($actionID);
        $history         = $this->action->getHistory($actionID);
        $action->history = isset($history[$actionID]) ? $history[$actionID] : array();

        /* Create the email content. */
        $this->view->task   = $task;
        $this->view->action = $action;
        $this->view->users  = $users;

        $mailContent = $this->parse($this->moduleName, 'sendmail');

        /* Send emails. */
        $this->loadModel('mail')->send($toList, $projectName . ':' . 'TASK#' . $task->id . $this->lang->colon . $task->name, $mailContent, $ccList);
        if($this->mail->isError()) trigger_error(join("\n", $this->mail->getError()));
    }
}
