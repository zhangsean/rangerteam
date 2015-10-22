<?php
/**
 * The model file of refund module of RanZhi.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv11.html)
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     refund
 * @version     $Id$
 * @link        http://www.ranzhico.com
 */
class refundModel extends model
{
    /**
     * Get a refund by id.
     * 
     * @param  int    $ID 
     * @access public
     * @return void
     */
    public function getByID($ID)
    {
        $refund  = $this->dao->select('*')->from(TABLE_REFUND)->where('id')->eq($ID)->fetch();
        $details = $this->dao->select('*')->from(TABLE_REFUND)->where('parent')->eq($ID)->fetchAll('id');
        $refund->detail = $details;
        return $refund;
    }

    /**
     * Get refund list. 
     * 
     * @param  string $deptID 
     * @param  string $status 
     * @param  string $createdBy 
     * @param  string $orderBy 
     * @param  object $pager 
     * @access public
     * @return array
     */
    public function getList($deptID = '', $status = '', $createdBy = '', $orderBy = 'id_desc', $pager = null)
    {
        $users = $this->loadModel('user')->getPairs('noclosed,noempty', $deptID);
        $refunds = $this->dao->select('*')->from(TABLE_REFUND)
            ->where('parent')->eq('0')
            ->beginIf($deptID != '')->andWhere('createdBy')->in(array_keys($users))->fi()
            ->beginIf($status != '')->andWhere('status')->in($status)->fi()
            ->beginIf($createdBy != '')->andWhere('createdBy')->in($createdBy)->fi()
            ->orderBy($orderBy)
            ->page($pager)
            ->fetchAll('id');

        /* Set pre and next condition. */
        $this->session->set('refundQueryCondition', $this->dao->get());

        $details = $this->dao->select('*')->from(TABLE_REFUND)->where('parent')->in(array_keys($refunds))->fetchGroup('parent', 'id');
        foreach($refunds as $key => $refund) $refund->detail = isset($details[$key]) ? $details[$key] : array();

        return $refunds;
    }

    /**
     * Create a refund.
     * 
     * @access public
     * @return bool
     */
    public function create()
    {
        $refund = fixer::input('post')
            ->add('status', 'wait')
            ->add('createdBy', $this->app->user->account)
            ->add('createdDate', helper::now())
            ->remove('firstReviewer,firstReviewDate,sencondReviewer,secondReviewDate,refundBy,refundDate')
            ->remove('dateList,moneyList,currencyList,categoryList,descList')
            ->get();

        $this->dao->insert(TABLE_REFUND)
            ->data($refund)
            ->autoCheck()
            ->batchCheck($this->config->refund->require->create, 'notempty')
            ->exec();

        if(dao::isError()) return false;
        $refundID = $this->dao->lastInsertID();
        $this->loadModel('action')->create('refund', $refundID, 'Created', '');

        /* Insert detail */
        if(!empty($_POST['moneyList']))
        {
            foreach($this->post->moneyList as $key => $money)
            {
                if(empty($money)) continue;
                $detail = new stdclass();
                $detail->parent      = $refundID;
                $detail->status      = 'wait';
                $detail->createdBy   = $this->app->user->account;
                $detail->createdDate = helper::now();
                $detail->money       = $money;
                $detail->date        = empty($_POST['dateList'][$key]) ? $refund->date : $_POST['dateList'][$key];
                $detail->currency    = $_POST['currencyList'][$key];
                $detail->category    = $_POST['categoryList'][$key];
                $detail->desc        = $_POST['descList'][$key];

                $this->dao->insert(TABLE_REFUND)->data($detail)->autoCheck()->exec();
            }
        }

        return dao::isError();
    } 

    /**
     * update a refund.
     * 
     * @param  int    $refundID 
     * @access public
     * @return object|bool
     */
    public function update($refundID)
    {
        $oldRefund = $this->getByID($refundID);
        $refund = fixer::input('post')
            ->add('editedBy', $this->app->user->account)
            ->add('editedDate', helper::now())
            ->remove('status,firstReviewer,firstReviewDate,sencondReviewer,secondReviewDate,refundBy,refundDate')
            ->remove('idList,dateList,moneyList,currencyList,categoryList,descList')
            ->get();

        $this->dao->update(TABLE_REFUND)
            ->data($refund)
            ->autoCheck()
            ->batchCheck($this->config->refund->require->edit, 'notempty')
            ->where('id')->eq($refundID)
            ->exec();

        /* update details. */
        if(!empty($_POST['moneyList']))
        {
            $newDetails = array();
            foreach($this->post->moneyList as $key => $money)
            {
                if(empty($money)) continue;
                $detail = new stdclass();
                $detail->id          = empty($_POST['idList'][$key]) ? '0' : $_POST['idList'][$key];
                $detail->parent      = $refundID;
                $detail->status      = 'wait';
                $detail->createdBy   = $this->app->user->account;
                $detail->createdDate = helper::now();
                $detail->money       = $money;
                $detail->date        = empty($_POST['dateList'][$key]) ? $refund->date : $_POST['dateList'][$key];
                $detail->currency    = $_POST['currencyList'][$key];
                $detail->category    = $_POST['categoryList'][$key];
                $detail->desc        = $_POST['descList'][$key];

                if($detail->id == '0') 
                {
                    $this->dao->insert(TABLE_REFUND)->data($detail, 'id')->autoCheck()->exec();
                    $detail->id = $this->dao->lastInsertID();
                }
                else
                {
                    $this->dao->update(TABLE_REFUND)->data($detail, 'id')->autoCheck()->where('id')->eq($detail->id)->exec();
                }
                $newDetails[$detail->id] = $detail;
            }
            $refund->detail = $newDetails;

            /* remove old details. */
            foreach($oldRefund->detail as $detail)
            {
                if(!isset($newDetails[$detail->id])) $this->dao->delete()->from(TABLE_REFUND)->where('id')->eq($detail->id)->exec();
            }
        }
        else
        {
            /* remove old details. */
            foreach($oldRefund->detail as $detail)
            {
                $this->dao->delete()->from(TABLE_REFUND)->where('id')->eq($detail->id)->exec();
            }
        }

        return commonModel::createChanges($oldRefund, $refund);
    }

    /**
     * delete a refund.
     * 
     * @param  int    $refundID 
     * @param  null   $null 
     * @access public
     * @return bool
     */
    public function delete($refundID, $null = null)
    {
        $oldRefund = $this->getByID($refundID);
        $this->dao->delete()->from(TABLE_REFUND)->where('id')->eq($refundID)->exec();

        /* remove old details. */
        if(!empty($oldRefund->detail))
        {
            foreach($oldRefund->detail as $detail)
            {
                $this->dao->delete()->from(TABLE_REFUND)->where('id')->eq($detail->id)->exec();
            }
        }
        return dao::isError();
    }

    /**
     * Set refund category. 
     * 
     * @parsm  array   $expenseIdList 
     * @access public
     * @return void
     */
    public function setCategory($expenseIdList)
    {
        $refundCategories   = $this->post->refundCategories;
        $unRefundCategories = array_diff($expenseIdList, $refundCategories);

        foreach($refundCategories as $refundCategory) $this->dao->update(TABLE_CATEGORY)->set('refund')->eq(1)->where('id')->eq($refundCategory)->exec();
        foreach($unRefundCategories as $unRefundCategory) $this->dao->update(TABLE_CATEGORY)->set('refund')->eq(0)->where('id')->eq($unRefundCategory)->exec();

        return !dao::isError();
    }

    /**
     * Get refund categories.
     * 
     * @access public
     * @return void
     */
    public function getCategory()
    {
        return $this->dao->select('*')->from(TABLE_CATEGORY)->where('type')->eq('out')->andWhere('refund')->eq(1)->fetchAll('id');
    }

    /**
     * Get refund category pairs.
     * 
     * @access public
     * @return void
     */
    public function getCategoryPairs()
    {
        return $this->dao->select('*')->from(TABLE_CATEGORY)->where('type')->eq('out')->andWhere('refund')->eq(1)->fetchPairs('id', 'name');
    }

    /**
     * Review a refund.
     * 
     * @param  int    $refundID 
     * @param  int    $status 
     * @access public
     * @return bool
     */
    public function review($refundID, $status)
    {
        $refund = $this->getByID($refundID);

        if($status == 'pass')
        {
            if(!empty($this->config->refund->secondReviewer) and $this->config->refund->secondReviewer != $this->app->user->account) $status = 'doing';
        }

        $data = fixer::input('post')->add('status', $status)->get();

        if($refund->status == 'wait')
        {
            $data->firstReviewer   = $this->app->user->account;
            $data->firstReviewDate = date('Y-m-d') ;
        }

        if($refund->status == 'doing')
        {
            $data->secondReviewer   = $this->app->user->account;
            $data->secondReviewDate = date('Y-m-d') ;
        }

        $this->dao->update(TABLE_REFUND)->data($data)->where('id')->eq($refundID)->exec();

        foreach($refund->detail as $detail)
        {
            if($detail->status != 'reject') $this->dao->update(TABLE_REFUND)->data($data, $skip = 'money')->where('id')->eq($detail->id)->exec();
        }

        return !dao::isError();
    }
}
