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
        $attendances = $this->dao->select('*')->from(TABLE_ATTENDANCE)
            ->where('account')->eq($account)
            ->beginIf($startDate != '')->andWhere('`date`')->gt($startDate)->fi()
            ->beginIf($endDate != '')->andWhere('`date`')->lt($endDate)->fi()
            ->orderBy('`date`')
            ->fetchAll();
        return $attendances;
    }

    /**
     * sign 
     * 
     * @param  string $account 
     * @param  string $date 
     * @access public
     * @return bool
     */
    public function sign($account = '', $date = '')
    {
        if($account == '') $account = $this->app->user->account;
        if($date == '')    $date    = date('y-m-d');

        $attendance = $this->dao->select('*')->from(TABLE_ATTENDANCE)->where('account')->eq($account)->andWhere('`date`')->eq($date)->fetch();
        if(empty($attendance))
        {
            $attendance = new stdclass();
            $attendance->account = $account;
            $attendance->date    = $date;
            $attendance->sign    = helper::now();
            $this->dao->insert(TABLE_ATTENDANCE)
                ->data($attendance)
                ->autoCheck()
                ->exec();
            return !dao::isError();
        }

        if($attendance->sign == '')
        {
            $this->dao->update(TABLE_ATTENDANCE)
                ->set('sign')->eq(helper::now)
                ->where('id')->eq($attendance->id)
                ->exec();
            return !dao::isError();
        }
        return true;
    }

    /**
     * quit 
     * 
     * @param  string $account 
     * @param  string $date 
     * @access public
     * @return bool
     */
    public function quit($account = '', $date = '')
    {
        if($account == '') $account = $this->app->user->account;
        if($date == '')    $date    = date('y-m-d');

        $attendance = $this->dao->select('*')->from(TABLE_ATTENDANCE)->where('account')->eq($account)->andWhere('`date`')->eq($date)->fetch();
        if(empty($attendance))
        {
            $attendance = new stdclass();
            $attendance->account = $account;
            $attendance->date    = $date;
            $attendance->quit    = helper::now();
            $this->dao->insert(TABLE_ATTENDANCE)
                ->data($attendance)
                ->autoCheck()
                ->exec();
            return !dao::isError();
        }

        $this->dao->update(TABLE_ATTENDANCE)
            ->set('quit')->eq(helper::now())
            ->where('id')->eq($attendance->id)
            ->exec();
        return !dao::isError();
    }
}

