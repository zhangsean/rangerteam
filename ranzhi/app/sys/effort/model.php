<?php
/**
 * The model file of effort module of Ranzhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @package     effort
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
?>
<?php
class effortModel extends model
{
    const DAY_IN_FUTURE = 20300101;

    /**
     * Batch create efforts.
     * 
     * @access public
     * @return array
     */
    public function batchCreate()
    {
        $this->loadModel('task');
        $this->loadModel('action');

        $now        = helper::now();
        $efforts    = fixer::input('post')->get();
        $data       = array();
        $taskIDList = array();
        foreach(array_keys($efforts->id) as $id)
        {
            if(strpos($efforts->objectType[$id], '_') !== false)
            {
                $pos = strpos($efforts->objectType[$id], '_');
                $efforts->objectID[$id]   = substr($efforts->objectType[$id], $pos+1);
                $efforts->objectType[$id] = substr($efforts->objectType[$id], 0, $pos);
            }

            if(!empty($efforts->work[$id]) or !empty($efforts->consumed[$id]))
            {
                if(empty($efforts->work[$id]))           return array('result' => false, 'message' => sprintf($this->lang->effort->nowork, $efforts->id[$id]));
                if(strlen($efforts->work[$id]) > 255)    return array('result' => false, 'message' => sprintf($this->lang->effort->tooLang, $efforts->id[$id]));
                if(empty($efforts->consumed[$id]))       return array('result' => false, 'message' => $this->lang->effort->common . $efforts->id[$id] . ' : ' . $this->lang->effort->consumed . $this->lang->effort->noEmpty);
                if(!is_numeric($efforts->consumed[$id])) return array('result' => false, 'message' => $this->lang->effort->common . $efforts->id[$id] . ' : ' . $this->lang->effort->consumed . $this->lang->effort->isNumber);
                if(!empty($efforts->left[$id]) and !is_numeric($efforts->left[$id])) return array('result' => false, 'message' => $this->lang->effort->common . $efforts->id[$id] . ' : ' . $this->lang->effort->left . $this->lang->effort->isNumber);

                $data[$id] = new stdclass();
                $data[$id]->product  = ',0,'; 
                $data[$id]->objectID = 0;

                $data[$id]->date       = isset($efforts->dates[$id]) ? $efforts->dates[$id] : $efforts->date;
                $data[$id]->consumed   = $efforts->consumed[$id];
                $data[$id]->account    = $this->app->user->account;
                $data[$id]->work       = $efforts->work[$id];
                $data[$id]->objectType = $efforts->objectType[$id];
                if($data[$id]->objectType == 'task')
                {
                    $taskIDList[$efforts->objectID[$id]] = $efforts->objectID[$id];
                    $data[$id]->left = (float)$efforts->left[$id];
                }
                if($data[$id]->objectType != 'custom') $data[$id]->objectID = $efforts->objectID[$id];
                if($data[$id]->objectID != 0) $data[$id]->product = $this->action->getProduct($data[$id]->objectType, $data[$id]->objectID);
            }
        }

        $tasks    = $this->dao->select('*')->from(TABLE_TASK)->where('id')->in($taskIDList)->fetchAll('id');
        $consumed = 0;

        foreach($data as $id => $effort)
        {
            $this->dao->insert(TABLE_EFFORT)->data($effort)
                ->autoCheck()
                ->batchCheck($this->config->effort->create->requiredFields, 'notempty')
                ->exec();
            $effortID = $this->dao->lastInsertID();

            if($effort->objectType == 'task')
            {
                $task = $tasks[$effort->objectID];

                $newTask   = new stdclass();
                $consumed += $effort->consumed;
                $newTask->consumed       = $task->consumed + $consumed;
                $newTask->left           = $effort->left;
                $newTask->status         = $task->status;
                $newTask->lastEditedBy   = $this->app->user->account;
                $newTask->lastEditedDate = $now;
                if($effort->left == 0)
                {    
                    $newTask->status       = 'done'; 
                    $newTask->assignedTo   = $task->openedBy;
                    $newTask->assignedDate = $now;
                    $newTask->finishedBy   = $this->app->user->account;
                    $newTask->finishedDate = $now;
                }    
                else if($task->status == 'wait')
                {
                    $newTask->status       = 'doing'; 
                    $newTask->assignedTo   = $this->app->user->account;
                    $newTask->assignedDate = $now;
                    $newTask->realStarted  = date('Y-m-d');
                }
                $this->dao->update(TABLE_TASK)->data($newTask)->where('id')->eq($effort->objectID)->exec();
            }
            if(isset($efforts->actionID[$id]))
            {
                $this->dao->update(TABLE_ACTION)->set('efforted')->eq(1)
                    ->where('id')->le($efforts->actionID[$id])
                    ->andWhere('objectType')->eq($effort->objectType)
                    ->andWhere('objectID')->eq($effort->objectID)
                    ->andWhere('date')->ge("$effort->date 00:00:00")
                    ->andWhere('date')->le("$effort->date 23:59:59")
                    ->exec();
            }

            $this->action->create('effort', $effortID, 'created');
            return array('result' => true);
        }
    }

    /**
     * update an effort.
     * 
     * @param  int    $effortID 
     * @access public
     * @return string
     */
    public function update($effortID)
    {
        $oldEffort = $this->getById($effortID);
        $effort = fixer::input('post')
            ->cleanInt('date, objectID')
            ->specialChars('objectType,work')
            ->get();

        $this->dao->update(TABLE_EFFORT)->data($effort)
            ->autoCheck()
            ->checkIF($effort->objectType == 'custom', $this->config->effort->edit->requiredFields, 'notempty')
            ->where('id')->eq($effortID)
            ->exec();
        /* When old objectType is task then remove old consumed for case that consumed disorder. */
        if($oldEffort->objectType == 'task') $this->dao->update(TABLE_TASK)->set("consumed=consumed-$oldEffort->consumed")->where('id')->eq($oldEffort->objectID)->exec();
        $this->changeTaskConsumed($effort);

        if(!dao::isError()) return commonModel::createChanges($oldEffort, $effort);
    }

    /**
     * Get info of an effort.
     * 
     * @param  int    $effortID 
     * @access public
     * @return object|bool
     */
    public function getById($effortID)
    {
        $effort = $this->dao->findById((int)$effortID)->from(TABLE_EFFORT)->fetch();
        if(!$effort) return false;
        $effort->date = str_replace('-', '', $effort->date);
        return $effort;
    }

    /**
     * Get efforts by object. 
     * 
     * @param  string    $objectType 
     * @param  int       $objectID 
     * @access public
     * @return array 
     */
    public function getByObject($objectType, $objectID)
    {
        $objectTypeList['user']        = $this->loadModel('user')->getPairs('noletter');
        $objectTypeList['order']       = $this->loadModel('order')->getPairs();
        $objectTypeList['custom'][0]   = $this->lang->effort->objectTypeList['custom'];
        $objectTypeList['task']        = $this->dao->select('id,name')->from(TABLE_TASK)->fetchPairs('id');
        $efforts  = $this->dao->select('*')->from(TABLE_EFFORT)->where('objectType')->eq($objectType)->andWhere('objectID')->eq($objectID)->orderBy('date_asc, id')->fetchAll('id');

        if(!empty($efforts))
        {
            foreach($efforts as $effort)
            {
                $key = "$effort->objectType" . '_' . "$effort->objectID";
                $typeList[$key] = '[' . $key . ']:' . $objectTypeList[$effort->objectType][$effort->objectID];
            }
            $efforts['typeList'] = $typeList;
        }
        return $efforts;
    }

    /**
     * Change task consumed.
     * 
     * @param  int    $effort 
     * @param  string $action 
     * @access public
     * @return void
     */
    public function changeTaskConsumed($effort, $action = 'add')
    {
        $action = $action == 'add' ? '+' : '-';
        $now    = helper::now();
        if($effort->objectType == 'task')
        {
            $updateSql   = array();
            $updateSql[] = "`left`=$effort->left";
            if($effort->consumed != 0)                      $updateSql[] = "`consumed`=`consumed`{$action}{$effort->consumed}";
            if(isset($effort->left) and $effort->left == 0) $updateSql[] = "`status`='done',`assignedTo`=`openedBy`,`assignedDate`='$now',`finishedBy`='{$this->app->user->account}',`finishedDate`='$now'";

            $updateSql = join(',', $updateSql);
            if($updateSql) $this->dao->update(TABLE_TASK)->set($updateSql)->where('id')->eq($effort->objectID)->exec();
        }
    }
}
