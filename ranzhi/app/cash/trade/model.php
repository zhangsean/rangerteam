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
        return $this->dao->select('*')->from(TABLE_TRADE)->where('parent')->eq(0)->orderBy($orderBy)->page($pager)->fetchAll('id');
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
            ->setIf($this->post->type == 'in', 'order', '')
            ->setIf(!$this->post->objectType or !in_array('order', $this->post->objectType), 'order', 0)
            ->setIf(!$this->post->objectType or !in_array('contract', $this->post->objectType), 'contract', 0)
            ->get();

        $depositor = $this->loadModel('depositor')->getByID($trade->depositor);
        $trade->currency = $depositor->currency;

        $this->dao->insert(TABLE_TRADE)
            ->data($trade)
            ->autoCheck()
            ->batchCheck($this->config->trade->require->create, 'notempty')
            ->exec();

        return $this->dao->lastInsertID();
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
        $oldDepositor = $this->getByID($tradeID);

        $trade = fixer::input('post')
            ->setIf(!$this->post->objectType or !in_array('order', $this->post->objectType),    'order', 0)
            ->setIf(!$this->post->objectType or !in_array('contract', $this->post->objectType), 'contract', 0)
            ->add('handlers', trim(join(',', $this->post->handlers), ','))
            ->removeIF($this->post->type == 'cash', 'public')
            ->add('editedBy', $this->app->user->account)
            ->add('editedDate', helper::now())
            ->remove('objectType')
            ->get();

        $handlers = $this->loadModel('user')->getByAccount($trade->handlers);
        if($handlers) $trade->dept = $handlers->dept;


        $this->dao->update(TABLE_TRADE)->data($trade)->autoCheck()->where('id')->eq($tradeID)->exec();

        if(!dao::isError()) return commonModel::createChanges($oldDepositor, $trade);

        return false;
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

        $now = helper::now();
        $receipt = fixer::input('post')
            ->add('type', 'in')
            ->add('depositor', $this->post->receipt)
            ->add('transfer', '1')
            ->add('createdBy', $this->app->user->account)
            ->add('createdDate', $now)
            ->add('editedDate', $now)
            ->setIF($this->post->transferIn, 'money', $this->post->transferIn)
            ->remove('receipt, payment, fee, transferIn, transferOut')
            ->get();

        $receiptDepositor = $this->loadModel('depositor')->getByID($receipt->depositor);
        $receipt->currency = $receiptDepositor->currency;

        $handlers = $this->loadModel('user')->getByAccount($receipt->handlers);
        if($handlers) $receipt->dept = $handlers->dept;

        $this->dao->insert(TABLE_TRADE)
            ->data($receipt)
            ->autoCheck()
            ->batchCheck($this->config->trade->require->transfer, 'notempty')
            ->checkIF(!$this->post->money && !$this->post->transferIn, 'transferIn', 'notempty')
            ->checkIF(!$this->post->money && !$this->post->transferOut, 'transferOut', 'notempty')
            ->exec();

        if(dao::isError()) return array('result' => false, 'message' => dao::getError());

        $receiptID = $this->dao->lastInsertID();
        $this->loadModel('action')->create('trade', $receiptID, 'Created');

        $payment = $receipt;
        $payment->type      = 'out';
        $payment->depositor = $this->post->payment;
        $paymentDepositor   = $this->loadModel('depositor')->getByID($payment->depositor);
        $payment->currency  = $paymentDepositor->currency;
        if($this->post->transferOut) $payment->money = $this->post->transferOut;

        $this->dao->insert(TABLE_TRADE)->data($payment)->exec();
        if(dao::isError()) return array('result' => false, 'message' => dao::getError());

        $paymentID = $this->dao->lastInsertID();
        $this->loadModel('action')->create('trade', $paymentID, 'Created');

        if($this->post->fee)
        {
            $fee = $payment;
            $fee->money    = $this->post->fee;
            $fee->transfer = 0;
            $fee->desc     = sprintf($this->lang->trade->feeDesc, $fee->date, $paymentDepositor->abbr, $this->lang->depositor->currencyList[$paymentDepositor->currency], $this->post->money, $receiptDepositor->abbr, $this->lang->depositor->currencyList[$receiptDepositor->currency], $this->post->money);
            if($this->post->transferIn && $this->post->transferOut) $fee->desc = sprintf($this->lang->trade->feeDesc, $fee->date, $paymentDepositor->abbr, $this->lang->depositor->currencyList[$paymentDepositor->currency], $this->post->transferIn, $receiptDepositor->abbr, $this->lang->depositor->currencyList[$receiptDepositor->currency], $this->post->transferOut);

            $this->dao->insert(TABLE_TRADE)->data($fee)->exec();
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
