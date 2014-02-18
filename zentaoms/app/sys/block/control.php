<?php
/**
 * The control file of block module of ZenTaoMS.
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
     * Admin all blocks. 
     * 
     * @param  int    $index 
     * @access public
     * @return void
     */
    public function admin($index)
    {
        $entries = $this->dao->select('*')->from(TABLE_ENTRY)->where('block')->ne('')->fetchAll('id');

        $allEntries[''] = '';
        foreach($entries as $id => $entry) $allEntries[$id] = $entry->name;
        $allEntries['rss']  = 'RSS';
        $allEntries['html'] = 'HTML';

        $this->view->block      = $this->block->getBlock($index);
        $this->view->entries    = $entries;
        $this->view->allEntries = $allEntries;
        $this->view->index      = $index;
        $this->display();
    }

    /**
     * Set params when type is rss or html. 
     * 
     * @param  int    $index 
     * @param  string $type 
     * @access public
     * @return void
     */
    public function set($index, $type)
    {
        if($_POST)
        {
            $this->block->save($index, $type);
            if(dao::isError())  $this->send(array('result' => 'fail', 'message' => dao::geterror()));
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => $this->server->http_referer));
        }

        $block = $this->block->getBlock($index);

        $this->view->type   = $type;
        $this->view->index  = $index;
        $this->view->block  = ($block and $block->type == $type) ? $block : array();
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
        if($block->type == 'system') $html = $this->block->getEntry($block);
        if($block->type == 'rss')    $html = $this->block->getRss($block);
        if($block->type == 'html')   $html = "<div class='article-content'>" . htmlspecialchars_decode($block->html) .'</div>';

        die($html);
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
        $oldOrder = explode(',', $oldOrder);
        $newOrder = explode(',', $newOrder);

        $orders  = array();
        $account = $this->app->user->account;
        foreach($newOrder as $key => $index)
        {
            $orders['b' . $index] = $this->config->personal->index->block->{'b' . $oldOrder[$key]}->value;

        }

        $this->loadModel('setting')->deleteItems("owner=$account&app=sys&module=index&section=block");
        $this->setting->setItems($account . '.sys.index.block', $orders);

        if(dao::isError()) $this->send(array('result' => 'fail'));
        $this->send(array('result' => 'success'));
    }

    /**
     * Delete block 
     * 
     * @param  int    $index 
     * @access public
     * @return void
     */
    public function delete($index)
    {
        $this->loadModel('setting')->deleteItems('owner=' . $this->app->user->account . '&app=sys&module=index&section=block&key=b' . $index);
        if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));
        $this->send(array('result' => 'success'));
    }
}
