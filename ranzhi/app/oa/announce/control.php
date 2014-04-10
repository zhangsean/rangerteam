<?php
/**
 * The control file of announce module of Ranzhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     announce
 * @version     $Id: control.php 8180 2014-04-08 07:22:52Z guanxiying $
 * @link        http://www.ranzhi.org
 */
class announce extends control
{
    /** 
     * The index page, locate to the first category or home page if no category.
     * 
     * @access public
     * @return void
     */
    public function index()
    {   
        $this->locate(inlink('browse'));
    }   

    /**
     * Browse article.
     * 
     * @param string $type        the article type
     * @param int    $categoryID  the category id
     * @param int    $recTotal 
     * @param int    $recPerPage 
     * @param int    $pageID 
     * @access public
     * @return void
     */
    public function browse($type = 'announce', $categoryID = 0, $orderBy = 'id_desc', $recTotal = 0, $recPerPage = 20, $pageID = 1)
    {   
        $this->loadModel('article');
        $this->lang->article->menu = $this->lang->$type->menu;
        $this->lang->menuGroups->article = $type;

        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal, $recPerPage, $pageID);

        $families = $categoryID ? $this->loadModel('tree')->getFamily($categoryID, $type) : '';
        $articles = $this->article->getList($type, $families, $orderBy, $pager);

        $this->view->title      = $this->lang->announce->browse;
        $this->view->type       = $type;
        $this->view->users      = $this->loadModel('user')->getPairs();
        $this->view->category   = $this->loadModel('tree')->getByID($categoryID);
        $this->view->categoryID = $categoryID;
        $this->view->articles   = $articles;
        $this->view->pager      = $pager;
        $this->view->orderBy    = $orderBy;

        $this->display();
    }   

    /**
     * View an announce.
     * 
     * @param int $announceID 
     * @access public
     * @return void
     */
    public function view($announceID)
    {
        $announce  = $this->loadModel('article')->getByID($announceID);

        /* fetch category for display. */
        $category = array_slice($announce->categories, 0, 1);
        $category = $category[0]->id;

        $currentCategory = $this->session->articleCategory;
        if($currentCategory > 0 && isset($announce->categories[$currentCategory])) $category = $currentCategory;  

        $category = $this->loadModel('tree')->getByID($category);

        $title    = $announce->title . ' - ' . $category->name;
        
        $this->view->title       = $title;
        $this->view->author      = $this->loadModel('user')->getByAccount($announce->author);
        $this->view->announce    = $announce;
        $this->view->prevAndNext = $this->article->getPrevAndNext($announce->id, $category->id);
        $this->view->category    = $category;

        $this->dao->update(TABLE_ARTICLE)->set('views = views + 1')->where('id')->eq($announceID)->exec(false);

        $this->display();
    }
}
