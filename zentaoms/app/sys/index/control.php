<?php
/**
 * The control file of index module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     index 
 * @version     $Id$
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

        $leftEntry  = ',';
        $allEntries = '';
        foreach($entries as $entry)
        {
            if($entry->visible) $leftEntry .= $entry->id . ',';
            $sso  = $this->createLink('entry', 'visit', "entryID=$entry->id");
            $logo = $entry->logoPath ? $entry->logoPath : '';
            $allEntries .= "entries['$entry->id'] = new entry('$entry->id', '$sso', '$entry->name', '$entry->open', '$entry->name', 'max', null, null, '$logo');\n";
        }

        $this->view->allEntries = $allEntries;
        $this->view->leftEntry  = $leftEntry;
        $this->display();
    }
}
