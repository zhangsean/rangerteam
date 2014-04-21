<?php
/**
 * The model file of contact module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     contact
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
class contactModel extends model
{
    /**
     * Get contact by id.
     * 
     * @param  int    $id 
     * @access public
     * @return object
     */
    public function getByID($id)
    {
        return $this->dao->select('*')->from(TABLE_CONTACT)->where('id')->eq($id)->limit(1)->fetch();
    }

    /** 
     * Get contact list.
     * 
     * @param  int     $customer
     * @param  string  $orderBy 
     * @param  object  $pager 
     * @access public
     * @return array
     */
    public function getList($customer = 0, $orderBy = 'id_desc', $pager = null)
    {
        return $this->dao->select('*')->from(TABLE_CONTACT)
            ->beginIF($customer)->where('customer')->eq($customer)->fi()
            ->orderBy($orderBy)
            ->page($pager)
            ->fetchAll('id');
    }

    /**
     * Get contact pairs.
     * 
     * @access public
     * @return array
     */
    public function getPairs()
    {
        $contacts = $this->dao->select('*')->from(TABLE_CONTACT)->fetchPairs('id', 'realname');
        return array(0 => '') + $contacts;
    }

    /**
     * Get common selecter of contact.
     * 
     * @param  int    $customer 
     * @access public
     * @return void
     */
    public function getOptionMenu($customer = 0, $withEmpty = true, $create = true)
    {
        $contacts = $this->dao->select('t1.*')
            ->from(TABLE_CONTACT)->alias('t1')
            ->leftJoin(TABLE_RESUME)->alias('t2')
            ->on('t1.id = t2.contact')
            ->beginIF($customer)->where('t2.customer')->eq($customer)->FI()
            ->fetchPairs('id', 'realname');

        if($withEmpty) $contacts = array('' => '') + $contacts;
        if($create)    $contacts = $contacts + array('create' => $this->lang->contact->create);

        return $contacts;
    }

    /**
     * Create a contact.
     * 
     * @access public
     * @return int
     */
    public function create()
    {
        $contact = fixer::input('post')
            ->add('createdBy', $this->app->user->account)
            ->get();

        $this->dao->insert(TABLE_CONTACT)
            ->data($contact, 'files')
            ->autoCheck()
            ->batchCheck($this->config->contact->require->create, 'notempty')
            ->checkIF($contact->email, 'email', 'email')
            ->exec();

        if(!dao::isError())
        {
            $contactID = $this->dao->lastInsertID();

            $resume = new stdclass();
            $resume->contact     = $contactID;
            $resume->customer    = $contact->customer;
            $this->dao->insert(TABLE_RESUME)->data($resume)->exec();

            return $contactID;
        }

        return false;
    }

    /**
     * Update a contact.
     * 
     * @param  int    $contactID 
     * @access public
     * @return string
     */
    public function update($contactID)
    {
        $oldContact = $this->getByID($contactID);
        $now        = helper::now();

        $contact = fixer::input('post')
            ->add('editedBy', $this->app->user->account)
            ->add('editedDate', $now)
            ->setDefault('maker', 0)
            ->setIF($this->post->avatar == '', 'avatar', $oldContact->avatar)
            ->remove('files')
            ->get();

        $this->dao->update(TABLE_CONTACT)
            ->data($contact)
            ->autoCheck()
            ->batchCheck($this->config->contact->require->edit, 'notempty')
            ->checkIF($contact->email, 'email', 'email')
            ->where('id')->eq($contactID)
            ->exec();

        if(!dao::isError())
        {
            if($oldContact->customer != $contact->customer)
            {
                $resume = new stdclass();
                $resume->contact     = $contactID;
                $resume->customer    = $contact->customer;
                $resume->createdDate = $now;
                $resume->createdBy   = $this->app->user->account;
                $this->dao->insert(TABLE_RESUME)->data($resume)->exec();
            }

            return commonModel::createChanges($oldContact, $contact);
        }

        return false;
    }

    /**
     * Delete a contact.
     *
     * @param  int    $contactID
     * @param  null   $table 
     * @access public
     * @return void
     */
    public function delete($contactID, $table = null)
    {
        $this->dao->delete()->from(TABLE_CONTACT)->where('id')->eq($contactID)->exec();

        return !dao::isError();
    }

    /**
     * Update contact avatar. 
     * 
     * @param  int    $contactID 
     * @access public
     * @return void
     */
    public function updateAvatar($contactID)
    {
        if(!$_FILES) return array('result' => true, 'contactID' => $contactID);

        $fileModel = $this->loadModel('file');

        if(!$this->file->checkSavePath()) return array('result' => false, 'message' => $this->lang->file->errorUnwritable);
        
        /* Delete old files. */
        $oldFiles = $this->dao->select('id')->from(TABLE_FILE)->where('objectType')->eq('avatar')->andWhere('objectID')->eq($contactID)->fetchAll('id');
        if($oldFiles)
        {
            foreach($oldFiles as $file) $fileModel->delete($file->id);
            if(dao::isError()) return array('result' => false, 'message' => $this->lang->contact->failedAvatar);
        }
        
        /* Upload new avatar. */
        $uploadResult = $fileModel->saveUpload('avatar', $contactID);
        if(!$uploadResult) return array('result' => false, 'message' => $this->lang->contact->failedAvatar);
        
        $fileIdList = array_keys($uploadResult);
        $file       = $fileModel->getById($fileIdList[0]);
        
        $avatarPath = $this->config->webRoot . 'data/upload/' . $file->pathname;
        $this->dao->update(TABLE_CONTACT)->set('avatar')->eq($avatarPath)->where('id')->eq($contactID)->exec();
        if(!dao::isError()) return array('result' => true, 'contactID' => $contactID);
        return array('result' => false, 'message' => $this->lang->contact->failedAvatar);
    }
}
