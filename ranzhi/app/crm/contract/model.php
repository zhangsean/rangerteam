<?php
/**
 * The model file for contract of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     contract
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
class contractModel extends model
{
    /**
     * Get contract by ID.
     * 
     * @param  int    $contractID 
     * @access public
     * @return object.
     */
    public function getByID($contractID)
    {
        $contract = $this->dao->select('*')->from(TABLE_CONTRACT)->where('id')->eq($contractID)->fetch();
        if($contract)
        {
            $contract->order = array();
            $contractOrders = $this->dao->select('*')->from(TABLE_CONTRACTORDER)->where('contract')->eq($contractID)->fetchAll();
            foreach($contractOrders as $contractOrder) $contract->order[] = $contractOrder->order;

            $contract->files = $this->loadModel('file')->getByObject('contract', $contractID);
        }

        return $contract;
    }

    /**
     * Get contract list.
     * 
     * @param  string $orderBy 
     * @param  object $pager 
     * @access public
     * @return array
     */
    public function getList($orderBy = 'id_desc', $pager = null)
    {
        return $this->dao->select('*')->from(TABLE_CONTRACT)->orderBy($orderBy)->page($pager)->fetchAll();
    }

    /**
     * Create contract.
     * 
     * @access public
     * @return int|bool
     */
    public function create()
    {
        $contract = fixer::input('post')
            ->add('createdBy', $this->app->user->account)
            ->add('createdDate', helper::now())
            ->add('status', 'normal')
            ->add('delivery', 'wait')
            ->add('return', 'wait')
            ->setDefault('order', array())
            ->setDefault('begin', '0000-00-00')
            ->setDefault('end', '0000-00-00')
            ->get();

        $this->dao->insert(TABLE_CONTRACT)->data($contract, 'order,uid')
            ->autoCheck()
            ->batchCheck($this->config->contract->require->create, 'notempty')
            ->exec();

        $contractID = $this->dao->lastInsertID();

        if(!dao::isError())
        {
            foreach($contract->order as $orderID)
            {
                $data = new stdclass();
                $data->contract = $contractID;
                $data->order    = $orderID;
                $this->dao->insert(TABLE_CONTRACTORDER)->data($data)->exec();

                $order = new stdclass();
                $order->status     = 'signed';
                $order->signedBy   = $contract->signedBy;
                $order->signedDate = $contract->signedDate;
                $this->dao->update(TABLE_ORDER)->data($order)->where('id')->eq($orderID)->exec();
            }

            return $contractID;
        }

        return false;
    }

    /**
     * Create items of contract.
     * 
     * @access public
     * @return int|bool
     */
    public function items($contractID)
    {
        $contract = fixer::input('post')->get();

        $this->dao->update(TABLE_CONTRACT)->data($contract, 'uid,files,labels')->where('id')->eq($contractID)->autoCheck()->exec();

        if(!dao::isError())
        {
            $this->loadModel('file')->saveUpload('contract', $contractID);
            return $contractID;
        }

        return false;
    }

    /**
     * Update contract.
     * 
     * @param  int    $contractID 
     * @access public
     * @return bool
     */
    public function update($contractID)
    {
        $now      = helper::now();
        $contract = $this->getByID($contractID);
        $data     = fixer::input('post')
            ->add('editedBy', $this->app->user->account)
            ->add('editedDate', $now)
            ->setDefault('order', array())
            ->setDefault('begin', '0000-00-00')
            ->setDefault('end', '0000-00-00')
            ->get();

        $this->dao->update(TABLE_CONTRACT)->data($data, 'order,uid,files,labels')
            ->where('id')->eq($contractID)
            ->autoCheck()
            ->batchCheck($this->config->contract->require->edit, 'notempty')
            ->exec();
        
        if(!dao::isError())
        {
            if($contract->order != $data->order)
            {
                $this->dao->delete()->from(TABLE_CONTRACTORDER)->where('contract')->eq($contractID)->exec();
                foreach($data->order as $orderID)
                {
                    $contractOrder = new stdclass();
                    $contractOrder->contract = $contractID;
                    $contractOrder->order    = $orderID;
                    $this->dao->insert(TABLE_CONTRACTORDER)->data($contractOrder)->exec();
                }
            }
            $this->loadModel('file')->saveUpload('contract', $contractID);
        }
    }

    /**
     * The delivery of the contract.
     * 
     * @param  int    $contractID 
     * @access public
     * @return bool
     */
    public function delivery($contractID)
    {
        $contract = new stdclass();
        $contract->delivery      = 'done';
        $contract->deliveredBy   = $this->app->user->account;
        $contract->deliveredDate = helper::now();

        $this->dao->update(TABLE_CONTRACT)->data($contract, $skip = 'uid, comment')
            ->autoCheck()
            ->where('id')->eq($contractID)
            ->exec();

        return !dao::isError();
    }

    /**
     * Receive payments of the contract.
     * 
     * @param  int    $contractID 
     * @access public
     * @return bool
     */
    public function receive($contractID)
    {
        $contract = new stdclass();
        $contract->return       = 'done';
        $contract->returnedBy   = $this->app->user->account;
        $contract->returnedDate = helper::now();

        $this->dao->update(TABLE_CONTRACT)->data($contract, $skip = 'uid, comment')
            ->autoCheck()
            ->where('id')->eq($contractID)
            ->exec();

        return !dao::isError();
    }

    /**
     * Cancel contract.
     * 
     * @param  int    $contractID 
     * @access public
     * @return bool
     */
    public function cancel($contractID)
    {
        $contract = new stdclass();
        $contract->status       = 'canceled';
        $contract->canceledBy   = $this->app->user->account;
        $contract->canceledDate = helper::now();

        $this->dao->update(TABLE_CONTRACT)->data($contract, $skip = 'uid, comment')
            ->autoCheck()
            ->where('id')->eq($contractID)
            ->exec();

        return !dao::isError();
    }

    /**
     * Finish contract.
     * 
     * @param  int    $contractID 
     * @access public
     * @return bool
     */
    public function finish($contractID)
    {
        $contract = new stdclass();
        $contract->status       = 'closed';
        $contract->finishedBy   = $this->app->user->account;
        $contract->finishedDate = helper::now();

        $this->dao->update(TABLE_CONTRACT)->data($contract, $skip = 'uid, comment')
            ->autoCheck()
            ->where('id')->eq($contractID)
            ->exec();

        return !dao::isError();
    }

    /**
     * Delete contract.
     * 
     * @param  int    $contractID 
     * @param  string $table 
     * @access public
     * @return void
     */
    public function delete($contractID, $table = null)
    {
        $this->dao->delete()->from(TABLE_CONTRACT)->where('id')->eq($contractID)->exec();
        $this->dao->delete()->from(TABLE_CONTRACTORDER)->where('contract')->eq($contractID)->exec();
    }

    /**
     * Set contract code's format. 
     * 
     * @access public
     * @return void
     */
    public function setCodeFormat()
    {
        $format = fixer::input('post')->get('unit');
        $unitList = array();
        foreach($format as $unit)
        {
           if($unit != '' and $unit != 'fix') $unitList[] = $unit; 
        }

        $path = 'system.crm.contract.codeFormat';
        return $this->loadModel('setting')->setItem($path, helper::jsonEncode($unitList));
    }
     
    /**
     * Build form of code.
     * 
     * @access public
     * @return string
     */
    public function buildCodeForm()
    {
        $format = $this->config->contract->codeFormat;
        if(!is_array($format)) $format = json_decode($format, true);
        
        $form = "<div class='input-group'>";
        foreach($format as $key => $unit)
        {
            if(in_array($unit, array('Y', 'm', 'd'))) $form .= "<span class='input-group-addon'>" . date($unit) . "</span>";
            elseif($unit == 'input') $form .= html::input("code[{$key}]", '', "class='form-control'");
            elseif(!isset($lang->contract->codeUnitList[$unit])) $form .= "<span class='input-group-addon'>{$unit}</span>";
        }

        return $form . '</div>';
    }
   
    /**
     * Parse code.
     * 
     * @access public
     * @return string
     */
    public function parseCode()
    {
        $format = $this->config->contract->codeFormat;
        if(!is_array($format)) $format = json_decode($format, true);

        $code = '';
        foreach($format as $key => $unit)
        {
            if(in_array($unit, array('Y', 'm', 'd'))) $code .= date($unit);
            elseif($unit == 'input') $code .= $_POST['code'][$key];
            elseif(!isset($lang->contract->codeUnitList[$unit])) $code .= $unit;
        }

        return $code;
    }
}
