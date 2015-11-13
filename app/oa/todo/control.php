<?php
/**
 * The control file of todo module of RanZhi.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv12.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     todo
 * @version     $Id: control.php 4976 2013-07-02 08:15:31Z wyd621@gmail.com $
 * @link        http://www.ranzhico.com
 */
class todo extends control
{
    /**
     * Construct function, load model of date.
     * 
     * @access public
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->app->loadClass('date');
        $this->loadModel('task');
        $this->loadModel('order', 'crm');
        $this->loadModel('customer', 'crm');
    }

    /**
     * calendar view.
     * 
     * @param  string $date 
     * @access public
     * @return void
     */
    public function calendar($date = '')
    {
        if($date == '' or $date == 'future') $date = date('Ymd');
        $account = $this->app->user->account;
        $todoList['custom']   = $this->todo->getList('future', $account);
        $todoList['task']     = array();
        $todoList['order']    = array();
        $todoList['customer'] = array();

        $this->view->title    = $this->lang->todo->calendar;
        $this->view->date     = $date;
        $this->view->data     = $this->todo->getCalendarData($date);
        $this->view->todoList = $todoList;
        $this->display();
    }

    /**
     * Create a todo.
     * 
     * @param  string|date $date 
     * @param  string      $account 
     * @access public
     * @return void
     */
    public function create($date = 'today', $account = '')
    {
        if($date == 'today') $date = date::today();
        if($account == '')   $account = $this->app->user->account;
        if(!empty($_POST))
        {
            $todoID = $this->todo->create($date, $account);
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));
            $this->loadModel('action')->create('todo', $todoID, 'opened');
            $date = str_replace('-', '', $this->post->date);
            if($date == '')
            {
                $date = 'future'; 
            }
            else if($date == date('Ymd'))
            {
                $date = 'today'; 
            }
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => $this->createLink('todo', 'calendar', "date=$date")));
        }

        $this->view->title      = $this->lang->todo->common . $this->lang->colon . $this->lang->todo->create;
        $this->view->date       = strftime("%Y-%m-%d", strtotime($date));
        $this->view->times      = date::buildTimeList($this->config->todo->times->begin, $this->config->todo->times->end, $this->config->todo->times->delta);
        $this->view->time       = date::now();
        $this->display();      
    }

    /**
     * Batch create todo
     * 
     * @param  string $date 
     * @access public
     * @return void
     */
    public function batchCreate($date = 'today')
    {
        if($date == 'today') $date = date(DT_DATE1, time());
        if(!empty($_POST))
        {
            $this->todo->batchCreate();
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));

            /* Locate the browser. */
            $date = str_replace('-', '', $this->post->date);
            if($date == '')
            {
                $date = 'future'; 
            }
            else if($date == date('Ymd'))
            {
                $date= 'today'; 
            }
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => $this->createLink('todo', 'calendar', "date=$date")));
        }

        $this->view->title = $this->lang->todo->common . $this->lang->colon . $this->lang->todo->batchCreate;
        $this->view->date  = (int)$date == 0 ? $date : date('Y-m-d', strtotime($date));
        $this->view->times = date::buildTimeList($this->config->todo->times->begin, $this->config->todo->times->end, $this->config->todo->times->delta);
        $this->view->time  = date::now();
        $this->view->users = $this->loadModel('user')->getPairs('noclosed,nodeleted');

        $this->display();
    }

    /**
     * Edit a todo.
     * 
     * @param  int    $todoID 
     * @access public
     * @return void
     */
    public function edit($todoID)
    {
        /* Judge a private todo or not, If private, die. */
        $todo = $this->todo->getById($todoID);
        $this->checkPriv($todo, 'edit');

        if(!empty($_POST))
        {
            $changes = $this->todo->update($todoID);
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));
            if($changes)
            {
                $actionID = $this->loadModel('action')->create('todo', $todoID, 'edited');
                $this->action->logHistory($actionID, $changes);
            }
            $date = str_replace('-', '', $this->post->date);
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => $this->createLink('todo', 'calendar', "date=$date")));
        }
       
        if($todo->date != '00000000') $todo->date = strftime("%Y-%m-%d", strtotime($todo->date));
        $this->view->title      = $this->lang->todo->edit;
        $this->view->position[] = $this->lang->todo->common;
        $this->view->position[] = $this->lang->todo->edit;
        $this->view->times      = date::buildTimeList($this->config->todo->times->begin, $this->config->todo->times->end, $this->config->todo->times->delta);
        $this->view->todo       = $todo;
        $this->display();
    }

    /**
     * View a todo. 
     * 
     * @param  int    $todoID 
     * @param  string $from     my|company
     * @access public
     * @return void
     */
    public function view($todoID, $from = 'company')
    {
        $todo = $this->todo->getById($todoID, true);
        $this->checkPriv($todo, 'view');
        if(!$todo) $this->locate($this->createLink('todo', 'calendar'));

        /* Save session for back to this app. */
        if($todo->type == 'task')     $this->session->set('taskList', $this->createLink('todo', 'calendar', "date=" . str_replace('-', '', $todo->date)));
        if($todo->type == 'order')    $this->session->set('orderList', "javascript:$.openEntry(\"oa\")");
        if($todo->type == 'customer') $this->session->set('customerList', "javascript:$.openEntry(\"oa\")");

        $this->view->title      = "{$this->lang->todo->common} #$todo->id $todo->name";
        $this->view->todo       = $todo;
        $this->view->times      = date::buildTimeList($this->config->todo->times->begin, $this->config->todo->times->end, $this->config->todo->times->delta);
        $this->view->users      = $this->loadModel('user')->getPairs('noletter');
        $this->view->actions    = $this->loadModel('action')->getList('todo', $todoID);
        $this->view->from       = $from;

        $this->display();
    }

    /**
     * Delete a todo.
     * 
     * @param  int    $todoID 
     * @access public
     * @return void
     */
    public function delete($todoID)
    {
        $todo = $this->todo->getByID($todoID);
        $this->checkPriv($todo, 'delete', 'json');
        $date = str_replace('-', '', $todo->date);
        if($date == '00000000') $date = '';

        $this->dao->delete()->from(TABLE_TODO)->where('id')->eq($todoID)->exec();
        $this->loadModel('action')->create('todo', $todoID, 'erased');
        if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));
        $this->send(array('result' => 'success', 'locate' => $this->createLink('oa.todo', 'calendar', "date=$date")));
    }

    /**
     * Close a todo.
     * 
     * @param  int    $todoID 
     * @access public
     * @return void
     */
    public function close($todoID)
    {
        $todo = $this->todo->getById($todoID);
        $this->checkPriv($todo, 'close', 'json');

        if($todo->status == 'done') $this->todo->close($todoID);
        $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => $this->createLink('todo', 'calendar', "date=$todo->date")));
    }

    /**
     * Activate a todo.
     * 
     * @param  int    $todoID 
     * @access public
     * @return void
     */
    public function activate($todoID)
    {
        $todo = $this->todo->getById($todoID);
        $this->checkPriv($todo, 'activate', 'json');

        if($todo->status == 'closed') $this->todo->activate($todoID);
        $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => $this->createLink('todo', 'calendar', "date=$todo->date")));
    }

    /**
     * Finish a todo.
     * 
     * @param  int    $todoID 
     * @access public
     * @return void
     */
    public function finish($todoID)
    {
        $todo = $this->todo->getById($todoID);
        $this->checkPriv($todo, 'finish', 'json');
        if(strpos('done,closed', $todo->status) === false) $this->todo->finish($todoID);

        if($todo->type == 'task') 
        {
            $task = $this->loadModel('task')->getById($todo->idvalue);
            $_POST['consumed'] = $task->left == 0 ? 1 : $task->left;
            $changes = $this->loadModel('task')->finish($todo->idvalue);
            if(!empty($changes))
            {
                $actionID = $this->loadModel('action')->create('task', $todo->idvalue, 'Finished');
                $this->action->logHistory($actionID, $changes);
            }
        }
        if($todo->type == 'order' or $todo->type == 'customer')
        {
            $entry = 'crm';
            $confirmNote = sprintf($this->lang->todo->confirmTip, $this->lang->{$todo->type}->common, $todo->id);
            $confirmURL  = $this->createLink("{$entry}.{$todo->type}", 'view', "id=$todo->idvalue", 'html');
            $this->send(array('result' => 'success', 'confirm' => array('note' => $confirmNote, 'url' => $confirmURL, 'entry' => $entry)));
        }
        $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => $this->createLink('todo', 'calendar', "date=$todo->date")));
    }

    /**
     * Assign one todo to someone. 
     * 
     * @param  int    $todoID 
     * @access public
     * @return void
     */
    public function assignTo($todoID)
    {
        $todo = $this->todo->getById($todoID);
        $this->checkPriv($todo, 'assignTo');

        if($_POST)
        {
            $changes = $this->todo->assignTo($todoID);
            if(!empty($changes))
            {
                $actionID = $this->loadModel('action')->create('todo', $todo->id, 'Assigned', '', $this->post->assignedTo);
                $this->action->logHistory($actionID, $changes);
            }
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'closeModal' => 'true', 'locate' => 'reload'));
        }

        if($todo->date != '00000000') $todo->date = strftime("%Y-%m-%d", strtotime($todo->date));
        $this->view->title = $this->lang->todo->assignTo;
        $this->view->todo  = $todo;
        $this->view->users = $this->loadModel('user')->getPairs('nodeleted,noclosed');
        $this->view->times = date::buildTimeList($this->config->todo->times->begin, $this->config->todo->times->end, $this->config->todo->times->delta);
        $this->display();
    }

    /**
     * Check privilage. 
     * 
     * @param  obejct $todo 
     * @param  string $action 
     * @param  string $errorType   html|json
     * @access public
     * @return bool
     */
    public function checkPriv($todo, $action, $errorType = '')
    {
        if(!$this->todo->checkPriv($todo, $action))
        {
            if($errorType == '') $errorType = empty($_POST) ? 'html' : 'json';
            if($errorType == 'json')
            {
                $this->app->loadLang('error');
                $this->send(array('result' => 'fail', 'message' => $this->lang->error->typeList['accessLimited']));
            }
            else
            {
                $locate = helper::safe64Encode($this->server->http_referer);
                $errorLink = helper::createLink('error', 'index', "type=accessLimited&locate={$locate}");
                $this->locate($errorLink);
            }
        }
        return true;
    }

    /**
     * AJAX: get actions of a todo. for web app.
     * 
     * @param  int    $todoID 
     * @access public
     * @return void
     */
    public function ajaxGetDetail($todoID)
    {
        $this->view->actions = $this->loadModel('action')->getList('todo', $todoID);
        $this->display();
    }
}
