<?php
/**
 * The model file of task module of RanZhi.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv11.html)
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
        $task     = $this->dao->select('*')->from(TABLE_TASK)->where('id')->eq($taskID)->limit(1)->fetch();
        $children = $this->dao->select('*')->from(TABLE_TASK)->where('parent')->eq($taskID)->fetchAll('id');

        foreach($task as $key => $value) if(strpos($key, 'Date') !== false and !(int)substr($value, 0, 4)) $task->$key = '';

        if($task) 
        {
            $task->files = $this->loadModel('file')->getByObject('task', $taskID);
            $task->children = $children;
        }

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
    public function getList($projectID = 0, $mode = 'all', $orderBy = 'id_desc', $pager = null, $groupBy = 'id')
    {
        if($this->session->taskQuery == false) $this->session->set('taskQuery', ' 1 = 1');
        $taskQuery = $this->loadModel('search', 'sys')->replaceDynamic($this->session->taskQuery);

        if(strpos($orderBy, 'id') === false) $orderBy .= ', id_desc';

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
        
        if($groupBy == 'id') $taskList = $this->dao->fetchAll('id');
        if($groupBy != 'id') $taskList = $this->dao->fetchGroup($groupBy);

        /* Process childen task. */
        if($groupBy == 'id') 
        {
            foreach($taskList as $key => $task)
            {
                if(!isset($task->children)) $task->children = array();
                if($task->parent != 0 and isset($taskList[$task->parent])) 
                {
                    $taskList[$task->parent]->children[$key] = $task;
                    unset($taskList[$key]);
                }
            } 
        }
        if($groupBy != 'id') 
        {
            foreach($taskList as $groupKey => $tasks)
            {
                $children = array();
                $done     = array();
                foreach($tasks as $task) if($task->parent != 0) $children[$task->parent][$task->id] = $task;
                foreach($tasks as $task)
                {
                    $task->children = array();
                    if(isset($children[$task->id])) 
                    {
                        $task->children = $children[$task->id];
                        $done += $children[$task->id];
                    }
                }
                foreach($tasks as $taskKey => $task) if(isset($done[$task->id])) unset($taskList[$groupKey][$taskKey]);
            }
        }

        return $taskList;
    }
    
    /**
     * Get tasks of a project.
     * 
     * @param  int    $projectID 
     * @param  string $type       all|wait|doing|done|cancel
     * @param  object $pager 
     * @access public
     * @return array
     */
    public function getProjectTasks($projectID, $type = 'all', $orderBy = 'status_asc, id_desc', $pager = null)
    {
        if(is_string($type)) $type = strtolower($type);

        $tasks = $this->dao->select('*')
            ->from(TABLE_TASK)
            ->where('project')->eq((int)$projectID)
            ->andWhere('deleted')->eq(0)
            ->beginIF($type == 'undone')->andWhere("(status = 'wait' or status ='doing')")->fi()
            ->beginIF($type == 'assignedtome')->andWhere('assignedTo')->eq($this->app->user->account)->fi()
            ->beginIF($type == 'finishedbyme')->andWhere('finishedby')->eq($this->app->user->account)->fi()
            ->beginIF($type == 'delayed')->andWhere('deadline')->between('1970-1-1', helper::now())->andWhere('status')->in('wait,doing')->fi()
            ->beginIF(is_array($type) or strpos(',all,undone,assignedtome,delayed,finishedbyme,', ",$type,") === false)->andWhere('status')->in($type)->fi()
            ->orderBy($orderBy)
            ->page($pager)
            ->fetchAll('id');

        if($tasks) return $tasks;
        return array();
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
            $task->parent      = empty($this->post->parent[$key]) ? 0 : $this->post->parent[$key];

            /* Process team. */
            if(isset($_POST['team'][$key]))
            {
                $team = $this->post->team[$key];
                foreach($team as $key => $account) if($account == '') unset($team[$key]);
                if(!isset($team[$assignedTo]) and !empty($team)) array_unshift($team, $assignedTo);
                $task->team = join(',', $team);
            }

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
                ->join('team', ',')
                ->setDefault('team', '')
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
            ->remove('files,labels')
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
            ->setDefault('assignedTo', 'closed')
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
     * @param  string $print 
     * @access public
     * @return string
     */
    public function buildOperateMenu($task, $class = '', $type = 'browse', $print = true)
    {
        $menu  = $type == 'view' ? "<div class='btn-group'>" : '';

        $disabled = self::isClickable($task, 'assignto') ? '' : 'disabled';
        $multiple = $task->team == '' ? false : true;
        $misc     = $disabled ? "class='$disabled $class'" : "data-toggle='modal' class='$class'";
        $link     = $disabled ? '###' : helper::createLink('task', 'assignto', "taskID=$task->id");
        $menu    .= commonModel::printLink('task', 'assignto', "taskID=$task->id", $multiple ? $this->lang->task->transmit : $this->lang->assign, $misc, false);

        $disabled = self::isClickable($task, 'start') ? '' : 'disabled';
        $misc     = $disabled ? "class='$disabled $class'" : "data-toggle='modal' class='$class'";
        $link     = $disabled ? '###' : helper::createLink('task', 'start', "taskID=$task->id");
        $menu    .= commonModel::printLink('task', 'start', "taskID=$task->id", $this->lang->start, $misc, false);

        if($type == 'view')
        {
            $disabled = self::isClickable($task, 'activate') ? '' : 'disabled';
            $misc     = $disabled ? "class='$disabled $class'" : "data-toggle='modal' class='$class'";
            $link     = $disabled ? '###' : helper::createLink('task', 'activate', "taskID=$task->id");
            $menu    .= commonModel::printLink('task', 'activate', "taskID=$task->id", $this->lang->activate, $misc, false);
        }

        $disabled = self::isClickable($task, 'finish') ? '' : 'disabled';
        $misc     = $disabled ? "class='$disabled $class'" : "data-toggle='modal' class='$class'";
        $link     = $disabled ? '###' : helper::createLink('task', 'finish', "taskID=$task->id");
        $menu    .= commonModel::printLink('task', 'finish', "taskID=$task->id", $this->lang->finish, $misc, false);

        if($type == 'view')
        {
            $disabled = self::isClickable($task, 'cancel') ? '' : 'disabled';
            $misc     = $disabled ? "class='$disabled $class'" : "data-toggle='modal' class='$class'";
            $link     = $disabled ? '###' : helper::createLink('task', 'cancel', "taskID=$task->id");
            $menu    .= commonModel::printLink('task', 'cancel', "taskID=$task->id", $this->lang->cancel, $misc, false);
        }

        $disabled = self::isClickable($task, 'close') ? '' : 'disabled';
        $misc     = $disabled ? "class='$disabled $class'" : "data-toggle='modal' class='$class'";
        $link     = $disabled ? '###' : helper::createLink('task', 'close', "taskID=$task->id");
        $menu    .= commonModel::printLink('task', 'close', "taskID=$task->id", $this->lang->close, $misc, false);

        if($type == 'view') $menu .= "</div><div class='btn-group'>";
        $menu .= commonModel::printLink('task', 'edit', "taskID=$task->id", $this->lang->edit, "class='$class'", false);
        $deleter = $type == 'browse' ? 'reloadDeleter' : 'deleter';
        $menu   .= commonModel::printLink('task', 'delete', "taskID=$task->id", $this->lang->delete, "class='$deleter $class'", false);
        if($type == 'view') $menu .= "</div>";

        if($task->parent == 0)
        {
            $disabled = self::isClickable($task, 'batchCreate') ? '' : 'disabled';
            $misc     = $disabled ? "class='$disabled $class'" : "data-toggle='modal' class='$class' data-width='80%'";
            $menu    .= commonModel::printLink('task', 'batchCreate', "projectID=$task->project&taskID=$task->id", $this->lang->task->children, $misc, false);
        }

        if($task->parent != 0 and $type == 'view')
        {
            $disabled = self::isClickable($task, 'view') ? '' : 'disabled';
            $misc     = $disabled ? "class='$disabled $class'" : "class='$class'";
            $menu    .= commonModel::printLink('task', 'view', "taskID=$task->parent", $this->lang->task->parent, $misc, false);
        }

        if($print) echo $menu;
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

    /**
     * Get next user. 
     * 
     * @param  string $users 
     * @param  string $currentUser 
     * @access public
     * @return void
     */
    public function getNextUser($users, $current)
    {
        /* Process user */
        if(!is_array($users)) $users = explode(',', trim($users, ','));
        if(!$current) return reset($users);
        $hit  = false;
        $next = '';
        foreach($users as $key => $account)
        {
            if($hit)
            {
                $next = $account;
                break;
            }

            if($account == $current) $hit = true;
        }
        if($next == '') return reset($users);
        return $next;
    }
}
