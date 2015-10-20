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
?>
<?php
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
        $refund  = $this->select('*')->from(TABLE_REFUND)->where('id')->eq($ID)->fetch();
        $details = $this->select('*')->from(TABLE_REFUND)->where('parent')->eq($ID)->fetchAll('id');
        $refund->detail = $details;
        return $refund;
    }

    /**
     * Get wait refunds.
     * 
     * @access public
     * @return array()
     */
    public function getByStatus($status)
    {
        return $this->dao->select('*')->from(TABLE_REFUND)->where('status')->eq($status)->fetchAll();
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
            ->remove('dateList,moneyList,currencyList,categoryList,descList')
            ->get();

        $this->dao->insert(TABLE_REFUND)
            ->data($refund)
            ->autoCheck()
            ->batchCheck($this->config->refund->require->create, 'notempty')
            ->exec();

        if(dao::isError()) return false;
        $refundID = $this->dao->lastInsertID();

        /* Insert detail */
        if(!empty($_POST['moneyList']))
        {
            foreach($this->post->moneyList as $key => $money)
            {
                if(empty($money)) continue;
                $detail = new stdclass();
                $detail->parent = $refundID;
                $detail->status = 'wait';
                $detail->createdBy = $this->app->user->account;
                $detail->createdDate = helper::now();
                $detail->money = $money;
                $detail->date = empty($_POST['dateList'][$key]) ? $refund->date : $_POST['dateList'][$key];
                $detail->currency = $_POST['currencyList'][$key];
                $detail->category = $_POST['categoryList'][$key];
                $detail->desc = $_POST['descList'][$key];

                $this->dao->insert(TABLE_REFUND)->data($detail)->autoCheck()->exec();
            }
        }

        return dao::isError();
    } 

    /**
     * Get department's refund list. 
     * 
     * @param  string $deptID
     * @param  string $status 
     * @access public
     * @return array
     */
    public function getByDept($deptID, $status)
    {
        $users = $this->loadModel('user')->getPairs('noclosed,noempty', $deptID);

        $refunds = $this->dao->select('t1.*, t2.dept')->from(TABLE_REFUND)->alias('t1')->leftJoin(TABLE_USER)->alias('t2')->on("t1.createdBy=t2.account")
            ->where('t1.createdBy')->in(array_keys($users))
            ->andWhere('t1.status')->eq($status)->fi()
            ->orderBy('t2.dept,t1.date')
            ->fetchAll();

        /* Format refund list. */
        $newRefunds = array();
        foreach($refunds as $key => $refund) $newRefunds[$refund->dept][$refund->createdBy] = $refund; 

        /* Fix dept's user record. */
        if(!is_array($deptID)) $deptID = explode(',', trim($deptID, ','));
        foreach($deptID as $dept)
        {
            if($dept == 0) continue;
            $deptUsers = $this->loadModel('user')->getPairs('noclosed,noempty', $dept);
            foreach($deptUsers as $account => $realname) if(!isset($newRefunds[$dept][$account])) $newRefunds[$dept][$account] = array();
        }

        return $newRefunds;
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
}
