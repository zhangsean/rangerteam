<?php
/**
 * The model file of depositor module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     contact
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
class depositorModel extends model
{
    /**
     * Get depositor by id.
     * 
     * @param  int    $id 
     * @access public
     * @return object
     */
    public function getByID($id)
    {
        return $this->dao->select('*')->from(TABLE_DEPOSITOR)->where('id')->eq($id)->limit(1)->fetch();
    }

    /** 
     * Get depositor list.
     * 
     * @param  string  $orderBy 
     * @param  object  $pager 
     * @access public
     * @return array
     */
    public function getList($type, $orderBy = 'id_desc', $pager = null)
    {
        return $this->dao->select('*')->from(TABLE_DEPOSITOR)->where('type')->eq($type)->orderBy($orderBy)->page($pager)->fetchAll('id');
    }

    /**
     * Create a depositor.
     * 
     * @access public
     * @return int|bool
     */
    public function create()
    {
        $now = helper::now();
        $depositor = fixer::input('post')
            ->add('createdBy', $this->app->user->account)
            ->add('createdDate', $now)
            ->add('editedDate', $now)
            ->removeIF($this->post->type == 'cash', 'public')
            ->get();

        $this->dao->insert(TABLE_DEPOSITOR)->data($depositor)->autoCheck()->exec();

        return $this->dao->lastInsertID();
    }

    /**
     * Update a depositor.
     * 
     * @param  int    $depositorID 
     * @access public
     * @return string
     */
    public function update($depositorID)
    {
        $oldDepositor = $this->getByID($depositorID);

        $depositor = fixer::input('post')
            ->add('editedBy', $this->app->user->account)
            ->add('editedDate', helper::now())
            ->removeIF($this->post->type == 'cash', 'public')
            ->get();

        $this->dao->update(TABLE_DEPOSITOR)->data($depositor)->autoCheck()->where('id')->eq($depositorID)->exec();

        if(!dao::isError())
        {
            return commonModel::createChanges($oldDepositor, $depositor);
        }

        return false;
    }

    /**
     * Forbid a depositor.
     * 
     * @param  int    $depositorID 
     * @access public
     * @return bool
     */
    public function forbid($depositorID)
    {
        $this->dao->update(TABLE_DEPOSITOR)->set('status')->eq('disable')->where('id')->eq($depositorID)->exec();

        return dao::isError();
    }

    /**
     * Activate a depositor.
     * 
     * @param  int    $depositorID 
     * @access public
     * @return bool
     */
    public function activate($depositorID)
    {
        $this->dao->update(TABLE_DEPOSITOR)->set('status')->eq('normal')->where('id')->eq($depositorID)->exec();

        return dao::isError();
    }
}
