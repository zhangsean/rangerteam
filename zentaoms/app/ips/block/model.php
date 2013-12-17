<?php
/**
 * The model file of block module of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     block
 * @version     $ID$
 * @link        http://www.chanzhi.org
 */
class blockModel extends model
{
    /**
     * Get block by id.
     * 
     * @param string $blockID 
     * @access public
     * @return object   the block.
     */
    public function getByID($blockID)
    {
        $block = $this->dao->findByID($blockID)->from(TABLE_BLOCK)->fetch();
        if(strpos('html,code', $block->type) === false) $block->content = json_decode($block->content);
        return $block;
    }

    /**
     * Get block list of one site.
     * 
     * @param  object    $pager 
     * @access public
     * @return array
     */
    public function getList($pager)
    {
        $blocks = $this->dao->select('*')->from(TABLE_BLOCK)->orderBy('id_desc')->page($pager)->fetchAll('id');
        return $blocks;
    }

    /**
     * Get block list of one region.
     * 
     * @param  string    $module 
     * @param  string    $method 
     * @access public
     * @return array
     */
    public function getPageBlocks($module, $method)
    {
        $pages      = "all,{$module}_{$method}";
        $rawLayouts = $this->dao->select('*')->from(TABLE_LAYOUT)->where('page')->in($pages)->fetchGroup('page', 'region');

        $blocks = '';
        foreach($rawLayouts as $page => $pageBlocks)
        {
            foreach($pageBlocks as $regionBlocks) $blocks .= ',' . $regionBlocks->blocks;
        }

        $blocks = explode(',', $blocks);
        $blocks = $this->dao->select('*')->from(TABLE_BLOCK)->where('id')->in($blocks)->fetchAll('id');

        $layouts = array();
        foreach($rawLayouts as $page => $pageBlocks) 
        {
            $layouts[$page] = array();
            foreach($pageBlocks as $region => $regionBlock)
            {
                $layouts[$page][$region] = array();
                $regionBlocks =  explode(',', $regionBlock->blocks);
                foreach($regionBlocks as $block)
                {
                    if(isset($blocks[$block])) $layouts[$page][$region][] = $blocks[$block];
                }
            }
        }
        return $layouts;
    }

    /**
     * Get block list of one region.
     * 
     * @param  string    $page 
     * @param  string    $region 
     * @access public
     * @return array
     */
    public function getRegionBlocks($page, $region)
    {
        $blockIdList = $this->dao->select('*')->from(TABLE_LAYOUT)->where('page')->eq($page)->andWhere('region')->eq($region)->fetch('blocks');
        $blocks      = $this->dao->select('*')->from(TABLE_BLOCK)->where('id')->in($blockIdList)->fetchAll('id');
        $blockIdList = explode(',', $blockIdList);

        $sortedBlocks = array();
        foreach($blockIdList as $id) 
        {
            if(isset($blocks[$id])) $sortedBlocks[$id] = $blocks[$id];
        }
        return $sortedBlocks;
    }

    /**
     * Get block id => title pairs.
     * 
     * @access public
     * @return array
     */
    public function getPairs()
    {
        return $this->dao->select('id, title')->from(TABLE_BLOCK)->fetchPairs();
    }
    
    /**
     * Create type  select area.
     * 
     * @param  string    $type 
     * @param  int       $blockID 
     * @access public
     * @return string
     */
    public function createTypeSelector($type, $blockID = 0)
    {
        $select = "<div class='btn-group'><button type='button' class='btn btn-default dropdown-toggle' data-toggle='dropdown'>";
        $select .= $this->lang->block->typeList[$type] . " <span class='caret'></span></button>";
        $select .= "<ul class='dropdown-menu' role='menu'>";
        foreach($this->lang->block->typeGroups as $block => $group)
        {
            if(isset($lastGroup) and $group !== $lastGroup) $select .= "<li class='divider'></li>";
            $lastGroup = $group;
            $class = ($block == $type) ? "class='active'" : '';
            if($blockID)
            {
                $select .= "<li {$class}>" . html::a(helper::createLink('block', $this->app->getMethodName(), "blockID={$blockID}&type={$block}"), $this->lang->block->typeList[$block]) . "</li>";
            }
            else
            {
                $select .= "<li {$class}>" . html::a(helper::createLink('block', $this->app->getMethodName(), "type={$block}"), $this->lang->block->typeList[$block]) . "</li>";
            }
        }
        $select .= "</ul></div>" .  html::hidden('type', $type);
        return $select;
    }

    /**
     * Create form entry of one block backend.
     * 
     * @param  object  $block 
     * @access public
     * @return void
     */
    public function createEntry($block = null )
    {
        $blockOptions[''] = $this->lang->block->select;
        $blockOptions += $this->getPairs();
        $entry = "<tr class='v-middle'>";
        $entry .= '<td>' . html::select('blocks[]', $blockOptions, isset($block->id) ? $block->id : '', "class='form-control'") . '</td>';
        $entry .= '<td class="text-middle">';
        $entry .= html::a('javascript:;', $this->lang->block->add, "class='plus'");
        $entry .= html::a('javascript:;', $this->lang->delete, "class='delete'");
        $entry .= html::a(inlink('edit', "blockID={$block->id}&type={$block->type}"), $this->lang->edit, "class='edit'");
        $entry .= "<i class='icon-arrow-up'></i> <i class='icon-arrow-down'></i>";
        $entry .= '</td></tr>';
        return $entry;
    }

    /**
     * Create a block.
     * 
     * @access public
     * @return void
     */
    public function create()
    {
        $block = fixer::input('post')->stripTags('content', $this->config->block->allowedTags)->get();

        if(isset($block->params))
        {
            foreach($block->params as $field => $value)
            {
                if(is_array($value)) $block->params[$field] = join($value, ',');
            }
            $block->content = json_encode($block->params);
        }

        $this->dao->insert(TABLE_BLOCK)->data($block, 'params,uid')->autoCheck()->exec();

        $blockID = $this->dao->lastInsertID();
        $this->loadModel('file')->updateObjectID($this->post->uid, $blockID, 'block');

        return true;
    }

    /**
     * Update  block.
     * 
     * @access public
     * @return void
     */
    public function update()
    {
        $block = fixer::input('post')->stripTags('content', $this->config->block->allowedTags)->get();

        if(isset($block->params))
        {
            foreach($block->params as $field => $value)
            {
                if(is_array($value)) $block->params[$field] = join($value, ',');
            }
            $block->content = json_encode($block->params);
        }

        $this->dao->update(TABLE_BLOCK)->data($block, 'params,uid,blockID')->autoCheck()->where('id')->eq($this->post->blockID)->exec();

        $this->loadModel('file')->updateObjectID($this->post->uid, $this->post->blockID, 'block');
        return true;
    }

    /**
     * Delete one block.
     * 
     * @param  int    $blockID 
     * @param  null    $table 
     * @access public
     * @return void
     */
    public function delete($blockID, $table = null)
    {
        $this->dao->delete()->from(TABLE_BLOCK)->where('id')->eq($blockID)->exec();
        return !dao::isError();
    }

    /**
     * Set block of one region.
     * 
     * @param string $page 
     * @param string $region 
     * @access public
     * @return void
     */
    public function setRegion($page, $region)
    {
        $layout = new stdclass();
        $layout->page   = $page;
        $layout->region = $region;
        $layout->blocks = trim(join($_POST['blocks'], ','), ',');

        $count = $this->dao->select('count(*) as count')->from(TABLE_LAYOUT)->where('page')->eq($page)->andWhere('region')->eq($region)->fetch('count');

        if($count)  $this->dao->update(TABLE_LAYOUT)->data($layout)->where('page')->eq($page)->andWhere('region')->eq($region)->exec();
        if(!$count) $this->dao->insert(TABLE_LAYOUT)->data($layout)->exec();

        return !dao::isError();
    }

    /**
     * Print blocks of one region.
     * 
     * @param  array    $blocks 
     * @param  string   $method 
     * @param  string   $region 
     * @param  string   $containerHeader 
     * @param  string   $containerFooter 
     * @access public
     * @return void
     */
    public function printRegion($blocks, $method = '', $region = '', $containerHeader = '', $containerFooter = '')
    {
        if(!isset($blocks[$method][$region])) return '';
        $blocks = $blocks[$method][$region];
        $html   = '';
        foreach($blocks as $block) $html .= $this->parseBlockContent($block, $containerHeader, $containerFooter);
        echo $html;
    }

    /**
     * Parse the content of one block.
     * 
     * @param object $block 
     * @param  string    $containerHeader 
     * @param  string    $containerFooter 
     * @access private
     * @return string
     */
    private function parseBlockContent($block, $containerHeader, $containerFooter)
    {
        $blockRoot = dirname(__FILE__) . '/ext/view/block/';
        $blockFile = $blockRoot . strtolower($block->type) . '.html.php';
        if(!file_exists($blockFile))
        {
            $blockRoot = dirname(__FILE__) . '/view/block/';
            $blockFile = $blockRoot . strtolower($block->type) . '.html.php';
        }
        if(!file_exists($blockFile)) return '';

        echo $containerHeader;
        include $blockFile;
        echo $containerFooter;
    }
}
