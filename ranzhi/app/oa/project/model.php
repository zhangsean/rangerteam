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
    /**
     * Get project by id. 
     * 
     * @param  int    $projectID 
     * @access public
     * @return object
     */
    public function getByID($projectID)
    {
        $project = $this->dao->select('*')->from(TABLE_PROJECT)->where('id')->eq($projectID)->fetch();
        $project->members = $this->getMembers($projectID); 
        return $project;
        
    }

    /**
     * Get members of a project.
     * 
     * @param  int    $project 
     * @access public
     * @return void
     */
    public function getMembers($project)
    {
        return $this->dao->select('*')->from(TABLE_TEAM)->where('type')->eq('project')->andWhere('id')->eq($project)->fetchGroup('role');
    }

    /**
     * Get project list.
     * 
     * @param  int    $status 
     * @access public
     * @return void
     */
    public function getList($status = null)
    {
        $projects = $this->dao->select('*')->from(TABLE_PROJECT)
            ->beginIF($status)->where('status')->eq($status)->fi()
            ->fetchAll('id');
        $members =  $this->dao->select('*')->from(TABLE_TEAM)->where('type')->eq('project')->fetchGroup('id');
        foreach($projects as $project) $project->members = isset($members[$project->id]) ? $members[$project->id] : array();
        return $projects;

    }

    /**
     * Get  project pairs.
     * 
     * @access public
     * @return void
     */
    public function getPairs()
    {
        return $this->dao->select('id,name')->from(TABLE_PROJECT)->where('deleted')->eq(0)->fetchPairs();
    }

    /**
     * Get left menu of project module. 
     * 
     * @param  int    $projectID 
     * @access public
     * @return void
     */
    public function getLeftMenus($projectID = 0)
    {
        $this->lang->menuGroups->task = 'project';

        $menu = "<nav class='menu leftmenu affix'><ul class='nav nav-stacked nav-primary'>";
        if(empty($projects)) $projects = $this->getPairs();

        $leftMenu = array();

        foreach($projects as $id => $project)
        {
            $class = $id == $projectID ? "class='active'" : '';
            $menu .= "<li {$class}>" . html::a(helper::createLink('task', 'browse', "projectID={$id}"), $project);
            
            $menu .= "<div class='actions'>
                        <div class='dropdown'>
                          <button class='btn btn-mini' data-toggle='dropdown'><span class='caret'></span></button>
                          <ul class='dropdown-menu pull-right'>";
                     
            $menu .= "<li>" . html::a(helper::createLink('project', 'edit', "projectID={$id}"), "<i class='icon-edit'> {$this->lang->edit}</i>", "data-toggle='modal'") . '</li>';
            $menu .= "<li>" . html::a(helper::createLink('project', 'delete', "projectID={$id}"), "<i class='icon-remove'> {$this->lang->delete}</i>", "class='deleter'") . '</li>';
            $menu .= "</ul></div></div>";
            
            $menu .= '</li>';
        }
        $isCreateMenu = ($this->app->getModuleName() == 'project' and $this->app->getmethodName() == 'create') ? "class='active'" : ''; 
        $menu .= "<li {$isCreateMenu}>" . html::a(helper::createLink('project', 'create'), $this->lang->project->create, "data-toggle='modal'");

        $menu .= '</ul></nav>';
        return $menu;
    }

    /**
     * create 
     * 
     * @access public
     * @return void
     */
    public function create()
    {
        $project = fixer::input('post')
            ->add('createdBy', $this->app->user->account)
            ->remove('member,manager,master')
            ->add('createdDate', helper::now())
            ->get();

        $this->dao->insert(TABLE_PROJECT)
            ->data($project, $skip = 'uid')
            ->autoCheck()
            ->batchCheck($this->config->project->require->create, 'notempty')
            ->exec();

        if(dao::isError()) return false;
        $projectID = $this->dao->lastInsertId();

        $members = array_merge(array($this->post->manager), (array)$this->post->member);

        $user = new stdclass();
        $user->type = 'project';
        $user->id   = $projectID;
        foreach($members as $member)
        {
            $user->account = $member;
            $user->role    = $member == $this->post->manager ? 'manager' : 'member';

            $this->dao->insert(TABLE_TEAM)->data($user)->autoCheck()->exec();
            if(dao::isError()) return false;
        }
        return $projectID;

    }

    /**
     * Update project 
     * 
     * @param  int    $projectID 
     * @param  mix    $project
     * @access public
     * @return bool
     */
    public function update($projectID, $project = null)
    {
        $oldProject = $this->getByID($projectID);
        if(empty($project))
        {
            $project = fixer::input('post')
                ->add('editedBy', $this->app->user->account)
                ->add('editedDate', helper::now())
                ->get();
        }

        $this->dao->update(TABLE_PROJECT)
            ->data($project, $skip = 'uid,member,manager')
            ->autoCheck()
            ->batchCheck($this->config->project->require->create, 'notempty')
            ->where('id')->eq($projectID)
            ->exec();

        if(dao::isError()) return false;

        $members = array_merge(array($this->post->manager), (array)$this->post->member);
        $this->dao->delete()->from(TABLE_TEAM)->where('type')->eq('project')->andWhere('id')->eq($projectID)->exec();

        $user = new stdclass();
        $user->type = 'project';
        $user->id   = $projectID;
        foreach($members as $member)
        {
            $user->account = $member;
            $user->role    = $member == $this->post->manager ? 'manager' : 'member';

            $this->dao->insert(TABLE_TEAM)->data($user)->autoCheck()->exec();
            if(dao::isError()) return false;
        }

        return commonModel::createChanges($oldProject, $project);
    }

    /**
     * Active project.
     * 
     * @param  int    $projectID 
     * @access public
     * @return bool
     */
    public function activate($projectID)
    {
        $project = new stdclass();
        $project->status     = 'doing';
        $project->editedBy   = $this->app->user->account;
        $project->editedDate = helper::now();

        $this->dao->update(TABLE_PROJECT)->data($project)->where('id')->eq((int)$projectID)->exec();
        return !dao::isError();
    }

    /**
     * Finish project.
     * 
     * @param  int    $projectID 
     * @access public
     * @return bool
     */
    public function finish($projectID)
    {
        $project = new stdclass();
        $project->status     = 'finished';
        $project->editedBy   = $this->app->user->account;
        $project->editedDate = helper::now();

        $this->dao->update(TABLE_PROJECT)->data($project)->where('id')->eq((int)$projectID)->exec();
        return !dao::isError();
    }
}
