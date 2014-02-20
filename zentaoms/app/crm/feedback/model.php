<?php
/**
 * The model file of feedback module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     feedback
 * @version     $Id$
 * @link        http://www.zentao.net
 */
class feedbackModel extends model
{
    /**
     * Get issue by id. 
     * 
     * @param  int    $issueID 
     * @access public
     * @return object
     */
    public function getByID($issueID)
    {
        return $this->dao->select('*')->from(TABLE_ISSUE)->where('id')->eq($issueID)->fetch();
    }

    /**
     * Get issue list.
     * 
     * @param  string $orderBy 
     * @param  object $pager 
     * @access public
     * @return array
     */
    public function getList($orderBy = 'id_desc', $pager = null)
    {
        return $this->dao->select('*')->from(TABLE_ISSUE)
            ->orderBy($orderBy)
            ->page($pager)
            ->fetchAll();
    }

    /**
     * Create issue 
     * 
     * @access public
     * @return int
     */
    public function create()
    {
        $now   = helper::now();
        $issue = fixer::input('post')
            ->setForce('type', 'feedback')
            ->setForce('status', 'wait')
            ->add('addedBy', $this->app->user->account)
            ->add('addedDate', $now)
            ->get();

        if($issue->assignedTo)
        {
            $issue->assignedBy   = $this->app->user->account;
            $issue->assignedDate = $now;
        }

        $this->dao->insert(TABLE_ISSUE)->data($issue, 'uid')
            ->autoCheck()
            ->batchCheck($this->config->feedback->require->create, 'notempty')
            ->exec();

        return $this->dao->lastInsertId();
    }

    /**
     * Update issue. 
     * 
     * @param  int    $issueID 
     * @access public
     * @return bool
     */
    public function update($issueID)
    {
        $oldIssue = $this->getByID($issueID);
        $now      = helper::now();

        $data = fixer::input('post')
            ->add('editedBy', $this->app->user->account)
            ->add('editedDate', $now)
            ->remove('closedReason')
            ->get();

        if($data->assignedTo and $data->assignedTo != $oldIssue->assignedTo)
        {
            $data->assignedBy   = $this->app->user->account;
            $data->assignedDate = $now;
        }

        if($data->status == 'transfered' and $data->status != $oldIssue->status)
        {
            $data->transferedBy   = $this->app->user->account;
            $data->transferedDate = $now;
        }
        elseif($data->status == 'closed' and $data->status != $oldIssue->status)
        {
            $data->closedBy     = $this->app->user->account;
            $data->closedDate   = $now;
            $data->closedReason = $this->post->closedReason;
        }

        $this->dao->update(TABLE_ISSUE)->data($data, 'uid')
            ->batchCheck($this->config->feedback->require->edit, 'notempty')
            ->checkIF($data->status == 'closed', 'closedReason', 'notempty')
            ->where('id')->eq($issueID)
            ->exec();

        return !dao::isError();
    }

    /**
     * Reply issue. 
     * 
     * @param  int    $issueID 
     * @access public
     * @return bool
     */
    public function reply($issueID)
    {
        $data = new stdclass;
        $data->status      = 'replied';
        $data->repliedBy   = $this->app->user->account;
        $data->repliedDate = helper::now();

        $this->dao->update(TABLE_ISSUE)->data($data)->where('id')->eq($issueID)->exec();

        $this->loadModel('action')->create('feedback', $issueID, 'Replied', $this->post->reply);

        return !dao::isError();
    }

    /**
     * Doubt issue. 
     * 
     * @param  int    $issueID 
     * @access public
     * @return bool
     */
    public function doubt($issueID)
    {
        $this->dao->update(TABLE_ISSUE)->set('status')->eq('doubted')->where('id')->eq($issueID)->exec();

        $this->loadModel('action')->create('feedback', $issueID, 'Doubted', $this->post->doubt);

        return !dao::isError();
    }

    /**
     * Assign issue 
     * 
     * @param  int    $issueID 
     * @access public
     * @return bool
     */
    public function assignTo($issueID)
    {
        $data = new stdclass();
        $data->assignedTo = $this->post->assignedTo;

        if($data->assignedTo)
        {
            $data->assignedBy   = $this->app->user->account;
            $data->assignedDate = helper::now();
        }

        $this->dao->update(TABLE_ISSUE)->data($data)->where('id')->eq($issueID)->exec();

        return !dao::isError();
    }

    /**
     * Close issue. 
     * 
     * @param  int    $issueID 
     * @access public
     * @return bool
     */
    public function close($issueID)
    {
        $data = new stdclass();
        $data->closedReason = $this->post->closedReason;
        $data->closedBy     = $this->app->user->account;
        $data->closedDate   = helper::now();

        $this->dao->update(TABLE_ISSUE)->data($data)
            ->batchCheck($this->config->feedback->require->close, 'notempty')
            ->where('id')->eq($issueID)
            ->exec();

        return !dao::isError();
    }

    /**
     * Delete issue. 
     * 
     * @param  int    $issueID 
     * @param  int    $table 
     * @access public
     * @return void
     */
    public function delete($issueID, $table = null)
    {
        $this->dao->delete()->from(TABLE_ISSUE)->where('id')->eq($issueID)->exec();
        /* Remove action for this issue when delete it. */
        $this->dao->delete()->from(TABLE_ACTION)->where('objectType')->eq('feedback')->andWhere('objectID')->eq($issueID)->exec();
    }
}
