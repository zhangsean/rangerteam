<?php
/**
 * The model file of order category of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     order
 * @version     $Id$
 * @link        http://www.zentao.net
 */
class orderModel extends model
{
    /* The members every linking. */
    const LINK_MEMBERS_ONE_TIME = 20;

    /**
     * Get order by id.
     * 
     * @param  int    $id 
     * @access public
     * @return object|bool
     */
    public function getByID($id)
    {
       $order   = $this->dao->select('*')->from(TABLE_ORDER)->where('id')->eq($id)->fetch();
       if(!$order) return false;

       $product = $this->loadModel('product')->getByID($order->product);
       if(!$product) return false;

       $custom  = $this->dao->select('*')->from('crm_order_' . $product->code)->where('`order`')->eq($id)->fetch();
       foreach($custom as $field => $value) $order->$field = $valeu;

       return $order;
    }

    /** 
     * Get order list.
     * 
     * @param  string  $orderBy 
     * @param  object  $pager 
     * @access public
     * @return array
     */
    public function getList($orderBy = 'id_desc', $pager = null)
    {
        $orders = $this->dao->select('*')->from(TABLE_ORDER)->orderBy($orderBy)->page($pager)->fetchAll('id');

        if(!$orders) return array();

        return $orders;
    }

    /**
     * Create an order.
     * 
     * @access public
     * @return int
     */
    public function create()
    {
        $now = helper::now();
        $order = fixer::input('post')
            ->add('createdBy', $this->app->user->account)
            ->add('createdDate', $now)
            ->setDefault('status', 'normal')
            ->setIF($this->post->assignedTo != '', 'assignedBy', $this->app->user->account)
            ->setIF($this->post->assignedTo != '', 'assignedDate', $now)
            ->setIF($this->post->assignedTo != '', 'status', 'assigned')
            ->get();

        $this->dao->insert(TABLE_ORDER)
            ->data($order)
            ->autoCheck()
            ->batchCheck($this->config->order->require->create, 'notempty')
            ->exec();

        $orderID = $this->dao->lastInsertID();

        $member = new stdclass();
        $member->order   = $orderID;
        $member->account = $this->app->user->account;
        $member->role    = $this->lang->user->roleList[$this->app->user->role];
        $member->join    = helper::today();

        $this->dao->insert(TABLE_TEAM)->data($member)->exec();

        if(dao::isError()) return false;

        return $orderID;
    }

    /**
     * Update an order.
     * 
     * @param  int $orderID 
     * @access public
     * @return void
     */
    public function update($orderID)
    {
        $order = fixer::input('post')->get();

        $this->dao->update(TABLE_ORDER)
            ->data($order)
            ->autoCheck()
            ->batchCheck($this->config->order->require->edit, 'notempty')
            ->where('id')->eq($orderID)
            ->exec();

        if(dao::isError()) return false;

        return !dao::isError();
    }

    /**
     * Close an order.
     * 
     * @param  int    $orderID 
     * @access public
     * @return bool
     */
    public function close($orderID)
    {
        $now   = helper::now();
        $order = fixer::input('post')
            ->add('closedDate', $now)
            ->add('closedBy', $this->app->user->account)
            ->add('status', 'closed')
            ->get();

        $this->dao->update(TABLE_ORDER)->data($order, $skip = 'uid')
            ->autoCheck()
            ->where('id')->eq($orderID)->exec();

        return !dao::isError();
    }

    /**
     * Activate an order.
     * 
     * @param  int    $orderID 
     * @access public
     * @return bool
     */
    public function activate($orderID)
    {
        $order = $this->getByID($orderID);
        $now   = helper::now();
        $order = fixer::input('post')
            ->add('activatedDate', $now)
            ->add('activatedBy', $this->app->user->account)
            ->setDefault('status', 'normal')
            ->setIF($order->assignedTo != '', 'status', 'assigned')
            ->get();

        $this->dao->update(TABLE_ORDER)->data($order)->autoCheck()->where('id')->eq($orderID)->exec();

        return !dao::isError();
    }

    /**
     * Get team members. 
     * 
     * @param  int    $orderID 
     * @access public
     * @return array
     */
    public function getTeamMembers($orderID)
    {
        return $this->dao->select('t1.*, t2.realname')->from(TABLE_TEAM)->alias('t1')
            ->leftJoin(TABLE_USER)->alias('t2')->on('t1.account = t2.account')
            ->where('t1.order')->eq((int)$orderID)
            ->fetchAll('account');
    }

    /**
     * Manage team members.
     * 
     * @param  int    $orderID 
     * @access public
     * @return void
     */
    public function manageMembers($orderID)
    {
        extract($_POST);

        $accounts = array_unique($accounts);
        foreach($accounts as $key => $account)
        {
            if(empty($account)) continue;

            $member = new stdclass();
            $member->role = $roles[$key];

            $mode = $modes[$key];
            if($mode == 'update')
            {
                $this->dao->update(TABLE_TEAM)->data($member)->where('`order`')->eq($orderID)->andWhere('account')->eq($account)->exec();
            }
            else
            {
                $member->order   = $orderID;
                $member->account = $account;
                $member->join    = helper::today();
                $this->dao->insert(TABLE_TEAM)->data($member)->exec();
            }
        }        
    }

    /**
     * Get enabled actions.
     * 
     * @param  object    $order 
     * @access public
     * @return void
     */
    public function getEnabledActions($order)
    {
        $order   = $this->getByID($order->id);
        $actions = $this->product->getActionList($order->product);

        $enabledActions = array();
        foreach($actions as $action)
        {
            $conditions = json_decode($action->conditions);
            $inputs     = json_decode($action->inputs);
            $results    = json_decode($action->results);
            $tasks      = json_decode($action->tasks);
            
            $enabled = true;
            foreach($conditions as $condition)
            {
                if(!$this->checkCondition($condition, $order)) $enabled = false;
            }

            if($enabled) $enabledActions[] = $action;
        }

        return $enabledActions;
    }

    /**
     * Check a condition is 
     * 
     * @param  int    $condition 
     * @param  int    $order 
     * @access public
     * @return void
     */
    public function checkCondition($condition, $order)
    {
        $checkFunc = 'check' . $condition->operater;
        $var = $order->{$condition->field};

        return validater::$checkFunc($var, $condition->param);
    }

    /**
     * Unlink a member.
     * 
     * @param  int    $orderID 
     * @param  string $account 
     * @access public
     * @return void
     */
    public function unlinkMember($orderID, $account)
    {
        $this->dao->delete()->from(TABLE_TEAM)->where('`order`')->eq($orderID)->andWhere('account')->eq($account)->exec();

        return !dao::isError();
    }

    /**
     * operate an order.
     * 
     * @param  object    $order 
     * @param  object    $action 
     * @access public
     * @return void
     */
    public function operate($order, $action)
    {
        $product = $this->loadModel('product')->getByID($order->product);
        $common = array();
        $custom = array();
        foreach($this->config->order->commonFields as $field)
        {
            if(isset($_POST[$field->field])) $common[$field->field] = $_POST[$field->field];
        }

        $customFields = $this->product->getFieldList($order->product);
        foreach($customFields as $field)
        {
            if(isset($_POST[$field->field])) $custom[$field->field] = $_POST[$field->field];
        }
        
        $dao = $this->dao->update(TABLE_ORDER)->data($common);
        foreach($common as $field => $value)
        {
            if(empty($action->inputs->{$field}->rules)) continue;
            $rules = explode(',', $action->inputs->{$field}->rules);
            foreach($rules as $rule) $dao->check($rule, $field, $value);
        }
        $dao->where('id')->eq($order->id)->exec();

        if(dao::isError()) return false;

        $this->dao->update('crm_order_' . $product->code)->data($custom);
        foreach($custom as $field => $value)
        {
            if(empty($action->inputs->{$field}->rules)) continue;
            $rules = explode(',', $action->inputs->{$field}->rules);
            foreach($rules as $rule) $dao->check($rule, $field, $value);
        }
        $dao->where('`order`')->eq($order->id)->exec();

        return !dao::isError();
    }
}
