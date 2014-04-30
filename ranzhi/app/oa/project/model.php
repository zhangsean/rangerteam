<?php
/**
 * The model file of project module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     project 
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
class projectModel extends model
{
    public function getPairs()
    {
        return $this->dao->select('id,name')->from(TABLE_PROJECT)->where('deleted')->eq(0)->fetchPairs();
    }

    public function getLeftMenus($projects = null)
    {
        if(empty($projects)) $projects = $this->getPairs();

        $leftMenu = array();

        foreach($projects as $id => $project)
        {
            $leftMenu[$id] = "$project|project|browse|projectID=$id";
        }

        $leftMenu += (array)$this->lang->project->menu;

        return (object)$leftMenu;
    }

    public function create()
    {
        $project = fixer::input('post')
            ->add('createdBy', $this->app->user->account)
            ->add('createdDate', helper::now())
            ->get();

        $this->dao->insert(TABLE_PROJECT)->data($project)
            ->autoCheck()
            ->batchCheck($this->config->project->require->create, 'notempty')
            ->exec();

        if(dao::isError()) return false;

        return $this->dao->lastInsertId();
    }
}
