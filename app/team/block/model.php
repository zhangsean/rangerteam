<?php
/**
 * The model file of block module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv11.html)
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.ranzhico.com
 */
helper::import(realpath('../../sys/block/model.php'));
class teamblockModel extends blockmodel
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
     * Get blog params.
     * 
     * @access public
     * @return string
     */
    public function getBlogParams()
    {
        $params = new stdclass();
        $params->num['name']    = $this->lang->block->num;
        $params->num['default'] = 15; 
        $params->num['control'] = 'input';

        return json_encode($params);
    }

    /**
     * Get thread params.
     * 
     * @access public
     * @return string
     */
    public function getThreadParams()
    {
        $params = new stdclass();
        $params->num['name']    = $this->lang->block->num;
        $params->num['default'] = 15; 
        $params->num['control'] = 'input';

        $params->type['name']    = $this->lang->block->type;
        $params->type['default'] = 15; 
        $params->type['options'] = $this->lang->block->typeList->thread; 
        $params->type['control'] = 'select';

        return json_encode($params);
    }
}
