<?php
class user extends control
{
    public function edit($account = '')
    {   
        if($this->app->user->account == 'guest') $this->locate(inlink('login'));
        if(empty($account)) $account = $this->app->user->account;

        if(!empty($_POST))
        {   
            $this->user->update($account);
            if(dao::isError()) $this->send( array( 'result' => 'fail', 'message' => dao::getError()));
            $this->send(array('result' => 'success', 'locate' => inlink('admin')));
        }

        $this->view->treeMenu = $this->loadModel('tree')->getTreeMenu('dept', 0, array('exttreeModel', 'createDeptLink'));
        $this->view->depts    = $this->tree->getOptionMenu('dept');
        $this->view->user     = $this->user->getByAccount($account);
        $this->display();
    }   
}
