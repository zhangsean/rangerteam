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
    /* The default counts when creating. */
    const NEW_ROLE_COUNT = 5;

    /** 
     * The index page, locate to browse.
     * 
     * @access public
     * @return void
     */
    public function index()
    {   
        $this->locate(inlink('browse'));
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
    public function browse($orderBy = 'id_desc', $recTotal = 0, $recPerPage = 20, $pageID = 1)
    {   
        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal, $recPerPage, $pageID);
        
        $products = $this->product->getList($orderBy, $pager);

        $this->view->title    = $this->lang->product->browse;
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
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('browse')));
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
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('browse')));
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
        $this->view->fields    = $this->product->getFieldList($productID);
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

    /**
     * Admin actions of order. 
     * 
     * @param  int    $productID 
     * @access public
     * @return void
     */
    public function adminAction($productID)
    {
        $this->view->productID = $productID;
        $this->view->actions   = $this->product->getActionList($productID);
        $this->display();
    }

    /**
     * Create an action of an order.
     * 
     * @param  int    $productID 
     * @access public
     * @return void
     */
    public function createAction($productID)
    {
        if($_POST)
        {
            if($this->product->createAction($productID)) $this->send(array('result' => 'success', 'message' => $this->lang->success, 'locate' => $this->inlink('adminaction', "productID={$productID}")));
            $this->send(array('result' => 'fail', 'message' => dao::getError()));
        }
        $this->view->productID = $productID;
        $this->display();
    }

    /**
     * Action conditions.
     * 
     * @param  int    $actionID 
     * @access public
     * @return void
     */
    public function actionConditions($actionID)
    {
        $action = $this->product->getActionByID($actionID);
        if(empty($action)) die('');
        if(empty($action->condations))
        {
            $action->condations = array();
            $defaultCondations  = new stdclass();
            $defaultCondations->operater = '';
            $defaultCondations->value    = '';

            $action->condations[''] = $defaultInput;
        }

        if($_POST)
        {
            $result = $this->product->saveConditions($actionID);
            if($result) $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => $this->inlink('adminAction', "actionID={$action->product}")));
            $this->send(array('result' => 'fail', 'message' => dao::getError()));
        }

        $this->loadModel('order');

        $conditionFields = array('' => '');
        foreach($this->config->order->conditionFields as $field) $conditionFields[$field] = $this->lang->order->{$field};

        $fields  = $this->product->getFieldList($action->productID);
        foreach($fields as $field) $conditionFields[$field->field] = $field->name;

        $this->view->action          = $action;
        $this->view->conditionFields = $conditionFields;
        $this->display();
    }
    
    /**
     * Action inputs.
     * 
     * @param  int    $actionID 
     * @access public
     * @return void
     */
    public function actionInputs($actionID)
    {
        $action = $this->product->getActionByID($actionID);      
        if(empty($action)) die('');
        if(empty($action->inputs))
        {
            $action->inputs = array();
            $defaultInput = new stdclass();
            $defaultInput->field   = '';
            $defaultInput->rules   = '';
            $defaultInput->default = '';
            $action->inputs[''] = $defaultInput;
        }

        if($_POST)
        {
            $result = $this->product->saveInputs($actionID);
            if($result) $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => $this->inlink('adminAction', "actionID={$action->product}")));
            $this->send(array('result' => 'fail', 'message' => dao::getError()));
        }

        $this->loadModel('order');

        $inputFields = array('' => '');
        foreach($this->config->order->conditionFields as $field) $inputFields[$field] = $this->lang->order->{$field};

        $fields  = $this->product->getFieldList($action->productID);
        foreach($fields as $field) $inputFields[$field->field] = $field->name;

        $this->view->action  = $action;
        $this->view->inputFields  = $inputFields;
        $this->display();
    }

    /**
<<<<<<< .mine
     * Action tasks 
     * 
     * @param  int    $actionID 
     * @access public
     * @return void
     */
    public function actionTasks($actionID)
    {
        $action = $this->product->getActionByID($actionID);      
        if(empty($action)) die('');
        if(empty($action->tasks))
        {
            $action->inputs = array();
            $defaultTask = new stdclass();
            $defaultTask->field   = '';
            $defaultTask->rules   = '';
            $defaultTask->default = '';
            $action->tasks =array($defaultTask);
        }

        if($_POST)
        {
            $result = $this->product->saveTasks($actionID);
            if($result) $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => $this->inlink('adminAction', "actionID={$action->product}")));
            $this->send(array('result' => 'fail', 'message' => dao::getError()));
        }

        $this->view->action = $action;

        $productRoles = $this->product->getRoleList($action->product);
        $systemRoles  = $this->loadModel('user', 'sys')->getRoleList();
        $this->view->roles = (array)$productRoles + (array)$systemRoles;

        $this->display();
    }

    /**
     * Admin roles of a product.
     *
     * @param  int    $productID.
     * @access public
     * @return void
     */
    public function adminRoles($productID)
    {
        if($_POST)
        {
            $this->product->adminRoles($productID);
            if(!dao::isError()) $this->send(array('result' => 'success', 'message'=>$this->lang->saveSuccess));
            $this->send(array('result' => 'fail', 'message' => dao::getError()));
        }

        $this->view->title = $this->lang->product->roles;
        $this->view->roles = $this->product->getRoleList($productID);

        $this->display(); 
    }
}
