<?php
/**
 * The model file for contract of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     contract
 * @version     $Id$
 * @link        http://www.ranzhico.com
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
            $contractOrders  = $this->dao->select('*')->from(TABLE_CONTRACTORDER)->where('contract')->eq($contractID)->fetchAll();
            foreach($contractOrders as $contractOrder) $contract->order[] = $contractOrder->order;

            $contract->files        = $this->loadModel('file')->getByObject('contract', $contractID);
            $contract->returnList   = $this->dao->select('*')->from(TABLE_PLAN)->where('contract')->eq($contractID)->fetchAll();
            $contract->deliveryList = $this->dao->select('*')->from(TABLE_DELIVERY)->where('contract')->eq($contractID)->fetchAll();
        }

        return $contract;
    }

    /**
     * Get contract list.
     * 
     * @param  int    $customer
     * @param  string $orderBy 
     * @param  object $pager 
     * @access public
     * @return array
     */
    public function getList($customer = 0, $mode = 'all', $orderBy = 'id_desc', $pager = null)
    {
        /* process search condition. */
        if($this->session->contractQuery == false) $this->session->set('contractQuery', ' 1 = 1');
        $contractQuery = $this->loadModel('search', 'sys')->replaceDynamic($this->session->contractQuery);

        return $this->dao->select('*')->from(TABLE_CONTRACT)
            ->where('deleted')->eq(0)
            ->beginIF($customer)->andWhere('customer')->eq($customer)->fi()
            ->beginIF($mode == 'unreceived')->andWhere('`return`')->ne('done')->fi()
            ->beginIF($mode == 'undeliveried')->andWhere('`delivery`')->ne('done')->fi()
            ->beginIF($mode == 'canceled')->andWhere('`status`')->eq('canceled')->fi()
            ->beginIF($mode == 'finished')->andWhere('`status`')->eq('closed')->fi()
            ->beginIF($mode == 'expired')->andWhere('`end`')->lt(date(DT_DATE1))->fi()
            ->beginIF($mode == 'expire')
            ->andWhere('`end`')->lt(date(DT_DATE1, strtotime('+1 month')))
            ->andWhere('`end`')->gt(date(DT_DATE1))
            ->fi()
            ->beginIF($mode == 'bysearch')->andWhere($contractQuery)->fi()
            ->orderBy($orderBy)
            ->page($pager)
            ->fetchAll();
    }

    /**
     * Get contract pairs.
     * 
     * @param  int    $customerID
     * @access public
     * @return array
     */
    public function getPairs($customerID)
    {
        return $this->dao->select('id, name')->from(TABLE_CONTRACT)
            ->where(1)
            ->beginIF($customerID)->andWhere('customer')->eq($customerID)->fi()
            ->andWhere('deleted')->eq(0)
            ->fetchPairs('id', 'name');
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
            ->setDefault('real', array())
            ->setDefault('begin', '0000-00-00')
            ->setDefault('end', '0000-00-00')
            ->join('handlers', ',')
            ->stripTags('items', $this->config->allowedTags->admin)
            ->get();

        $this->dao->insert(TABLE_CONTRACT)->data($contract, 'order,uid,files,labels,real')
            ->autoCheck()
            ->batchCheck($this->config->contract->require->create, 'notempty')
            ->checkIF($contract->end != '0000-00-00', 'end', 'ge', $contract->begin)
            ->exec();

        $contractID = $this->dao->lastInsertID();

        if(!dao::isError())
        {
            foreach($contract->order as $key => $orderID)
            {
                if($orderID)
                {
                    $data = new stdclass();
                    $data->contract = $contractID;
                    $data->order    = $orderID;
                    $this->dao->insert(TABLE_CONTRACTORDER)->data($data)->exec();

                    $order = new stdclass();
                    $order->status     = 'signed';
                    $order->real       = $contract->real[$key];
                    $order->signedBy   = $contract->signedBy;
                    $order->signedDate = $contract->signedDate;
                    $this->dao->update(TABLE_ORDER)->data($order)->where('id')->eq($orderID)->exec();

                    if(dao::isError()) return false;
                    $this->loadModel('action')->create('order', $orderID, 'Signed', '', $contract->real[$key]);
                }
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
            ->join('handlers', ',')
            ->add('editedBy', $this->app->user->account)
            ->add('editedDate', $now)
            ->setDefault('order', array())
            ->setDefault('real', array())
            ->setDefault('customer', $contract->customer)
            ->setDefault('signedDate', '0000-00-00')
            ->setDefault('finishedDate', '0000-00-00')
            ->setDefault('canceledDate', '0000-00-00')
            ->setDefault('deliveredDate', '0000-00-00')
            ->setDefault('returnedDate', '0000-00-00')
            ->setDefault('begin', '0000-00-00')
            ->setDefault('end', '0000-00-00')
            ->setIF($this->post->status == 'normal', 'canceledBy', '')
            ->setIF($this->post->status == 'normal', 'canceledDate', '0000-00-00')
            ->setIF($this->post->status == 'normal', 'finishedBy', '')
            ->setIF($this->post->status == 'normal', 'finishedDate', '0000-00-00')
            ->setIF($this->post->status == 'cancel' and $this->post->canceledBy == '', 'canceledBy', $this->app->user->account)
            ->setIF($this->post->status == 'cancel' and $this->post->canceledDate == '0000-00-00', 'canceledDate', $now)
            ->setIF($this->post->status == 'finished' and $this->post->finishedBy == '', 'finishedBy', $this->app->user->account)
            ->setIF($this->post->status == 'finished' and $this->post->finishedDate == '0000-00-00', 'finishedDate', $now)
            ->remove('uid,files,labels')
            ->stripTags('items', $this->config->allowedTags->admin)
            ->get();

        $this->dao->update(TABLE_CONTRACT)->data($data, 'order,real')
            ->where('id')->eq($contractID)
            ->autoCheck()
            ->batchCheck($this->config->contract->require->edit, 'notempty')
            ->checkIF($contract->end != '0000-00-00', 'end', 'ge', $contract->begin)
            ->exec();
        
        if(!dao::isError())
        {
            if($data->order)
            {
                $oldOrders = $this->loadModel('order')->getByIdList($data->order);
                $real = array();
                foreach($data->order as $key => $orderID) $real[$key] = $oldOrders[$orderID]->real;

                if($contract->order != $data->order || $real != $data->real)
                {
                    $this->dao->delete()->from(TABLE_CONTRACTORDER)->where('contract')->eq($contractID)->exec();
                    foreach($data->order as $key => $orderID)
                    {
                        $oldOrder = $this->loadModel('order')->getByID($orderID);

                        $contractOrder = new stdclass();
                        $contractOrder->contract = $contractID;
                        $contractOrder->order    = $orderID;
                        $this->dao->insert(TABLE_CONTRACTORDER)->data($contractOrder)->exec();

                        $order = new stdclass();
                        $order->real       = $data->real[$key];
                        $order->signedBy   = $data->signedBy;
                        $order->signedDate = $data->signedDate;

                        $this->dao->update(TABLE_ORDER)->data($order)->where('id')->eq($orderID)->exec();

                        if(dao::isError()) return false;

                        $changes  = commonModel::createChanges($oldOrder, $order);
                        $actionID = $this->loadModel('action')->create('order', $orderID, 'Edited');
                        $this->action->logHistory($actionID, $changes);
                    }
                }
            }

            if($contract->status == 'canceled' and $data->status == 'normal')
            {
                foreach($data->order as $key => $orderID)
                {
                    $order = new stdclass();
                    $order->status     = 'signed';
                    $order->real       = $data->real[$key];
                    $order->signedBy   = $data->signedBy;
                    $order->signedDate = $data->signedDate;

                    $this->dao->update(TABLE_ORDER)->data($order)->where('id')->eq($orderID)->exec();
                    if(dao::isError()) return false;
                }
            }

            if($contract->status == 'normal' and $data->status == 'canceled')
            {
                foreach($data->order as $orderID)
                {
                    $order = new stdclass();
                    $order->status     = 'normal';
                    $order->real       = 0;
                    $order->signedBy   = '';
                    $order->signedDate = '0000-00-00';

                    $this->dao->update(TABLE_ORDER)->data($order)->where('id')->eq($orderID)->exec();
                    if(dao::isError()) return false;
                }
            }
            
            return commonModel::createChanges($contract, $data);
        }

        return false;
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
        $now = helper::now();
        $data = fixer::input('post')
            ->add('contract', $contractID)
            ->setDefault('deliveredBy', $this->app->user->account)
            ->setDefault('deliveredDate', $now)
            ->stripTags('comment', $this->config->allowedTags->admin)
            ->get();

        $this->dao->insert(TABLE_DELIVERY)->data($data, $skip = 'uid, handlers, finish')->autoCheck()->exec();

        if(!dao::isError())
        {
            $contract = fixer::input('post')
                ->add('delivery', 'doing')
                ->add('editedBy', $this->app->user->account)
                ->add('editedDate', $now)
                ->setDefault('deliveredBy', $this->app->user->account)
                ->setDefault('deliveredDate', $now)
                ->setIF($this->post->finish, 'delivery', 'done')
                ->join('handlers', ',')
                ->remove('finish')
                ->get();

            $this->dao->update(TABLE_CONTRACT)->data($contract, $skip = 'uid, comment')
                ->autoCheck()
                ->where('id')->eq($contractID)
                ->exec();

            return !dao::isError();
        }

        return false;
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
        $contract = $this->getByID($contractID);

        $now = helper::now();
        $data = fixer::input('post')
            ->add('contract', $contractID)
            ->setDefault('returnedBy', $this->app->user->account)
            ->setDefault('returnedDate', $now)
            ->remove('finish,handlers,depositor,category,dept')
            ->get();

        $this->dao->insert(TABLE_PLAN)
            ->data($data, $skip = 'uid, comment')
            ->autoCheck()
            ->batchCheck($this->config->contract->require->receive, 'notempty')
            ->exec();

        if(!dao::isError())
        {
            $contractData = new stdclass();
            $contractData->return       = 'doing';
            $contractData->editedBy     = $this->app->user->account;
            $contractData->editedDate   = $now;
            $contractData->handlers     = implode(',', $this->post->handlers);
            $contractData->returnedBy   = $this->post->returnedBy ? $this->post->returnedBy : $this->app->user->account;
            $contractData->returnedDate = $now;
            if($this->post->finish) $contractData->return = 'done';

            $this->dao->update(TABLE_CONTRACT)->data($contractData, $skip = 'uid, comment')->where('id')->eq($contractID)->exec();

            if(!dao::isError() and $this->post->finish) $this->dao->update(TABLE_CUSTOMER)->set('status')->eq('payed')->where('id')->eq($contract->customer)->exec();

            $trade = fixer::input('post')
                ->add('money', $this->post->amount)
                ->add('type', 'in')
                ->add('date', substr($now, 0, 10))
                ->add('createdBy', $this->app->user->account)
                ->add('createdDate', $now)
                ->add('editedBy', $this->app->user->account)
                ->add('editedDate', $now)
                ->join('handlers', ',')
                ->add('trader', $contract->customer)
                ->add('contract', $contractID)
                ->remove('finish,amount,returnedBy,returnedDate')
                ->get();

            $depositor = $this->loadModel('depositor', 'cash')->getByID($trade->depositor);
            $trade->currency = $depositor->currency;

            $this->dao->insert(TABLE_TRADE)->data($trade, $skip = 'uid,comment')->autoCheck()->exec();

            return !dao::isError();
        }

        return false;
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
        $contract->editedBy     = $this->app->user->account;
        $contract->editedDate   = helper::now();

        $this->dao->update(TABLE_CONTRACT)->data($contract, $skip = 'uid, comment')
            ->autoCheck()
            ->where('id')->eq($contractID)
            ->exec();

        if(!dao::isError()) 
        {
            $contract = $this->getByID($contractID);
            if($contract->order)
            {
                foreach($contract->order as $orderID)
                {
                    $order = new stdclass(); 
                    $order->status     = 'normal';
                    $order->signedDate = '0000-00-00';
                    $order->real       = 0;
                    $order->signedBy   = '';

                    $this->dao->update(TABLE_ORDER)->data($order)->autoCheck()->where('id')->eq($orderID)->exec();
                }
                return !dao::isError();
            }
            return true;
        }
        return false;
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
        $contract->editedBy     = $this->app->user->account;
        $contract->editedDate   = helper::now();

        $this->dao->update(TABLE_CONTRACT)->data($contract, $skip = 'uid, comment')
            ->autoCheck()
            ->where('id')->eq($contractID)
            ->exec();

        return !dao::isError();
    }

    /**
     * Build operate menu.
     * 
     * @param  object $contract 
     * @param  string $class 
     * @param  string $type 
     * @access public
     * @return string
     */
    public function buildOperateMenu($contract, $class = '', $type = 'browse')
    {
        $menu  = '';

        if($type == 'view') $menu .= "<div class='btn-group'>";

        $menu .= html::a(helper::createLink('action', 'createRecord', "objectType=contract&objectID={$contract->id}&customer={$contract->customer}"), $this->lang->contract->record, "class='$class' data-toggle='modal' data-type='iframe'");

        if($contract->return != 'done' and $contract->status == 'normal')
        {
            $menu .= html::a(helper::createLink('contract', 'receive',  "contract=$contract->id"), $this->lang->contract->return, "data-toggle='modal' class='$class'");
        }
        else
        {
            $menu .= "<a href='###' disabled='disabled' class='disabled  $class'>" . $this->lang->contract->return . '</a> ';
        }

        if($contract->delivery != 'done' and $contract->status == 'normal')
        {
            $menu .= html::a(helper::createLink('contract', 'delivery', "contract=$contract->id"), $this->lang->contract->delivery, "data-toggle='modal' class='$class'");
        }
        else
        {
            $menu .= "<a href='###' disabled='disabled' class='disabled $class'>" . $this->lang->contract->delivery . '</a> ';
        }

        if($type == 'view') $menu .= "</div><div class='btn-group'>";

        if($contract->status == 'normal' and $contract->return == 'done' and $contract->delivery == 'done')
        {
            $menu .= html::a(helper::createLink('contract', 'finish', "contract=$contract->id"), $this->lang->finish, "data-toggle='modal' class='$class'");
        }
        else
        {
            $menu .= "<a href='###' disabled='disabled' class='disabled $class'>" . $this->lang->finish . '</a> ';
        }

        $menu .= html::a(helper::createLink('contract', 'edit', "contract=$contract->id"), $this->lang->edit, "class='$class'");

        if($type == 'view')
        {
            $menu .= "</div><div class='btn-group'>";
            if($contract->status == 'normal' and !($contract->return == 'done' and $contract->delivery == 'done'))
            {
                $menu .= html::a(helper::createLink('contract', 'cancel', "contract=$contract->id"), $this->lang->cancel, "data-toggle='modal' class='$class'");
            }
            else
            {
                $menu .= "<a href='###' disabled='disabled' class='disabled $class'>" . $this->lang->cancel . '</a> ';
            }

            if($contract->status == 'canceled' or ($contract->status == 'normal' and !($contract->return == 'done' and $contract->delivery == 'done')))
            {
                $menu .= html::a(helper::createLink('contract', 'delete', "contract=$contract->id"), $this->lang->delete, "class='deleter $class'");
            }
            else
            {
                $menu .= "<a href='###' disabled='disabled' class='disabled $class'>" . $this->lang->delete . '</a> ';
            }
        }

        if($type == 'browse')
        {
            $menu .="<div class='dropdown'><a data-toggle='dropdown' href='javascript:;'>" . $this->lang->more . "<span class='caret'></span> </a><ul class='dropdown-menu pull-right'>";

            if($contract->status == 'normal' and !($contract->return == 'done' and $contract->delivery == 'done'))
            {
                $menu .= "<li>" . html::a(helper::createLink('contract', 'cancel', "contract=$contract->id"), $this->lang->cancel, "data-toggle='modal' class='$class'") . "</li>";
            }
            else
            {
                $menu .= "<li><a href='###' disabled='disabled' class='disabled $class'>" . $this->lang->cancel . '</a></li> ';
            }

            if($contract->status == 'canceled' or ($contract->status == 'normal' and !($contract->return == 'done' and $contract->delivery == 'done')))
            {
                $menu .= "<li>" . html::a(helper::createLink('contract', 'delete', "contract=$contract->id"), $this->lang->delete, "class='reloadDeleter $class'") . "</li>";
            }
            else
            {
                $menu .= "<li><a href='###' disabled='disabled' class='disabled $class'>" . $this->lang->delete . '</a></li> ';
            }
            $menu .= '</ul>';
        }

        $menu .= "</div>";

        return $menu;
    }

    /**
     * Count amount.
     * 
     * @param  array  $contracts 
     * @access public
     * @return array
     */
    public function countAmount($contracts)
    {
        $totalAmount  = array();
        $currencyList = $this->loadModel('common', 'sys')->getCurrencyList();
        $currencySign = $this->common->getCurrencySign();
        $totalReturn  = $this->dao->select('*')->from(TABLE_PLAN)->fetchGroup('contract');

        foreach($contracts as $contract)
        {
            foreach($currencyList as $key => $currency)
            {
                if($contract->currency == $key)
                {
                    if(!isset($totalAmount['contract'][$key])) $totalAmount['contract'][$key] = 0;
                    if(!isset($totalAmount['return'][$key]))   $totalAmount['return'][$key] = 0;

                    $totalAmount['contract'][$key] += $contract->amount;
                    
                    if(isset($totalReturn[$contract->id])) foreach($totalReturn[$contract->id] as $return) $totalAmount['return'][$key] += $return->amount;
                }
            }
        }

        foreach($totalAmount as $type => $currencyAmount) foreach($currencyAmount as $currency => $amount) $totalAmount[$type][$currency] = $currencySign[$currency] . $amount;

        return $totalAmount;
    }
}
