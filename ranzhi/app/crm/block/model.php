<?php
/**
 * The model file for block module of Ranzhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.zentao.net
 */
class blockModel extends model
{
    /** 
     * Save params 
     * 
     * @param  int    $index 
     * @access public
     * @return void
     */
    public function save($index)
    {   
        $account = $this->app->user->account;
        $data    = fixer::input('post')->get();

        $data->type = 'system';

        $this->loadModel('setting')->setItem($account . '.crm.index.block.b' . $index, json_encode($data));
    }

    /**
     * Get block list.
     * 
     * @access public
     * @return string
     */
    public function getBlockList()
    {
        $blocks = new stdclass();

        $blocks->order    = new stdclass();
        $blocks->task     = new stdclass();
        $blocks->contract = new stdclass();

        $blocks->order->name    = $this->lang->block->order;
        $blocks->task->name     = $this->lang->block->task;
        $blocks->contract->name = $this->lang->block->contract;

        return json_encode($blocks);
    }

    /**
     * Get order params.
     * 
     * @access public
     * @return string
     */
    public function getOrderParams()
    {
        $this->app->loadLang('order');

        $orderByList['id_asc']        = $this->lang->order->id . $this->lang->block->asc;
        $orderByList['id_desc']       = $this->lang->order->id . $this->lang->block->desc;
        $orderByList['customer_asc']  = $this->lang->order->customer . $this->lang->block->asc;
        $orderByList['customer_desc'] = $this->lang->order->customer . $this->lang->block->desc;
        $orderByList['product_asc']   = $this->lang->order->product . $this->lang->block->asc;
        $orderByList['product_desc']  = $this->lang->order->product . $this->lang->block->desc;

        $params = new stdclass();
        $params->num['name']        = $this->lang->block->num;
        $params->num['default']     = 15; 
        $params->num['control']     = 'input';

        $params->orderBy['name']    = $this->lang->block->orderBy;
        $params->orderBy['default'] = 'id_asc';
        $params->orderBy['values']  = $orderByList;
        $params->orderBy['control'] = 'select';

        $statusList = array('' => '') + $this->lang->order->statusList;
        $params->status['name']    = $this->lang->order->status;
        $params->status['values']  = $statusList;
        $params->status['control'] = 'select';
        $params->status['attr']    = 'multiple';

        return json_encode($params);
    }

    /**
     * Get task params.
     * 
     * @access public
     * @return string
     */
    public function getTaskParams()
    {
        $this->app->loadLang('task');

        $orderByList['id_asc']        = $this->lang->task->id . $this->lang->block->asc;
        $orderByList['id_desc']       = $this->lang->task->id . $this->lang->block->desc;
        $orderByList['pri_asc']       = $this->lang->task->pri . $this->lang->block->asc;
        $orderByList['pri_desc']      = $this->lang->task->pri . $this->lang->block->desc;
        $orderByList['deadline_asc']  = $this->lang->task->deadline . $this->lang->block->asc;
        $orderByList['deadline_desc'] = $this->lang->task->deadline . $this->lang->block->desc;

        $params = new stdclass();
        $params->num['name']        = $this->lang->block->num;
        $params->num['default']     = 15; 
        $params->num['control']     = 'input';

        $params->orderBy['name']    = $this->lang->block->orderBy;
        $params->orderBy['default'] = 'id_asc';
        $params->orderBy['values']  = $orderByList;
        $params->orderBy['control'] = 'select';

        $params->status['name']    = $this->lang->task->status;
        $params->status['values']  = $this->lang->task->statusList;
        $params->status['control'] = 'select';
        $params->status['attr']    = 'multiple';

        return json_encode($params);
    }

    /**
     * Get contract params.
     * 
     * @access public
     * @return string
     */
    public function getContractParams()
    {
        $this->app->loadLang('contract');

        $orderByList['id_asc']        = $this->lang->contract->id . $this->lang->block->asc;
        $orderByList['id_desc']       = $this->lang->contract->id . $this->lang->block->desc;
        $orderByList['customer_asc']  = $this->lang->contract->customer . $this->lang->block->asc;
        $orderByList['customer_desc'] = $this->lang->contract->customer . $this->lang->block->desc;
        $orderByList['amount_asc']    = $this->lang->contract->amount . $this->lang->block->asc;
        $orderByList['amount_desc']   = $this->lang->contract->amount . $this->lang->block->desc;

        $params = new stdclass();
        $params->num['name']        = $this->lang->block->num;
        $params->num['default']     = 15; 
        $params->num['control']     = 'input';

        $params->orderBy['name']    = $this->lang->block->orderBy;
        $params->orderBy['default'] = 'id_asc';
        $params->orderBy['values']  = $orderByList;
        $params->orderBy['control'] = 'select';

        unset($this->lang->contract->statusList[0]);
        $statusList = array('' => '') + $this->lang->contract->statusList;
        $params->status['name']    = $this->lang->contract->status;
        $params->status['values']  = $statusList;
        $params->status['control'] = 'select';
        $params->status['attr']    = 'multiple';

        return json_encode($params);
    }
}
