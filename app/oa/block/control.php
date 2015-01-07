<?php
/**
 * The control file for block module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.ranzhico.com
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
        $this->app->loadLang('block');

        $mode = strtolower($this->get->mode);
        if($mode == 'getblocklist')
        {   
            echo $this->block->getAvailableBlocks();
        }   
        elseif($mode == 'getblockform')
        {   
            $code = strtolower($this->get->blockid);
            $func = 'get' . ucfirst($code) . 'Params';
            echo $this->block->$func();
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
     * @param  int    $index 
     * @param  string $blockID 
     * @access public
     * @return void
     */
    public function admin($index = 0, $blockID = '')
    {
        $this->app->loadLang('block', 'sys');
        $title = $index == 0 ? $this->lang->block->createBlock : $this->lang->block->editBlock;

        if(!$index) $index = $this->block->getLastKey('oa') + 1;

        if($_POST)
        {
            $this->block->save($index, 'system', 'oa');
            if(dao::isError())  $this->send(array('result' => 'fail', 'message' => dao::geterror())); 
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => $this->server->http_referer));
        }

        $block   = $this->block->getBlock($index, 'oa');
        $blockID = $blockID ? $blockID : ($block ? $block->block : '');

        $blocks = json_decode($this->block->getAvailableBlocks(), true);
        $this->view->blocks  = array_merge(array(''), $blocks);

        $this->view->title   = $title;
        $this->view->params  = $blockID ? json_decode($this->block->{'get' . ucfirst($blockID) . 'Params'}(), true) : array();;
        $this->view->blockID = $blockID;
        $this->view->block   = $block;
        $this->view->index   = $index;
        $this->display();
    }

    /**
     * Sort block. 
     * 
     * @param  string    $oldOrder 
     * @param  string    $newOrder 
     * @access public
     * @return void
     */
    public function sort($oldOrder, $newOrder)
    {
        $this->locate($this->createLink('sys.block', 'sort', "oldOrder=$oldOrder&newOrder=$newOrder&app=oa"));
    }

    /**
     * Delete block. 
     * 
     * @param  int    $index 
     * @access public
     * @return void
     */
    public function delete($index)
    {
        $this->locate($this->createLink('sys.block', 'delete', "index=$index&app=oa"));
    }

    /**
     * Print announce block.
     * 
     * @access public
     * @return void
     */
    public function printAnnounceBlock()
    {
        $this->lang->announce = new stdclass();
        $this->app->loadLang('announce', 'oa');

        $this->processParams();

        $this->view->announces = $this->dao->select('*')->from(TABLE_ARTICLE)
            ->where('type')->eq('announce')
            ->orderBy('createdDate desc')
            ->limit($this->params->num)
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
        $this->app->loadLang('task', 'sys');
        $this->session->set('taskList', $this->createLink('dashboard', 'index'));

        $this->processParams();

        /* Get project ids. */
        $projects = $this->loadMOdel('project')->getPairs();
        $ids = '';
        foreach($projects as $key => $project) $ids .= ',' . $key;

        $this->view->tasks = $this->dao->select('*')->from(TABLE_TASK)
            ->where('deleted')->eq(0)
            ->andWhere('project')->ne(0)
            ->andWhere('project')->in($ids)
            ->beginIF(isset($this->params->status) and join($this->params->status) != false)->andWhere('status')->in($this->params->status)->fi()
            ->beginIF($this->params->type)->andWhere($this->params->type)->eq($this->params->account)->fi()
            ->orderBy($this->params->orderBy)
            ->limit($this->params->num)
            ->fetchAll('id');

        $this->display();
    }

    /**
     * Print task block for created by me.
     * 
     * @access public
     * @return void
     */
    public function printMyCreatedTaskBlock()
    {
        $this->lang->task = new stdclass();
        $this->app->loadLang('task', 'sys');
        $this->session->set('taskList', $this->createLink('dashboard', 'index'));

        $this->processParams();

        $this->view->tasks = $this->dao->select('*')->from(TABLE_TASK)
            ->where('createdBy')->eq($this->params->account)
            ->andWhere('deleted')->eq(0)
            ->andWhere('project')->ne(0)
            ->beginIF(isset($this->params->status) and join($this->params->status) != false)->andWhere('status')->in($this->params->status)->fi()
            ->orderBy($this->params->orderBy)
            ->limit($this->params->num)
            ->fetchAll('id');

        $this->display();
    }

    /**
     * Print task block for assigned to me.
     * 
     * @access public
     * @return void
     */
    public function printAssignedMeTaskBlock()
    {
        $this->lang->task = new stdclass();
        $this->app->loadLang('task', 'sys');
        $this->session->set('taskList', $this->createLink('dashboard', 'index'));

        $this->processParams();

        $this->view->tasks = $this->dao->select('*')->from(TABLE_TASK)
            ->where('assignedTo')->eq($this->params->account)
            ->andWhere('deleted')->eq(0)
            ->andWhere('project')->ne(0)
            ->beginIF(isset($this->params->status) and join($this->params->status) != false)->andWhere('status')->in($this->params->status)->fi()
            ->orderBy($this->params->orderBy)
            ->limit($this->params->num)
            ->fetchAll('id');

        $this->display();
    }

    /**
     * Print broject block.
     * 
     * @access public
     * @return void
     */
    public function printProjectBlock()
    {
        $this->lang->project = new stdclass();
        $this->app->loadLang('project', 'oa');

        $this->processParams();

        $this->view->users    = $this->loadModel('user')->getPairs();
        $this->view->projects = $this->dao->select('*')->from(TABLE_PROJECT)
            ->where('deleted')->eq(0)
            ->orderBy($this->params->orderBy)
            ->limit($this->params->num)
            ->fetchAll('id');

        $this->display();
    }

    /**
     * Process params.
     * 
     * @access public
     * @return void
     */
    public function processParams()
    {
        $params = $this->get->param;
        $this->params = json_decode(base64_decode($params));

        $this->view->sso  = base64_decode($this->get->sso);
        $this->view->code = $this->get->blockid;
    }
}
