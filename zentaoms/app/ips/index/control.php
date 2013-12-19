<?php
/**
 * The control file of index module of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     index
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
class index extends control
{
    /**
     * Construct, must create this contruct function since there's index() also
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * The index page of whole site.
     * 
     * @access public
     * @return void
     */
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
