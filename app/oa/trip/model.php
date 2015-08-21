<?php
/**
 * The model file of trip module of Ranzhi.
 *
 * @copyright   Copyright 2009-2015 QingDao Nature Easy Soft Network Technology Co,LTD (www.cnezsoft.com)
 * @license     ZPL 
 * @author      chujilu <chujilu@cnezsoft.com>
 * @package     trip
 * @version     $Id$
 * @link        http://www.ranzhico.com
 */
class tripModel extends model
{
    /**
     * Get a trip by id. 
     * 
     * @param  int    $id 
     * @access public
     * @return object
     */
    public function getById($id)
    {
        return $this->dao->select('*')->from(TABLE_TRIP)->where('id')->eq($id)->fetch();
    }

    /**
     * Get trip list. 
     * 
     * @param  string $year 
     * @param  string $month 
     * @param  string $account 
     * @param  string $dept 
     * @access public
     * @return array
     */
    public function getList($year = '', $month = '', $account = '', $dept = '')
    {
        return $this->dao->select('t1.*, t2.realname, t2.dept')->from(TABLE_TRIP)->alias('t1')->leftJoin(TABLE_USER)->alias('t2')->on("t1.createdBy=t2.account")
            ->where('1=1')
            ->beginIf($year != '')->andWhere('t1.year')->eq($year)->fi()
            ->beginIf($month != '')->andWhere('t1.begin')->like("%-$month-%")->fi()
            ->beginIf($account != '')->andWhere('t1.createdBy')->eq($account)->fi()
            ->beginIf($dept != '')->andWhere('t2.dept')->in($dept)->fi()
            ->orderBy('t2.dept,t1.id_desc')
            ->fetchAll();
    }

    /**
     * Get all month of trip's begin.
     * 
     * @access public
     * @return array
     */
    public function getAllMonth()
    {
        $monthList = array();
        $dateList  = $this->dao->select('begin')->from(TABLE_TRIP)->groupBy('begin')->orderBy('begin_asc')->fetchAll('begin');
        foreach($dateList as $date)
        {
            $year  = substr($date->begin, 0, 4);
            $month = substr($date->begin, 5, 2);
            if(!isset($monthList[$year][$month])) $monthList[$year][$month] = $month;
        }
        return $monthList;
    }

    /**
     * Create a trip.
     * 
     * @access public
     * @return bool
     */
    public function create()
    {
        $trip = fixer::input('post')
            ->add('createdBy', $this->app->user->account)
            ->add('createdDate', helper::now())
            ->get();
        if(isset($trip->begin) and $trip->begin != '') $trip->year = substr($trip->begin, 0, 4);

        $this->dao->insert(TABLE_TRIP)
            ->data($trip)
            ->autoCheck()
            ->batchCheck($this->config->trip->require->create, 'notempty')
            ->exec();
        return !dao::isError();
    }

    /**
     * update trip.
     * 
     * @param  int    $id 
     * @access public
     * @return bool
     */
    public function update($id)
    {
        $trip = fixer::input('post')
            ->remove('createdBy')
            ->remove('createdDate')
            ->get();
        if(isset($trip->begin) and $trip->begin != '') $trip->year = substr($trip->begin, 0, 4);

        $this->dao->update(TABLE_TRIP)
            ->data($trip)
            ->autoCheck()
            ->batchCheck($this->config->trip->require->edit, 'notempty')
            ->where('id')->eq($id)
            ->exec();
        return !dao::isError();
    }

    /**
     * delete trip.
     * 
     * @param  int    $id 
     * @access public
     * @return bool
     */
    public function delete($id, $null = null)
    {
        $this->dao->delete()->from(TABLE_TRIP)->where('id')->eq($id)->exec();
        return !dao::isError();
    }
}
