<?php
/**
 * The control file of webapp of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2013 QingDao Nature Easy Soft Network Technology Co,LTD (www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Yidong Wang <Yidong@cnezsoft.com>
 * @package     webapp
 * @version     $Id$
 * @link        http://www.zentao.net
 */
class webapp extends control
{

    /**
     * Obtain web app. 
     * 
     * @param  string $type 
     * @param  string $param 
     * @param  int    $recTotal 
     * @param  int    $recPerPage 
     * @param  int    $pageID 
     * @access public
     * @return void
     */
    public function obtain($type = 'byUpdatedTime', $param = '', $recTotal = 0, $recPerPage = 20, $pageID = 1)
    {
        $this->lang->webapp->menu = $this->lang->entry->menu;
        $this->lang->menuGroups->webapp = 'entry';

        /* Init vars. */
        $type     = strtolower($type);
        $moduleID = $type == 'bymodule' ? (int)$param : 0;
        $webapps  = array();
        $pager    = null;

        /* Set the key. */
        if($type == 'bysearch') $param = helper::safe64Encode($this->post->key);

        /* Get results from the api. */
        $recPerPage = $this->cookie->pagerWebappObtain ? $this->cookie->pagerWebappObtain : $recPerPage;
        $results = $this->webapp->getAppsByAPI($type, $param, $recTotal, $recPerPage, $pageID);
        if($results)
        {
            $this->app->loadClass('pager', $static = true);
            $pager   = new pager($results->dbPager->recTotal, $results->dbPager->recPerPage, $results->dbPager->pageID);
            $webapps = $results->webapps;
        }

        $this->view->title      = $this->lang->webapp->common . $this->lang->colon . $this->lang->webapp->obtain;
        $this->view->position[] = $this->lang->webapp->obtain;
        $this->view->moduleTree = $this->webapp->getModulesByAPI();
        $this->view->webapps    = $webapps;
        $this->view->installeds = $this->webapp->getLocalApps();
        $this->view->pager      = $pager;
        $this->view->tab        = 'obtain';
        $this->view->type       = $type;
        $this->view->moduleID   = $moduleID;
        $this->display();
    }

    /**
     * Install web app. 
     * 
     * @param  int    $webappID 
     * @access public
     * @return void
     */
    public function install($webappID)
    {
        $result = $this->webapp->install($webappID);
        if(dao::isError())
        {
            echo js::error(dao::getError());
            die(js::locate($this->createLink('webapp', 'obtain')));
        }
        echo js::alert($this->lang->webapp->successInstall);
        die(js::locate($this->createLink('entry', 'admin')));
    }

    /**
     * View app.
     * 
     * @param  int    $webappID 
     * @param  string $type 
     * @access public
     * @return void
     */
    public function view($webappID, $type = 'local')
    {
        $this->view->title   = $this->lang->webapp->common . $this->lang->colon . $this->lang->webapp->edit;
        $this->view->modules = $this->loadModel('tree')->getOptionMenu(0, 'webapp');
        $this->view->users   = $this->loadModel('user')->getPairs('noletter');
        $this->view->webapp  = $type == 'local' ? $this->webapp->getLocalAppByID($webappID) : $this->webapp->getAppInfoByAPI($webappID)->webapp;
        $this->view->type    = $type;
        $this->display();
    }
}
