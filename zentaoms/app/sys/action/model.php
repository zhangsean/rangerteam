<?php
/**
 * The model file of action module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     action
 * @version     $Id: model.php 5028 2013-07-06 02:59:41Z wyd621@gmail.com $
 * @link        http://www.zentao.net
 */
?>
<?php
class actionModel extends model
{
    const BE_UNDELETED  = 0;    // The deleted object has been undeleted.
    const CAN_UNDELETED = 1;    // The deleted object can be undeleted.
    const BE_HIDDEN     = 2;    // The deleted object has been hidded.

    /**
     * Create a action.
     * 
     * @param  string $objectType 
     * @param  int    $objectID 
     * @param  string $actionType 
     * @param  string $comment 
     * @param  string $extra        the extra info of this action, according to different modules and actions, can set different extra.
     * @param  string $actor
     * @access public
     * @return int
     */
    public function create($objectType, $objectID, $actionType, $comment = '', $extra = '', $actor = '')
    {
        $action = new stdclass();

        $objectType = str_replace('`', '', $objectType);
        $action->objectType = strtolower($objectType);
        $action->objectID   = $objectID;
        $action->actor      = $actor ? $actor : $this->app->user->account;
        $action->action     = strtolower($actionType);
        $action->date       = helper::now();
        $action->comment    = trim(strip_tags($comment, "<img>")) ? $comment : '';
        $action->extra      = $extra;

        /* Get product and project for this object. */
        $action->product = $this->getProduct($action->objectType, $objectID);

        $this->dao->insert(TABLE_ACTION)->data($action)->autoCheck()->exec();
        return $this->dbh->lastInsertID();
    }

    /**
     * Get product of an object.
     * 
     * @param  string $objectType 
     * @param  int    $objectID 
     * @access public
     * @return array
     */
    public function getProduct($objectType, $objectID)
    {
        $product = 0;

        /* If objectType is product, return the objectID. */
        if($objectType == 'product') return $objectID;

        /* Only process these object types. */
        if(strpos(',order,orderAction,orderField,', ",$objectType,") !== false)
        {
            if(!isset($this->config->objectTables[$objectType])) return $product;

            /* Set fields to fetch. */
            $record = $this->dao->select('product')->from($this->config->objectTables[$objectType])->where('id')->eq($objectID)->fetch();

            if($record) return isset($record->product) ? $record->product : 0;
        }
        return $product;
    }

    /**
     * Get actions of an object.
     * 
     * @param  int    $objectType 
     * @param  int    $objectID 
     * @access public
     * @return array
     */
    public function getList($objectType, $objectID)
    {
        $actions   = $this->dao->select('*')->from(TABLE_ACTION)
            ->where('objectType')->eq($objectType)
            ->andWhere('objectID')->eq($objectID)
            ->orderBy('date, id')->fetchAll('id');
        $histories = $this->getHistory(array_keys($actions));
        $this->loadModel('file');
        foreach($actions as $actionID => $action)
        {
            $action->history = isset($histories[$actionID]) ? $histories[$actionID] : array();
            $actions[$actionID] = $action;
        }
        return $actions;
    }

    /**
     * Get an action record.
     * 
     * @param  int    $actionID 
     * @access public
     * @return object
     */
    public function getById($actionID)
    {
        return $this->dao->findById((int)$actionID)->from(TABLE_ACTION)->fetch();
    }

    /**
     * Get deleted objects.
     * 
     * @param  string    $type all|hidden 
     * @param  string    $orderBy 
     * @param  object    $pager 
     * @access public
     * @return array
     */
    public function getTrashes($type, $orderBy, $pager)
    {
        $extra = $type == 'hidden' ? self::BE_HIDDEN : self::CAN_UNDELETED;
        $trashes = $this->dao->select('*')->from(TABLE_ACTION)
            ->where('action')->eq('deleted')
            ->andWhere('extra')->eq($extra)
            ->orderBy($orderBy)->page($pager)->fetchAll();
        if(!$trashes) return array();
        
        /* Group trashes by objectType, and get there name field. */
        foreach($trashes as $object) 
        {
            $object->objectType = str_replace('`', '', $object->objectType);
            $typeTrashes[$object->objectType][] = $object->objectID;
        }
        foreach($typeTrashes as $objectType => $objectIds)
        {
            $objectIds   = array_unique($objectIds);
            $table       = $this->config->objectTables[$objectType];
            $field       = $this->config->action->objectNameFields[$objectType];

            if(!$table) continue;
            $objectNames[$objectType] = $this->dao->select("id, $field AS name")->from($table)->where('id')->in($objectIds)->fetchPairs();
        }

        /* Add name field to the trashes. */
        foreach($trashes as $trash) $trash->objectName = $objectNames[$trash->objectType][$trash->objectID];
        return $trashes;
    }

    /**
     * Get histories of an action.
     * 
     * @param  int    $actionID 
     * @access public
     * @return array
     */
    public function getHistory($actionID)
    {
        return $this->dao->select()->from(TABLE_HISTORY)->where('action')->in($actionID)->orderBy('id')->fetchGroup('action');
    }

    /**
     * Log histories for an action.
     * 
     * @param  int    $actionID 
     * @param  array  $changes 
     * @access public
     * @return void
     */
    public function logHistory($actionID, $changes)
    {
        foreach($changes as $change) 
        {
            $change['action'] = $actionID;
            $this->dao->insert(TABLE_HISTORY)->data($change)->exec();
        }
    }

    /**
     * Print actions of an object.
     * 
     * @param  array    $action 
     * @access public
     * @return void
     */
    public function printAction($action)
    {
        $objectType = $action->objectType;
        $actionType = strtolower($action->action);

        /**
         * Set the desc string of this action.
         *
         * 1. If the module of this action has defined desc of this actionType, use it.
         * 2. If no defined in the module language, search the common action define.
         * 3. If not found in the lang->action->desc, use the $lang->action->desc->common or $lang->action->desc->extra as the default.
         */
        if(isset($this->lang->$objectType->action->$actionType))
        {
            $desc = $this->lang->$objectType->action->$actionType;
        }
        elseif(isset($this->lang->action->desc->$actionType))
        {
            $desc = $this->lang->action->desc->$actionType;
        }
        else
        {
            $desc = $action->extra ? $this->lang->action->desc->extra : $this->lang->action->desc->common;
        }

        if($this->app->getViewType() == 'mhtml') $action->date = date('m-d H:i', strtotime($action->date));

        /* Cycle actions, replace vars. */
        foreach($action as $key => $value)
        {
            if($key == 'history') continue;

            /* Desc can be an array or string. */
            if(is_array($desc))
            {
                if($key == 'extra') continue;
                $desc['main'] = str_replace('$' . $key, $value, $desc['main']);
            }
            else
            {
                $desc = str_replace('$' . $key, $value, $desc);
            }
        }

        /* If the desc is an array, process extra. Please bug/lang. */
        if(is_array($desc))
        {
            $extra = strtolower($action->extra);
            if(isset($desc['extra'][$extra])) 
            {
                echo str_replace('$extra', $desc['extra'][$extra], $desc['main']);
            }
            else
            {
                echo str_replace('$extra', $action->extra, $desc['main']);
            }
        }
        else
        {
            echo $desc;
        }
    }

    /**
     * Transform the actions for display.
     * 
     * @param  int    $actions 
     * @access public
     * @return void
     */
    public function transformActions($actions)
    {
        /* Group actions by objectType, and get there name field. */
        foreach($actions as $object) $objectTypes[$object->objectType][] = $object->objectID;
        foreach($objectTypes as $objectType => $objectIds)
        {
            if(!isset($this->config->objectTables[$objectType])) continue;    // If no defination for this type, omit it.

            $objectIds   = array_unique($objectIds);
            $table       = $this->config->objectTables[$objectType];
            $field       = $this->config->action->objectNameFields[$objectType];
            if($table != '`zt_todo`')
            {
                $objectNames[$objectType] = $this->dao->select("id, $field AS name")->from($table)->where('id')->in($objectIds)->fetchPairs();
            }
            else
            {
                $todos = $this->dao->select("id, $field AS name, account, private, type, idvalue")->from($table)->where('id')->in($objectIds)->fetchAll('id');
                foreach($todos as $id => $todo)
                {
                    if($todo->type == 'task') $todo->name = $this->dao->findById($todo->idvalue)->from(TABLE_TASK)->fetch('name');
                    if($todo->type == 'bug')  $todo->name = $this->dao->findById($todo->idvalue)->from(TABLE_BUG)->fetch('title');
                    if($todo->private == 1 and $todo->account != $this->app->user->account) 
                    {
                       $objectNames[$objectType][$id] = $this->lang->todo->thisIsPrivate;
                    }
                    else
                    {
                       $objectNames[$objectType][$id] = $todo->name;
                    }
                }
            } 
        }
        $objectNames['user'][0] = 'guest';    // Add guest account.

        foreach($actions as $action)
        {
            /* Add name field to the actions. */
            $action->objectName = isset($objectNames[$action->objectType][$action->objectID]) ? $objectNames[$action->objectType][$action->objectID] : '';

            $actionType = strtolower($action->action);
            $objectType = strtolower($action->objectType);
            $action->date        = date(DT_MONTHTIME2, strtotime($action->date));
            $action->actionLabel = isset($this->lang->action->label->$actionType) ? $this->lang->action->label->$actionType : $action->action;
            $action->objectLabel = isset($this->lang->action->label->$objectType) ? $this->lang->action->label->$objectType : $objectType;

            /* Other actions, create a link. */
            if(strpos($action->objectLabel, '|') !== false)
            {
                list($objectLabel, $moduleName, $methodName, $vars) = explode('|', $action->objectLabel);
                $action->objectLink  = helper::createLink($moduleName, $methodName, sprintf($vars, $action->objectID));
                $action->objectLabel = $objectLabel;
            }
            else
            {
                $action->objectLink = '';
            }
        }
        return $actions;
    }

    /**
     * Print changes of every action.
     * 
     * @param  string    $objectType 
     * @param  array     $histories 
     * @access public
     * @return void
     */
    public function printChanges($objectType, $histories)
    {
        if(empty($histories)) return;

        $maxLength            = 0;          // The max length of fields names.
        $historiesWithDiff    = array();    // To save histories without diff info.
        $historiesWithoutDiff = array();    // To save histories with diff info.

        /* Diff histories by hasing diff info or not. Thus we can to make sure the field with diff show at last. */
        foreach($histories as $history)
        {
            $fieldName = $history->field;
            $history->fieldLabel = isset($this->lang->$objectType->$fieldName) ? $this->lang->$objectType->$fieldName : $fieldName;
            if(($length = strlen($history->fieldLabel)) > $maxLength) $maxLength = $length;
            $history->diff ? $historiesWithDiff[] = $history : $historiesWithoutDiff[] = $history;
        }
        $histories = array_merge($historiesWithoutDiff, $historiesWithDiff);

        foreach($histories as $history)
        {
            $history->fieldLabel = str_pad($history->fieldLabel, $maxLength, $this->lang->action->label->space);
            if($history->diff != '')
            {
                $history->diff      = str_replace(array('<ins>', '</ins>', '<del>', '</del>'), array('[ins]', '[/ins]', '[del]', '[/del]'), $history->diff);
                $history->diff      = ($history->field != 'subversion' and $history->field != 'git') ? htmlspecialchars($history->diff) : $history->diff;   // Keep the diff link.
                $history->diff      = str_replace(array('[ins]', '[/ins]', '[del]', '[/del]'), array('<ins>', '</ins>', '<del>', '</del>'), $history->diff);
                $history->diff      = nl2br($history->diff);
                $history->noTagDiff = preg_replace('/&lt;\/?([a-z][a-z0-9]*)[^\/]*\/?&gt;/Ui', '', $history->diff);
                printf($this->lang->action->desc->diff2, $history->fieldLabel, $history->noTagDiff, $history->diff);
            }
            else
            {
                printf($this->lang->action->desc->diff1, $history->fieldLabel, $history->old, $history->new);
            }
        }
    }

    /**
     * Undelete a record.
     * 
     * @param  int      $actionID 
     * @access public
     * @return void
     */
    public function undelete($actionID)
    {
        $action = $this->loadModel('action')->getById($actionID);
        if($action->action != 'deleted') return;

        /* Update deleted field in object table. */
        $table = $this->config->objectTables[$action->objectType];
        $this->dao->update($table)->set('deleted')->eq(0)->where('id')->eq($action->objectID)->exec();

        /* Update action record in action table. */
        $this->dao->update(TABLE_ACTION)->set('extra')->eq(ACTIONMODEL::BE_UNDELETED)->where('id')->eq($actionID)->exec();
        $this->action->create($action->objectType, $action->objectID, 'undeleted');
    }

    /**
     * Update comment of a action.
     * 
     * @param  int    $actionID 
     * @access public
     * @return void
     */
    public function updateComment($actionID)
    {
        $this->dao->update(TABLE_ACTION)
            ->set('date')->eq(helper::now())
            ->set('comment')->eq($this->post->lastComment)
            ->where('id')->eq($actionID)
            ->exec();
    }
}
