<?php
/**
 * The control file of my module of RanZhi.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv12.html)
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     my
 * @version     $Id$
 * @link        http://www.ranzhico.com
 */
class my extends control
{
    public function task()
    {
        $this->loadModel('task');

        $this->view->title   = $this->lang->task->common;
        $this->view->company = $this->loadModel('setting')->getItem('owner=system&app=sys&module=common&section=company&key=name');
        $this->display();
    }
}
