<?php
/**
 * The control file of attendance of Ranzhi.
 *
 * @copyright   Copyright 2009-2015 QingDao Nature Easy Soft Network Technology Co,LTD (www.cnezsoft.com)
 * @license     ZPL 
 * @author      chujilu <chujilu@cnezsoft.com>
 * @package     attendance
 * @version     $Id$
 * @link        http://www.ranzhico.com
 */
class attendance extends control
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

        $dayNum      = (int)date('d', strtotime("$endDate -1 day"));
        $weekNum     = (int)ceil($dayNum / 7);
        $account     = $this->app->user->account;
        $attendances = $this->attendance->getByAccount($account, $startDate, $endDate);

        $yearList  = array();
        $monthList = array();
        $dateList  = $this->attendance->getAllDate();
        foreach($dateList as $date)
        {
            $year  = substr($date->date, 0, 4);
            $month = substr($date->date, 5, 2);
            if(!isset($yearList[$year])) $yearList[$year] = $year;
            if(!isset($monthList[$year][$month])) $monthList[$year][$month] = $month;
        }

        $this->view->attendances  = $attendances;
        $this->view->dayNum       = $dayNum;
        $this->view->weekNum      = $weekNum;
        $this->view->currentYear  = $currentYear;
        $this->view->currentMonth = $currentMonth;
        $this->view->yearList     = $yearList;
        $this->view->monthList    = $monthList;
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
        $date    = date('y-m-d');
        $result  = $this->attendance->signIn($account, $date);
        if(!$result) $this->send(array('result' => 'fail', 'message' => $this->lang->attendance->signInFail));
        $this->send(array('result' => 'success', 'message' => $this->lang->attendance->signInSuccess));
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
        $date    = date('y-m-d');
        $result  = $this->attendance->signOut($account, $date);
        if(!$result) $this->send(array('result' => 'fail', 'message' => $this->lang->attendance->signOutFail));
        $this->send(array('result' => 'success', 'message' => $this->lang->attendance->signOutSuccess));
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
            $this->loadModel('setting')->setItems('system.oa.attendance', $settings);
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess));
        }
        $this->view->latestSignInTime    = $this->config->attendance->latestSignInTime;
        $this->view->earliestSignOutTime = $this->config->attendance->earliestSignOutTime;
        $this->view->workingDaysPerWeek  = $this->config->attendance->workingDaysPerWeek;
        $this->view->forcedSignOut       = $this->config->attendance->forcedSignOut;
        $this->display();
    }
}

