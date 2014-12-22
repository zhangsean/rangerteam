<?php
/**
 * The control file of block module of RanZhi.
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
     * Admin all blocks. 
     * 
     * @param  int    $index 
     * @access public
     * @return void
     */
    public function admin($index = 0)
    {
        $title = $index == 0 ? $this->lang->block->createBlock : $this->lang->block->editBlock;

        $entries = $this->dao->select('*')->from(TABLE_ENTRY)
            ->where('block')->ne('')
            ->orWhere('buildin')->eq(1)
            ->fetchAll('id');

        if(!$index) $index = $this->block->getLastKey('sys') + 1;

        $allEntries[''] = '';
        foreach($entries as $id => $entry) $allEntries[$entry->code] = $entry->name;
        //$allEntries['rss']  = 'RSS';
        $allEntries['html'] = 'HTML';

        $hiddenBlocks = $this->block->getHiddenBlocks();
        foreach($hiddenBlocks as $block) $allEntries['hiddenBlock' . $block->id] = $block->title;

        $this->view->block      = $this->block->getBlock($index);
        $this->view->entries    = $entries;
        $this->view->allEntries = $allEntries;
        $this->view->index      = $index;
        $this->view->title      = $title;
        $this->display();
    }

    /**
     * Set params when type is rss or html. 
     * 
     * @param  int    $index 
     * @param  string $type 
     * @param  int    $blockID 
     * @access public
     * @return void
     */
    public function set($index, $type, $blockID = 0)
    {
        if($_POST)
        {
            $this->block->save($index, $type, 'sys', $blockID);
            if(dao::isError())  $this->send(array('result' => 'fail', 'message' => dao::geterror()));
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => $this->createLink('index')));
        }

        $block = $blockID ? $this->block->getByID($blockID) : $this->block->getBlock($index);
        if($block) $type = $block->block;

        $this->view->type    = $type;
        $this->view->index   = $index;
        $this->view->blockID = $blockID;
        $this->view->block   = ($block) ? $block : array();
        $this->display();
    }

    /**
     * Print block. 
     * 
     * @param  int    $index 
     * @access public
     * @return void
     */
    public function printBlock($index)
    {
        $block = $this->block->getBlock($index);

        if(empty($block)) return false;

        $html = '';
        if($block->block == 'html')
        {
            $html = "<div class='article-content'>" . htmlspecialchars_decode($block->params->html) .'</div>';
        }
        elseif($block->block == 'rss')
        {
            $html = $this->block->getRss($block);
        }
        elseif($block->source != '')
        {
            $html = $this->block->getEntry($block);
        }
        
        die($html);
    }

    /**
     * Sort block.
     * 
     * @param  string    $oldOrder 
     * @param  string    $newOrder 
     * @param  string    $app 
     * @access public
     * @return void
     */
    public function sort($oldOrder, $newOrder, $app = 'sys')
    {
        $oldOrder  = explode(',', $oldOrder);
        $newOrder  = explode(',', $newOrder);
        $orderList = $this->block->getBlockList($app);

        foreach($oldOrder as $key => $oldIndex)
        {
            if(!isset($orderList[$oldIndex])) continue;
            $order = $orderList[$oldIndex];
            $order->order = $newOrder[$key];
            $this->dao->replace(TABLE_BLOCK)->data($order)->exec();
        }

        if(dao::isError()) $this->send(array('result' => 'fail'));
        $this->send(array('result' => 'success'));
    }

    /**
     * Delete block 
     * 
     * @param  int    $index 
     * @param  string $sys 
     * @param  string $type 
     * @access public
     * @return void
     */
    public function delete($index, $app = 'sys', $type = 'delete')
    {
        if($type == 'hidden')
        {
            $this->dao->update(TABLE_BLOCK)->set('hidden')->eq(1)->where('`order`')->eq($index)->andWhere('account')->eq($this->app->user->account)->andWhere('app')->eq($app)->exec();
        }
        else
        {
            $this->dao->delete()->from(TABLE_BLOCK)->where('`order`')->eq($index)->andWhere('account')->eq($this->app->user->account)->andWhere('app')->eq($app)->exec();
        }
        if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));
        $this->send(array('result' => 'success'));
    }

    /**
     * Display dashboard for app.
     * 
     * @param  string    $appName 
     * @access public
     * @return void
     */
    public function dashboard($appName)
    {
        $this->app->loadLang('index', 'sys');
        $blocks = $this->block->getBlockList($appName);
        $inited = empty($this->config->personal->common->blockInited) ? '' : $this->config->personal->common->blockInited;

        /* Init block when vist index first. */
        if(empty($blocks) and !($inited and $inited->app == $appName and $inited->value))
        {
            if($this->block->initBlock($appName)) die(js::reload());
        }

        foreach($blocks as $key => $block)
        {
            $block->params = json_decode($block->params);

            if(empty($block->params)) $block->params = new stdclass();
            $block->params->account = $this->app->user->account;
            $block->params->uid     = $this->app->user->id;

            $query            = array();
            $query['mode']    = 'getblockdata';
            $query['blockid'] = $block->block;
            $query['hash']    = '';
            $query['lang']    = $this->app->getClientLang();
            $query['sso']     = '';
            $query['app']     = $appName;
            if(isset($block->params)) $query['param'] = base64_encode(json_encode($block->params));

            $query = http_build_query($query);
            $sign  = $this->config->requestType == 'PATH_INFO' ? '?' : '&';

            $block->blockLink = $this->createLink($appName . '.block', 'index') . $sign . $query;
        }

        $this->view->blocks = $blocks;
        $this->display();
    }
}
