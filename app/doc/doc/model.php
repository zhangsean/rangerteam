<?php
/**
 * The model file of doc module of RanZhi.
 *
 * @copyright   Copyright 2009-2016 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv12.html)
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     doc 
 * @version     $Id$
 * @link        http://www.ranzhico.com
 */
?>
<?php
class docModel extends model
{
    /**
     * Get library by id.
     * 
     * @param  int    $libID 
     * @access public
     * @return object
     */
    public function getLibById($libID)
    {
        $lib = $this->dao->findByID($libID)->from(TABLE_DOCLIB)->fetch();
        /* Check rights. */
        if(!$this->hasRight($lib)) return false;
        return $lib;
    }

    /**
     * Get libraries.
     * 
     * @access public
     * @return array
     */
    public function getLibList()
    {
        return $this->dao->select('*')->from(TABLE_DOCLIB)->where('deleted')->eq(0)->fetchAll();
    }

    /**
     * Get libraries.
     * 
     * @access public
     * @return array
     */
    public function getLibPairs()
    {
        $libs    = $this->dao->select('*')->from(TABLE_DOCLIB)->where('deleted')->eq(0)->fetchAll();
        $libList = array();
        /* Check rights. */
        foreach($libs as $lib)
        {
            if(!$this->hasRight($lib)) continue;
            $libList[$lib->id] = $lib->name;
        }
        return $libList;
    }

    /**
     * Get all libs by type.
     * 
     * @param  string $type 
     * @param  int    $pager 
     * @access public
     * @return array
     */
    public function getAllLibsByType($type, $pager = null)
    {
        $key = ($type == 'project') ? $type : 'id';
        $stmt = $this->dao->select("DISTINCT $key")->from(TABLE_DOCLIB)->where('deleted')->eq(0);
        if($type == 'project')
        {
            $stmt = $stmt->andWhere($type)->ne(0);
        }
        else
        {
            $stmt = $stmt->andWhere('project')->eq(0);
        }

        $idList = $stmt->orderBy("{$key}_desc")->page($pager, $key)->fetchPairs($key, $key);

        if($type == 'project')
        {
            $table = TABLE_PROJECT;
            $libs = $this->dao->select('id,name')->from($table)->where('id')->in($idList)->orderBy('id desc')->fetchAll('id');
        }
        else
        {
            $libs = $this->dao->select('id,name')->from(TABLE_DOCLIB)->where('id')->in($idList)->orderBy('id desc')->fetchAll('id');
        }

        return $libs;
    }

    /**
     * Get limit libs.
     * 
     * @param  string $type 
     * @param  int    $limit 
     * @access public
     * @return array
     */
    public function getLimitLibs($type, $limit = 4)
    {
        if($type == 'project')
        {
            $stmt  = $this->dao->select('t1.*')->from(TABLE_DOCLIB)->alias('t1')
                ->leftJoin(TABLE_PROJECT)->alias('t2')->on('t1.project=t2.id')
                ->where('t1.deleted')->eq(0)->andWhere('t1.project')->ne(0)
                ->orderBy('id desc')
                ->query();
        }
        else
        {
            $stmt = $this->dao->select('*')->from(TABLE_DOCLIB)->where('deleted')->eq(0)->andWhere('project')->eq(0)->orderBy('id desc')->query();
        }

        $i    = 1;
        $libs = array();
        while($docLib = $stmt->fetch())
        {
            if($i > $limit) break;
            $key = ($type == 'project') ? 'project' : 'id';
            if($this->hasRight($docLib) and !isset($libs[$docLib->$key]))
            {
                $libs[$docLib->$key] = $docLib->name;
                $i++;
            }
        }

        if($type == 'project') $libs = $this->dao->select('id,name')->from(TABLE_PROJECT)->where('id')->in(array_keys($libs))->orderBy('id desc')->fetchAll('id');

        return $libs;
    }

    /**
     * Get libs by project.
     * 
     * @param  int    $projectID 
     * @param  string $mode 
     * @access public
     * @return array
     */
    public function getLibsByProject($projectID, $mode = '')
    {
        $projectLibs = $this->dao->select('*')->from(TABLE_DOCLIB)->where('deleted')->eq(0)->andWhere('project')->eq($projectID)->orderBy('id')->fetchAll('id');

        $libs = array();
        foreach($projectLibs as $lib)
        {
            if($this->hasRight($lib)) $libs[$lib->id] = $lib->name;
        }

        if(strpos($mode, 'onlylib') === false)
        {
            if(commonModel::hasPriv('doc', 'showFiles')) $libs['files'] = $this->lang->doc->files;
        }

        return $libs;
    }

    /**
     * Get lib files.
     * 
     * @param  int    $projectID 
     * @access public
     * @return array
     */
    public function getLibFiles($projectID, $pager = null)
    {
        $this->loadModel('file');
        $docIdList = $this->dao->select('id')->from(TABLE_DOC)->where('project')->eq($projectID)->get();

        $taskIdList  = $this->dao->select('id')->from(TABLE_TASK)->where('project')->eq($projectID)->andWhere('deleted')->eq('0')->get();
        $files = $this->dao->select('*')->from(TABLE_FILE)->alias('t1')
            ->where("(objectType = 'project' and objectID = $projectID)")
            ->orWhere("(objectType = 'doc' and objectID in ($docIdList))")
            ->orWhere("(objectType = 'task' and objectID in ($taskIdList))")
            ->andWhere('size')->gt('0')
            ->page($pager)
            ->fetchAll('id');

        foreach($files as $fileID => $file)
        {
            $file->realPath = $this->file->savePath . $file->pathname;
            $file->webPath  = $this->file->webPath . $file->pathname;
        }

        return $files;
    }

    
    /**
     * Get left menus.
     * 
     * @param  mix    $libs 
     * @access public
     * @return void
     */
    public function getSubMenus($libs = null)
    {
        if(empty($libs)) $libs = $this->getLibPairs();

        $libMenu = array();

        foreach($libs as $id => $libName)
        {
            $libID = isset($this->lang->doc->systemLibs[$id]) ? $id : 'lib' . $id;
            $libMenu[$libID] = "$libName|doc|browse|libID=$id";
        }

        //$libMenu += (array)$this->lang->doc->menu;

        return (object)$libMenu;
    }

    /**
     * Get left menus order.
     * 
     * @param  mix    $libs 
     * @access public
     * @return void
     */
    public function getSubMenusOrder($libs = null)
    {
        if(empty($libs)) $libs = $this->getLibPairs();

        $libMenuOrder = array();
        foreach($libs as $id => $libName)
        {
            $libID = isset($this->lang->doc->systemLibs[$id]) ? $id : 'lib' . $id;
            $libMenuOrder[] = $libID;
        }

        foreach($this->lang->doc->menuOrder as $menu) $libMenuOrder[] = $menu;

        return $libMenuOrder;
    }

    /**
     * Get project libs groups. 
     * 
     * @param  array  $idList 
     * @access public
     * @return array
     */
    public function getSubLibGroups($idList)
    {
        $libGroups   = $this->dao->select('*')->from(TABLE_DOCLIB)->where('deleted')->eq(0)->andWhere('project')->in($idList)->orderBy('id')->fetchGroup('project', 'id');
        $buildGroups = array();
        foreach($libGroups as $projectID => $libs)
        {
            foreach($libs as $lib)
            {
                if($this->hasRight($lib)) $buildGroups[$projectID][$lib->id] = $lib->name;
            }
            if(commonModel::hasPriv('doc', 'showFiles')) $buildGroups[$projectID]['files'] = $this->lang->doc->fileLib;
        }

        return $buildGroups;
    }

    /**
     * Create a library.
     * 
     * @access public
     * @return void
     */
    public function createLib()
    {
        $lib = fixer::input('post')->stripTags('name')
            ->setForce('project', $this->post->libType == 'project' ? $this->post->project : 0)
            ->add('createdBy', $this->app->user->account)
            ->add('createdDate', helper::now())
            ->join('users', ',')
            ->join('groups', ',')
            ->remove('libType')
            ->get();

        $lib->users  = !empty($lib->users) ? ',' . trim($lib->users, ',') . ',' : '';
        $lib->groups = !empty($lib->groups) ? ',' . trim($lib->groups, ',') . ',' : '';

        $this->dao->insert(TABLE_DOCLIB)
            ->data($lib)
            ->autoCheck()
            ->batchCheck('name', 'notempty')
            ->check('name', 'unique')
            ->exec();

        $libID = $this->dao->lastInsertID();

        if(!$this->post->private and $this->post->libType == 'project') $this->setLibUsers($lib->project);

        return $libID;
    }

    /**
     * Update a library.
     * 
     * @param  int    $libID 
     * @access public
     * @return void
     */
    public function updateLib($libID)
    {
        $libID  = (int)$libID;
        $oldLib = $this->getLibById($libID);
        $lib    = fixer::input('post')->stripTags('name')
            ->setIF(empty($oldLib->createdBy), 'createdBy', $this->app->user->account)
            ->setIF(empty($oldLib->createdDate), 'createdDate', helper::now())
            ->add('editedBy', $this->app->user->account)
            ->add('editedDate', helper::now())
            ->join('users', ',')
            ->join('groups', ',')
            ->get();

        $lib->private = $this->post->private ? 1 : 0;
        $lib->users   = !empty($lib->users) ? ',' . trim($lib->users, ',') . ',' : '';
        $lib->groups  = !empty($lib->groups) ? ',' . trim($lib->groups, ',') . ',' : '';

        $this->dao->update(TABLE_DOCLIB)
            ->data($lib)
            ->autoCheck()
            ->batchCheck('name', 'notempty')
            ->check('name', 'unique', "id != $libID")
            ->where('id')->eq($libID)
            ->exec();

        if(!dao::isError()) return commonModel::createChanges($oldLib, $lib);
    }

    /**
     * Delete a lib.
     * 
     * @param  int      $tradeID 
     * @access public
     * @return void
     */
    public function deleteLib($libID)
    {
        $this->dao->delete()->from(TABLE_DOCLIB)->where('id')->eq($libID)->exec();
        return !dao::isError();
    }

    /**
     * Get docs.
     * 
     * @param  int|string   $libID 
     * @param  int          $projectID 
     * @param  int          $module 
     * @param  string       $orderBy 
     * @param  object       $pager 
     * @access public
     * @return void
     */
    public function getDocList($libID, $projectID, $module, $orderBy, $pager)
    {
        $projects = array();
        $projects = $this->loadModel('project', 'proj')->getPairs();

        $keysOfProjects = array_keys($projects);
        $allKeysOfProjects = $keysOfProjects;
        $allKeysOfProjects[] = 0;

        if(strpos($orderBy, 'id') === false) $orderBy .= ', id_desc';

        $docs = $this->dao->select('*')->from(TABLE_DOC)
            ->where('deleted')->eq(0)
            ->beginIF(is_numeric($libID))->andWhere('lib')->eq($libID)->fi()
            ->beginIF($libID == 'project')->andWhere('project')->in($keysOfProjects)->fi()
            ->beginIF($projectID > 0)->andWhere('project')->eq($projectID)->fi()
            ->beginIF((string)$projectID == 'int')->andWhere('project')->gt(0)->fi()
            ->beginIF($module)->andWhere('module')->in($module)->fi()
            ->orderBy($orderBy)
            ->fetchAll();

        $docs = $this->process($docs, $orderBy, $pager);
        
        return $docs;
    }

    /**
     * get doc list by search.
     * 
     * @param  string $orderBy 
     * @param  string $pager 
     * @access public
     * @return array
     */
    public function getDocListBySearch($orderBy, $pager)
    {
        if($this->session->docQuery == false) $this->session->set('docQuery', ' 1 = 1');
        $docQuery = $this->loadModel('search', 'sys')->replaceDynamic($this->session->docQuery);

        $docs = $this->dao->select('*')->from(TABLE_DOC)
            ->where('deleted')->eq(0)
            ->andWhere($docQuery)
            ->orderBy($orderBy)
            ->fetchAll();

        $docs = $this->process($docs, $orderBy, $pager);
        
        return $docs;
    }

    /**
     * Get doc info by id.
     * 
     * @param  int    $docID 
     * @param  bool   $setImgSize 
     * @access public
     * @return void
     */
    public function getById($docID, $setImgSize = false)
    {
        $doc = $this->dao->select('*')
            ->from(TABLE_DOC)
            ->where('id')->eq((int)$docID)
            ->fetch();
        if(!$doc) return false;
        if(!$this->hasRight($doc)) return false;
        $doc->files = $this->loadModel('file')->getByObject('doc', $docID);

        $doc->libName     = '';
        $doc->projectName = '';
        $doc->moduleName  = '';
        if($doc->lib)     $doc->libName     = $this->dao->findByID($doc->lib)->from(TABLE_DOCLIB)->fetch('name');
        if($doc->project) $doc->projectName = $this->dao->findByID($doc->project)->from(TABLE_PROJECT)->fetch('name');
        if($doc->module)  $doc->moduleName  = $this->dao->findByID($doc->module)->from(TABLE_CATEGORY)->fetch('name');
        return $doc;
    }

    /**
     * Create a doc.
     * 
     * @access public
     * @return void
     */
    public function create()
    {
        $now = helper::now();
        $doc = fixer::input('post')
            ->add('createdBy', $this->app->user->account)
            ->add('createdDate', $now)
            ->setDefault('project, module', 0)
            ->specialChars('title, digest, keywords')
            ->encodeURL('url')
            ->stripTags('content', $this->config->allowedTags)
            ->cleanInt('project, module')
            ->remove('files,labels')
            ->join('users', ',')
            ->join('groups', ',')
            ->get();

        $doc->users  = !empty($doc->users) ? ',' . trim($doc->users, ',') . ',' : '';
        $doc->groups = !empty($doc->groups) ? ',' . trim($doc->groups, ',') . ',' : '';

        $condition = "lib = '$doc->lib' AND module = $doc->module";
        $doc = $this->loadModel('file')->processEditor($doc, $this->config->doc->editor->create['id']);
        $this->dao->insert(TABLE_DOC)
            ->data($doc, 'uid')
            ->autoCheck()
            ->batchCheck($this->config->doc->require->create, 'notempty')
            ->check('title', 'unique', $condition)
            ->exec();

        if(!dao::isError())
        {
            $docID = $this->dao->lastInsertID();
            $this->file->saveUpload('doc', $docID);
            return $docID;
        }
        return false;
    }

    /**
     * Update a doc.
     * 
     * @param  int    $docID 
     * @access public
     * @return void
     */
    public function update($docID)
    {
        $oldDoc = $this->getById($docID);
        $doc = fixer::input('post')
            ->cleanInt('module')
            ->setDefault('module', 0)
            ->specialChars('title, digest, keywords')
            ->encodeURL('url')
            ->stripTags('content', $this->config->allowedTags)
            ->add('editedBy',   $this->app->user->account)
            ->add('editedDate', helper::now())
            ->remove('comment,files,labels')
            ->join('users', ',')
            ->join('groups', ',')
            ->get();

        $doc->private = $this->post->private ? 1 : 0;
        $doc->users   = !empty($doc->users) ? ',' . trim($doc->users, ',') . ',' : '';
        $doc->groups  = !empty($doc->groups) ? ',' . trim($doc->groups, ',') . ',' : '';

        $uniqueCondition = "lib = '{$oldDoc->lib}' AND module = {$doc->module} AND id != $docID";
        $doc = $this->loadModel('file')->processEditor($doc, $this->config->doc->editor->edit['id']);
        $this->dao->update(TABLE_DOC)->data($doc, 'uid')
            ->autoCheck()
            ->batchCheck($this->config->doc->require->edit, 'notempty')
            ->check('title', 'unique', $uniqueCondition)
            ->where('id')->eq((int)$docID)
            ->exec();

        if(!dao::isError()) return commonModel::createChanges($oldDoc, $doc);
    }
 
    /**
     * Get docs of a project.
     * 
     * @param  int    $projectID 
     * @access public
     * @return array
     */
    public function getProjectDocList($projectID)
    {
        return $this->dao->findByProject($projectID)->from(TABLE_DOC)->andWhere('deleted')->eq(0)->orderBy('id_desc')->fetchAll();
    }

    /**
     * Get pairs of project modules.
     * 
     * @access public
     * @return array
     */
    public function getProjectModulePairs()
    {
        return $this->dao->findByType('projectdoc')->from(TABLE_CATEGORY)->andWhere('type')->eq('projectdoc')->fetchPairs('id', 'name');
    }

    /**
     * Extract css styles for tables created in kindeditor.
     *
     * Like this: <table class="ke-table1" style="width:100%;" cellpadding="2" cellspacing="0" border="1" bordercolor="#000000">
     * 
     * @param  string    $content 
     * @access public
     * @return void
     */
    public function extractKETableCSS($content)
    {
        $css = '';
        $rule = '/<table class="ke(.*)" .*/';
        if(preg_match_all($rule, $content, $results))
        {
            foreach($results[0] as $tableLine)
            {
                $attributes = explode(' ', str_replace('"', '', $tableLine));
                foreach($attributes as $attribute)
                {
                    if(strpos($attribute, '=') === false) continue;
                    list($attributeName, $attributeValue) = explode('=', $attribute);
                    $$attributeName = trim(str_replace('>', '', $attributeValue));
                }

                if(!isset($class)) continue;
                $className   = $class;
                $borderSize  = isset($border)      ? $border . 'px' : '1px';
                $borderColor = isset($bordercolor) ? $bordercolor : 'gray';
                $borderStyle = "{border:$borderSize $borderColor solid}\n";
                $css .= ".$className$borderStyle";
                $css .= ".$className td$borderStyle";
            }
        }
        return $css;
    }

    /**
     * Process docs and fix pager. 
     * 
     * @param  array  $docs 
     * @param  string $orderBy
     * @param  object $pager 
     * @access public
     * @return array
     */
    public function process($docs = array(), $orderBy = 'id_desc', $pager = null)
    {
        $idList = array();
        foreach($docs as $key => $doc)
        {
            if($this->hasRight($doc)) $idList[] = $doc->id;
        }

        $docIDList = $this->dao->select('id')->from(TABLE_DOC)->where('id')->in($idList)->orderBy($orderBy)->page($pager)->fetchAll('id');
        foreach($docs as $key => $doc)
        {
            if(!isset($docIDList[$doc->id])) unset($docs[$key]);
        }

        return $docs;
    }

    public function setMenu($projectID = 0, $libID = 0, $category = 0, $extra = '')
    {
        if(isset($this->config->customMenu->doc))
        {
            $customMenu = json_decode($this->config->customMenu->doc);
            $menuLibIdList = array();
            foreach($customMenu as $i => $menu)
            {
                if(strpos($menu->name, 'custom') === 0)
                {
                    $menuLibID = (int)substr($menu->name, 6);
                    if($menuLibID) $menuLibIdList[$i] = $menuLibID;
                }
            }

            $projectIdList = array();
            if($menuLibIdList)
            {
                $libs = $this->dao->select('id,name,project')->from(TABLE_DOCLIB)->where('id')->in($menuLibIdList)->fetchAll('id');
                foreach($libs as $lib)
                {
                    if($lib->project) $projectIdList[] = $lib->project;
                }
            }
            $projects = $projectIdList ? $this->dao->select('id,name')->from(TABLE_PROJECT)->where('id')->in($projectIdList)->fetchPairs('id', 'name') : array();
            foreach($menuLibIdList as $i => $menuLibID)
            {
                $lib = $libs[$menuLibID];
                $libName = '';
                if($lib->project) $libName = isset($projects[$lib->project]) ? '[' . $projects[$lib->project] . ']' : '';
                $libName .= $lib->name;
                $customMenu[$i]->link = "{$libName}|doc|browse|libID={$menuLibID}";
            }
            $this->config->customMenu->doc = json_encode($customMenu);
        }

        /* Check the privilege. */
        $lib = $this->getLibById($libID);
        $projectID = !empty($lib) ? $lib->project : $projectID;
        $project = $this->loadModel('project', 'proj')->getById($projectID);

        $menu  = "<nav id='menu'><ul class='nav'>";
        $menu .= '<li>';

        if($project)
        {
            $menu .= html::a(helper::createLink('doc', 'allLibs', "type=project"), $this->lang->doc->libTypeList['project']);
            $menu .= "<i class='icon-angle-right'></i>";
            $menu .= html::a(helper::createLink('doc', 'projectLibs', "projectID=$project->id"), $project->name);
            if($lib)   $menu .= "<i class='icon-angle-right'></i> " . $lib->name;
            if($extra) $menu .= "<i class='icon-angle-right'></i> " . $extra;
        }
        else
        {
            
            if($lib)
            {
                $menu .= html::a(helper::createLink('doc', 'allLibs', "type=custom") , $this->lang->doc->libTypeList['custom']);
                $menu .= "<i class='icon-angle-right'></i> " . $lib->name;
            }
            if($extra) $menu .= "<i class='icon-angle-right'></i> " . $extra;
        }
        $menu .= '</li></ul></nav>';
        echo  $menu;
    }

    /**
     * Set lib users.
     * 
     * @param  int    $projectID 
     * @access public
     * @return void
     */
    public function setLibUsers($projectID)
    {
        $libs  = $this->dao->select('*')->from(TABLE_DOCLIB)->where('project')->eq($projectID)->fetchAll();
        $teams = $this->dao->select('account')->from(TABLE_TEAM)->where('type')->eq('project')->andWhere('id')->eq($projectID)->fetchPairs('account', 'account');

        foreach($libs as $lib)
        {
            foreach(explode(',', $lib->users) as $account) $teams[$account] = $account;
            $this->dao->update(TABLE_DOCLIB)->set('users')->eq(join(',', $teams))->where('id')->eq($lib->id)->exec();
        }
        return true;
    }

    /**
     * Check rights of doc and lib.
     * 
     * @param  object $object 
     * @access public
     * @return bool
     */
    public function hasRight($object = null)
    {
        if(!$object) return false;

        if($this->app->user->admin == 'super' || $this->app->user->account == $object->createdBy) return true;
        
        if(!empty($object->private))
        {
            return $this->app->user->account == $object->createdBy;
        }   

        if(empty($object->users) && empty($object->groups))
        {
            $hasRight = true;
        }
        else
        {
            $hasRight = false;
            if(!empty($object->users))
            {
                $hasRight = strpos($object->users, ',' . $this->app->user->account . ',') !== false;
            }

            if(!$hasRight && !empty($object->groups))
            {
                $count = $this->dao->select('count(t2.account) as count')
                    ->from(TABLE_USER)->alias('t1')
                    ->leftJoin(TABLE_USERGROUP)->alias('t2')->on('t1.account = t2.account')
                    ->where('t1.deleted')->eq(0)
                    ->andWhere('t1.account')->eq($this->app->user->account)
                    ->andWhere('t2.group')->in($object->groups)
                    ->fetch('count');
                $hasRight = $count > 0;
            }
        }

        if($hasRight && !empty($object->lib))
        {
            $object   = $this->getLibById($object->lib);
            $hasRight = $this->hasRight($object);
        }

        return $hasRight;
    }
}
