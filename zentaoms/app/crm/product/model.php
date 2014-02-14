<?php
/**
 * The model file of product category of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     product
 * @version     $Id$
 * @link        http://www.zentao.net
 */
class productModel extends model
{
    /**
     * Get produt by id.
     * 
     * @param  int    $id 
     * @access public
     * @return object 
     */
    public function getByID($id)
    {
       return $this->dao->select('*')->from(TABLE_PRODUCT)->where('id')->eq($id)->limit(1)->fetch();
    }

    /** 
     * Get product list.
     * 
     * @param  string  $orderBy 
     * @param  object  $pager 
     * @access public
     * @return array
     */
    public function getList($orderBy = 'id_desc', $pager = null)
    {
        return $this->dao->select('*')->from(TABLE_PRODUCT)->where('deleted')->eq(0)->orderBy($orderBy)->page($pager)->fetchAll('id');
    }

    /** 
     * Get product pairs.
     * 
     * @param  string  $orderBy 
     * @access public
     * @return array
     */
    public function getPairs($orderBy = 'id_desc')
    {
        return $this->dao->select('id, name')->from(TABLE_PRODUCT)->where('deleted')->eq(0)->orderBy($orderBy)->fetchPairs('id');
    }

    /**
     * Create a product.
     * 
     * @access public
     * @return int|bool
     */
    public function create()
    {
        $now = helper::now();
        $product = fixer::input('post')
            ->add('createdBy', $this->app->user->account)
            ->add('createdDate', $now)
            ->add('editedDate', $now)
            ->setDefault('deleted', 0)
            ->get();

        $this->dao->insert(TABLE_PRODUCT)
            ->data($product)
            ->autoCheck()
            ->batchCheck($this->config->product->require->create, 'notempty')
            ->check('code', 'unique')
            ->check('code', 'code')
            ->exec();

        $productID = $this->dao->lastInsertID();

        if(dao::isError()) return false;

        $sql = "CREATE TABLE IF NOT EXISTS `crm_order_{$product->code}` ( `order` mediumint(5) NOT NULL, PRIMARY KEY (`order`)) ENGINE=MyISAM DEFAULT CHARSET=utf8";
        if(!$this->dbh->query($sql)) return false;

        return $productID;
    }

    /**
     * Update a product.
     * 
     * @param  int $productID 
     * @access public
     * @return void
     */
    public function update($productID)
    {
        $product = $this->getByID($productID);
        $code    = $product->code;

        $product = fixer::input('post')
            ->add('editedBy', $this->app->user->account)
            ->add('editedDate', helper::now())
            ->setDefault('deleted', 0)
            ->get();

        $this->dao->update(TABLE_PRODUCT)
            ->data($product)
            ->autoCheck()
            ->batchCheck($this->config->product->require->edit, 'notempty')
            ->check('code', 'unique', "id<>{$productID}")
            ->check('code', 'code')
            ->where('id')->eq($productID)
            ->exec();

        if(dao::isError()) return false;

        if($code != $product->code)
        {
            $sql = "RENAME TABLE `crm_order_{$code}` TO `crm_order_{$product->code}`" ;
            if(!$this->dbh->query($sql)) return false;
        }

        return !dao::isError();
    }

    /**
     * Delete a product.
     * 
     * @param  int      $productID 
     * @access public
     * @return void
     */
    public function delete($productID, $table = null)
    {
        $this->dao->update(TABLE_PRODUCT)->set('deleted')->eq(1)->where('id')->eq($productID)->exec();

        return !dao::isError();
    }

    /**
     * Get field by id. 
     * 
     * @param  int    $fieldID 
     * @access public
     * @return object
     */
    public function getFieldByID($fieldID)
    {
        $field = $this->dao->select('*')->from(TABLE_ORDERFIELD)->where('id')->eq($fieldID)->limit(1)->fetch();
        $field->options = json_decode($field->options, true);
        return $field;
    }

    /**
     * Get field list.
     * 
     * @param  int    $productID 
     * @access public
     * @return void
     */
    public function getFieldList($productID)
    {
        $fields = $this->dao->select('*')->from(TABLE_ORDERFIELD)->where('product')->eq($productID)->orderBy('`order`')->fetchAll('field');
        foreach($fields as $field)
        {
            $field->options = json_decode($field->options, true);
        }
        return $fields;
    }

    /**
     * Build order form of a product.
     * 
     * @param  int       $productID 
     * @param  object    $values 
     * @access public
     * @return void
     */
    public function buildFieldForm($productID, $values = '')
    {
        $form = '';
        $fieldList = $this->getFieldList($productID);
        foreach($fieldList as $field)
        {
            $form .= '<tr><th>';
            $form .= $field->name;
            $form .= '</th><td>';
            $form .= $this->buildControl($field, $values->{$field->field});
            $form .= '</td></tr>';
        }
        return $form;
    }
    
    /**
     * Build control of a field.
     * 
     * @param  int    $field 
     * @param  mix    $value 
     * @access public
     * @return void
     */
    public function buildControl($field, $value = null)
    {
        if(!isset($field->default)) $field->default = '';
        switch($field->control)
        {
            case 'input':
                return html::input($field->field, !empty($value) ? $value : $field->default, "class='form-control'");
            case 'textarea':
                return html::textarea($field->field, $value, "class='form-control'");
            case 'select':
                return html::select($field->field, ($field->options), !empty($value) ? $value : $field->default, "class='form-control'");
            case 'radio':
                return  html::radio($field->field, ($field->options), !empty($value) ? $value : $field->default, "class='form-control'");
            case 'checkbox':
                return html::checkbox($field->field, ($field->options), !empty($value) ? $value :$field->default, "class='form-control'");
            case 'date':
                return html::date($field->field, !empty($value) ? $value : $field->default, "data-format='yyyy-mm-dd'", "class='form-control'");
            case 'datetime':
                return html::dateTime($field->field, !empty($value) ? $value : $field->default, '', "class='form-control'");
        }
    }

    /**
     * Create a field.
     * 
     * @param  int    $productID 
     * @access public
     * @return int|bool
     */
    public function createField($productID)
    {
        $field = fixer::input('post')->add('product', $productID)->join('rules', ',')->get();

        $options = array();
        foreach($field->options['value'] as $key => $value)
        {
            $options[$value] = $field->options['text'][$key];   
        }
        $field->options = json_encode($options);

        $product = $this->getByID($productID);
        if(empty($product)) return false;

        $this->dao->insert(TABLE_ORDERFIELD)->data($field)->autoCheck()
            ->check('field', 'unique', "product={$productID}")
            ->batchCheck($this->config->field->require->create, 'notempty')
            ->exec();

        if(dao::isError()) return false;
        $alterQuery = "ALTER TABLE crm_order_{$product->code} ADD `{$field->field}` {$this->config->field->controlTypeList[$field->control]} NOT NULL";
        if($field->default) $alterQuery .= " default '{$field->default}'";
        if(!$this->dbh->query($alterQuery)) return false;

        return true;
    }

    /**
     * Update field.
     * 
     * @param  int    $fieldID 
     * @access public
     * @return bool
     */
    public function updateField($fieldID)
    {
        $field = $this->getFieldByID($fieldID);
        $data  = fixer::input('post')->join('rules', ',')->get();

        $options = array();
        foreach($data->options['value'] as $key => $value)
        {
            $options[$value] = $data->options['text'][$key];   
        }
        $data->options = json_encode($options);

        $this->dao->update(TABLE_ORDERFIELD)->data($data)->autoCheck()
            ->batchCheck($this->config->field->require->edit, 'notempty')
            ->where('id')->eq($fieldID)
            ->exec();

        if(dao::isError()) return false;
        if($field->field == $data->field) return true;

        $product    = $this->getByID($field->product);
        $alterQuery = "ALTER TABLE crm_order_{$product->code} CHANGE `{$field->field}` `$data->field` {$this->config->field->controlTypeList[$data->control]} NOT NULL";

        if($field->default) $alterQuery .= " default '{$data->default}'";
        if(!$this->dbh->query($alterQuery)) return false;

        return true;
    }

    /**
     * Delete field. 
     * 
     * @param  int    $fieldID 
     * @param  string $table 
     * @access public
     * @return bool
     */
    public function deleteField($fieldID, $table = null)
    {
        $field = $this->getFieldByID($fieldID);
        $this->dao->delete()->from(TABLE_ORDERFIELD)->where('id')->eq($fieldID)->exec();

        if(dao::isError()) return false;
        $product   = $this->getByID($field->product);
        $dropQuery = "ALTER TABLE crm_order_{$product->code} DROP `{$field->field}`";
        if(!$this->dbh->query($dropQuery)) return false;

        return true;
    }

    /**
     * Get action by ID.
     * 
     * @param  int    $actionID 
     * @access public
     * @return void
     */
    public function getActionByID($actionID)
    {
        $action =  $this->dao->select('*')->from(TABLE_ORDERACTION)->where('id')->eq($actionID)->fetch();

        $action->conditions = !empty($action->conditions) ? json_decode($action->conditions) : array();
        $action->inputs     = !empty($action->inputs)     ? json_decode($action->inputs) : array();
        $action->results    = !empty($action->results)    ? json_decode($action->results) : array();
        $action->tasks      = !empty($action->tasks)      ? json_decode($action->tasks) : array();
        return $action;
    }

    /**
     * Get actions of a product.
     * 
     * @param  int    $productID 
     * @access public
     * @return void
     */
    public function getActionList($productID)
    {
        return $this->dao->select('*')->from(TABLE_ORDERACTION)->where('product')->eq($productID)->fetchAll('id');
    }

    /**
     * Create an action of product's order.
     * 
     * @param  int    $productID 
     * @access public
     * @return void
     */
    public function createAction($productID)
    {
        $action = fixer::input('post')->add('product', $productID)->get();

        $this->dao->insert(TABLE_ORDERACTION)
            ->data($action)
            ->autoCheck()
            ->batchCheck($this->config->action->require->create, 'notempty')
            ->exec();
        return !dao::isError();
    }

    /**
     * Update an action.
     * 
     * @param  int    $actionID 
     * @access public
     * @return void
     */
    public function updateAction($actionID)
    {
       $action = fixer::input('post')->get(); 
       $this->dao->update(TABLE_ORDERACTION)
           ->data($action)
           ->autoCheck()
           ->batchCheck($this->config->action->require->edit, 'notempty')
           ->where('id')->eq($actionID)
           ->exec();
       return !dao::isError();
    }

    /**
     * Delete an action.
     * 
     * @param  int    $actionID 
     * @access public
     * @return void
     */
    public function deleteAction($actionID, $table = null)
    {
        $this->dao->delete()->from(TABLE_ORDERACTION)->where('id')->eq($actionID)->exec();

        return !dao::isError();
    }

    /**
     * Save conditions of an action.
     * 
     * @param  int    $actionID 
     * @access public
     * @return void
     */
    public function saveConditions($actionID)
    {
        foreach($_POST['field'] as $key => $field)
        {
            if(empty($field) or empty($_POST['operater'][$key])) continue;
            $conditions[] = array('field' => $field, 'operater' => $_POST['operater'][$key], 'param' => $_POST['param'][$key]);
        }

        $this->dao->update(TABLE_ORDERACTION)->set('conditions')->eq(json_encode($conditions))->where('id')->eq($actionID)->exec();
        return !dao::isError();
    }

    /**
     * Save inputs of an action.
     * 
     * @param  int    $actionID 
     * @access public
     * @return void
     */
    public function saveInputs($actionID)
    {
        foreach($_POST['field'] as $key => $field)
        {
            if(empty($field)) continue;
            $inputs[$field]['rules']   = join($_POST['rules'][$key], ',');
            $inputs[$field]['default'] = $_POST['default'][$key];
        }

        $this->dao->update(TABLE_ORDERACTION)->set('inputs')->eq(json_encode($inputs))->where('id')->eq($actionID)->exec();
        return !dao::isError();
    }

    /**
     * Save tasks of an action.
     * 
     * @param  int    $actionID 
     * @access public
     * @return void
     */
    public function saveTasks($actionID)
    {
        $tasks = array();
        foreach($_POST['name'] as $key => $name )
        {
            $task = array();
            $task['name'] = $name;   
            $task['role'] = $_POST['role'][$key];
            $task['date'] = $_POST['date'][$key];

            $tasks[] = $task;
        }

        $this->dao->update(TABLE_ORDERACTION)->set('tasks')->eq(json_encode($tasks))->where('id')->eq($actionID)->exec();
        return !dao::isError();
    }

    /**
     * Get roles of a product.
     * 
     * @param  int    $productID 
     * @access public
     * @return int|bool
     */
    public function getRoleList($productID)
    {
       $roles = $this->dao->select('roles')->from(TABLE_PRODUCT)->where('id')->eq($productID)->fetch('roles');
       return json_decode($roles);
    }

    /**
     * Admin a product's roles.
     *
     * @param  int    $productID 
     * @access public
     * @return bool
     */
    public function adminRoles($productID)
    {
        $roles = array();
        foreach($_POST['code'] as $key => $code) $roles[$code] = $_POST['name'][$key];
        a($roles);

        $this->dao->update(TABLE_PRODUCT)->set('roles')->eq(json_encode($roles))->where('id')->eq($productID)->exec();

        return !dao::isError();
    }
}
