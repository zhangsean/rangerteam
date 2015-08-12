<?php
/**
 * The model file of attend module of Ranzhi.
 *
 * @copyright   Copyright 2009-2015 QingDao Nature Easy Soft Network Technology Co,LTD (www.cnezsoft.com)
 * @license     ZPL
 * @author      chujilu <chujilu@cnezsoft.com>
 * @package     attend
 * @version     $Id$
 * @link        http://www.ranzhico.com
 */
class attendModel extends model
{
    /**
     * Get by attend id. 
     * 
     * @param  int    $attendID 
     * @access public
     * @return object
     */
    public function getByID($attendID)
    {
        return $this->dao->select('*')->from(TABLE_ATTEND)->where('ID')->eq($attendID)->fetch();
    }

    /**
     * Get by account. 
     * 
     * @param  string $account 
     * @param  string $startDate 
     * @param  string $endDate 
     * @access public
     * @return array
     */
    public function getByAccount($account, $startDate = '', $endDate = '')
    {
        $this->processStatus();
        $attends = $this->dao->select('*')->from(TABLE_ATTEND)
            ->where('account')->eq($account)
            ->beginIf($startDate != '')->andWhere('`date`')->ge($startDate)->fi()
            ->beginIf($endDate != '')->andWhere('`date`')->lt($endDate)->fi()
            ->orderBy('`date`')
            ->fetchAll('date');

        return $this->processAttendList($attends);
    }

    /**
     * Get department's attend list. 
     * 
     * @param  string $deptID
     * @param  string $startDate 
     * @param  string $endDate 
     * @access public
     * @return array
     */
    public function getByDept($deptID, $startDate = '', $endDate = '')
    {
        $this->processStatus();
        $users = $this->loadModel('user')->getPairs('noclosed,noempty', $deptID);

        $attends = $this->dao->select('*')->from(TABLE_ATTEND)
            ->where('account')->in(array_keys($users))
            ->beginIf($startDate != '')->andWhere('`date`')->ge($startDate)->fi()
            ->beginIf($endDate != '')->andWhere('`date`')->lt($endDate)->fi()
            ->orderBy('`date`')
            ->fetchAll();
        $attends = $this->processAttendList($attends);

        $newAttends = array();
        foreach($attends as $key => $attend) $newAttends[$attend->account][$attend->date] = $attend; 

        foreach($newAttends as $userAttends) $userAttends = $this->fixUserAttendList($userAttends);
        return $newAttends;
    }

    /**
     * Process attend, add dayName, comput today's status.
     * 
     * @param  object $attend 
     * @access public
     * @return object
     */
    public function processAttend($attend)
    {
        /* Compute status and remove signOut if date is today. */
        if($attend->date == helper::today()) 
        {
            if(time() < strtotime("{$attend->date} {$this->config->attend->signOutLimit}")) $attend->signOut = '00:00:00';
            $status = $this->computeStatus($attend);
            if($status == 'early') $attend->status = 'normal';
            if($status == 'both')  $attend->status = 'late';
        }

        $dayIndex = date('w', strtotime($attend->date));
        $attend->dayName = $this->lang->datepicker->dayNames[$dayIndex];
        return $attend;
    }

    /**
     * Process attend list. 
     * 
     * @param  array $attends 
     * @access public
     * @return array
     */
    public function processAttendList($attends)
    {
        foreach($attends as $attend) $attend = $this->processAttend($attend);
        return $attends;
    }

    /**
     * Fix user's attendlist, add default data if no this date record. 
     * 
     * @param  array $attends 
     * @access public
     * @return void
     */
    public function fixUserAttendList($attends)
    {
        $startDate = '0000-00-00';
        $endDate   = '0000-00-00';
        $account   = '';
        /* Get account, start date and end date. */
        foreach($attends as $attend)
        {
            if(strtotime($attend->date) < strtotime($startDate) or $startDate == '0000-00-00') $startDate = $attend->date;
            if(strtotime($attend->date) > strtotime($endDate)) $endDate   = $attend->date;
            if($account == '') $account = $attend->account;
        }

        /* Add data if not set. */
        while(strtotime($startDate) < strtotime($endDate))
        {
            if(!isset($attends[$startDate]))
            {
                $attend = new stdclass();
                $attend->account = $account;
                $attend->date    = $startDate;
                $attend->signIn  = '00:00:00';
                $attend->signOut = '00:00:00';
                $attend->status  = '';
                $attend->ip      = '';
                $attend->device  = '';
                $attends[$startDate] = $attend;
            }
            $startDate = date("Y-m-d", strtotime("$startDate +1 day"));
        }

        return $attends;
    }

    /**
     * Get all month data.
     * return array[year][month]
     * 
     * @access public
     * @return array
     */
    public function getAllMonth()
    {
        $dateList = $this->dao->select('date')->from(TABLE_ATTEND)->groupBy('date')->orderBy('date_asc')->fetchAll();

        $monthList = array();
        foreach($dateList as $date)
        {
            $year  = substr($date->date, 0, 4);
            $month = substr($date->date, 5, 2);
            if(!isset($monthList[$year][$month])) $monthList[$year][$month] = $month;
        }
        return $monthList;
    }

    /**
     * sign in.
     * 
     * @param  string $account 
     * @param  string $date 
     * @access public
     * @return bool
     */
    public function signIn($account = '', $date = '')
    {
        if($account == '') $account = $this->app->user->account;
        if($date == '')    $date    = date('Y-m-d');

        $attend = $this->dao->select('*')->from(TABLE_ATTEND)->where('account')->eq($account)->andWhere('`date`')->eq($date)->fetch();
        if(empty($attend))
        {
            $attend = new stdclass();
            $attend->account = $account;
            $attend->date    = $date;
            $attend->signIn  = helper::time();
            $this->dao->insert(TABLE_ATTEND)
                ->data($attend)
                ->autoCheck()
                ->exec();
            return !dao::isError();
        }

        if($attend->signIn == '')
        {
            $this->dao->update(TABLE_ATTEND)
                ->set('signIn')->eq(helper::time())
                ->where('id')->eq($attend->id)
                ->exec();
            return !dao::isError();
        }

        return true;
    }

    /**
     * sign out.
     * 
     * @param  string $account 
     * @param  string $date 
     * @access public
     * @return bool
     */
    public function signOut($account = '', $date = '')
    {
        if($account == '') $account = $this->app->user->account;
        if($date == '')    $date    = date('Y-m-d');

        $attend = $this->dao->select('*')->from(TABLE_ATTEND)->where('account')->eq($account)->andWhere('`date`')->eq($date)->fetch();
        if(empty($attend))
        {
            $attend = new stdclass();
            $attend->account = $account;
            $attend->date    = $date;
            $attend->signOut = helper::time();
            $this->dao->insert(TABLE_ATTEND)
                ->data($attend)
                ->autoCheck()
                ->exec();
            return !dao::isError();
        }

        $this->dao->update(TABLE_ATTEND)
            ->set('signOut')->eq(helper::time())
            ->where('id')->eq($attend->id)
            ->exec();
        return !dao::isError();
    }

    /**
     * Update status of unknow attend.
     * 
     * @access public
     * @return bool
     */
    public function processStatus()
    {
        $attends = $this->dao->select('*')->from(TABLE_ATTEND)
            ->where('status')->eq('')
            ->andWhere('date')->lt(helper::today())
            ->fetchAll('id');

        foreach($attends as $attend)
        {
            $status = $this->computeStatus($attend);
            $this->dao->update(TABLE_ATTEND)->set('status')->eq($status)->where('id')->eq($attend->id)->exec();
        }
        return true;
    }

    /**
     * Compute attend's status. 
     * 
     * @param  object $attend 
     * @access public
     * @return string
     */
    public function computeStatus($attend)
    {
        /* 'rest', rest day. */
        $dayIndex = date('w', strtotime($attend->date));
        if($dayIndex >= $this->config->attend->workingDays) return 'rest';

        /* 'leave', ask for leave. 'trip', biz trip. */

        /* 'absent', absenteeism */
        if($attend->signIn == "00:00:00" and $attend->signOut == "00:00:00") return 'absent';

        /* normal, late, early, both */
        $status = 'normal';
        if(strtotime("{$attend->date} {$attend->signIn}") > strtotime("{$attend->date} {$this->config->attend->signInLimit}")) $status = 'late';
        if($this->config->attend->mustSignOut == 'yes')
        {
            if(strtotime("{$attend->date} {$attend->signOut}") <  strtotime("{$attend->date} {$this->config->attend->signOutLimit}"))
            {
                $status = $status == 'late' ? 'both' : 'early';
            }
        }
        return $status;
    }
}

