<?php
/**
 * The model file of task module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     task
 * @version     $Id$
 * @link        http://www.ranzhico.com
 */
class taskModel extends model
{
    /**
     * Get task by ID.
     * 
     * @param  int    $taskID 
     * @access public
     * @return object.
     */
    public function getByID($taskID)
    {
        $task = $this->dao->select('*')->from(TABLE_TASK)->where('id')->eq($taskID)->limit(1)->fetch();

        foreach($task as $key => $value) if(strpos($key, 'Date') !== false and !(int)substr($value, 0, 4)) $task->$key = '';

        if($task) $task->files = $this->loadModel('file')->getByObject('task', $taskID);

        return $task;
    }

    /**
     * Get task list.
     * 
     * @param  int       $projectID 
     * @param  string    $mode
     * @param  string    $orderBy 
     * @param  object    $pager 
     * @param  string    $groupBy
     * @access public
     * @return array
     */
    public function getList($projectID = 0, $mode = null, $orderBy = 'id_desc', $pager = null, $groupBy = 'id')
    {
        if($this->session->taskQuery == false) $this->session->set('taskQuery', ' 1 = 1');
        $taskQuery = $this->loadModel('search', 'sys')->replaceDynamic($this->session->taskQuery);

        $this->dao->select('*')->from(TABLE_TASK)
            ->where('deleted')->eq(0)
            ->beginIF($projectID)->andWhere('project')->eq($projectID)->fi()
            ->beginIF($mode == 'createdBy')->andWhere('createdBy')->eq($this->app->user->account)->fi()
            ->beginIF($mode == 'assignedTo')->andWhere('assignedTo')->eq($this->app->user->account)->fi()
            ->beginIF($mode == 'finishedBy')->andWhere('finishedBy')->eq($this->app->user->account)->fi()
            ->beginIF($mode == 'untilToday')->andWhere('deadline')->eq(helper::today())->fi()
            ->beginIF($mode == 'expired')->andWhere('deadline')->ne('0000-00-00')->andWhere('deadline')->lt(helper::today())->fi()
            ->beginIF($mode == 'bysearch')->andWhere($taskQuery)->fi()
            ->beginIF($groupBy == 'closedBy')->andWhere('status')->eq('closed')->fi()
            ->beginIF($groupBy == 'finishedBy')->andWhere('finishedBy')->ne('')->fi()
            ->orderBy($orderBy)
            ->page($pager);
        
        if($groupBy == 'id') return $this->dao->fetchAll('id');
        if($groupBy != 'id') return $this->dao->fetchGroup($groupBy);
    }

    /**
     * Fix task groups.
     * 
     * @param  array    $tasks 
     * @param  string   $groupBy 
     * @access public
     * @return void
     */
    public function fixTaskGroups($project, $tasks, $groupBy)
    {
        $taskGroups = array();
        if($groupBy == 'status')
        {
            foreach($this->lang->task->statusList as $status => $statusName) if(!empty($status) and !isset($tasks[$status])) $tasks[$status] = array();
            foreach($this->lang->task->statusList as $status => $statusName) if(!empty($status)) $taskGroups[$status] = $tasks[$status];
        }

        if($groupBy != 'status' and !empty($project->members))
        {
            foreach($project->members as $member) if(!isset($tasks[$member])) $tasks[$member] = array();

            foreach($tasks as $groupKey => $task)
            {
                if($groupKey == '') $taskGroups[''] = $tasks[''];
                foreach($project->members as $member) $taskGroups[$member] = $tasks[$member];
                if(!in_array($groupKey, $project->members)) $taskGroups[$groupKey] = $tasks[$groupKey];
            }
        }

        if(!empty($taskGroups)) return $taskGroups;
        return $tasks;
    }

    /**
     * Create a task.
     * 
     * @param  object    $task 
     * @access public
     * @return void
     */
    public function create($task = null)
    {
        $now  = helper::now();
        if(empty($task))
        {
            $task = fixer::input('post')
                ->setDefault('estimate, left', 0)
                ->setDefault('estStarted', '0000-00-00')
                ->setDefault('deadline', '0000-00-00')
                ->setDefault('status', 'wait')
                ->setIF($this->post->estimate != false, 'left', $this->post->estimate)
                ->setIF($this->post->assignedTo, 'assignedDate', $now)
                ->setForce('assignedTo', $this->post->assignedTo)
                ->setDefault('createdBy', $this->app->user->account)
                ->setDefault('createdDate', $now)
                ->specialChars('name')
                ->stripTags('desc', $this->config->allowedTags->admin)
                ->get();
        }

        $this->dao->insert(TABLE_TASK)->data($task, $skip = 'uid,files,labels')
            ->autoCheck()
            ->batchCheck($this->config->task->require->create, 'notempty')
            ->checkIF($task->estimate != '', 'estimate', 'float')
            ->checkIF($task->deadline != '0000-00-00', 'deadline', 'ge', $task->estStarted)
            ->exec();

        if(dao::isError()) return false;

        $taskID = $this->dao->lastInsertID();
        $this->loadModel('file')->saveUpload('task', $taskID);
        return $taskID;
    }

    /**
     * Batch create.
     * 
     * @param  int    $projectID 
     * @access public
     * @return array
     */
    public function batchCreate($projectID)
    {
        $now        = helper::now();
        $assignedTo = '';
        $tasks      = array();

        /* Get data. */
        foreach($this->post->name as $key => $name)
        {
            if(empty($name)) break;

            $assignedTo = $this->post->assignedTo[$key] == 'ditto' ? $assignedTo : $this->post->assignedTo[$key];

            $task = new stdclass();
            $task->project     = $projectID;
            $task->name        = htmlspecialchars($name);
            $task->assignedTo  = $assignedTo;
            $task->estimate    = (float)$this->post->estimate[$key];
            $task->left        = $task->estimate;
            $task->deadline    = $this->post->deadline[$key] ? $this->post->deadline[$key] : '0000-00-00';
            $task->desc        = strip_tags(nl2br($this->post->desc[$key]), $this->config->allowedTags->admin);
            $task->pri         = $this->post->pri[$key];
            $task->status      = 'wait';
            $task->createdBy   = $this->app->user->account;
            $task->createdDate = $now;

            if($task->assignedTo) $task->assignedDate = $now;

            $tasks[] = $task;
        }

        $taskIDList = array();
        foreach($tasks as $task)
        {
            $this->dao->insert(TABLE_TASK)->data($task)->autoCheck()->exec();
            if(!dao::isError()) $taskIDList[] = $this->dao->lastInsertID();
        }

        return $taskIDList;
    }

    /**
     * Update a task.
     * 
     * @param  int       $taskID 
     * @param  object    $task
     * @access public
     * @return void
     */
    public function update($taskID, $task = null)
    {
        $oldTask = $this->getById($taskID);
        $now     = helper::now();
        if(!$task)
        {
            $task = fixer::input('post')
                ->setDefault('estimate, left, consumed', 0)
                ->setDefault('deadline,estStarted,realStarted', '0000-00-00')

                ->setIF($this->post->status == 'done', 'left', 0)
                ->setIF($this->post->status == 'done', 'canceledBy', '')
                ->setIF($this->post->status == 'done', 'canceledDate', '')
                ->setIF($this->post->status == 'done'   and !$this->post->finishedBy,   'finishedBy',   $this->app->user->account)
                ->setIF($this->post->status == 'done'   and !$this->post->finishedDate, 'finishedDate', $now)

                ->setIF($this->post->status == 'cancel' and !$this->post->canceledBy,   'canceledBy',   $this->app->user->account)
                ->setIF($this->post->status == 'cancel' and !$this->post->canceledDate, 'canceledDate', $now)
                ->setIF($this->post->status == 'cancel', 'assignedTo',   $oldTask->createdBy)
                ->setIF($this->post->status == 'cancel', 'assignedDate', $now)

                ->setIF($this->post->status == 'closed', 'finishedBy', '')
                ->setIF($this->post->status == 'closed', 'finishedDate', '')
                ->setIF($this->post->status == 'closed' and !$this->post->closedBy,   'closedBy',   $this->app->user->account)
                ->setIF($this->post->status == 'closed' and !$this->post->closedDate, 'closedDate', $now)

                ->setIF($this->post->status == 'wait' and $this->post->left == $oldTask->left and $this->post->consumed == 0, 'left', $this->post->estimate)

                ->setIF($this->post->consumed > 0 and $this->post->left > 0 and $this->post->status == 'wait', 'status', 'doing')
                ->setIF($this->post->assignedTo != $oldTask->assignedTo, 'assignedDate', $now)

                ->add('editedBy',   $this->app->user->account)
                ->add('editedDate', $now)
                ->specialChars('name')
                ->stripTags('desc', $this->config->allowedTags->admin)
                ->remove('referer, uid, files, labels')
                ->join('mailto', ',')
                ->get();
        }
        $this->dao->update(TABLE_TASK)->data($task)
            ->autoCheck()
            ->batchCheckIF($task->status != 'cancel', $this->config->task->require->edit, 'notempty')

            ->checkIF($task->estimate != false, 'estimate', 'float')
            ->checkIF($task->left     != false, 'left',     'float')
            ->checkIF($task->consumed != false, 'consumed', 'float')
            ->checkIF($task->status   != 'wait' and $task->left == 0 and $task->status != 'cancel' and $task->status != 'closed', 'status', 'equal', 'done')

            ->batchCheckIF($task->status == 'wait' or $task->status == 'doing', 'finishedBy, finishedDate,canceledBy, canceledDate, closedBy, closedDate, closedReason', 'empty')

            ->checkIF($task->status == 'done', 'consumed', 'notempty')
            ->checkIF($task->status == 'done' and $task->closedReason, 'closedReason', 'equal', 'done')
            ->batchCheckIF($task->status == 'done', 'canceledBy, canceledDate', 'empty')

            ->checkIF($task->status == 'closed', 'closedReason', 'notempty')
            ->batchCheckIF($task->closedReason == 'cancel', 'finishedBy, finishedDate', 'empty')
            ->where('id')->eq((int)$taskID)
            ->exec();
        if(dao::isError()) return false;
        return commonModel::createChanges($oldTask, $task);
    }

    /**
     * Finish task.
     * 
     * @param  int    $taskID 
     * @access public
     * @return bool
     */
    public function finish($taskID)
    {
        $oldTask = $this->getById($taskID);
        $now     = helper::now();

        $task = fixer::input('post')
            ->setDefault('left', 0)
            ->setDefault('assignedTo',   $oldTask->createdBy)
            ->setDefault('assignedDate', $now)
            ->setDefault('status', 'done')
            ->setDefault('finishedBy, editedBy', $this->app->user->account)
            ->setDefault('finishedDate, editedDate', $now) 
            ->get();

        $this->dao->update(TABLE_TASK)
            ->data($task, $skip = 'uid, comment')
            ->autoCheck()
            ->check('consumed', 'notempty')
            ->where('id')->eq((int)$taskID)
            ->exec();

        if(!dao::isError()) return commonModel::createChanges($oldTask, $task);
    }

    /**
     * Start a task.
     * 
     * @param  int      $taskID 
     * @access public
     * @return void
     */
    public function start($taskID)
    {
        $oldTask = $this->getById($taskID);
        $now  = helper::now();
        $task = fixer::input('post')
            ->setDefault('assignedTo', $this->app->user->account)
            ->setDefault('editedBy', $this->app->user->account)
            ->setDefault('editedDate', $now) 
            ->setIF($oldTask->assignedTo != $this->app->user->account, 'assignedDate', $now)
            ->get();

        if($this->post->left == 0)
        {
            $task->status       = 'done'; 
            $task->finishedBy   = $this->app->user->account;
            $task->finishedDate = helper::now();
        }
        else
        {
            $task->status = 'doing';
        }

        $this->dao->update(TABLE_TASK)->data($task, $skip = 'uid,comment,doStart')
            ->autoCheck()
            ->check('consumed,left', 'float')
            ->checkIF($this->post->consumed < $oldTask->consumed, 'consumed', 'ge', $this->lang->task->consumedBefore)
            ->where('id')->eq((int)$taskID)
            ->exec();

        if(!dao::isError()) return commonModel::createChanges($oldTask, $task);
    }

    /**
     * Assign a task to a user again.
     * 
     * @param  int    $taskID 
     * @access public
     * @return void
     */
    public function assign($taskID)
    {
        $oldTask = $this->getById($taskID);
        $task    = fixer::input('post')
            ->cleanFloat('left')
            ->setDefault('editedBy', $this->app->user->account)
            ->setDefault('editedDate', helper::now())
            ->get();

        $this->dao->update(TABLE_TASK)
            ->data($task, $skip = 'uid, comment')
            ->autoCheck()
            ->check('left', 'float')
            ->where('id')->eq($taskID)
            ->exec();

        if(!dao::isError()) return commonModel::createChanges($oldTask, $task);
    }

    /**
     * Activate task. 
     * 
     * @param  int    $taskID 
     * @access public
     * @return array
     */
    public function activate($taskID)
    {
        $oldTask = $this->getById($taskID);
        $task    = fixer::input('post')
            ->cleanFloat('left')
            ->setDefault('status', 'doing')
            ->setDefault('finishedBy, canceledBy, closedBy, closedReason', '')
            ->setDefault('finishedDate, canceledDate, closedDate', '0000-00-00 00:00:00')
            ->setDefault('editedBy', $this->app->user->account)
            ->setDefault('editedDate', helper::now())
            ->get();

        $this->dao->update(TABLE_TASK)
            ->data($task, $skip = 'uid,comment')
            ->autoCheck()
            ->check('left', 'float')
            ->where('id')->eq($taskID)
            ->exec();

        if(!dao::isError()) return commonModel::createChanges($oldTask, $task);
    }

    /**
     * Cancel task. 
     * 
     * @param  int    $taskID 
     * @access public
     * @return array
     */
    public function cancel($taskID)
    {
        $oldTask = $this->getById($taskID);
        $now     = helper::now();
        $task = fixer::input('post')
            ->setDefault('status', 'cancel')
            ->setDefault('assignedTo', $oldTask->createdBy)
            ->setDefault('assignedDate', $now)
            ->setDefault('finishedBy', '')
            ->setDefault('finishedDate', '0000-00-00')
            ->setDefault('canceledBy, editedBy', $this->app->user->account)
            ->setDefault('canceledDate, editedDate', $now)
            ->get();

        $this->dao->update(TABLE_TASK)->data($task, 'uid,comment')->autoCheck()->where('id')->eq((int)$taskID)->exec();

        if(!dao::isError()) return commonModel::createChanges($oldTask, $task);
    }

    /**
     * Close task. 
     * 
     * @param  int    $taskID 
     * @access public
     * @return array
     */
    public function close($taskID)
    {
        $oldTask = $this->getById($taskID);
        $now     = helper::now();
        $task = fixer::input('post')
            ->setDefault('status', 'closed')
            ->setDefault('assignedTo', $oldTask->createdBy)
            ->setDefault('assignedDate', $now)
            ->setDefault('closedBy, editedBy', $this->app->user->account)
            ->setDefault('closedDate, editedDate', $now)
            ->setIF($oldTask->status == 'done',   'closedReason', 'done')
            ->setIF($oldTask->status == 'cancel', 'closedReason', 'cancel')
            ->get();

        $this->dao->update(TABLE_TASK)->data($task, 'uid,comment')->autoCheck()->where('id')->eq((int)$taskID)->exec();

        if(!dao::isError()) return commonModel::createChanges($oldTask, $task);
    }

    /**
     * Check clickable for action.
     * 
     * @param  object    $task 
     * @param  string    $action 
     * @static
     * @access public
     * @return bool
     */
    public static function isClickable($task, $action)
    {
        $action = strtolower($action);  

        if($action == 'assignto') return $task->status != 'closed' and $task->status != 'cancel';
        if($action == 'start')    return $task->status != 'doing'  and $task->status != 'closed' and $task->status != 'cancel';
        if($action == 'finish')   return $task->status != 'done'   and $task->status != 'closed' and $task->status != 'cancel';
        if($action == 'close')    return $task->status == 'done'   or  $task->status == 'cancel';  
        if($action == 'activate') return $task->status == 'done'   or  $task->status == 'closed'  or $task->status == 'cancel' ;  
        if($action == 'cancel')   return $task->status != 'done  ' and $task->status != 'closed' and $task->status != 'cancel';

        return true;
    }

    /**
     * Build operate menu.
     * 
     * @param  object $task 
     * @param  string $class 
     * @param  string $type 
     * @access public
     * @return string
     */
    public function buildOperateMenu($task, $class = '', $type = 'browse')
    {
        $menu  = $type == 'view' ? "<div class='btn-group'>" : '';

        $disabled = self::isClickable($task, 'assignto') ? '' : 'disabled';
        $misc     = $disabled ? "class='$disabled $class'" : "data-toggle='modal' class='$class'";
        $link     = $disabled ? '###' : helper::createLink('task', 'assignto', "taskID=$task->id");
        $menu    .= html::a($link, $this->lang->assign, $misc);

        $disabled = self::isClickable($task, 'start') ? '' : 'disabled';
        $misc     = $disabled ? "class='$disabled $class'" : "data-toggle='modal' class='$class'";
        $link     = $disabled ? '###' : helper::createLink('task', 'start', "taskID=$task->id");
        $menu    .= html::a($link, $this->lang->start, $misc);

        if($type == 'view')
        {
            $disabled = self::isClickable($task, 'activate') ? '' : 'disabled';
            $misc     = $disabled ? "class='$disabled $class'" : "data-toggle='modal' class='$class'";
            $link     = $disabled ? '###' : helper::createLink('task', 'activate', "taskID=$task->id");
            $menu    .= html::a($link, $this->lang->activate, $misc);
        }

        $disabled = self::isClickable($task, 'finish') ? '' : 'disabled';
        $misc     = $disabled ? "class='$disabled $class'" : "data-toggle='modal' class='$class'";
        $link     = $disabled ? '###' : helper::createLink('task', 'finish', "taskID=$task->id");
        $menu    .= html::a($link, $this->lang->finish, $misc);

        if($type == 'view')
        {
            $disabled = self::isClickable($task, 'cancel') ? '' : 'disabled';
            $misc     = $disabled ? "class='$disabled $class'" : "data-toggle='modal' class='$class'";
            $link     = $disabled ? '###' : helper::createLink('task', 'cancel', "taskID=$task->id");
            $menu    .= html::a($link, $this->lang->cancel, $misc);
        }

        $disabled = self::isClickable($task, 'close') ? '' : 'disabled';
        $misc     = $disabled ? "class='$disabled $class'" : "data-toggle='modal' class='$class'";
        $link     = $disabled ? '###' : helper::createLink('task', 'close', "taskID=$task->id");
        $menu    .= html::a($link, $this->lang->close, $misc);

        if($type == 'view') $menu .= "</div><div class='btn-group'>";
        $menu .= html::a(helper::createLink('task', 'edit', "taskID=$task->id"), $this->lang->edit, "class='$class'");
        $deleter = $type == 'browse' ? 'reloadDeleter' : 'deleter';
        $menu   .= html::a(helper::createLink('task', 'delete', "taskID=$task->id"), $this->lang->delete, "class='$deleter $class'");
        if($type == 'view') $menu .= "</div>";

        return $menu;
    }

    /**
     * Save data from mind.
     * 
     * @param  int    $changes 
     * @access public
     * @return void
     */
    public function saveMind($changes)
    {
        $newTasks     = array();
        $updatedTasks = array();
        foreach($changes as $task)
        {
            $task->estimate     = false;
            $task->left         = false;
            $task->closedReason = false;
            if(empty($task->deadline)) $task->deadline = '0000-00-00';
            if(empty($task->consumed)) $task->consumed = '0';

            if($task->change == 'add')  $newTasks[] = $task;
            if($task->change == 'edit') $updatedTasks[] = $task;
        }
        a($newTasks);

        foreach($newTasks as $task)
        {
            unset($task->id);
            unset($task->change);
            $task->createdBy   = $this->app->user->account;
            $task->createdDate = helper::now();
            $this->create($task);
        }
        
        foreach($updatedTasks as $task)
        {
            unset($task->change);
            $task->editedBy   = $this->app->user->account;
            $task->editedDate = helper::now();
            $this->update($task->id, $task);
        }
        return !dao::isError();
    }

}
