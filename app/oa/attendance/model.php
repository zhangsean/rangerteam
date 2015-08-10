<?php
/**
 * The model file of attendance module of Ranzhi.
 *
 * @copyright   Copyright 2009-2015 QingDao Nature Easy Soft Network Technology Co,LTD (www.cnezsoft.com)
 * @license     ZPL
 * @author      chujilu <chujilu@cnezsoft.com>
 * @package     attendance
 * @version     $Id$
 * @link        http://www.ranzhico.com
 */
class attendanceModel extends model
{
    /**
     * Get by attendance id. 
     * 
     * @param  int    $attendanceID 
     * @access public
     * @return object
     */
    public function getByID($attendanceID)
    {
        return $this->dao->select('*')->from(TABLE_ATTENDANCE)->where('ID')->eq($attendanceID)->fetch();
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

        $attendances = $this->dao->select('*')->from(TABLE_ATTENDANCE)
            ->where('account')->eq($account)
            ->beginIf($startDate != '')->andWhere('`date`')->ge($startDate)->fi()
            ->beginIf($endDate != '')->andWhere('`date`')->lt($endDate)->fi()
            ->orderBy('`date`')
            ->fetchAll('date');
        return $this->processAttendancelist($attendances);
    }

    /**
     * Process attendance. 
     * 
     * @param  object $attendance 
     * @access public
     * @return object
     */
    public function processAttendance($attendance)
    {
        /* get status and remove signout for today. */
        if($attendance->date == helper::today()) 
        {
            if(time() < strtotime("{$attendance->date} {$this->config->attendance->earliestSignOutTime}")) $attendance->signOut = '0000-00-00 00:00:00';
            $status = $this->computeStatus($attendance);
            if($status == 'early') $attendance->status = 'normal';
            if($status == 'lateEarly') $attendance->status = 'late';
        }

        $dayIndex = date('w', strtotime($attendance->date));
        $attendance->dayName = $this->lang->datepicker->dayNames[$dayIndex];
        return $attendance;
    }

    /**
     * Process attendance list. 
     * 
     * @param  array $attendances 
     * @access public
     * @return array
     */
    public function processAttendanceList($attendances)
    {
        foreach($attendances as $attendance) $attendance = $this->processAttendance($attendance);
        return $attendances;
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

        $attendance = $this->dao->select('*')->from(TABLE_ATTENDANCE)->where('account')->eq($account)->andWhere('`date`')->eq($date)->fetch();
        if(empty($attendance))
        {
            $attendance = new stdclass();
            $attendance->account = $account;
            $attendance->date    = $date;
            $attendance->signIn  = helper::now();
            $this->dao->insert(TABLE_ATTENDANCE)
                ->data($attendance)
                ->autoCheck()
                ->exec();
            return !dao::isError();
        }

        if($attendance->signIn == '')
        {
            $this->dao->update(TABLE_ATTENDANCE)
                ->set('signIn')->eq(helper::now)
                ->where('id')->eq($attendance->id)
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

        $attendance = $this->dao->select('*')->from(TABLE_ATTENDANCE)->where('account')->eq($account)->andWhere('`date`')->eq($date)->fetch();
        if(empty($attendance))
        {
            $attendance = new stdclass();
            $attendance->account = $account;
            $attendance->date    = $date;
            $attendance->signOut = helper::now();
            $this->dao->insert(TABLE_ATTENDANCE)
                ->data($attendance)
                ->autoCheck()
                ->exec();
            return !dao::isError();
        }

        $this->dao->update(TABLE_ATTENDANCE)
            ->set('signOut')->eq(helper::now())
            ->where('id')->eq($attendance->id)
            ->exec();
        return !dao::isError();
    }

    /**
     * Update status of unknow attendance.
     * 
     * @access public
     * @return bool
     */
    public function updateStatus()
    {
        $attendances = $this->dao->select('*')->from(TABLE_ATTENDANCE)
            ->where('status')->eq('unknown')
            ->andWhere('date')->lt(helper::today())
            ->fetchAll('id');

        foreach($attendances as $attendance)
        {
            $status = $this->computeStatus($attendance);
            $this->dao->update(TABLE_ATTENDANCE)->set('status')->eq($status)->where('id')->eq($attendance->id)->exec();
        }
        return true;
    }

    /**
     * Compute attendance's status. 
     * 
     * @param  object $attendance 
     * @access public
     * @return string
     */
    public function computeStatus($attendance)
    {
        /* holiday */
        $dayIndex = date('w', strtotime($attendance->date));
        if($dayIndex >= $this->config->attendance->workingDaysPerWeek) return 'holiday';

        /* travel, off */

        /* absenteeism */
        if($attendance->signIn == "0000-00-00 00:00:00" and $attendance->signOut == "0000-00-00 00:00:00") return 'absenteeism';

        /* late, early, lateEarly */
        $status = 'unknown';
        if(strtotime($attendance->signIn) > strtotime("{$attendance->date} {$this->config->attendance->latestSignInTime}")) $status = 'late';
        if($this->config->attendance->forcedSignOut == 'yes')
        {
            if(strtotime($attendance->signOut) <  strtotime("{$attendance->date} {$this->config->attendance->earliestSignOutTime}"))
            {
                $status = $status == 'late' ? 'lateEarly' : 'early';
            }
        }
        if($status != 'unknown') return $status;

        /* normal */
        return 'normal';
    }
}

