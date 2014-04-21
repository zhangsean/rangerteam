<?php
/**
 * The model file of customer module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     customer
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
class customerModel extends model
{
    /**
     * Get customer by id.
     * 
     * @param  int    $id 
     * @access public
     * @return int|bool
     */
    public function getByID($id)
    {
        return $this->dao->select('*')->from(TABLE_CUSTOMER)->where('id')->eq($id)->limit(1)->fetch();
    }

    /** 
     * Get customer list.
     * 
     * @param  string  $orderBy 
     * @param  object  $pager 
     * @access public
     * @return array
     */
    public function getList($orderBy = 'id_desc', $pager = null)
    {
        return $this->dao->select('*')->from(TABLE_CUSTOMER)->orderBy($orderBy)->page($pager)->fetchAll('id');
    }

    /** 
     * Get customer pairs.
     * 
     * @param  string  $orderBy 
     * @access public
     * @return array
     */
    public function getPairs($orderBy = 'id_desc', $emptyOption = true, $createOption = true)
    {
        $customers = $this->dao->select('id, name')->from(TABLE_CUSTOMER)->orderBy($orderBy)->fetchPairs('id');

        if($emptyOption)  $customers = array('' => '') + $customers;
        if($createOption) $customers = $customers + array('create' => $this->lang->customer->create);
        return $customers;
    }

    /**
     * Create a customer.
     * 
     * @access public
     * @return int|bool
     */
    public function create()
    {
        $customer = fixer::input('post')
            ->add('createdBy', $this->app->user->account)
            ->add('createdDate', helper::now())
            ->get();

        $this->dao->insert(TABLE_CUSTOMER)
            ->data($customer, $skip = 'uid, contact, email, qq, phone')
            ->autoCheck()
            ->batchCheck($this->config->customer->require->create, 'notempty')
            ->exec();

        $customerID = $this->dao->lastInsertID();

        $contact = new stdclass();
        $contact->customer = $customerID;
        $contact->realname = $customer->contact;
        $contact->phone    = $customer->phone;
        $contact->email    = $customer->email;
        $contact->qq       = $customer->qq;

        $this->dao->insert(TABLE_CONTACT)->data($contact)->autoCheck()->exec();

        if(dao::isError()) return false;

        return $customerID;
    }

    /**
     * Update a customer.
     * 
     * @param  int    $customerID 
     * @access public
     * @return bool
     */
    public function update($customerID)
    {
        $customer = fixer::input('post')
            ->add('editedBy', $this->app->user->account)
            ->add('editedDate', helper::now())
            ->get();

        $this->dao->update(TABLE_CUSTOMER)
            ->data($customer)
            ->autoCheck()
            ->batchCheck($this->config->customer->require->edit, 'notempty')
            ->where('id')->eq($customerID)
            ->exec();

        return !dao::isError();
    }

    /**
     * Delete a customer.
     *
     * @param  int      $customerID
     * @param  string   $table
     * @access public 
     * @return bool
     */
    public function delete($customerID, $table = null)
    {
        $this->dao->delete()->from(TABLE_CUSTOMER)->where('id')->eq($customerID)->exec();
        return !dao::isError();
    }
}
