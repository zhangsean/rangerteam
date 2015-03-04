<?php
/**
 * The model file of project module of RanZhi.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv11.html)
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     project 
 * @version     $Id$
 * @link        http://www.ranzhico.com
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
        $members = $this->getMembers($projectID); 

        if(isset($members['manager'])) $project->PM = $members['manager'][0]->account;
        $project->members = array($project->PM);
        if(isset($members['member']))
        {
            foreach($members['member'] as $member)
            {
                $project->members[] = $member->account;   
            }
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
     * Get member pairs.
     * 
     * @param  int    $projectID
     * @access public
     * @return array
     */
    public function getMemberPairs($projectID)
    {
        $members = $this->dao->select('account')->from(TABLE_TEAM)->where('type')->eq('project')->andWhere('id')->eq($projectID)->fetchPairs('account');
        $users = $this->dao->select('account, realname')->from(TABLE_USER)->where('account')->in($members)->orderBy('id_asc')->fetchPairs();
        foreach($users as $account => $realname) if($realname == '') $users[$account] = $account; 
        return array('' => '') + $users;
    }

    /**
     * Get project list.
     * 
     * @param  string  $status 
     * @access public
     * @return array
     */
    public function getList($status = null)
    {
        $projects = $this->dao->select('*')->from(TABLE_PROJECT)
            ->where('deleted')->eq(0)
            ->beginIF($status)->andWhere('status')->eq($status)->fi()
            ->fetchAll('id');

        $members = $this->dao->select('*')->from(TABLE_TEAM)->where('type')->eq('project')->fetchGroup('id');

        foreach($projects as $project)
        {
            $project->members = isset($members[$project->id]) ? $members[$project->id] : array();
            foreach($project->members as $key => $member)
            {
                if(!$member->account) unset($project->members[$key]);
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
     * @return array
     */
    public function getPairs()
    {
        return $this->dao->select('id,name')->from(TABLE_PROJECT)->where('deleted')->eq(0)->fetchPairs();
    }

    /**
     * Get projects to import 
     * 
     * @access public
     * @return array
     */
    public function getProjectsToImport()
    {
        $projects = $this->dao->select('distinct t1.*')->from(TABLE_PROJECT)->alias('t1')
            ->leftJoin(TABLE_TASK)->alias('t2')->on('t1.id=t2.project')
            ->where('t2.status')->notIN('done,closed')
            ->andWhere('t2.deleted')->eq(0)
            ->andWhere('t1.deleted')->eq(0)
            ->orderBy('id desc')
            ->fetchAll('id');

        $pairs = array();
        $now   = date('Y-m-d');
        foreach($projects as $id => $project)
        {
            if($project->status == 'done' or $project->end < $now) $pairs[$id] = $project->name;
        }
        return $pairs;
    }

    /**
     * Get tasks can be imported.
     * 
     * @param  int    $fromProject 
     * @access public
     * @return array
     */
    public function getTasks2Imported($fromProject)
    {
        $tasks        = array();
        $projectTasks = $this->loadModel('task')->getProjectTasks($fromProject, 'wait,doing,pause,cancel');
        $tasks        = array_merge($tasks, $projectTasks); 
        return $tasks;
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
            ->add('createdDate', helper::now())
            ->remove('member,manager,master')
            ->stripTags('desc', $this->config->allowedTags->admin)
            ->get();

        $this->dao->insert(TABLE_PROJECT)
            ->data($project, $skip = 'uid')
            ->autoCheck()
            ->batchCheck($this->config->project->require->create, 'notempty')
            ->checkIF($project->end, 'end', 'ge', $project->begin)
            ->exec();

        if(dao::isError()) return false;
        $projectID = $this->dao->lastInsertId();

        $members = array_unique(array_merge(array($this->post->manager), (array)$this->post->member));

        $user = new stdclass();
        $user->type = 'project';
        $user->id   = $projectID;
        foreach($members as $member)
        {
            if($member == '') continue;
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
                ->stripTags('desc', $this->config->allowedTags->admin)
                ->remove('member,manager,master')
                ->get();
        }

        $this->dao->update(TABLE_PROJECT)
            ->data($project, $skip = 'uid')
            ->autoCheck()
            ->batchCheck($this->config->project->require->create, 'notempty')
            ->checkIF($project->end, 'end', 'ge', $project->begin)
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
            if($member == '') continue;
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
     * Import tasks.
     * 
     * @param  int    $projectID 
     * @access public
     * @return void
     */
    public function importTask($projectID)
    {
        $this->loadModel('task');

        /* Update tasks. */
        $tasks = $this->dao->select('id, project, assignedTo, consumed, status')->from(TABLE_TASK)->where('id')->in($this->post->tasks)->fetchAll('id');
        foreach($tasks as $task)
        {
            /* Save the assignedToes, should linked to project. */
            $assignedToes[$task->assignedTo] = $task->project;

            $data = new stdclass();
            $data->project = $projectID;

            if($task->status == 'cancel')
            {
                $data->canceledBy = '';
                $data->canceledDate = NULL;
            }

            $data->status = $task->consumed > 0 ? 'doing' : 'wait';
            $this->dao->update(TABLE_TASK)->data($data)->where('id')->eq($task->id)->exec();

            if(dao::isError()) return false;

            $this->loadModel('action')->create('task', $task->id, 'moved', '', $task->project);
        }

        /* Add members to project team. */
        $members = $this->getMemberPairs($projectID);
        foreach($assignedToes as $account => $preProjectID)
        {
            if(!isset($members[$account]))
            {
                $role = $this->dao->select('*')->from(TABLE_TEAM)->where('type')->eq('project')->andWhere('id')->eq($preProjectID)->andWhere('account')->eq($account)->fetch();
                $role->id   = $projectID;
                $role->join = helper::today();
                $this->dao->insert(TABLE_TEAM)->data($role)->exec();
                
                return !dao::isError();
            }
        }

        return true;
    }

    /**
     * Save the project id user last visited to session.
     * 
     * @param  int   $projectID 
     * @param  array $projects 
     * @access public
     * @return int
     */
    public function saveState($projectID, $projects)
    {
        if($projectID > 0) $this->session->set('project', (int)$projectID);
        if($projectID == 0 and $this->cookie->lastProject)    $this->session->set('project', (int)$this->cookie->lastProject);
        if($projectID == 0 and $this->session->project == '') $this->session->set('project', $projects[0]);
        if(!in_array($this->session->project, $projects)) $this->session->set('project', $projects[0]);
        return $this->session->project;
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

        $methodName = $this->app->getMethodName();
        $moduleName = $this->app->getModuleName();
            
        $menu  = "<nav id='menu'><ul class='nav'>";
        $menu .= "<li><a id='currentItem' href=\"javascript:showDropMenu('project', '$projectID', '$currentModule', '$currentMethod', '$extra')\"><i class='icon-folder-open-alt'></i> <strong>{$currentProject->name}</strong> <span class='icon-caret-down'></span></a><div id='dropMenu'></div></li>";

        $viewIcons = array('browse' => 'list-ul', 'kanban' => 'columns', 'outline' => 'list-alt');
        $this->lang->task->browse = $this->lang->task->list;

        if($methodName ==  'browse' or $methodName == 'importtask')
        {
            $menu .= '<li class="divider angle"></li>';
            $menu .= "<li class='all'>" . html::a(helper::createLink('task', 'browse', "projectID=$projectID"), $this->lang->task->all);
            $menu .= "<li>" . html::a(helper::createLink('task', 'browse', "projectID=$projectID&mode=createdBy"), $this->lang->task->createdByMe);
            $menu .= "<li>" . html::a(helper::createLink('task', 'browse', "projectID=$projectID&mode=assignedTo"), $this->lang->task->assignedToMe);
            $menu .= "<li>" . html::a(helper::createLink('task', 'browse', "projectID=$projectID&mode=finishedBy"), $this->lang->task->finishedByMe);
            $menu .= "<li>" . html::a(helper::createLink('task', 'browse', "projectID=$projectID&mode=untilToday"), $this->lang->task->untilToday);
            $menu .= "<li>" . html::a(helper::createLink('task', 'browse', "projectID=$projectID&mode=expired"), $this->lang->task->expired);
        }
        else if($methodName == 'kanban' || $methodName == 'outline')
        {
            $menu .= '<li class="divider angle"></li>';
            foreach($this->lang->task->groups as $key => $value)
            {
                if(empty($key)) continue;
                $menu .= "<li data-group='{$key}'>" . html::a(helper::createLink('task', $methodName, "projectID=$projectID&groupBy=$key"), $value) . "</li>";
            }
        }
        else if($methodName == 'view')
        {
            $menu .= '<li class="divider angle"></li>';
            $menu .= '<li class="title">' . $this->lang->{$moduleName}->view . '</li>';
        }
        else if($methodName == 'batchcreate')
        {
            $menu .= '<li class="divider angle"></li>';
            $menu .= '<li class="title">' . $this->lang->{$moduleName}->batchCreate . '</li>';
        }

        $menu .= "</ul>";
        $menu .= "<div class='pull-right'>" . html::a(helper::createLink('task', 'batchCreate', "projectID=$projectID"), '<i class="icon-plus"></i> ' . $this->lang->task->create, 'class="btn btn-primary"') . "</div>";
        $menu .= "<div class='pull-right'>" . html::a(helper::createLink('project', 'importTask', "projectID=$projectID"), '<i class="icon-upload-alt"></i> ' . $this->lang->project->importTask, 'class="btn btn-primary"') . "</div>";

        if($methodName == 'browse' || $methodName == 'kanban' || $methodName == 'outline')
        {
            $taskListType = $methodName;
            $viewName = $this->lang->task->{$methodName};
            $menu .= "<ul class='nav pull-right'>";
            $menu .= "<li id='viewBar' class='dropdown'><a href='javascript:;' id='groupButton' data-toggle='dropdown' class='dropdown-toggle'><i class='icon-" . $viewIcons[$methodName] . "'></i> {$viewName} <i class='icon-caret-down'></i></a><ul class='dropdown-menu'>";
            $menu .= "<li" . ($methodName == 'browse' ? " class='active'" : '') . ">" . html::a(helper::createLink('task', 'browse', "projectID=$projectID"), "<i class='icon-list-ul icon'></i> " . $this->lang->task->list) . "</li>";
            $menu .= "<li" . ($methodName == 'kanban' ? " class='active'" : '') . ">" . html::a(helper::createLink('task', 'kanban', "projectID=$projectID"), "<i class='icon-columns icon'></i> " . $this->lang->task->kanban) . "</li>";
            $menu .= "<li" . ($methodName == 'outline' ? " class='active'" : '') . ">" . html::a(helper::createLink('task', 'outline', "projectID=$projectID"), "<i class='icon-list-alt icon'></i> " . $this->lang->task->outline) . "</li>";
            $menu .= '</ul></li>';

            if($methodName == 'outline')
            {
                $menu .= '<li><a href="javascript:;" id="toggleAll"><i class="icon-plus"></i></a></li>';
            }

            $menu .= "</ul>";
        }

        $menu .= '</nav>';

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
