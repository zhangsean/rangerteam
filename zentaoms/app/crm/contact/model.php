<?php
/**
 * The model file of contact category of ZenTaoMS.
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
     * @return int|bool
     */
    public function getByID($id)
    {
       $contact = $this->dao->select('*')->from(TABLE_CONTACT)->where('id')->eq($id)->limit(1)->fetch();

       if(!$contact) return false;

       return $contact;
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
        $contacts = $this->dao->select('*')->from(TABLE_CONTACT)->orderBy($orderBy)->page($pager)->fetchAll('id');

        if(!$contacts) return array();

        return $contacts;
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
            ->exec();

        if(dao::isError()) return false;

        $contactID = $this->dao->lastInsertID();

        return $contactID;
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
            ->where('id')->eq($contactID)
            ->exec();

        if(dao::isError()) return false;

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
        //upload avatar img.
        $file = $this->loadModel('file')->getUpload('avatar');
        if(isset($file[0]))
        {
            $file = $file[0];
            if(@move_uploaded_file($file['tmpname'], $this->file->savePath . $file['pathname']))
            {
                $url = $this->file->webPath . $file['pathname'];

                $file['addedBy']    = $this->app->user->account;
                $file['addedDate']  = helper::today();
                $file['objectType'] = 'contactAvatar';
                $file['objectID']   = $contactID;
                unset($file['tmpname']);
                $this->dao->insert(TABLE_FILE)->data($file)->exec();

                $avatarPath = $this->config->webRoot . 'data/upload/' . $file['pathname'];
                $this->dao->update(TABLE_CONTACT)->set('avatar')->eq($avatarPath)->where('id')->eq($contactID)->exec();
            }
            else
            {
                $error = strip_tags(sprintf($this->lang->file->errorCanNotWrite, $this->file->savePath, $this->file->savePath));
                die(js::alert($error));
            }
        }
    }
}
