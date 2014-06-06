<?php
/**
 * The control file of blog module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     blog
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
class blog extends control
{
    public function __CONSTRUCT()
    {
        parent::__CONSTRUCT();
        unset($this->lang->blog->menu);

        $this->app->loadClass('pager', $static = true);
        $pager = new pager(0, 8, 1);
        $this->view->latestArticles = $this->loadModel('article', 'sys')->getList('blog', 0, '', 'id_desc');

        $this->view->authors = $this->loadModel('article', 'sys')->getAuthorList('blog');

        $this->view->latestComments = $this->loadModel('message', 'sys')->getList('comment', 'blog', '');

    }

    /** 
     * Browse blog in front.
     * 
     * @param int    $categoryID   the category id
     * @param  string $author 
     * @param  int    $pageID 
     * @access public
     * @return void
     */
    public function index($categoryID = 0, $author = '', $pageID = 1)
    {
        $this->app->loadClass('pager', $static = true);
        $pager = new pager(0, 10, $pageID);

        $category   = $this->loadModel('tree')->getByID($categoryID, 'blog');
        $categoryID = is_numeric($categoryID) ? $categoryID : $category->id;
        $articles   = $this->loadModel('article')->getList('blog', $this->tree->getFamily($categoryID, 'blog'), $author, $orderBy = 'id_desc', $pager);
        $title      = '';

        if($category)
        {
            $title    = $category->name;
            $desc     = strip_tags($category->desc);
            $this->session->set('articleCategory', $category->id);
        }

        $this->view->title    = $title;
        $this->view->category = $category;
        $this->view->articles = $articles;
        $this->view->users    = $this->loadModel('user')->getPairs();
        $this->view->pager    = $pager;

        $this->display();
    }
    
    /**
     * View an article.
     * 
     * @param int $articleID 
     * @param int $currentCategory 
     * @access public
     * @return void
     */
    public function view($articleID, $currentCategory = 0)
    {
        $article  = $this->loadModel('article')->getByID($articleID);

        /* fetch category for display. */
        $category = array_slice($article->categories, 0, 1);
        $category = $category[0]->id;

        $currentCategory = $this->session->articleCategory;
        if($currentCategory > 0 && isset($article->categories[$currentCategory])) $category = $currentCategory;  
        $category = $this->loadModel('tree')->getByID($category);

        $title    = $article->title . ' - ' . $category->name;
        
        $this->view->title       = $title;
        $this->view->article     = $article;
        $this->view->prevAndNext = $this->loadModel('article')->getPrevAndNext($article->id, $category->id);
        $this->view->category    = $category;

        $this->dao->update(TABLE_ARTICLE)->set('views = views + 1')->where('id')->eq($articleID)->exec(false);
        $this->display();
    }
}
