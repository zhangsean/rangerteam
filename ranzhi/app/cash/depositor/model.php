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
    public function getList($orderBy = 'id_desc', $pager = null)
    {
        return $this->dao->select('*')->from(TABLE_DEPOSITOR)->orderBy($orderBy)->page($pager)->fetchAll('id');
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
}
