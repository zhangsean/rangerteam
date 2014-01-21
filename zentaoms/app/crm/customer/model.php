<?php
/**
 * The model file of customer category of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     customer
 * @version     $Id$
 * @link        http://www.zentao.net
 */
class customerModel extends model
{
    /** 
     * Get customer list.
     * 
     * @param  string  $orderBy 
     * @param  object  $pager 
     * @access public
     * @return array
     */
    public function getList($orderBy = 'id_desc', $pager = null)
    {
        $customers = $this->dao->select('*')->from(TABLE_CUSTOMER)->orderBy($orderBy)->page($pager)->fetchAll('id');

        if(!$customers) return array();

        return $customers;
    }

    /** 
     * Get customer pairs.
     * 
     * @param  string  $orderBy 
     * @access public
     * @return array
     */
    public function getPairs($orderBy = 'id_desc')
    {
        return $this->dao->select('id, name')->from(TABLE_CUSTOMER)->orderBy($orderBy)->fetchPairs('id');
    }

    /**
     * Create a customer.
     * 
     * @access public
     * @return int|bool
     */
    public function create()
    {
        $now = helper::now();
        $customer = fixer::input('post')
            ->add('createdBy', $this->app->user->account)
            ->add('createdDate', helper::now())
            ->get();


        $this->dao->insert(TABLE_CUSTOMER)
            ->data($customer)
            ->autoCheck()
            ->exec();

        if(dao::isError()) return false;

        return true;
    }
}
