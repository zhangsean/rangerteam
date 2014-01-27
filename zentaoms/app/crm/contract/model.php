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

        $this->dao->insert(TABLE_CONTRACT)->data($contract, 'order,uid')
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
            }

            return $contractID;
        }

        return false;
    }
}
