<?php
/**
 * The control file of index module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     index 
 * @version     $Id: control.php 2605 2013-12-23 09:12:58Z wwccss $
 * @link        http://www.zentao.net
 */
class index extends control
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function index()
    {
        $entries = $this->loadModel('entry')->getEntries();

        $leftBarEntry = ',';
        $allEntries   = '';
        foreach($entries as $entry)
        {
            if($entry->visible) $leftBarEntry .= $entry->id . ',';
            $ssoLoginLink = $this->createLink('entry', 'visit', "entryID=$entry->id");
            $logo         = $entry->logoPath ? $entry->logoPath : '';
            $allEntries  .= "entries['$entry->id'] = new entry('$entry->id', '$ssoLoginLink', '$entry->name', '$entry->openMode', '', 'max', null, null, '$logo');\n";
        }

        $this->view->allEntries   = $allEntries;
        $this->view->leftBarEntry = $leftBarEntry;
        $this->display();
    }
}
