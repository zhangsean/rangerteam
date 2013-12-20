<?php
/**
 * The control file of tree category of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     tree
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
class tree extends control
{
    const NEW_CHILD_COUNT = 5;

    /**
     * Browse the categories and print manage links.
     * 
     * @param  string $type 
     * @param  int    $root 
     * @access public
     * @return void
     */
    public function browse($type = 'article', $root = 0)
    {
        if($type == 'forum')
        {
            $this->lang->category   = $this->lang->board;
            $this->lang->tree->menu = $this->lang->forum->menu;
            $this->lang->menuGroups->tree = 'forum';
        }

        if($type == 'blog')
        {
            $this->lang->tree->menu = $this->lang->blog->menu;
            $this->lang->menuGroups->tree = 'blog';
        }

        if($type == 'product')
        {
            $this->lang->tree->menu = $this->lang->product->menu;
            $this->lang->menuGroups->tree = 'product';
        }

        $this->view->title    = $this->lang->category->common;
        $this->view->type     = $type;
        $this->view->root     = $root;
        $this->view->treeMenu = $this->tree->getTreeMenu($type, 0, array('treeModel', 'createManageLink'));
        $this->view->children = $this->tree->getChildren($root, $type);

        $this->display();
    }

    /**
     * Edit a category.
     * 
     * @param  int      $categoryID 
     * @access public
     * @return void
     */
    public function edit($categoryID)
    {
        /* Get current category. */
        $category = $this->tree->getById($categoryID);

        /* If type is forum, assign board to category. */
        if($category->type == 'forum') $this->lang->category = $this->lang->board;

        if(!empty($_POST))
        {
            $result = $this->tree->update($categoryID);
            if($result === true) $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess));

            $this->send(array('result' => 'fail', 'message' => dao::isError() ? dao::getError() : $result));
        }

        /* Get option menu and remove the families of current category from it. */
        $optionMenu = $this->tree->getOptionMenu($category->type);
        $families   = $this->tree->getFamily($categoryID);
        foreach($families as $member) unset($optionMenu[$member]);

        /* Assign. */
        $this->view->category   = $category;
        $this->view->optionMenu = $optionMenu;
        $this->view->aliasAddon = trim("http://" . $this->server->http_host . $config->webRoot, '/' ). '/';

        if(strpos('forum,blog', $category->type) !== false) $this->view->aliasAddon .=  $category->type . '/';

        if($category->type == 'forum') 
        {
            $this->lang->menuGroups->tree = 'forum';
            $this->view->users = $this->loadModel('user')->getPairs('admin');
        }
        else if($category->type == 'blog')
        {
            $this->lang->menuGroups->tree = 'blog';
        }

        /* remove left menu. */
        unset($this->lang->tree->menu);

        $this->display();
    }

    /**
     * Manage children.
     *
     * @param  string    $type 
     * @param  int       $category    the current category id.
     * @access public
     * @return void
     */
    public function children($type, $category = 0)
    {
        /* If type is forum, assign board to category. */
        if($type == 'forum') $this->lang->category = $this->lang->board;

        if(!empty($_POST))
        { 
            $result = $this->tree->manageChildren($type, $this->post->parent, $this->post->children);
            $locate = $this->inLink('browse', "type=$type&root={$this->post->parent}");
            if($result === true) $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => $locate));
            $this->send(array('result' => 'fail', 'message' => dao::isError() ? dao::getError() : $result));
        }

        $this->view->title    = $this->lang->tree->manage;
        $this->view->type     = $type;
        $this->view->children = $this->tree->getChildren($category, $type);
        $this->view->origins  = $this->tree->getOrigin($category);
        $this->view->parent   = $category;

        $this->display();
    }

    /**
     * Delete a category.
     * 
     * @param  int    $categoryID 
     * @access public
     * @return void
     */
    public function delete($categoryID)
    {
        /* If type is 'forum' and has children, warning. */
        $category = $this->tree->getByID($categoryID);
        $children = $this->tree->getChildren($categoryID, $category->type); 
        if($children) $this->send(array('result' => 'fail', 'message' => $this->lang->tree->hasChildren));
 
        if($this->tree->delete($categoryID)) $this->send(array('result' => 'success'));
        $this->send(array('result' => 'fail', 'message' => dao::getError()));
    }
}
