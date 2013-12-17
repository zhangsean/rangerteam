<?php
class user extends control
{
    public function create()
    {   
        if(!empty($_POST))
        {   
            $this->user->create();
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));
            /* Go to the referer. */
            $this->send( array('result' => 'success', 'locate'=>inlink('admin')) );
        }   

        $this->view->treeMenu = $this->loadModel('tree')->getTreeMenu('dept', 0, array('exttreeModel', 'createDeptLink'));
        $this->view->depts    = $this->tree->getOptionMenu('dept');
        $this->display();
    }
}
