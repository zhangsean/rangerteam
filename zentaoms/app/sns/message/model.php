<?php
/**
 * The model file of message module of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     message
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
class messageModel extends model
{
    /**
     * Get message by ID. 
     * 
     * @param  int    $messageID 
     * @access public
     * @return object
     */
    public function getByID($messageID)
    {
        return $this->dao->select('*')->from(TABLE_MESSAGE)->findByID($messageID)->fetch();
    }
    
    /**
     * Get message list By Account 
     * 
     * @param  string    $account 
     * @param  object    $pager 
     * @access public
     * @return array
     */
    public function getByAccount($account, $pager)
    {
         return $this->dao->select('*')->from(TABLE_MESSAGE)
            ->where('`to`')->eq($account)
            ->orderBy('id_desc')
            ->page($pager)
            ->fetchAll('id');
    }   

    /**
     * Get messages of one object.
     * 
     * @param  string $type          the message type
     * @param  string $objectType    the object type
     * @param  int    $objectID      the object id
     * @access public
     * @return array
     */
    public function getByObject($type, $objectType, $objectID, $pager = null)
    {
        $userMessages = $this->cookie->cmts;
        $userMessages = trim($userMessages, ',');
        if(empty($userMessages)) $userMessages = '0';
        return  $this->dao->select('*')->from(TABLE_MESSAGE)
            ->where('type')->eq($type)
            ->beginIf(RUN_MODE == 'front' and $type == 'message')->andWhere('public')->eq(1)->fi()
            ->andWhere('objectType')->eq($objectType)
            ->andWhere('objectID')->eq($objectID)
            ->andWhere("(id in ({$userMessages}) or (status = '1'))")
            ->orderBy('id_desc')
            ->page($pager)
            ->fetchAll();
    }

    /**
     * Get replies of message list. 
     * 
     * @param  mix    $messages 
     * @access public
     * @return array
     */
    public function getReplies($messages)
    {
        foreach($messages as $message) $objectList[] = $message->id;
        return $this->dao->select('*')->from(TABLE_MESSAGE)
            ->where('type')->eq('reply')
            ->andWhere('objectID')->in($objectList)
            ->fetchGroup('objectID');
    }

    /**
     * Get message list.
     * 
     * @param string $type      the message type
     * @param int    $status    the message status
     * @param object $pager 
     * @access public
     * @return void
     */
    public function getList($type, $status, $pager = null)
    {
        $messages = $this->dao->select('*')->from(TABLE_MESSAGE)
            ->where('type')->eq($type)
            ->andWhere('status')->eq($status)
            ->beginIf(RUN_MODE == 'front')->andWhere('public')->eq(1)->fi()
            ->orderBy('id_desc')
            ->page($pager)
            ->fetchAll('id');

        /* Get object titles and id. */
        $articles = array();
        $products = array();

        foreach($messages as $message)
        {
            if('article' == $message->objectType) $articles[] = $message->objectID;
            if('product' == $message->objectType) $products[] = $message->objectID;
        }

        $articleTitles = $this->dao->select('id, title')->from(TABLE_ARTICLE)->where('id')->in($articles)->fetchPairs('id', 'title');
        $productTitles = $this->dao->select('id, name')->from(TABLE_PRODUCT)->where('id')->in($products)->fetchPairs('id', 'name');

        foreach($messages as $message)
        {
            if($message->objectType == 'article') $message->objectTitle = isset($articleTitles[$message->objectID]) ? $articleTitles[$message->objectID] : '';
            if($message->objectType == 'product') $message->objectTitle = isset($productTitles[$message->objectID]) ? $productTitles[$message->objectID] : '';
        }

        foreach($messages as $message)
        {
            $message->objectViewURL = $this->getObjectLink($message);
        }

        return $messages;
    }

    /**
     * Post a message.
     * 
     * @access public
     * @return void
     */
    public function post($type)
    {
        $message = fixer::input('post')
            ->add('date', helper::now())
            ->add('type', $type)
            ->setDefault('public', '0')
            ->setIF($type == 'message', 'to', 'admin')
            ->add('ip', $this->server->REMOTE_ADDR)
            ->add('status', '0')
            ->get();

        $this->dao->insert(TABLE_MESSAGE)
            ->data($message, $skip = 'captcha')
            ->autoCheck()
            ->check('captcha', 'captcha')
            ->check('type', 'in', $this->config->message->types)
            ->checkIF($message->email, 'email', 'email')
            ->batchCheck('from, type, content', 'notempty')
            ->exec();

        if(dao::isError()) return false;
        return $this->dao->lastInsertId();
    }

    /**
     * Reply a message.
     * 
     * @param  int    $messageID 
     * @access public
     * @return void
     */
    public function reply($messageID)
    {
        $message = $this->getByID($messageID);

        $reply = fixer::input('post')
            ->add('objectType', $message->type)
            ->add('objectID', $message->id)
            ->add('to', $message->to)
            ->add('type', 'reply')
            ->add('date', helper::now())
            ->add('public', 1)
            ->add('ip', $this->server->REMOTE_ADDR)
            ->remove('status')
            ->get();

        $this->dao->insert(TABLE_MESSAGE)
            ->data($reply, $skip = 'captcha')
            ->autoCheck()
            ->check('captcha', 'captcha')
            ->check('type', 'in', $this->config->message->types)
            ->checkIF($reply->email, 'email', 'email')
            ->batchCheck('from, type, content', 'notempty')
            ->exec();

        if(dao::isError()) return false;
        return $this->dao->lastInsertId();
    }

    /**
     * Delete a message.
     * 
     * @param string $messageID 
     * @param string $mode 
     * @access public
     * @return void
     */
    public function delete($messageID, $mode)
    {
        $message = $this->dao->select('status')->from(TABLE_MESSAGE)->where('id')->eq($messageID)->fetch('', false);
        if($message->status == 0)
        {
            $this->dao->delete()
                ->from(TABLE_MESSAGE)
                ->where('status')->eq(0)
                ->beginIF($mode == 'single')->andWhere('id')->eq($messageID)->fi()
                ->beginIF($mode == 'pre')->andWhere('id')->ge($messageID)->fi()
                ->exec(false);
        }
        else
        {
            $this->dao->delete()->from(TABLE_MESSAGE)->where('id')->eq($messageID)->exec(false);
        }
    }

    /**
     * Pass messages.
     * 
     * @param string $messageID 
     * @param string $type          single|pr
     * @access public
     * @return void
     */
    public function pass($messageID, $type)
    {
        $this->dao->update(TABLE_MESSAGE)
            ->set('status')->eq(1)
            ->where('status')->eq(0)
            ->beginIF($type == 'single')->andWhere('id')->eq($messageID)->fi()
            ->beginIF($type == 'pre')->andWhere('id')->ge($messageID)->fi()
            ->exec(false);
    }

    /**
     * Set the message id the user posted to the cookie. Thus before approvaled, the user can view these messages.
     * 
     * @param string $messageID
     * @access public
     * @return void
     */
    public function setCookie($messageID)
    {
        $messages = $this->cookie->cmts;
        if(!$messages)
        {
            $messages = $messageID;
        }
        else
        {
            if(strpos($messages, $messageID) === false)
            {
                $messages .= ',' . $messageID;
            }
        }
        setcookie('cmts', $messages);
    }

    /**
     * Get the link of the object of one message.
     * 
     * @param string $message 
     * @access public
     * @return sting
     */
    public function getObjectLink($message)
    {
        if($message->objectType == 'article')
        {
            $link = $this->loadModel('article')->createPreviewLink($message->objectID);
        }
        elseif($message->objectType == 'product')
        {
            $link = commonModel::createFrontLink('product', 'view', "prodcutID=$message->objectID");
        }

        return $link;
    }
}
