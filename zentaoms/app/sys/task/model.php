<?php
/**
 * The model file of task module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
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
        return $this->dao->select('*')->from(TABLE_TASK)->where('id')->eq($taskID)->limit(1)->fetch();
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
     * Update a task.
     * 
     * @param  int   $taskID 
     * @access public
     * @return void
     */
    public function update($taskID)
    {
        $task = fixer::input('post')
            ->add('lastEditedBy', $this->app->user->account)
            ->add('lastEditedDate', helper::now())
            ->setDefault('deleted', 0)
            ->get();

        $this->dao->update(TABLE_TASK)
            ->data($task)
            ->autoCheck()
            ->where('id')->eq($taskID)
            ->exec();

        return !dao::isError();
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
        $task = fixer::input('post')
            ->add('finishedBy', $this->app->user->account)
            ->add('status', 'done')
            ->get();

        $this->dao->update(TABLE_TASK)->data($task)->autoCheck()->where('id')->eq($taskID)->exec();

        return !dao::isError();
    }

    /**
     * Assign to others.
     * 
     * @param  int    $taskID 
     * @access public
     * @return void
     */
    public function assignTo($taskID)
    {
        $task = fixer::input('post')->add('assignedDate', helper::now())->get();

        $this->dao->update(TABLE_TASK)->data($task)->autoCheck()->where('id')->eq($taskID)->exec();

        return !dao::isError();
    }
}
