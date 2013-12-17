<?php
include "../../control.php";
class myuser extends user
{
    public function admin($deptID = 0, $recTotal = 0, $recPerPage = 10, $pageID = 1)
    {
        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal, $recPerPage, $pageID);

        $key = $this->post->key ? $this->post->key : '';

        $this->view->treeMenu = $this->loadModel('tree')->getTreeMenu('dept', 0, array('exttreeModel', 'createDeptLink'));
        $this->view->depts    = $this->tree->getOptionMenu('dept');
        $this->view->users    = $this->user->getList($pager, $key, $deptID);
        $this->view->key      = $key;      
        $this->view->pager    = $pager;    
        $this->view->deptID   = $deptID;

        $this->display();
    }
}
