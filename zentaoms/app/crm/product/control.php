<?php
/**
 * The control file of product category of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     product
 * @version     $Id$
 * @link        http://www.zentao.net
 */
class product extends control
{
    /** 
     * The index page, locate to admin.
     * 
     * @access public
     * @return void
     */
    public function index()
    {   
        $this->locate(inlink('admin'));
    }   

    /**
     * Browse product.
     * 
     * @param string $orderBy     the order by
     * @param int    $recTotal 
     * @param int    $recPerPage 
     * @param int    $pageID 
     * @access public
     * @return void
     */
    public function admin($orderBy = 'id_desc', $recTotal = 0, $recPerPage = 20, $pageID = 1)
    {   
        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal, $recPerPage, $pageID);
        
        $products = $this->product->getList($orderBy, $pager);

        $this->view->title    = $this->lang->product->admin;
        $this->view->products = $products;
        $this->view->pager    = $pager;
        $this->display();
    }   

    /**
     * Create a product.
     * 
     * @access public
     * @return void
     */
    public function create()
    {
        if($_POST)
        {
            $productID = $this->product->create();       
            if(dao::isError())  $this->send(array('result' => 'fail', 'message' => dao::geterror()));
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('admin')));
        }

        $this->view->title = $this->lang->product->create;
        $this->display();
    }

    /**
     * Edit a product.
     * 
     * @param  int $productID 
     * @access public
     * @return void
     */
    public function edit($productID)
    {
        if($_POST)
        {
            $this->product->update($productID);
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('admin')));
        }

        $product = $this->product->getByID($productID);

        $this->view->title   = $this->lang->product->edit;
        $this->view->product = $product;

        $this->display();
    }

    /**
     * Delete a product.
     * 
     * @param  int      $productID 
     * @access public
     * @return void
     */
    public function delete($productID)
    {
        if($this->product->delete($productID)) $this->send(array('result' => 'success'));
        $this->send(array('result' => 'fail', 'message' => dao::getError()));
    }

    /**
     * Browse field. 
     * 
     * @param  int    $productID 
     * @access public
     * @return void
     */
    public function adminField($productID)
    {
        $this->view->productID = $productID;
        $this->view->fields    = $this->product->getFieldList($productID);

        $this->display();
    }

    /**
     * Create a field.
     * 
     * @param  int    $productID 
     * @access public
     * @return void
     */
    public function createField($productID)
    {
        if($_POST)
        {
            if($this->product->createField($productID)) $this->send(array('result' => 'success', 'locate' => $this->inlink('adminField' , "productID={$productID}")));
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
    public function editField($field)
    {
        $this->display();
    }
}
