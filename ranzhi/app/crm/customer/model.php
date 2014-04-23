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
        return $this->dao->select('*')->from(TABLE_CUSTOMER)
            ->where('deleted')->eq(0)
            ->orderBy($orderBy)
            ->page($pager)
            ->fetchAll('id');
    }

    /** 
     * Get customer pairs.
     * 
     * @param  string $orderBy 
     * @param  int    $emptyOption 
     * @access public
     * @return void
     */
    public function getPairs($orderBy = 'id_desc', $emptyOption = true)
    {
        $customers = $this->dao->select('id, name')->from(TABLE_CUSTOMER)
            ->where('deleted')->eq(0)
            ->orderBy($orderBy)
            ->fetchPairs('id');

        if($emptyOption)  $customers = array('' => '') + $customers;
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

        if(dao::isError()) return false;
        $customerID = $this->dao->lastInsertID();

        $contact = new stdclass();
        $contact->customer = $customerID;
        $contact->realname = $customer->contact;
        $contact->phone    = $customer->phone;
        $contact->email    = $customer->email;
        $contact->qq       = $customer->qq;

        $this->dao->insert(TABLE_CONTACT)->data($contact)->autoCheck()->exec();

        if(dao::isError()) return false;

        $contactID = $this->dao->lastInsertID();
        $this->loadModel('action')->create('contact', $contactID, 'Created');

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
        $oldCustomer = $this->getByID($customerID);
        $customer    = fixer::input('post')
            ->add('editedBy', $this->app->user->account)
            ->add('editedDate', helper::now())
            ->get();

        /* Add http:// in head when that has not http:// or https://. */
        if(strpos($customer->site, '://') === false )  $customer->site  = 'http://' . $customer->site;
        if(strpos($customer->weibo, 'http://weibo.com/') === false ) $customer->weibo = 'http://weibo.com/' . $customer->weibo;

        $this->dao->update(TABLE_CUSTOMER)
            ->data($customer)
            ->autoCheck()
            ->batchCheck($this->config->customer->require->edit, 'notempty')
            ->where('id')->eq($customerID)
            ->exec();

        if(dao::isError()) return false;
        return commonModel::createChanges($oldCustomer, $customer);
    }

    /**
     * Link contact.
     * 
     * @param  int    $customerID 
     * @access public
     * @return bool
     */
    public function linkContact($customerID)
    {
        $this->loadModel('action');
        $this->loadModel('contact');
        if($this->post->newContact)
        {
            unset($_POST['newContact']);
            unset($_POST['contact']);
            $_POST['customer']    = $customerID;
            $_POST['createdDate'] = helper::now();

            $contactID = $this->contact->create();

            if($contactID) $this->action->create('contact', $contactID, 'Created');
            return $contactID;
        }

        if($this->post->contact)
        {
            $contactID = $this->post->contact;
            $contact   = $this->contact->getByID($contactID);

            if($contact->customer != $customerID)
            {

                $_POST = array();
                $_POST['customer'] = $customerID;
                $resumeID = $this->loadModel('resume')->create($contactID);

                if($resumeID)
                {
                    $changes[] = array('field' => 'customer', 'old' => $contact->customer, 'new' => $customerID, 'diff' => '');
                    $actionID  = $this->action->create('contact', $contactID, 'Edited');
                    $this->action->logHistory($actionID, $changes);
                }
                return $resumeID;
            }
        }
    }
}
