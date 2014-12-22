<?php
/**
 * The model file for block module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.ranzhico.com
 */
helper::import(realpath('../../sys/block/model.php'));
class crmblockModel extends blockModel
{
    /**
     * Get block list.
     * 
     * @access public
     * @return string
     */
    public function getAvailableBlocks()
    {
        return json_encode($this->lang->block->availableBlocks);
    }

    /**
     * Get order params.
     * 
     * @access public
     * @return string
     */
    public function getOrderParams()
    {
        $this->app->loadLang('order', 'crm');

        $params = new stdclass();

        $params->type['name']    = $this->lang->block->type;
        $params->type['options'] = $this->lang->block->typeList->order;
        $params->type['control'] = 'select';

        $params->num['name']        = $this->lang->block->num;
        $params->num['default']     = 15; 
        $params->num['control']     = 'input';

        $params->orderBy['name']    = $this->lang->block->orderBy;
        $params->orderBy['default'] = 'id_desc';
        $params->orderBy['options'] = $this->lang->block->orderByList->order;
        $params->orderBy['control'] = 'select';

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
        $this->app->loadLang('task', 'sys');

        $params = new stdclass();
        $params->num['name']    = $this->lang->block->num;
        $params->num['default'] = 15; 
        $params->num['control'] = 'input';

        $params->orderBy['name']    = $this->lang->block->orderBy;
        $params->orderBy['default'] = 'id_desc';
        $params->orderBy['options'] = $this->lang->block->orderByList->task;
        $params->orderBy['control'] = 'select';

        $params->status['name']    = $this->lang->task->status;
        $params->status['options'] = $this->lang->task->statusList;
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
        $this->app->loadLang('contract', 'crm');

        $params = new stdclass();

        $params->type['name']    = $this->lang->block->type;
        $params->type['options'] = $this->lang->block->typeList->contract;
        $params->type['control'] = 'select';

        $params->num['name']    = $this->lang->block->num;
        $params->num['default'] = 15; 
        $params->num['control'] = 'input';

        $params->orderBy['name']    = $this->lang->block->orderBy;
        $params->orderBy['default'] = 'id_desc';
        $params->orderBy['options'] = $this->lang->block->orderByList->contract;
        $params->orderBy['control'] = 'select';

        return json_encode($params);
    }
}
