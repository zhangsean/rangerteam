<?php
/**
 * The control file of product module of ZenTaoMS.
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
        
        $this->view->title    = $this->lang->product->browse;
        $this->view->products = $this->product->getList($orderBy, $pager);
        $this->view->pager    = $pager;
        $this->view->orderBy  = $orderBy;
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
            if(dao::isError())  $this->send(array('result' => 'fail', 'message' => dao::getError()));
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

        $this->view->title   = $this->lang->product->edit;
        $this->view->product = $this->product->getByID($productID);
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
        $this->view->title     = $this->lang->product->field->admin;
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
            if($this->product->createField($productID)) $this->send(array('result' => 'success', 'locate' => $this->inlink('adminField', "productID={$productID}")));
            $this->send(array('result' => 'fail', 'message' => dao::getError()));
        }
        $this->display();
    }

    /**
     * Edit a field.
     * 
     * @param  int    $fieldID
     * @access public
     * @return void
     */
    public function editField($fieldID)
    {
        $field = $this->product->getFieldByID($fieldID);

        if($_POST)
        {
            if($this->product->updateField($fieldID)) $this->send(array('result' => 'success', 'locate' => $this->inlink('adminField', "productID={$field->product}")));
            $this->send(array('result' => 'fail', 'message' => dao::getError()));
        }

        $this->view->field = $field;
        $this->display();
    }

    /**
     * Delete field.
     * 
     * @param  int    $fieldID 
     * @access public
     * @return void
     */
    public function deleteField($fieldID)
    {
        if($this->product->deleteField($fieldID)) $this->send(array('result' => 'success'));
        $this->send(array('result' => 'fail', 'message' => dao::getError()));
    }

    /**
     * Check field length.
     * 
     * @param  int    $fieldID 
     * @param  string $control 
     * @access public
     * @return void
     */
    public function checkFieldLength($fieldID, $control)
    {
        $field = $this->product->getFieldByID($fieldID);

        /* Init length to 256. */
        $oldLength = '256';
        $newLength = '256';
        foreach($this->config->field->lengthList as $length => $controls)
        {
            if(strpos($controls, ",$control,") !== false) $newLength = $length;
            if(strpos($controls, ",{$field->control},") !== false) $oldLength = $length;
        }

        if(($newLength < $oldLength)) echo $this->lang->product->field->lengthNotice;
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
            if($this->product->createAction($productID)) $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => $this->inlink('adminaction', "productID={$productID}")));
            $this->send(array('result' => 'fail', 'message' => dao::getError()));
        }
        $this->view->productID = $productID;
        $this->display();
    }

    /**
     * Edit an action.
     * 
     * @param  int    $actionID 
     * @access public
     * @return void
     */
    public function editAction($actionID)
    {
        $action = $this->product->getActionByID($actionID);
        if($_POST)
        {
            if($this->product->updateAction($actionID)) $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => $this->inlink('adminaction', "productID={$action->product}")));
            $this->send(array('result' => 'fail', 'message' => dao::getError()));
        }

        $this->view->title  = $this->lang->product->action->edit;
        $this->view->action = $action;
        $this->display();
    } 

    /**
     * Delete an action.
     * 
     * @param  int      $actionID 
     * @access public
     * @return void
     */
    public function deleteAction($actionID)
    {
        if($this->product->deleteAction($actionID)) $this->send(array('result' => 'success'));
        $this->send(array('result' => 'fail', 'message' => dao::getError()));
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
        if(empty($action->conditions))
        {
            $action->conditions = array();
            $defaultConditions  = new stdclass();
            $defaultConditions->operater = '';
            $defaultConditions->value    = '';
            $defaultConditions->field    = '';
            $defaultConditions->param    = '';

            $action->conditions[] = $defaultConditions;
        }

        if($_POST)
        {
            $result = $this->product->saveConditions($actionID);
            if($result) $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => $this->inlink('adminAction', "actionID={$action->product}")));
            $this->send(array('result' => 'fail', 'message' => dao::getError()));
        }

        $this->loadModel('order');

        $conditionFields = array('' => '');
        foreach($this->lang->order->fields as $name => $field) $conditionFields[$name] = $this->lang->order->{$name};

        $fields  = $this->product->getFieldList($action->product);
        foreach($fields as $field) $conditionFields[$field->field] = $field->name;

        $this->view->title           = $this->lang->product->action->adminConditions;
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
            if($result) $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => $this->inlink('adminAction', "actionID={$action->id}")));
            $this->send(array('result' => 'fail', 'message' => dao::getError()));
        }

        $this->loadModel('order');

        $inputFields = array('' => '');
        foreach($this->lang->order->fields as $name => $field) $inputFields[$name] = $this->lang->order->{$name};

        $fields  = $this->product->getFieldList($action->product);
        foreach($fields as $field) $inputFields[$field->field] = $field->name;

        $this->view->title   = $this->lang->product->action->adminInputs;
        $this->view->action  = $action;
        $this->view->inputFields  = $inputFields;
        $this->display();
    }
        
    /**
     * Action results list page.
     * 
     * @param  int    $actionID 
     * @access public
     * @return void
     */
    public function actionResults($actionID)
    {
        $action = $this->product->getActionByID($actionID);
        $this->loadModel('order');

        $commonFields = array('');
        foreach($this->lang->order->fields as $name => $field) $commonFields[$name] = $this->lang->order->{$name};
        $productFields  = $this->product->getFieldList($action->product);
        foreach($fields as $field) $commonFields[$field->field] = $field->name;
       

        $this->view->action  = $action; 
        $this->view->fields  = array_merge($commonFields, $productFields);
        $this->display();
    }

    /**
     * Create an action result.
     * 
     * @param  int    $actionID 
     * @access public
     * @return void
     */
    public function createResult($actionID)
    {
        $action = $this->product->getActionByID($actionID);      

        if($_POST)
        {
            $result = $this->product->createResult($action);
            if($result) $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('adminresults', "actionID={$actionID}")));
            $this->send(array('result' => 'fail', 'message' => dao::getError()));
        }

        $this->loadModel('order');

        $inputFields = array('');
        foreach($this->lang->order->fields as $name => $field) $inputFields[$name] = $this->lang->order->{$name};

        $fields  = $this->product->getFieldList($action->product);
        foreach($fields as $field) $inputFields[$field->field] = $field->name;
        
        $conditionFields = $inputFields;
        foreach($inputFields as $field => $name)
        {
            if(isset($action->inputs->{$field})) unset($inputFields[$field]);
        }

        $this->view->action          = $action;
        $this->view->inputFields     = $inputFields;
        $this->view->conditionFields = $conditionFields;
        $this->display(); 
    } 

    /**
     * Action tasks. 
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
            $action->tasks = array();

            $defaultTask = new stdclass();
            $defaultTask->name     = '';
            $defaultTask->role     = '';
            $defaultTask->days     = '';
            $defaultTask->desc     = '';
            $defaultTask->estimate = '';

            $action->tasks[] =$defaultTask;
        }

        if($_POST)
        {
            $result = $this->product->saveTasks($actionID);
            if($result) $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => $this->inlink('adminAction', "actionID={$action->product}")));
            $this->send(array('result' => 'fail', 'message' => dao::getError()));
        }

        $this->view->title  = $this->lang->product->action->adminTasks;
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

        $this->view->roles = $this->product->getRoleList($productID);
        if(empty($this->view->roles)) $this->view->roles = array('' => '');

        $this->view->title = $this->lang->product->roles;
        $this->display(); 
    }
}
