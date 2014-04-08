<?php
/**
 * The control file of article category of Ranzhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     article
 * @version     $Id: control.php 7417 2013-12-23 07:51:50Z wwccss $
 * @link        http://www.ranzhi.co
 */
class index extends control
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->locate($this->createLink('dashboard', 'index'));
    }
}
