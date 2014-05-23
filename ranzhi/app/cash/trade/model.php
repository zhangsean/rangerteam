<?php
/**
 * The model file of trade module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     contact
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
class tradeModel extends model
{
    /**
     * Get trade by id.
     * 
     * @param  int    $id 
     * @access public
     * @return object
     */
    public function getByID($id)
    {
        return $this->dao->select('*')->from(TABLE_TRADE)->where('id')->eq($id)->limit(1)->fetch();
    }

    /** 
     * Get trade list.
     * 
     * @param  string  $orderBy 
     * @param  object  $pager 
     * @access public
     * @return array
     */
    public function getList($orderBy, $pager = null)
    {
        return $this->dao->select('*')->from(TABLE_TRADE)->orderBy($orderBy)->page($pager)->fetchAll('id');
    }

    /**
     * Create a trade.
     * 
     * @access public
     * @return int|bool
     */
    public function create()
    {
        $now = helper::now();
        $trade = fixer::input('post')
            ->add('createdBy', $this->app->user->account)
            ->add('createdDate', $now)
            ->add('editedDate', $now)
            ->get();

        $handler = $this->loadModel('user')->getByAccount($trade->handler);
        if($handler) $trade->dept = $handler->dept;

        $this->dao->insert(TABLE_TRADE)
            ->data($trade)
            ->autoCheck()
            ->batchCheck($this->config->trade->require->create, 'notempty')
            ->exec();

        return $this->dao->lastInsertID();
    }

    /**
     * Update a trade.
     * 
     * @param  int    $tradeID 
     * @access public
     * @return string|bool
     */
    public function update($tradeID)
    {
        $oldDepositor = $this->getByID($tradeID);

        $trade = fixer::input('post')
            ->removeIF($this->post->type == 'cash', 'public')
            ->get();

        $handler = $this->loadModel('user')->getByAccount($trade->handler);
        if($handler) $trade->dept = $handler->dept;


        $this->dao->update(TABLE_TRADE)->data($trade)->autoCheck()->where('id')->eq($tradeID)->exec();

        if(!dao::isError()) return commonModel::createChanges($oldDepositor, $trade);

        return false;
    }
}
