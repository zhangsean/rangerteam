<?php
/**
 * The control file of attend of Ranzhi.
 *
 * @copyright   Copyright 2009-2015 QingDao Nature Easy Soft Network Technology Co,LTD (www.cnezsoft.com)
 * @license     ZPL 
 * @author      chujilu <chujilu@cnezsoft.com>
 * @package     attend
 * @version     $Id$
 * @link        http://www.ranzhico.com
 */
class attend extends control
{
    /**
     * personal 
     * 
     * @param  string $date 
     * @access public
     * @return void
     */
    public function personal($date = '')
    {
        if($date == '' or strlen($date) != 6) $date = date('Ym');
        $currentYear  = substr($date, 0, 4);
        $currentMonth = substr($date, 4, 2);
        $startDate    = "{$currentYear}-{$currentMonth}-01";
        $endDate      = date('Y-m-d', strtotime("$startDate +1 month"));
        $dayNum       = (int)date('d', strtotime("$endDate -1 day"));
        $weekNum      = (int)ceil($dayNum / 7);

        $attends   = $this->attend->getByAccount($this->app->user->account, $startDate, $endDate);
        $monthList = $this->attend->getAllMonth();
        $yearList  = array_reverse(array_keys($monthList));

        $this->view->title        = $this->lang->attend->personal;
        $this->view->attends      = $attends;
        $this->view->dayNum       = $dayNum;
        $this->view->weekNum      = $weekNum;
        $this->view->currentYear  = $currentYear;
        $this->view->currentMonth = $currentMonth;
        $this->view->yearList     = $yearList;
        $this->view->monthList    = $monthList;
        $this->display();
    }

    /**
     * department's attend. 
     * 
     * @param  string $date 
     * @param  bool   $company 
     * @access public
     * @return void
     */
    public function department($date = '', $company = false)
    {
        if($date == '' or strlen($date) != 6) $date = date('Ym');
        $currentYear  = substr($date, 0, 4);
        $currentMonth = substr($date, 4, 2);
        $startDate    = "{$currentYear}-{$currentMonth}-01";
        $endDate      = date('Y-m-d', strtotime("$startDate +1 month"));

        $dayNum    = (int)date('d', strtotime("$endDate -1 day"));
        $weekNum   = (int)ceil($dayNum / 7);
        $monthList = $this->attend->getAllMonth();
        $yearList  = array_reverse(array_keys($monthList));

        /* Get deptList. */
        if($company) 
        {
            $deptList = $this->loadModel('tree')->getPairs('', 'dept');
            $deptList[0] = '/';
        }
        else
        {
            $deptList = $this->loadModel('tree')->getDeptManagedByMe($this->app->user->account);
            foreach($deptList as $key => $value) $deptList[$key] = $value->name;
        }

        /* Get attend. */
        $attends = array();
        if(!empty($deptList)) 
        {
            $dept = array_keys($deptList);
            $attends = $this->attend->getByDept($dept, $startDate, $endDate);
        }

        $users    = $this->loadModel('user')->getList();
        $newUsers = array();
        foreach($users as $key => $user) $newUsers[$user->account] = $user;

        $this->view->title        = $this->lang->attend->department;
        $this->view->attends      = $attends;
        $this->view->dayNum       = $dayNum;
        $this->view->weekNum      = $weekNum;
        $this->view->currentYear  = $currentYear;
        $this->view->currentMonth = $currentMonth;
        $this->view->yearList     = $yearList;
        $this->view->monthList    = $monthList;
        $this->view->deptList     = $deptList;
        $this->view->users        = $newUsers;
        $this->view->company      = $company;
        $this->display();
    }

    /**
     * Export attend data.
     * 
     * @param  string $date 
     * @param  bool   $company 
     * @access public
     * @return void
     */
    public function export($date = '', $company = false)
    {
        if($_POST)
        {
            if($date == '' or strlen($date) != 6) $date = date('Ym');
            $currentYear  = substr($date, 0, 4);
            $currentMonth = substr($date, 4, 2);
            $startDate    = "{$currentYear}-{$currentMonth}-01";
            $endDate      = date('Y-m-d', strtotime("$startDate +1 month"));
            $dayNum       = (int)date('d', strtotime("$endDate -1 day"));

            /* Get deptList. */
            if($company) 
            {
                $deptList = $this->loadModel('tree')->getPairs('', 'dept');
                $deptList[0] = '/';
            }
            else
            {
                $deptList = $this->loadModel('tree')->getDeptManagedByMe($this->app->user->account);
                foreach($deptList as $key => $value) $deptList[$key] = $value->name;
            }

            /* Get attend. */
            $attends = array();
            if(!empty($deptList)) 
            {
                $dept = array_keys($deptList);
                $attends = $this->attend->getByDept($dept, $startDate, $endDate);
            }

            $users    = $this->loadModel('user')->getList();
            $tmpUsers = array();
            foreach($users as $key => $user) $tmpUsers[$user->account] = $user;
            $users = $tmpUsers;

            /* Get fields. */
            $this->app->loadLang('user');
            $fields['id']       = $this->lang->attend->id;
            $fields['dept']     = $this->lang->user->dept;
            $fields['realname'] = $this->lang->user->realname;
            for($i = 1; $i <= $dayNum; $i++)
            {
                $currentDate  = date("Y-m-d", strtotime("$currentYear-$currentMonth-$i"));
                $dayNameIndex = date('w', strtotime($currentDate));
                $fields[$currentDate] = "$currentDate({$this->lang->datepicker->dayNames[$dayNameIndex]})";
            }

            /* Get row data. */
            $datas = array();
            foreach($attends as $account => $attendList)
            {
                $data = new stdclass();
                $data->id       = $users[$account]->id;
                $data->dept     = $deptList[$users[$account]->dept];
                $data->realname = $users[$account]->realname;
                for($i = 1; $i <= $dayNum; $i++)
                {
                    $currentDate  = date("Y-m-d", strtotime("$currentYear-$currentMonth-$i"));
                    $data->$currentDate = isset($attendList[$currentDate]) ? $this->lang->attend->abbrStatusList[$attendList[$currentDate]->status] : '';
                }
                $datas[] = $data;
            }

            $this->post->set('fields', $fields);
            $this->post->set('rows', $datas);
            $this->post->set('kind', 'attendance');
            $this->fetch('file', 'export2CSV', $_POST);
        }
        $this->display();
    }

    /**
     * Sign in. 
     * 
     * @access public
     * @return void
     */
    public function signIn()
    {
        $result = $this->attend->signIn();
        if(!$result) $this->send(array('result' => 'fail', 'message' => $this->lang->attend->inFail));
        $this->send(array('result' => 'success', 'message' => $this->lang->attend->inSuccess));
    }

    /**
     * Sign out. 
     * 
     * @access public
     * @return void
     */
    public function signOut()
    {
        $result  = $this->attend->signOut();
        if(!$result) $this->send(array('result' => 'fail', 'message' => $this->lang->attend->outFail));
        $this->send(array('result' => 'success', 'message' => $this->lang->attend->outSuccess));
    }

    /**
     * settings 
     * 
     * @access public
     * @return void
     */
    public function settings()
    {
        if($_POST)
        {
            $settings = fixer::input('post')->get();
            $settings->signInLimit  = date("H:i", strtotime($settings->signInLimit));
            $settings->signOutLimit = date("H:i", strtotime($settings->signOutLimit));
            $this->loadModel('setting')->setItems('system.oa.attend', $settings);
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => 'reload'));
        }

        $this->view->title        = $this->lang->attend->settings; 
        $this->view->signInLimit  = $this->config->attend->signInLimit;
        $this->view->signOutLimit = $this->config->attend->signOutLimit;
        $this->view->workingDays  = $this->config->attend->workingDays;
        $this->view->mustSignOut  = $this->config->attend->mustSignOut;
        $this->display();
    }

    /**
     * add manual sign in and sign out data. 
     * 
     * @param  string $date 
     * @access public
     * @return void
     */
    public function edit($date)
    {
        $account = $this->app->user->account;
        $attend  = $this->attend->getByDate($date, $account);

        if($_POST)
        {
            $this->attend->update($date, $account);
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => 'reload'));
        }

        $this->view->title  = $this->lang->attend->manual;
        $this->view->attend = $attend;
        $this->display();
    }

    /**
     * browse review list.
     * 
     * @param  int    $dept 
     * @param  string $reviewStatus 
     * @access public
     * @return void
     */
    public function review($dept = '', $reviewStatus = 'wait')
    {
        $attends  = array();
        $deptList = $this->loadModel('tree')->getDeptManagedByMe($this->app->user->account);
        if(!empty($deptList)) 
        {
            if($dept == '' or !isset($deptList[$dept])) $dept = current($deptList)->id;
            $attends = $this->attend->getByDept($dept, $startDate = '', $endDate = '', $reviewStatus);
        }

        $users    = $this->loadModel('user')->getList($dept);
        $newUsers = array();
        foreach($users as $key => $user) $newUsers[$user->account] = $user;

        $this->view->title        = $this->lang->attend->review;
        $this->view->attends      = $attends;
        $this->view->currentDept  = $dept;
        $this->view->reviewStatus = $reviewStatus;
        $this->view->deptList     = $deptList;
        $this->view->users        = $newUsers;
        $this->display();
    }

    /**
     * Pass manual sign data. 
     * 
     * @param  int    $attendID 
     * @access public
     * @return void
     */
    public function pass($attendID)
    {
        $result = $this->attend->pass($attendID);
        if(!$result) $this->send(array('result' => 'fail', 'message' => dao::getError()));
        $this->send(array('result' => 'fail', 'message' => $this->lang->saveSuccess, 'locate' => $this->createLink('attend', 'review')));
    }

    /**
     * Reject manual sign data. 
     * 
     * @param  int    $attendID 
     * @access public
     * @return void
     */
    public function reject($attendID)
    {
        $result = $this->attend->reject($attendID);
        if(!$result) $this->send(array('result' => 'fail', 'message' => dao::getError()));
        $this->send(array('result' => 'fail', 'message' => $this->lang->saveSuccess, 'locate' => $this->createLink('attend', 'review')));
    }
}
