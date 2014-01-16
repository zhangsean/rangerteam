<?php
/**
 * The control file of field category of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     field
 * @version     $Id$
 * @link        http://www.zentao.net
 */
class field extends control
{
    /**
     * Browse field. 
     * 
     * @param  int    $productID 
     * @access public
     * @return void
     */
    public function browse($productID)
    {
        $this->view->productID = $productID;
        $this->display();
    }

    /**
     * Create a field.
     * 
     * @param  int    $productID 
     * @access public
     * @return void
     */
    public function create($productID)
    {
        if($_POST)
        {
            if($this->field->create($productID)) $this->send(array('result' => 'success', 'locate' => $this->inlink('browse' , "productID={$productID}")));
            $this->send(array('result' => 'fail', 'message' => dao::getError()));
        }
        $this->display();
    }

    /**
     * Edit a field.
     * 
     * @param  int    $field 
     * @access public
     * @return void
     */
    public function edit($field)
    {
        $this->display();
    }

}
