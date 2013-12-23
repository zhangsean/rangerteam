<?php
/**
 * The control file of error module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     error 
 * @version     $Id: control.php 2605 2013-12-23 09:12:58Z wwccss $
 * @link        http://www.zentao.net
 */
class error extends control
{
    /**
     * Show 404 error page.
     * 
     * @access public
     * @return void
     */
    public function index()
    {
        @header("http/1.1 404 not found");
        @header("status: 404 not found");

        $this->display();
    }
}
