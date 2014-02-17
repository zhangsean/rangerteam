<?php
/**
 * The control file of dashboard module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     dashboard
 * @version     $Id$
 * @link        http://www.zentao.net
 */
class dashboard extends control
{
    /**
     * Dsahboard Index page.
     * 
     * @access public
     * @return void
     */
    public function index()
    {
        $this->app->loadLang('index', 'sys');
        $blocks = empty($this->config->index->block) ? array() : (array)$this->config->index->block;
        ksort($blocks);

        $this->view->blocks = $blocks;
        $this->display();
    }
}

