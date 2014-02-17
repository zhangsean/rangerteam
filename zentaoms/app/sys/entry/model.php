<?php
/**
 * The model file of entry module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     entry 
 * @version     $Id$
 * @link        http://www.zentao.net
 */
class entryModel extends model
{
    /**
     * Get all entries. 
     * 
     * @access public
     * @return object
     */
    public function getEntries()
    {
        $entries = $this->dao->select('*')->from(TABLE_ENTRY)->fetchAll();
        return $entries;
    }

    /**
     * Get entry by id.
     * 
     * @param  int    $entryID
     * @access public
     * @return object 
     */
    public function getById($entryID)
    {
        $webPath = $this->loadModel('file')->webPath;
        $entry = $this->dao->select('t1.*, t2.pathname as logoPath')->from(TABLE_ENTRY)->alias('t1')
            ->leftJoin(TABLE_FILE)->alias('t2')
            ->on('t1.logo = t2.id')
            ->where('t1.id')->eq($entryID)
            ->fetch();
        if($entry and $entry->logoPath) $entry->logoPath = $webPath . $entry->logoPath;

        return $entry;
    }

    /**
     * Get entry by code.
     * 
     * @param  string $code 
     * @access public
     * @return object 
     */
    public function getByCode($code)
    {
        return $this->dao->select('*')->from(TABLE_ENTRY)->where('code')->eq($code)->fetch(); 
    }

    /**
     * Create entry. 
     * 
     * @access public
     * @return void
     */
    public function create()
    {
        $entry = fixer::input('post')->get();
        if($entry->size == 'custom') $entry->size = json_encode(array('width' => (int)$entry->width, 'height' => (int)$entry->height));

        $this->dao->insert(TABLE_ENTRY)
            ->data($entry, $skip = 'width,height')
            ->autoCheck()
            ->batchCheck($this->config->entry->require->create, 'notempty')
            ->check('code', 'unique')
            ->check('code', 'code')
            ->exec();

        if(dao::isError()) return false;

        $entryID = $this->dao->lastInsertID();
        return $entryID;
    }

    /**
     * Update entry.
     * 
     * @param  int    $code 
     * @access public
     * @return void
     */
    public function update($code)
    {
        $oldEntry = $this->getByCode($code);
        $entry    = fixer::input('post')->get();
        if($entry->size == 'custom') $entry->size = json_encode(array('width' => (int)$entry->width, 'height' => (int)$entry->height));
        if(!isset($entry->visible)) $entry->visible = 0;
        unset($entry->logo);
        $this->dao->update(TABLE_ENTRY)->data($entry, $skip = 'width,height')->autoCheck()->batchCheck($this->config->entry->require->edit, 'notempty')->where('code')->eq($code)->exec();
        return $oldEntry->id;
    }

    /**
     * Delete entry. 
     * 
     * @param  string $code 
     * @access public
     * @return void
     */
    public function delete($code, $table = null)
    { 
        $entry = $this->getByCode($code);
        $this->loadModel('file')->delete($entry->logo);
        $this->dao->delete()->from(TABLE_ENTRY)->where('code')->eq($code)->exec();
        return !dao::isError();
    }

    /**
     * Get key of entry. 
     * 
     * @param  string $entry 
     * @access public
     * @return object 
     */
    public function getAppKey($entry)
    {
        return $this->config->entry->$entry->key;
    }
    /**
     * Create a key.
     * 
     * @access public
     * @return string 
     */
    public function createKey()
    {
        return md5(rand());
    }

    /**
     * Get all departments.
     * 
     * @access public
     * @return object 
     */
    public function getAllDepts()
    {
        return $this->dao->select('*')->from(TABLE_DEPT)->fetchAll();
    }

    /**
     * Get all users. 
     * 
     * @access public
     * @return object 
     */
    public function getAllUsers()
    {
        return $this->dao->select('*')->from(TABLE_USER)
            ->where('deleted')->eq(0)
            ->fetchAll();
    }
    /**
     * Get entry logo. 
     * 
     * @param  int    $entryID
     * @access public
     * @return bool|object 
     */
    public function getLogo($entryID)
    {
        $entry = $this->getById($entryID);
        if($entry->logo) 
        {
            $logo = $this->loadModel('file')->getById($entry->logo);
            return $logo->pathname;
        }
        return '';
    }

    /**
     * Update entry logo. 
     * 
     * @param  int    $entryID 
     * @access public
     * @return void
     */
    public function updateLogo($entryID)
    {
        //upload logo img.
        $file = $this->loadModel('file')->getUpload('logo');
        if(isset($file[0]))
        {
            $file = $file[0];
            if(@move_uploaded_file($file['tmpname'], $this->file->savePath . $file['pathname']))
            {
                $url =  $this->file->webPath . $file['pathname'];

                $file['addedBy']    = $this->app->user->account;
                $file['addedDate']  = helper::today();
                $file['objectType'] = 'entryLogo';
                $file['objectID']   = $entryID;
                unset($file['tmpname']);
                $this->dao->insert(TABLE_FILE)->data($file)->exec();

                $logoPath = $this->config->webRoot . 'data/upload/' . $file['pathname'];
                $this->dao->update(TABLE_ENTRY)->set('logo')->eq($logoPath)->where('id')->eq($entryID)->exec();
            }
            else
            {
                $error = strip_tags(sprintf($this->lang->file->errorCanNotWrite, $this->file->savePath, $this->file->savePath));
                die(js::alert($error));
            }
        }
    }

    /**
     * Reset entry logo. 
     * 
     * @param  int    $entryID 
     * @access public
     * @return void
     */
    public function resetLogo($entryID)
    {
        $this->dao->update(TABLE_ENTRY)->set('logo')->eq(0)->where('id')->eq($entryID)->exec();
    }

    /**
     * Get blocks by API.
     * 
     * @param  object    $entry 
     * @access public
     * @return json
     */
    public function getBlocksByAPI($entry)
    {
        $http = $this->app->loadClass('http');

        if(empty($entry)) return array();
        $parseUrl   = parse_url($entry->block);
        $blockQuery = "mode=getblocklist&hash={$entry->key}&lang=" . $this->app->getClientLang();
        $parseUrl['query'] = empty($parseUrl['query']) ? $blockQuery : $parseUrl['query'] . '&' . $blockQuery;

        $link = '';
        if(!isset($parseUrl['scheme'])) 
        {
            $link  = commonModel::getSysURL() . $parseUrl['path'];
            $link .= '?' . $parseUrl['query'];
        }
        else
        {
            $link .= $parseUrl['scheme'] . '://' . $parseUrl['host'];
            if(isset($parseUrl['port'])) $link .= ':' . $parseUrl['port']; 
            if(isset($parseUrl['path'])) $link .= $parseUrl['path']; 
            $link .= '?' . $parseUrl['query'];
        }

        $blocks = $http->get($link);

        return json_decode($blocks);
    }

    /**
     * Get block params.
     * 
     * @param  object $entry 
     * @param  int    $blockID 
     * @access public
     * @return json
     */
    public function getBlockParams($entry, $blockID)
    {
        $http = $this->app->loadClass('http');

        if(empty($entry)) return array();
        $parseUrl  = parse_url($entry->block);
        $formQuery = "mode=getblockform&blockid=$blockID&hash={$entry->key}&lang=" . $this->app->getClientLang();
        $parseUrl['query'] = empty($parseUrl['query']) ? $formQuery : $parseUrl['query'] . '&' . $formQuery;

        $link = '';
        if(!isset($parseUrl['scheme'])) 
        {
            $link  = commonModel::getSysURL() . $parseUrl['path'];
            $link .= '?' . $parseUrl['query'];
        }
        else
        {
            $link .= $parseUrl['scheme'] . '://' . $parseUrl['host'];
            if(isset($parseUrl['port'])) $link .= ':' . $parseUrl['port']; 
            if(isset($parseUrl['path'])) $link .= $parseUrl['path']; 
            $link .= '?' . $parseUrl['query'];
        }
        $params = $http->get($link);

        return json_decode($params, true);
    }
}
