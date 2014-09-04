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

        foreach($project->members as $role => $member)
        {
            if($role != 'manager') continue;
            if($role == 'manager') $project->PM = $member[0]->account;
        }

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
            ->where('deleted')->eq(0)
            ->beginIF($status)->andWhere('status')->eq($status)->fi()
            ->fetchAll('id');

        $members =  $this->dao->select('*')->from(TABLE_TEAM)->where('type')->eq('project')->fetchGroup('id');

        foreach($projects as $project)
        {
            $project->members = isset($members[$project->id]) ? $members[$project->id] : array();
            foreach($project->members as $member)
            {
                if($member->role != 'manager') continue;
                if($member->role == 'manager') $project->PM = $member->account;
            }
        }

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

        $members = array_unique(array_merge(array($this->post->manager), (array)$this->post->member));
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
     * Suspend project.
     * 
     * @param  int    $projectID 
     * @access public
     * @return bool
     */
    public function suspend($projectID)
    {
        $project = new stdclass();
        $project->status     = 'suspend';
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

    /**
     * Set menu.
     * 
     * @param  array  $projects 
     * @param  int    $projectID 
     * @param  string $extra
     * @access public
     * @return void
     */
    public function setMenu($projects, $projectID, $extra = '')
    {
        /* Check the privilege. */
        $project = $this->getById($projectID);

        if($projects and !isset($projects[$projectID]))
        {
            echo(js::alert($this->lang->project->accessDenied));
            die(js::locate('back'));
        }

        $moduleName = $this->app->getModuleName();
        $methodName = $this->app->getMethodName();

        if($this->cookie->projectMode == 'noclosed' and $project->status == 'finished') 
        {
            setcookie('projectMode', 'all');
            $this->cookie->projectMode = 'all';
        }

        $selectHtml = $this->select($projects, $projectID, $moduleName, $methodName, $extra);

        echo  $selectHtml;
    }

    /**
     * Create the select code of projects. 
     * 
     * @param  array     $projects 
     * @param  int       $projectID 
     * @param  string    $currentModule 
     * @param  string    $currentMethod 
     * @param  string    $extra
     * @access public
     * @return string
     */
    public function select($projects, $projectID, $currentModule, $currentMethod, $extra = '')
    {
        if(!$projectID) return;

        setCookie("lastProject", $projectID, $this->config->cookieLife, $this->config->webRoot);
        $currentProject = $this->getById($projectID);

        $menu  = "<nav class='menu leftmenu affix taskMenu'><ul class='nav nav-stacked nav-primary'>";
        $menu .= "<li><a id='currentItem' href=\"javascript:showDropMenu('project', '$projectID', '$currentModule', '$currentMethod', '$extra')\">{$currentProject->name} <span class='icon-caret-down'></span></a><div id='dropMenu'></div></li>";
        $menu .= "<li>" . html::a(helper::createLink('task', 'browse', "projectID=$projectID&mode=createdBy"), $this->lang->task->createdByMe);
        $menu .= "<li>" . html::a(helper::createLink('task', 'browse', "projectID=$projectID&mode=assignedTo"), $this->lang->task->assignedToMe);
        $menu .= "<li>" . html::a(helper::createLink('task', 'browse', "projectID=$projectID&mode=closedBy"), $this->lang->task->closedByMe);
        $menu .= "<li>" . html::a(helper::createLink('task', 'browse', "projectID=$projectID&mode=untilToday"), $this->lang->task->untilToday);
        $menu .= "<li>" . html::a(helper::createLink('task', 'browse', "projectID=$projectID&mode=expired"), $this->lang->task->expired);
        $menu .= "</ul></nav>";

        return $menu;
    }

    /**
     * Create the link from module,method,extra
     * 
     * @param  string  $module 
     * @param  string  $method 
     * @param  mix     $extra 
     * @access public
     * @return void
     */
    public function getProjectLink($module, $method, $extra)
    {
        $link = '';
        if($module == 'task' && ($method == 'view' || $method == 'edit' || $method == 'batchedit'))
        {   
            $module = 'task';
            $method = 'browse';
        }   

        if($module == 'project' && $method == 'create') return;

        $link = helper::createLink($module, $method, "projectID=%s");
        if($extra != '') $link = helper::createLink($module, $method, "projectID=%s&type=$extra");
        return $link;
    }
}
