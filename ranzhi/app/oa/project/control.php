<?php
/**
 * The control file of project module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     project
 * @version     $Id: control.php 7417 2013-12-23 07:51:50Z wwccss $
 * @link        http://www.ranzhi.org
 */
class project extends control
{
    public function __construct()
    {
        parent::__construct();

        $this->projects = $this->project->getPairs();

        $this->lang->project->menu = $this->project->getLeftMenus($this->projects);
    }

    public function index()
    {
        $this->locate(inlink('browse'));
    }

    public function browse($projectID = 0, $orderBy = 'id_desc', $recTotal = 0, $recPerPage = 20, $pageID = 1)
    {
        $projectID = $projectID ? $projectID : key((array)$this->projects);
        if(!$projectID) $this->locate(inlink('create'));

        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal, $recPerPage, $pageID);

        $this->loadModel('task');
        $this->session->set('taskList', $this->app->getURI(true));

        $this->view->title     = $this->lang->task->browse;
        $this->view->tasks     = $this->task->getByProject($projectID, $orderBy, $pager);
        $this->view->pager     = $pager;
        $this->view->orderBy   = $orderBy;
        $this->view->projectID = $projectID;
        $this->display();
    }

    public function create()
    {
        if($_POST)
        {
            $projectID = $this->project->create();
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));

            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('browse')));
        }

        $this->view->title = $this->lang->project->create;
        $this->display();
    }
}
