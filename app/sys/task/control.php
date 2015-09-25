<?php
/**
 * The control file of task module of RanZhi.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv11.html)
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
    public function browse($projectID = 0, $mode = 'assignedTo', $orderBy = 'status', $recTotal = 0, $recPerPage = 20, $pageID = 1)
    {
        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal, $recPerPage, $pageID);

        /* Check project deleted and privilage. */
        if($projectID)
        {
            $project = $this->loadModel('project')->getByID($projectID);
            if($project->deleted) $this->locate($this->createLink('project'));
            if(!$this->project->checkPriv($projectID)) $this->locate($this->createLink('project'));
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
     * @param  int    $taskID 
     * @access public
     * @return void
     */
    public function batchCreate($projectID, $taskID = '')
    {
        if($_POST)
        {
            $taskIDList = $this->task->batchCreate($projectID);

            $this->loadModel('action');
            foreach($taskIDList as $taskID) $this->action->create('task', $taskID, 'Created');

            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => $this->post->referer));
        }

        $this->view->title     = $taskID == '' ? $this->lang->task->batchCreate : $this->lang->task->children;
        $this->view->projectID = $projectID;
        $this->view->projects  = $this->loadModel('project')->getPairs();
        $this->view->users     = $this->loadModel('project')->getMemberPairs($projectID);
        $this->view->taskID    = $taskID;
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

        $task = $this->task->getByID($taskID);
        $this->checkPriv($task, 'edit');

        $this->view->title     = $this->lang->task->edit;
        $this->view->task      = $task;
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
        $this->checkPriv($task, 'view');

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
            $files = $this->loadModel('file')->saveUpload('task', $taskID);

            if(!empty($changes) or !empty($files))
            {
                $fileAction = '';
                if($files) $fileAction = $this->lang->addFiles . join(',', $files);

                $actionID = $this->loadModel('action')->create('task', $taskID, 'Finished', $fileAction .  ' ' . $this->post->comment);
                $this->action->logHistory($actionID, $changes);
            }

            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => $this->server->http_referer));
        }

        $task = $this->task->getByID($taskID);
        $this->checkPriv($task, 'finish');
        $status = 'finish';
        foreach($task->children as $child) if($child->status == 'wait' or $child->status == 'doing') $status = '';

        $this->view->title  = $status == 'finish' ? $task->name : $task->name . " <span class='label label-warning'>{$this->lang->task->children} {$this->lang->task->unfinished}</span>";
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
                if($this->post->left == '0') $this->send(array('result' => 'fail', 'confirm' => $this->lang->task->confirmFinish));
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

            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => $this->server->http_referer));
        }

        $task = $this->task->getByID($taskID);
        $this->checkPriv($task, 'start');

        $this->view->taskID = $taskID; 
        $this->view->task   = $task;
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

            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => $this->server->http_referer));
        }

        $task    = $this->task->getByID($taskID);
        $members = $this->loadModel('project')->getMemberPairs($task->project);
        $this->checkPriv($task, 'assignTo');

        /* Process team member and assignedTo data. */
        if($task->team != '')
        {
            $users = array();
            $team  = explode(',', trim($task->team, ','));
            foreach($team as $key => $account) $users[$account] = $members[$account];
            $task->assignedTo = $this->task->getNextUser($task->team, $task->assignedTo);
            if(!empty($users)) $members = $users;
        }

        $this->view->title  = $task->name;
        $this->view->taskID = $taskID;
        $this->view->task   = $task;
        $this->view->users  = $members;
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
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => $this->server->http_referer));
        }

        $task = $this->task->getByID($taskID);
        $this->checkPriv($task, 'activate');

        $this->view->title = $this->lang->task->activate;
        $this->view->task  = $task;
        $this->view->users = $this->loadModel('project')->getMemberPairs($task->project);
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
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => $this->server->http_referer));
        }
        $task = $this->task->getByID($taskID);
        $this->checkPriv($task, 'cancel');

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
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => $this->server->http_referer));
        }

        $task = $this->task->getByID($taskID);
        $this->checkPriv($task, 'close');

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
        $task = $this->task->getByID($taskID);
        $this->checkPriv($task, 'delete');

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
        $this->session->set('taskQueryCondition', $this->dao->get());

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
        $this->session->set('taskQueryCondition', $this->dao->get());

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

    /**
     * get data to export.
     * 
     * @param  int $projectID 
     * @param  string $orderBy 
     * @access public
     * @return void
     */
    public function export($mode, $projectID, $orderBy = 'id_desc')
    {
        if($_POST)
        {
            $taskLang   = $this->lang->task;
            $taskConfig = $this->config->task;

            /* Create field lists. */
            $fields = explode(',', $taskConfig->exportFields);
            foreach($fields as $key => $fieldName)
            {
                $fieldName = trim($fieldName);
                $fields[$fieldName] = isset($taskLang->$fieldName) ? $taskLang->$fieldName : $fieldName;
                unset($fields[$key]);
            }

            /* Get tasks. */
            $tasks = array();
            if($mode == 'all')
            {
                $taskQueryCondition = $this->session->taskQueryCondition;
                if(strpos($taskQueryCondition, 'limit') !== false) $taskQueryCondition = substr($taskQueryCondition, 0, strpos($taskQueryCondition, 'limit'));
                $stmt = $this->dbh->query($taskQueryCondition);
                while($row = $stmt->fetch()) $tasks[$row->id] = $row;
            }

            if($mode == 'thisPage')
            {
                $stmt = $this->dbh->query($this->session->taskQueryCondition);
                while($row = $stmt->fetch()) $tasks[$row->id] = $row;
            }

            /* Get users and projects. */
            $users    = $this->loadModel('user')->getPairs('noletter');
            $projects = $this->loadModel('project')->getPairs();

            $relatedFiles = $this->dao->select('id, objectID, pathname, title')->from(TABLE_FILE)->where('objectType')->eq('task')->andWhere('objectID')->in(@array_keys($tasks))->fetchGroup('objectID');

            foreach($tasks as $task)
            {
                $task->desc = htmlspecialchars_decode($task->desc);
                $task->desc = str_replace("<br />", "\n", $task->desc);
                $task->desc = str_replace('"', '""', $task->desc);

                if(isset($projects[$task->project]))                  $task->project      = $projects[$task->project] . "(#$task->project)";
                if(isset($taskLang->typeList[$task->type]))           $task->type         = $taskLang->typeList[$task->type];
                if(isset($taskLang->priList[$task->pri]))             $task->pri          = $taskLang->priList[$task->pri];
                if(isset($taskLang->statusList[$task->status]))       $task->status       = $taskLang->statusList[$task->status];
                if(isset($taskLang->reasonList[$task->closedReason])) $task->closedReason = $taskLang->reasonList[$task->closedReason];

                if(isset($users[$task->createdBy]))  $task->createdBy  = $users[$task->createdBy];
                if(isset($users[$task->assignedTo])) $task->assignedTo = $users[$task->assignedTo];
                if(isset($users[$task->finishedBy])) $task->finishedBy = $users[$task->finishedBy];
                if(isset($users[$task->canceledBy])) $task->canceledBy = $users[$task->canceledBy];
                if(isset($users[$task->closedBy]))   $task->closedBy   = $users[$task->closedBy];
                if(isset($users[$task->editedBy]))   $task->editedBy   = $users[$task->editedBy];

                $task->createdDate  = substr($task->createdDate,  0, 10);
                $task->assignedDate = substr($task->assignedDate, 0, 10);
                $task->finishedDate = substr($task->finishedDate, 0, 10);
                $task->canceledDate = substr($task->canceledDate, 0, 10);
                $task->closedDate   = substr($task->closedDate,   0, 10);
                $task->editedDate   = substr($task->editedDate,   0, 10);

                /* Set related files. */
                if(isset($relatedFiles[$task->id]))
                {
                    $task->files = '';
                    foreach($relatedFiles[$task->id] as $file)
                    {
                        $fileURL = 'http://' . $this->server->http_host . $this->config->webRoot . "data/upload/" . $file->pathname;
                        $task->files .= html::a($fileURL, $file->title, '_blank') . '<br />';
                    }
                }
            }

            $this->post->set('fields', $fields);
            $this->post->set('rows', $tasks);
            $this->post->set('kind', 'task');
            $this->fetch('file', 'export2CSV', $_POST);
        }

        $this->display();
    }

    /**
     * ajax get user tasks for todo. 
     * 
     * @param  string $account 
     * @param  string $id 
     * @access public
     * @return void
     */
    public function ajaxGetTodoList($account = '', $id = '')
    {
        if($account = '') $account = $this->app->user->account;
        $tasks = $this->task->getUserTaskPairs($account, 'wait,doing');
        if($id) die(html::select("idvalues[$id]", $tasks, '', 'class="form-control"'));
        die(html::select('idvalue', $tasks, '', 'class=form-control'));
    }

    /**
     * Check task privilege and locate project if no privilege. 
     * 
     * @param  object $task 
     * @param  string $action 
     * @access private
     * @return void
     */
    private function checkPriv($task, $action)
    {
        if(!$this->task->checkPriv($task, $action))
        {
            $locate = helper::safe64Encode($this->server->http_referer);
            $errorLink = helper::createLink('error', 'index', "type=accessLimited&locate={$locate}");
            $this->locate($errorLink);
        }
    }
}
