<?php
/**
 * The model file of leave module of Ranzhi.
 *
 * @copyright   Copyright 2009-2015 QingDao Nature Easy Soft Network Technology Co,LTD (www.cnezsoft.com)
 * @license     ZPL 
 * @author      chujilu <chujilu@cnezsoft.com>
 * @package     leave
 * @version     $Id$
 * @link        http://www.ranzhico.com
 */
class leaveModel extends model
{
    /**
     * Get a leave by id. 
     * 
     * @param  int    $id 
     * @access public
     * @return object
     */
    public function getById($id)
    {
        return $this->dao->select('*')->from(TABLE_LEAVE)->where('id')->eq($id)->fetch();
    }

    /**
     * Get leave list. 
     * 
     * @param  string $year 
     * @param  string $month 
     * @param  string $account 
     * @param  string $dept 
     * @param  string $status 
     * @access public
     * @return array
     */
    public function getList($year = '', $month = '', $account = '', $dept = '', $status = '')
    {
        return $this->dao->select('t1.*, t2.realname, t2.dept')->from(TABLE_LEAVE)->alias('t1')->leftJoin(TABLE_USER)->alias('t2')->on("t1.createdBy=t2.account")
            ->where('1=1')
            ->beginIf($year != '')->andWhere('t1.year')->eq($year)->fi()
            ->beginIf($month != '')->andWhere('t1.begin')->like("%-$month-%")->fi()
            ->beginIf($account != '')->andWhere('t1.createdBy')->eq($account)->fi()
            ->beginIf($dept != '')->andWhere('t2.dept')->in($dept)->fi()
            ->beginIf($status != '')->andWhere('t1.status')->eq($status)->fi()
            ->orderBy('t2.dept,t1.id_desc')
            ->fetchAll();
    }

    /**
     * Get all month of leave's begin.
     * 
     * @access public
     * @return array
     */
    public function getAllMonth()
    {
        $monthList = array();
        $dateList  = $this->dao->select('begin')->from(TABLE_LEAVE)->groupBy('begin')->orderBy('begin_asc')->fetchAll('begin');
        foreach($dateList as $date)
        {
            $year  = substr($date->begin, 0, 4);
            $month = substr($date->begin, 5, 2);
            if(!isset($monthList[$year][$month])) $monthList[$year][$month] = $month;
        }
        return $monthList;
    }

    /**
     * Create a leave.
     * 
     * @access public
     * @return bool
     */
    public function create()
    {
        $leave = fixer::input('post')
            ->add('status', 'wait')
            ->add('createdBy', $this->app->user->account)
            ->add('createdDate', helper::now())
            ->get();
        if(isset($leave->begin) and $leave->begin != '') $leave->year = substr($leave->begin, 0, 4);

        $this->dao->insert(TABLE_LEAVE)
            ->data($leave)
            ->autoCheck()
            ->batchCheck($this->config->leave->require->create, 'notempty')
            ->check('end', 'ge', $leave->begin)
            ->exec();
        return !dao::isError();
    }

    /**
     * update leave.
     * 
     * @param  int    $id 
     * @access public
     * @return bool
     */
    public function update($id)
    {
        $leave = fixer::input('post')
            ->remove('status')
            ->remove('createdBy')
            ->remove('createdDate')
            ->get();
        if(isset($leave->begin) and $leave->begin != '') $leave->year = substr($leave->begin, 0, 4);

        $this->dao->update(TABLE_LEAVE)
            ->data($leave)
            ->autoCheck()
            ->batchCheck($this->config->leave->require->edit, 'notempty')
            ->check('end', 'ge', $leave->begin)
            ->where('id')->eq($id)
            ->exec();
        return !dao::isError();
    }

    /**
     * review 
     * 
     * @param  int    $id 
     * @param  string $status 
     * @access public
     * @return bool
     */
    public function review($id, $status)
    {
        if(!isset($this->lang->leave->statusList[$status])) return false;
        $this->dao->update(TABLE_LEAVE)
            ->set('status')->eq($status)
            ->set('reviewedBy')->eq($this->app->user->account)
            ->set('reviewedDate')->eq(helper::now())
            ->where('id')->eq($id)
            ->exec();
        return !dao::isError();
    }

    /**
     * check date is in leave. 
     * 
     * @param  string $date 
     * @param  string $account 
     * @access public
     * @return bool
     */
    public function isLeave($date, $account)
    {
        static $leaveList = array();
        if(!isset($leaveList[$account])) $leaveList[$account] = $this->getList($year = '', $month = '', $account, $dept = '', 'pass');

        foreach($leaveList[$account] as $leave)
        {
            if(strtotime($date) >= strtotime($leave->begin) and strtotime($date) <= strtotime($leave->end)) return true;
        }

        return false;
    }

    /**
     * delete leave.
     * 
     * @param  int    $id 
     * @access public
     * @return bool
     */
    public function delete($id, $null = null)
    {
        $this->dao->delete()->from(TABLE_LEAVE)->where('id')->eq($id)->exec();
        return !dao::isError();
    }
}
