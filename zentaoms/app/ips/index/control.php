<?php
/**
 * The control file of index module of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     index
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
class index extends control
{
    /**
     * Construct, must create this contruct function since there's index() also
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * The index page of whole site.
     * 
     * @access public
     * @return void
     */
    public function index()
    {
        $this->app->loadLang('user');
        
        $this->view->products = $this->loadModel('product')->getLatest(0, 3);

        $this->view->slides         = $this->loadModel('slide')->getList();
        $this->view->latestArticles = $this->loadModel('article')->getLatest(0, 8);
        $this->view->latestBlogs    = $this->loadModel('article')->getLatest(0, 8, 'blog');
        $this->view->contact        = $this->loadModel('company')->getContact();
        $this->display();
    }
}
