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
        if($date == '' or strlen($date) != 6) $date = date('ym');
        $currentYear  = substr($date, 0, 4);
        $currentMonth = substr($date, 4, 2);
        $startDate    = strtotime("{$currentYear}-{$currentMonth}-01");
        $endDate      = strtotime("+1 month", $startDate);

        $account = $this->app->user->account;
        $this->view->attendances = $this->attendance->getByAccount($account, $startDate, $endDate);
        $this->display();
    }

    /**
     * sign 
     * 
     * @access public
     * @return void
     */
    public function sign()
    {
        $account = $this->app->user->account;
        $date    = date('y-m-d');
        $result  = $this->attendance->sign($account, $date);
        if(!$result) $this->send(array('result' => 'fail', 'message' => $this->lang->attendance->signFail));
        $this->send(array('result' => 'success', 'message' => $this->lang->attendance->signSuccess));
    }

    /**
     * quit 
     * 
     * @access public
     * @return void
     */
    public function quit()
    {
        $account = $this->app->user->account;
        $date    = date('y-m-d');
        $result  = $this->attendance->quit($account, $date);
        if(!$result) $this->send(array('result' => 'fail', 'message' => $this->lang->attendance->quitFail));
        $this->send(array('result' => 'success', 'message' => $this->lang->attendance->quitSuccess));
    }
}

