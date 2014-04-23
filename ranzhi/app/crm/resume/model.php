<?php
/**
 * The model file of resume module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     resume
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
class resumeModel extends model
{ 
    /**
     * Get by id.
     * 
     * @param  int    $resumeID 
     * @access public
     * @return object
     */
    public function getByID($resumeID)
    {
        return $this->dao->select('*')->from(TABLE_RESUME)->where('id')->eq($resumeID)->fetch();
    }

    /**
     * Get list.
     * 
     * @param  int    $contactID 
     * @access public
     * @return array
     */
    public function getList($contactID)
    {
        return $this->dao->select('*')->FROM(TABLE_RESUME)->where('contact')->eq($contactID)->orderBy('id')->fetchAll();
    }

    /**
     * Create resume. 
     * 
     * @param  int    $contactID 
     * @access public
     * @return int
     */
    public function create($contactID)
    {
        $contact = $this->loadModel('contact')->getByID($contactID);

        $resume = fixer::input('post')
            ->add('contact', $contactID)
            ->setDefault('join', '0000-00-00')
            ->setDefault('left', '0000-00-00')
            ->remove('newCustomer,type,size,status,level,name')
            ->get();

        if($this->post->newCustomer)
        {
            $customer = new stdclass();
            $customer->name        = $this->post->name;
            $customer->type        = $this->post->type;
            $customer->size        = $this->post->size;
            $customer->status      = $this->post->status;
            $customer->level       = $this->post->level;
            $customer->createdBy   = $this->app->user->account;
            $customer->createdDate = helper::now();
            $this->dao->insert(TABLE_CUSTOMER)->data($customer)->autoCheck()->batchCheck('name', 'notempty')->exec();

            if(dao::isError()) return false;
            $resume->customer = $this->dao->lastInsertID();
            $this->loadModel('action')->create('customer', $resume->customer, 'Created');
        }

        $this->dao->insert(TABLE_RESUME)->data($resume)
            ->autoCheck()
            ->batchCheck($this->config->resume->require->create, 'notempty')
            ->exec();

        if(!dao::isError())
        {
            $this->dao->update(TABLE_CONTACT)->set('customer')->eq($resume->customer)->where('id')->eq($contactID)->exec();
            return $this->dao->lastInsertID();
        }

        return false;
    }

    /**
     * Update resume.
     * 
     * @param  int    $resumeID 
     * @access public
     * @return string
     */
    public function update($resumeID)
    {
        $oldResume = $this->getByID($resumeID);
        $resume    = fixer::input('post')
            ->setDefault('dept', $oldResume->dept)
            ->setDefault('title', $oldResume->title)
            ->setDefault('join', $oldResume->join)
            ->setDefault('left', $oldResume->left)
            ->remove('newCustomer,type,size,status,level,name')
            ->get();

        $this->dao->update(TABLE_RESUME)->data($resume)->where('id')->eq($resumeID)->exec();

        return commonModel::createChanges($oldResume, $resume);
    }

    /**
     * Delete resume.
     * 
     * @param  int    $resumeID 
     * @param  string $table 
     * @access public
     * @return bool
     */
    public function delete($resumeID, $table = null)
    {
        $this->dao->delete()->from(TABLE_RESUME)->where('id')->eq($resumeID)->exec();
        return !dao::isError();
    }
}
