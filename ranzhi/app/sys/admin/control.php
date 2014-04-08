<?php
/**
 * The control file of admin module of Ranzhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     admin 
 * @version     $Id$
 * @link        http://www.ranzhi.co
 */
class admin extends control
{
    /**
     * The index page of admin panel, print the sites.
     * 
     * @access public
     * @return void
     */
    public function index()
    {
        $this->display();
    }
}
