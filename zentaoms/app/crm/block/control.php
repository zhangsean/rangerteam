<?php
/**
 * The control file for block module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.zentao.net
 */
class block extends control
{
    /**
     * Block Index Page.
     * 
     * @access public
     * @return void
     */
    public function index()
    {
        $lang = $this->get->lang;
        $this->app->setClientLang($lang);
        $this->app->loadLang('common', 'crm');
        $this->app->loadLang('block');

        $mode = strtolower($this->get->mode);
        if($mode == 'getblocklist')
        {   
            die($this->block->getBlockList());
        }   
        elseif($mode == 'getblockform')
        {   
            $code = strtolower($this->get->blockid);
            $func = 'get' . ucfirst($code) . 'Params';
            die($this->block->$func());
        }   
        elseif($mode == 'getblockdata')
        {   
            $code = strtolower($this->get->blockid);
            $func = 'print' . ucfirst($code) . 'Block';
            $this->$func();
        }   
    }

    /**
     * Block Admin Page.
     * 
     * @access public
     * @return void
     */
    public function admin()
    {
        $this->display();
    }

    /**
     * Print order block.
     * 
     * @access public
     * @return void
     */
    public function printOrderBlock()
    {
        $this->lang->order = new stdclass();
        $this->app->loadLang('order');

        $params = $this->get->param;
        $params = json_decode(base64_decode($params));

        $this->view->sso       = base64_decode($this->get->sso);
        $this->view->code      = $this->get->blockid;
        $this->view->products  = $this->loadModel('product')->getPairs();
        $this->view->customers = $this->loadModel('customer')->getPairs();

        $this->view->orders = $this->dao->select('*')->from(TABLE_ORDER)
            ->where(("createdBy='$params->account' OR assignedTo = '$params->account'"))
            ->beginIF(isset($params->status) and join($params->status) != false)->andWhere('status')->in($params->status)->fi()
            ->orderBy($params->orderBy)
            ->limit($params->num)
            ->fetchAll('id');

        $this->display();
    }

    /**
     * Print task block.
     * 
     * @access public
     * @return void
     */
    public function printTaskBlock()
    {
        $this->lang->task = new stdclass();
        $this->app->loadLang('task');

        $params = $this->get->param;
        $params = json_decode(base64_decode($params));

        $this->view->sso  = base64_decode($this->get->sso);
        $this->view->code = $this->get->blockid;

        $this->view->tasks = $this->dao->select('*')->from(TABLE_TASK)
            ->where(("createdBy='$params->account' OR assignedTo = '$params->account'"))
            ->beginIF(isset($params->status) and join($params->status) != false)->andWhere('status')->in($params->status)->fi()
            ->orderBy($params->orderBy)
            ->limit($params->num)
            ->fetchAll('id');

        $this->display();
    }

    /**
     * Print contract block.
     * 
     * @access public
     * @return void
     */
    public function printContractBlock()
    {
        $this->lang->contract = new stdclass();
        $this->app->loadLang('contract');

        $params = $this->get->param;
        $params = json_decode(base64_decode($params));

        $this->view->sso  = base64_decode($this->get->sso);
        $this->view->code = $this->get->blockid;

        $this->view->contracts = $this->dao->select('*')->from(TABLE_CONTRACT)
            ->where('createdBy')->eq($params->account)
            ->beginIF(isset($params->status) and join($params->status) != false)->andWhere('status')->in($params->status)->fi()
            ->orderBy($params->orderBy)
            ->limit($params->num)
            ->fetchAll('id');

        $this->display();
    }
}
