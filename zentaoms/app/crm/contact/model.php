<?php
/**
 * The model file of contact module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     contact
 * @version     $Id$
 * @link        http://www.zentao.net
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
     * @param  string  $orderBy 
     * @param  object  $pager 
     * @access public
     * @return array
     */
    public function getList($orderBy = 'id_desc', $pager = null)
    {
        return $this->dao->select('*')->from(TABLE_CONTACT)->orderBy($orderBy)->page($pager)->fetchAll('id');
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
     * Create a contact.
     * 
     * @access public
     * @return int|bool
     */
    public function create()
    {
        $now = helper::now();
        $contact = fixer::input('post')
            ->add('createdBy', $this->app->user->account)
            ->add('createdDate', helper::now())
            ->get();

        $this->dao->insert(TABLE_CONTACT)
            ->data($contact)
            ->autoCheck()
            ->batchCheck($this->config->contact->require->create, 'notempty')
            ->check('email', 'email')
            ->exec();

        if(dao::isError()) return array('result' => false, 'message' => dao::getError());

        $contactID = $this->dao->lastInsertID();
        $this->updateAvatar($contactID);

        return array('result' => true);
    }

    /**
     * Update a contact.
     * 
     * @param  int    $contactID 
     * @access public
     * @return void
     */
    public function update($contactID)
    {
        $contact = $this->getByID($contactID);
        $avatar  = $contact->avatar;

        $contact = fixer::input('post')
            ->add('editedBy', $this->app->user->account)
            ->add('editedDate', helper::now())
            ->setIF($this->post->avatar == '', 'avatar', $avatar)
            ->get();

        $this->dao->update(TABLE_CONTACT)
            ->data($contact)
            ->autoCheck()
            ->batchCheck($this->config->contact->require->edit, 'notempty')
            ->check('email', 'email')
            ->where('id')->eq($contactID)
            ->exec();

        $this->updateAvatar($contactID);

        if(dao::isError()) return array('result' => false, 'message' => dao::getError());
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
        $fileModel = $this->loadModel('file');
        
        if(!$this->file->checkSavePath()) return array('result' => false, 'message' => $this->lang->file->errorUnwritable);
        
        /* Delete old files. */
        $oldFiles = $this->dao->select('id')->from(TABLE_FILE)->where('objectType')->eq('avatar')->andWhere('objectID')->eq($contactID)->fetchAll('id');
        foreach($oldFiles as $file) $fileModel->delete($file->id);
        if(dao::isError()) return array('result' => false, 'message' => $this->lang->fail);
        
        /* Upload new avatar. */
        $uploadResult = $fileModel->saveUpload('avatar', $contactID);
        if(!$uploadResult) return array('result' => 'false', 'message' => $this->lang->fail);
        
        $fileIdList = array_keys($uploadResult);
        $file       = $fileModel->getById($fileIdList[0]);
        
        $avatarPath = $this->config->webRoot . 'data/upload/' . $file->pathname;
        $this->dao->update(TABLE_CONTACT)->set('avatar')->eq($avatarPath)->where('id')->eq($contactID)->exec();
        if(!dao::isError()) return array('result' => true);
        return array('result' => false, 'message' => $this->lang->fail);
    }
}
