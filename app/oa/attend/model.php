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
        return $this->dao->select('*')->from(TABLE_ATTENDANCE)->where('ID')->eq($attendID)->fetch();
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
        $this->updateStatus();

        $attends = $this->dao->select('*')->from(TABLE_ATTENDANCE)
            ->where('account')->eq($account)
            ->beginIf($startDate != '')->andWhere('`date`')->ge($startDate)->fi()
            ->beginIf($endDate != '')->andWhere('`date`')->lt($endDate)->fi()
            ->orderBy('`date`')
            ->fetchAll('date');
        return $this->processAttendlist($attends);
    }

    /**
     * Get department's attend list. 
     * 
     * @param  string $deptID
     * @param  string $startDate 
     * @param  string $endDate 
     * @param  string $groupBy 
     * @access public
     * @return array
     */
    public function getByDept($deptID, $startDate = '', $endDate = '', $groupBy = '')
    {
        $this->updateStatus();
        $users = $this->loadModel('user')->getPairs('noclosed,noempty', $deptID);

        $attends = $this->dao->select('*')->from(TABLE_ATTENDANCE)
            ->where('account')->in(array_keys($users))
            ->beginIf($startDate != '')->andWhere('`date`')->ge($startDate)->fi()
            ->beginIf($endDate != '')->andWhere('`date`')->lt($endDate)->fi()
            ->orderBy('`date`')
            ->fetchAll();

        if($groupBy != '')
        {
            $newAttends = array();
            foreach($attends as $key => $attend)
            {
                $newAttends[$attend->$groupBy][$attend->date] = $attend; 
            }
            return $newAttends;
        }

        return $this->processAttendlist($attends);
    }

    /**
     * Process attend. 
     * 
     * @param  object $attend 
     * @access public
     * @return object
     */
    public function processAttend($attend)
    {
        /* get status and remove signout for today. */
        if($attend->date == helper::today()) 
        {
            if(time() < strtotime("{$attend->date} {$this->config->attend->earliestSignOutTime}")) $attend->signOut = '0000-00-00 00:00:00';
            $status = $this->computeStatus($attend);
            if($status == 'early') $attend->status = 'normal';
            if($status == 'lateEarly') $attend->status = 'late';
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
     * Get date pairs. 
     * 
     * @access public
     * @return array
     */
    public function getAllDate()
    {
        return $this->dao->select('date')->from(TABLE_ATTENDANCE)->groupBy('date')->orderBy('date_asc')->fetchAll('date');
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
        if($date == '')    $date    = date('y-m-d');

        $attend = $this->dao->select('*')->from(TABLE_ATTENDANCE)->where('account')->eq($account)->andWhere('`date`')->eq($date)->fetch();
        if(empty($attend))
        {
            $attend = new stdclass();
            $attend->account = $account;
            $attend->date    = $date;
            $attend->signIn  = helper::now();
            $this->dao->insert(TABLE_ATTENDANCE)
                ->data($attend)
                ->autoCheck()
                ->exec();
            return !dao::isError();
        }

        if($attend->signIn == '')
        {
            $this->dao->update(TABLE_ATTENDANCE)
                ->set('signIn')->eq(helper::now)
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
        if($date == '')    $date    = date('y-m-d');

        $attend = $this->dao->select('*')->from(TABLE_ATTENDANCE)->where('account')->eq($account)->andWhere('`date`')->eq($date)->fetch();
        if(empty($attend))
        {
            $attend = new stdclass();
            $attend->account = $account;
            $attend->date    = $date;
            $attend->signOut = helper::now();
            $this->dao->insert(TABLE_ATTENDANCE)
                ->data($attend)
                ->autoCheck()
                ->exec();
            return !dao::isError();
        }

        $this->dao->update(TABLE_ATTENDANCE)
            ->set('signOut')->eq(helper::now())
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
    public function updateStatus()
    {
        $attends = $this->dao->select('*')->from(TABLE_ATTENDANCE)
            ->where('status')->eq('unknown')
            ->andWhere('date')->lt(helper::today())
            ->fetchAll('id');

        foreach($attends as $attend)
        {
            $status = $this->computeStatus($attend);
            $this->dao->update(TABLE_ATTENDANCE)->set('status')->eq($status)->where('id')->eq($attend->id)->exec();
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
        /* holiday */
        $dayIndex = date('w', strtotime($attend->date));
        if($dayIndex >= $this->config->attend->workingDaysPerWeek) return 'holiday';

        /* travel, off */

        /* absenteeism */
        if($attend->signIn == "0000-00-00 00:00:00" and $attend->signOut == "0000-00-00 00:00:00") return 'absenteeism';

        /* late, early, lateEarly */
        $status = 'unknown';
        if(strtotime($attend->signIn) > strtotime("{$attend->date} {$this->config->attend->latestSignInTime}")) $status = 'late';
        if($this->config->attend->forcedSignOut == 'yes')
        {
            if(strtotime($attend->signOut) <  strtotime("{$attend->date} {$this->config->attend->earliestSignOutTime}"))
            {
                $status = $status == 'late' ? 'lateEarly' : 'early';
            }
        }
        if($status != 'unknown') return $status;

        /* normal */
        return 'normal';
    }
}

