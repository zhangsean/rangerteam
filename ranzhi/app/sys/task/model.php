<?php
/**
 * The model file of task module of Ranzhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     task
 * @version     $Id$
 * @link        http://www.zentao.net
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
     * @param  string $orderBy 
     * @param  object $pager 
     * @access public
     * @return array
     */
    public function getList($orderBy = 'id_desc', $pager = null)
    {
        return $this->dao->select('*')->from(TABLE_TASK)
            ->where('deleted')->eq(0)
            ->orderBy($orderBy)
            ->page($pager)
            ->fetchAll('id');
    }

    /**
     * Create a task.
     * 
     * @access public
     * @return int|bool
     */
    public function create()
    {
        $task = fixer::input('post')
            ->setDefault('estimate, left', 0)
            ->setDefault('estStarted', '0000-00-00')
            ->setDefault('deadline', '0000-00-00')
            ->setDefault('status', 'wait')
            ->setIF($this->post->estimate != false, 'left', $this->post->estimate)
            ->setIF($this->post->assignedTo, 'assignedDate', helper::now())
            ->setForce('assignedTo', $this->post->assignedTo)
            ->setDefault('createdBy', $this->app->user->account)
            ->setDefault('createdDate', helper::now())
            ->get();

        $this->dao->insert(TABLE_TASK)->data($task, $skip = 'uid,files,labels')
            ->autoCheck()
            ->batchCheck($this->config->task->require->create, 'notempty')
            ->checkIF($task->estimate != '', 'estimate', 'float')
            ->checkIF($task->deadline != '0000-00-00', 'deadline', 'ge', $task->estStarted)
            ->exec();

        if(!dao::isError())
        {
            $taskID = $this->dao->lastInsertID();

            $this->loadModel('file')->saveUpload('task', $taskID);

            return $taskID;
        }

        return false;
    }

    /**
     * Update a task.
     * 
     * @param  int    $taskID 
     * @access public
     * @return void
     */
    public function update($taskID)
    {
        $oldTask = $this->getById($taskID);
        $now     = helper::now();
        $task    = fixer::input('post')
            ->setDefault('estimate, left, consumed', 0)
            ->setDefault('deadline', '0000-00-00')

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
            ->setIF($this->post->status == 'closed' and !$this->post->closedBy,     'closedBy',     $this->app->user->account)
            ->setIF($this->post->status == 'closed' and !$this->post->closedDate,   'closedDate',   $now)
            ->setIF($this->post->consumed > 0 and $this->post->left > 0 and $this->post->status == 'wait', 'status', 'doing')

            ->setIF($this->post->assignedTo != $oldTask->assignedTo, 'assignedDate', $now)

            ->setIF($this->post->status == 'wait' and $this->post->left == $oldTask->left and $this->post->consumed == 0, 'left', $this->post->estimate)

            ->add('editedBy',   $this->app->user->account)
            ->add('editedDate', $now)
            ->remove('uid, files, labels')
            ->get();

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

        if(!dao::isError())
        {
            $this->loadModel('file')->saveUpload('task', $taskID);
            return commonModel::createChanges($oldTask, $task);
        }

        return false;
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
        $task    = fixer::input('post')
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

        return !dao::isError();
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
        $task = fixer::input('post')
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

        return !dao::isError();
    }
}
