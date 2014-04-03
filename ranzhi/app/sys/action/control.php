<?php
/**
 * The control file of action module of Ranzhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     action
 * @version     $Id$
 * @link        http://www.zentao.net
 */
class action extends control
{
    /**
     * Edit comment of a action.
     * 
     * @param  int    $actionID 
     * @access public
     * @return void
     */
    public function editComment($actionID)
    {
        if(!strip_tags($this->post->lastComment)) $this->send(array('result' => 'success', 'locate' => $this->server->http_referer));
        $this->action->updateComment($actionID);
        $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => $this->server->http_referer));
    }
}
