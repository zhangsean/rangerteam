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

        $dayNum  = (int)date('d', strtotime("$endDate -1 day"));
        $weekNum = (int)ceil($dayNum / 7);
        $account = $this->app->user->account;
        $attends = $this->attend->getByAccount($account, $startDate, $endDate);

        $yearList  = array();
        $monthList = array();
        $dateList  = $this->attend->getAllDate();
        foreach($dateList as $date)
        {
            $year  = substr($date->date, 0, 4);
            $month = substr($date->date, 5, 2);
            if(!isset($yearList[$year])) $yearList[$year] = $year;
            if(!isset($monthList[$year][$month])) $monthList[$year][$month] = $month;
        }

        $this->view->attends  = $attends;
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
     * @access public
     * @return void
     */
    public function department($date = '', $dept = '')
    {
        if($date == '' or strlen($date) != 6) $date = date('Ym');
        $currentYear  = substr($date, 0, 4);
        $currentMonth = substr($date, 4, 2);
        $startDate    = "{$currentYear}-{$currentMonth}-01";
        $endDate      = date('Y-m-d', strtotime("$startDate +1 month"));

        $deptList = $this->loadModel('tree')->getDeptByAccount($this->app->user->account);
        if(empty($deptList)) 
        {
            $this->display();
        }
        if($dept == '' or !isset($deptList[$dept])) $dept = current($deptList)->id;

        $dayNum      = (int)date('d', strtotime("$endDate -1 day"));
        $weekNum     = (int)ceil($dayNum / 7);
        $account     = $this->app->user->account;
        $attends = $this->attend->getByDept($dept, $startDate, $endDate, 'account');

        $yearList  = array();
        $monthList = array();
        $dateList  = $this->attend->getAllDate();
        foreach($dateList as $date)
        {
            $year  = substr($date->date, 0, 4);
            $month = substr($date->date, 5, 2);
            if(!isset($yearList[$year])) $yearList[$year] = $year;
            if(!isset($monthList[$year][$month])) $monthList[$year][$month] = $month;
        }

        $newUsers = array();
        $users    = $this->loadMOdel('user')->getList($dept);
        foreach($users as $key => $user) $newUsers[$user->account] = $user;

        $this->view->attends  = $attends;
        $this->view->dayNum       = $dayNum;
        $this->view->weekNum      = $weekNum;
        $this->view->currentYear  = $currentYear;
        $this->view->currentMonth = $currentMonth;
        $this->view->currentDept  = $dept;
        $this->view->yearList     = $yearList;
        $this->view->monthList    = $monthList;
        $this->view->deptList     = $deptList;
        $this->view->users        = $newUsers;
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
        $account = $this->app->user->account;
        $date    = date('Y-m-d');
        $result  = $this->attend->signIn($account, $date);
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
        $account = $this->app->user->account;
        $date    = date('Y-m-d');
        $result  = $this->attend->signOut($account, $date);
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
            $this->loadModel('setting')->setItems('system.oa.attend', $settings);
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess));
        }
        $this->view->signInLimit    = $this->config->attend->signInLimit;
        $this->view->signOutLimit = $this->config->attend->signOutLimit;
        $this->view->workingDays  = $this->config->attend->workingDays;
        $this->view->mustSignOut       = $this->config->attend->mustSignOut;
        $this->display();
    }
}
