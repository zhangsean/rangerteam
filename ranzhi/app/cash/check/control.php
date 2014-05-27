<?php
/**
 * The control file of check module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     check
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
class check extends control
{
    /** 
     * The index page of check module.
     * 
     * @param  int    $depositor 
     * @access public
     * @return void
     */
    public function index($depositor = 0)
    {
        $errors = array();
        if(!$this->post->start) $error['start'] = $this->lang->check->validateNoice->start;
        if(!$this->post->end)   $error['end']   = $this->lang->check->validateNoice->end;

        if($_POST)
        {
            $this->view->start   = $this->post->start;
            $this->view->end     = $this->post->end;
            $this->view->results = $this->check->compute($this->post->depositor, $this->post->start, $this->post->end);
        }

        $this->view->title         = $this->lang->check->common;
        $this->view->errors        = $errors;
        $this->view->depositor     = $depositor;
        $this->view->depositorList = $this->loadModel('depositor')->getPairs();
        $this->view->dateOptions   = $this->loadModel('balance')->getDateOptions();

        $this->display();
    }   
}
