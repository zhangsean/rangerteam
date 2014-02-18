<?php
/**
 * The model file for contract of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     contract
 * @version     $Id$
 * @link        http://www.zentao.net
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
     * @return void
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
        $now      = helper::now();
        $contract = fixer::input('post')
            ->add('createdBy', $this->app->user->account)
            ->add('createdDate', $now)
            ->add('status', 'normal')
            ->add('delivery', 'wait')
            ->add('return', 'wait')
            ->setDefault('order', array())
            ->setDefault('begin', '0000-00-00')
            ->setDefault('end', '0000-00-00')
            ->get();

        $this->dao->insert(TABLE_CONTRACT)->data($contract, 'order,uid,files,labels')
            ->autoCheck()
            ->check('order', 'notempty')
            ->check('code', 'unique')
            ->check('code', 'code')
            ->exec();

        if(!dao::isError())
        {
            $contractID = $this->dao->lastInsertID();
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
            ->check('order', 'notempty')
            ->check('code', 'unique', "id!={$contractID}")
            ->check('code', 'code')
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
}
