<?php
/**
 * The control file of misc module of RanZhi.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv11.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     misc 
 * @version     $Id$
 * @link        http://www.ranzhico.com
 */
class misc extends control
{
    /**
     * keep logon function.
     * 
     * @access public
     * @return void
     */
    public function ping()
    {
        die();
    }

    /**
     * Show about info of zentao.
     * 
     * @access public
     * @return void
     */
    public function about()
    {
        die($this->display());
    }
}
