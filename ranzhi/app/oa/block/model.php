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

        $this->loadModel('setting')->setItem($account . '.oa.index.block.b' . $index, json_encode($data));
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
        $blocks->announce = $this->lang->block->announce;

        return json_encode($blocks);
    }

    /**
     * Get announce params.
     * 
     * @access public
     * @return string
     */
    public function getAnnounceParams()
    {
        $params = new stdclass();
        $params->num['name']        = $this->lang->block->num;
        $params->num['default']     = 15; 
        $params->num['control']     = 'input';

        return json_encode($params);
    }
}
