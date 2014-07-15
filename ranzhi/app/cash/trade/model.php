<?php
/**
 * The model file of trade module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     contact
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
class tradeModel extends model
{
    /**
     * Get trade by id.
     * 
     * @param  int    $id 
     * @access public
     * @return object
     */
    public function getByID($id)
    {
        return $this->dao->select('*')->from(TABLE_TRADE)->where('id')->eq($id)->limit(1)->fetch();
    }

    /** 
     * Get trade list.
     * 
     * @param  string  $orderBy 
     * @param  object  $pager 
     * @access public
     * @return array
     */
    public function getList($orderBy, $pager = null)
    {
        return $this->dao->select('*')->from(TABLE_TRADE)->where('parent')->eq('')->orderBy($orderBy)->page($pager)->fetchAll('id');
    }

    /** 
     * Get trade list by trade's id list.
     * 
     * @param  array    $idList 
     * @access public
     * @return void
     */
    public function getListByIdList($idList)
    {
        return $this->dao->select('*')->from(TABLE_TRADE)->where('id')->in($idList)->fetchAll('id');
    }

    /** 
     * Get trade detail.
     * 
     * @access public
     * @return array
     */
    public function getDetail($tradeID)
    {
        return $this->dao->select('*')->from(TABLE_TRADE)->where('parent')->eq($tradeID)->fetchAll();
    }

    /**
     * Create a trade.
     * 
     * @param  string    $type   in|out
     * @access public
     * @return void
     */
    public function create($type)
    {
        $now = helper::now();
        
        $trade = fixer::input('post')
            ->add('type', $type)
            ->add('createdBy', $this->app->user->account)
            ->add('createdDate', $now)
            ->add('editedBy', $this->app->user->account)
            ->add('editedDate', $now)
            ->add('handlers', trim(join(',', $this->post->handlers), ','))
            ->setIf($this->post->type == 'in', 'contract', '')
            ->setIf($this->post->createTrader, 'trader', 0)
            ->setIf($this->post->type == 'in', 'order', '')
            ->setIf(!$this->post->objectType or !in_array('order', $this->post->objectType), 'order', 0)
            ->setIf(!$this->post->objectType or !in_array('contract', $this->post->objectType), 'contract', 0)
            ->removeIf($type == 'out', 'objectType')
            ->get();


        $depositor = $this->loadModel('depositor')->getByID($trade->depositor);
        $trade->currency = $depositor->currency;

        $this->dao->insert(TABLE_TRADE)
            ->data($trade, $skip = 'createTrader,traderName')
            ->autoCheck()
            ->batchCheck($this->config->trade->require->create, 'notempty')
            ->checkIF(!$this->post->createTrader, 'trader', 'notempty')
            ->exec();

        $tradeID = $this->dao->lastInsertID();

        if($this->post->createTrader and $type == 'out')
        {
            $trader = new stdclass();
            $trader->relation = 'provider';
            $trader->name     = $this->post->traderName;
            $trader->public   = 1;

            $this->dao->insert(TABLE_CUSTOMER)->data($trader)->check('name', 'notempty')->exec();
            $trader = $this->dao->lastInsertID();
            $this->loadModel('action')->create('customer', $trader, 'Created');

            $this->dao->update(TABLE_TRADE)->set('trader')->eq($trader)->where('id')->eq($tradeID)->exec();
        }

        return $tradeID;

    }

    /**
     * Batch create.
     * 
     * @access public
     * @return array
     */
    public function batchCreate()
    {
        $now    = helper::now();
        $trades = array();

        $depositorList = $this->loadModel('depositor')->getList();

        $this->loadModel('action');
        /* Get data. */
        foreach($this->post->type as $key => $type)
        {
            if(empty($type)) break;
            if(!$this->post->money[$key]) continue;
            $trade = new stdclass();
            $trade->type           = $type;
            $trade->depositor      = $this->post->depositor[$key];
            $trade->money          = $this->post->money[$key];
            $trade->category       = $this->post->category[$key];
            $trade->dept           = $this->post->dept[$key];
            $trade->trader         = $this->post->trader[$key];
            $trade->createTrader   = zget($this->post->createTrader, $key, null);
            $trade->createCustomer = false;
            $trade->traderName     = $this->post->traderName[$key];
            $trade->handlers       = !empty($this->post->handlers[$key]) ? join(',', $this->post->handlers[$key]) : '';
            $trade->date           = $this->post->date[$key];
            $trade->desc           = strip_tags(nl2br($this->post->desc[$key]), $this->config->allowedTags->admin);
            $trade->currency       = $depositorList[$trade->depositor]->currency;
            $trade->createdBy      = $this->app->user->account;
            $trade->createdDate    = $now;

            if($trade->createTrader)
            {
                $this->dao->insert(TABLE_CUSTOMER)->data(array('relation' => 'provider', 'name' => $trade->traderName, 'public' => 1))->exec();
                $trade->trader = $this->dao->lastInsertID();
                $this->action->create('customer', $trade->trader, 'Created');
            }

            $trades[$key] = $trade;
        }

        if(empty($trades)) return array('result' => 'fail');

        $errors = $this->batchCheck($trades);
        if(!empty($errors)) return array('result' => 'fail', 'message' => $errors);

        $tradeIDList = array();
        foreach($trades as $trade)
        {
            $this->dao->insert(TABLE_TRADE)->data($trade, $skip = 'createTrader,traderName,createCustomer')->autoCheck()->exec();
        }
        if(!dao::isError()) return array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('browse'));
        return array('result' => 'fail', 'message' => dao::getError());
    }

    /**
     * Batch update trades.
     * 
     * @access public
     * @return void
     */
    public function batchUpdate()
    {
        $trades = array();

        $depositorList = $this->loadModel('depositor')->getList();

        /* Get data. */
        foreach($this->post->type as $key => $type)
        {
            if(empty($type)) break;
            $trade = new stdclass();
            $trade->depositor      = $this->post->depositor[$key];
            $trade->money          = $this->post->money[$key];
            $trade->type           = $type;
            $trade->category       = $this->post->category[$key];
            $trade->dept           = $this->post->dept[$key];
            $trade->trader         = $this->post->trader[$key];
            $trade->createTrader   = false;
            $trade->createCustomer = false;
            $trade->traderName     = $this->post->traderName[$key];
            $trade->handlers       = !empty($this->post->handlers[$key]) ? join(',', $this->post->handlers[$key]) : '';
            $trade->date           = $this->post->date[$key];
            $trade->desc           = strip_tags(nl2br($this->post->desc[$key]), $this->config->allowedTags->admin);
            $trade->currency       = $depositorList[$trade->depositor]->currency;

            $trades[$key] = $trade;
        }

        if(empty($trades)) return array('result' => 'fail');

        $errors = $this->batchCheck($trades);
        if(!empty($errors)) return array('result' => 'fail', 'message' => $errors);

        $tradeIDList = array();
        foreach($trades as $tradeID => $trade)
        {
            $this->dao->update(TABLE_TRADE)->data($trade, $skip = 'createTrader,traderName,createCustomer')->where('id')->eq($tradeID)->autoCheck()->exec();
        }
        if(!dao::isError()) return array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('browse'));
        return array('result' => 'fail', 'message' => dao::getError());
    }

    /**
     * Batch check trades.
     * 
     * @param  array    $trades 
     * @access public
     * @return void
     */
    public function batchCheck($trades)
    {
        $errors = array();
        $this->app->loadClass('filter', true);
        foreach($trades as $key => $trade)
        {
            $item = $this->lang->trade->trader;
            if($trade->createTrader)
            {
                if(empty($trade->traderName)) $errors['traderName' . $key] = sprintf($this->lang->error->notempty, $item);
            }
            elseif($trade->createCustomer)
            {
                if(empty($trade->customerName)) $errors['customerName' . $key] = sprintf($this->lang->error->notempty, $item);
            }
            elseif(in_array($trade->type, array('in', 'out')))
            {
               if(empty($trade->trader) or !validater::checkInt($trade->trader)) $errors['trader' . $key] = sprintf($this->lang->error->notempty, $item) . sprintf($this->lang->error->int[0], $item);
            }

            $item = $this->lang->trade->money; 
            if(empty($trade->money) or !validater::checkFloat($trade->money)) $errors["money" . $key] = sprintf($this->lang->error->notempty, $item) . sprintf($this->lang->error->float, $item);

            $item = $this->lang->trade->handlers;
            if(empty($trade->handlers)) $errors['handlers'. $key] = sprintf($this->lang->error->notempty, $item);

            $item = $this->lang->trade->date;
            if(empty($trade->date) or !validater::checkDate($trade->date)) $errors['date' . $key] = sprintf($this->lang->error->date, $item) . sprintf($this->lang->error->notempty, $item);

        }
        return $errors;
    }

    /**
     * Update a trade.
     * 
     * @param  int    $tradeID 
     * @access public
     * @return string|bool
     */
    public function update($tradeID)
    {
        $oldTrade = $this->getByID($tradeID);

        $trade = fixer::input('post')
            ->add('type', $oldTrade->type)
            ->setIf(!$this->post->objectType or !in_array('order', $this->post->objectType),    'order', 0)
            ->setIf(!$this->post->objectType or !in_array('contract', $this->post->objectType), 'contract', 0)
            ->add('handlers', trim(join(',', $this->post->handlers), ','))
            ->add('editedBy', $this->app->user->account)
            ->add('editedDate', helper::now())
            ->remove('objectType')
            ->get();

        $handlers = $this->loadModel('user')->getByAccount($trade->handlers);
        if($handlers) $trade->dept = $handlers->dept;


        $this->dao->update(TABLE_TRADE)
            ->data($trade, $skip = 'createTrader,traderName')
            ->autoCheck()
            ->batchCheck($this->config->trade->require->edit, 'notempty')
            ->checkIF($oldTrade->type == 'out' and !$this->post->createTrader, 'trader', 'notempty')
            ->where('id')->eq($tradeID)->exec();

        if($this->post->createTrader and $trade->type == 'out')
        {
            $trader = new stdclass();
            $trader->relation = 'provider';
            $trader->name     = $this->post->traderName;
            $trader->public   = 1;

            $this->dao->insert(TABLE_CUSTOMER)->data($trader)->check('name', 'notempty')->exec();
            $trader = $this->dao->lastInsertID();
            $this->loadModel('action')->create('customer', $trader, 'Created');

            $this->dao->update(TABLE_TRADE)->set('trader')->eq($trader)->where('id')->eq($tradeID)->exec();
        }

        if(!dao::isError()) return commonModel::createChanges($oldTrade, $trade);

        return false;
    }

    public function saveImport($depositorID)
    {
        $now       = helper::now();
        $trades    = array();
        $depositor = $this->getByID($depositorID);

        $this->loadModel('action');

        $newCustomer = array();
        $newTrader   = array();
        /* Get data. */
        foreach($this->post->type as $key => $type)
        {
            if(empty($type)) break;
            if(!$this->post->money[$key]) continue;
            $trade = new stdclass();
            $trade->type           = $type;
            $trade->depositor      = $depositorID;
            $trade->money          = $this->post->money[$key];
            $trade->category       = $this->post->category[$key];
            $trade->dept           = $this->post->dept[$key];
            $trade->trader         = $this->post->trader[$key];
            $trade->createTrader   = isset($this->post->createTrader[$key])   ? $this->post->createTrader[$key] : '';
            $trade->traderName     = isset($this->post->traderName[$key])     ? $this->post->traderName[$key] : '';
            $trade->createCustomer = isset($this->post->createCustomer[$key]) ? $this->post->createCustomer[$key] : '';
            $trade->customerName   = isset($this->post->customerName[$key])   ? $this->post->customerName[$key] : '';
            $trade->handlers       = !empty($this->post->handlers[$key]) ? join(',', $this->post->handlers[$key]) : '';
            $trade->date           = $this->post->date[$key];
            $trade->desc           = strip_tags(nl2br($this->post->desc[$key]), $this->config->allowedTags->admin);
            $trade->currency       = $depositor->currency;
            $trade->createdBy      = $this->app->user->account;
            $trade->createdDate    = $now;

            $handlers = $this->loadModel('user')->getByAccount($trade->handlers);
            if($handlers) $trade->dept = $handlers->dept;

            if($trade->createTrader)
            {
                if(isset($newTrader[$trade->traderName]))
                {
                    $trade->trader = $newTrader[$trade->traderName];
                }
                else
                {
                    $data = new stdclass();
                    $data->relation    = 'provider';
                    $data->name        = $trade->traderName;
                    $data->level       = 0;
                    $data->public      = 1;
                    $data->createdBy   = $this->app->user->account;
                    $data->createdDate = $now;

                    $this->dao->insert(TABLE_CUSTOMER)->data($data)->exec();
                    $trade->trader = $this->dao->lastInsertID();
                    $this->action->create('customer', $trade->trader, 'Created');

                    $newTrader[$data->name] = $trade->trader;
                }
            }

            if($trade->createCustomer)
            {
                if(isset($newCustomer[$trade->customerName]))
                {
                    $trade->trader = $newCustomer[$trade->customerName];
                }
                else
                {
                    $data = new stdclass();
                    $data->relation    = 'client';
                    $data->name        = $trade->customerName;
                    $data->level       = 0;
                    $data->createdBy   = $this->app->user->account;
                    $data->createdDate = $now;

                    $this->dao->insert(TABLE_CUSTOMER)->data($data)->exec();
                    $trade->trader = $this->dao->lastInsertID();
                    $this->action->create('customer', $trade->trader, 'Created');

                    $newCustomer[$data->name] = $trade->trader;
                }
            }

            if(empty($trade->trader)) $trade->trader = 0; 

            $trades[$key] = $trade;
        }

        if(empty($trades)) return array('result' => 'fail');

        $errors = $this->batchCheck($trades);
        if(!empty($errors)) return array('result' => 'fail', 'message' => $errors);

        $tradeIDList = array();
        foreach($trades as $trade)
        {
            $this->dao->insert(TABLE_TRADE)->data($trade, $skip = 'createTrader,traderName,createCustomer,customerName')->autoCheck()->exec();
        }
        if(!dao::isError()) return array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('browse'));
        return array('result' => 'fail', 'message' => dao::getError());
    }

    /**
     * Transfer.
     * 
     * @access public
     * @return int|bool
     */
    public function transfer()
    {
        if($this->post->receipt == $this->post->payment) return array('result' => false, 'message' => $this->lang->trade->notEqual);

        $receiptDepositor = $this->loadModel('depositor')->getByID($this->post->receipt);
        $paymentDepositor = $this->loadModel('depositor')->getByID($this->post->payment);

        $diffCurrency = $receiptDepositor->currency != $paymentDepositor->currency;

        $now = helper::now();

        $payment = fixer::input('post')
            ->add('type', 'transferout')
            ->add('category', 'transferout')
            ->add('depositor', $this->post->payment)
            ->add('currency', $paymentDepositor->currency)
            ->add('handlers', trim(join(',', $this->post->handlers), ','))
            ->add('createdBy', $this->app->user->account)
            ->add('createdDate', $now)
            ->add('editedDate', $now)
            ->setIF($diffCurrency, 'money', $this->post->transferOut)
            ->get();

        $receipt = $payment;
        $fee     = $payment;

        $this->dao->insert(TABLE_TRADE)
            ->data($payment, $skip = 'receipt, payment, fee, transferIn, transferOut')
            ->autoCheck()
            ->check('handlers', 'notempty')
            ->batchCheckIF($diffCurrency, 'transferOut,transferIn', 'notempty')
            ->batchCheckIF($diffCurrency, 'transferOut,transferIn', 'float')
            ->checkIF(!$diffCurrency, 'money', 'notempty')
            ->exec();

        if(dao::isError()) return array('result' => false, 'message' => dao::getError());

        $paymentID = $this->dao->lastInsertID();
        $this->loadModel('action')->create('trade', $paymentID, 'Created');

        $receipt->type      = 'transferin';
        $receipt->category  = 'transferin';
        $receipt->depositor = $this->post->receipt;
        $receipt->currency  = $receiptDepositor->currency;
        if($diffCurrency) $receipt->money = $this->post->transferIn;

        $this->dao->insert(TABLE_TRADE)
            ->data($receipt, $skip = 'receipt, payment, fee, transferIn, transferOut')
            ->autoCheck()
            ->check('handlers', 'notempty')
            ->batchCheckIF($diffCurrency, 'transferOut, transferIn', 'notempty')
            ->checkIF(!$diffCurrency, 'money', 'notempty')
            ->exec();

        if(dao::isError()) return array('result' => false, 'message' => dao::getError());

        $receiptID = $this->dao->lastInsertID();
        $this->loadModel('action')->create('trade', $receiptID, 'Created');

        if($this->post->fee)
        {
            $fee->type     = 'fee';
            $fee->category = 'fee';
            $fee->money    = $this->post->fee;
            $fee->desc     = sprintf($this->lang->trade->feeDesc, $fee->date, $paymentDepositor->abbr, $receiptDepositor->abbr);
            if($diffCurrency) $fee->desc = sprintf($this->lang->trade->feeDesc, $fee->date, $paymentDepositor->abbr, $receiptDepositor->abbr);

            $this->dao->insert(TABLE_TRADE)->data($fee, $skip = 'receipt, payment, fee, transferIn, transferOut')->exec();
            if(dao::isError()) return array('result' => false, 'message' => dao::getError());

            $feeID = $this->dao->lastInsertID();
            $this->loadModel('action')->create('trade', $feeID, 'Created');
        }

        return array('result' => true);
    }

    /**
     * Save details of a trade. 
     * 
     * @param  int    $tradeID 
     * @access public
     * @return void
     */
    public function saveDetail($tradeID)
    {
        $trade = $this->getByID($tradeID);
        $trade->parent = $tradeID;

        $now = helper::now();
        $trade->createdDate = $now;
        $trade->createdBy   = $this->app->user->account;
        $trade->editedDate  = $now;
        $trade->editedBy    = $this->app->user->account;
        $trade->category    = 0;
        $trade->handlers    = '';

        $this->dao->delete()->from(TABLE_TRADE)->where('parent')->eq($tradeID)->exec();

        foreach($this->post->money as $key => $money)
        {
            if($money !== '')
            {
                $trade->money    = $money;
                if(isset($this->post->category[$key])) $trade->category = join(',', $this->post->category[$key]);
                if(isset($this->post->handlers[$key])) $trade->handlers = join(',', $this->post->handlers[$key]);
                $trade->desc     = $this->post->desc[$key];
                $this->dao->insert(TABLE_TRADE)->data($trade, 'id')->exec();
            }
        }
        return !dao::isError();
    }

    /**
     * Delete a trade.
     * 
     * @param  int      $tradeID 
     * @access public
     * @return void
     */
    public function delete($tradeID, $null = null)
    {
        $trade = $this->getByID($tradeID);
        if(!$trade) return false;

        $this->dao->delete()->from(TABLE_TRADE)->where('id')->eq($tradeID)->exec();

        return !dao::isError();
    }
}
