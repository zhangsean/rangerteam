<?php
include '../../control.php';
class mytree extends tree
{
    public function browse($type = 'article', $root = 0)
    {
        if($type == 'dept')
        {   
            $this->lang->category   = $this->lang->dept;
            $this->lang->tree->menu = $this->lang->dept->menu;
            $this->lang->menuGroups->tree = 'user';
        }
        return parent::browse($type, $root);
    }
}
