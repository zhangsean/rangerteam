<?php
/**
 * The control file of index module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     index 
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
class index extends control
{
    /**
     * Construct.
     * 
     * @access public
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Index page.
     * 
     * @access public
     * @return void
     */
    public function index()
    {
        $entries    = $this->loadModel('entry')->getEntries();
        $allEntries = '';

        foreach($entries as $entry)
        {

            $sso  = $this->createLink('entry', 'visit', "entryID=$entry->id");
            $logo = !empty($entry->logo) ? $this->config->webRoot . $entry->logo : '';
            $size = !empty($entry->size) ? ($entry->size != 'max' ? $entry->size : "'$entry->size'") : "'max'";
            $menu = $entry->visible ? 'all' : 'list';
            
            if(!isset($entry->control))  $entry->control = '';
            if(!isset($entry->position)) $entry->position = '';
            $allEntries .= "entries.push(
            {
                id:       '$entry->id',
                name:     '$entry->name',
                url:      '$sso',
                open:     '$entry->open', 
                desc:     '$entry->name',
                size:     $size,
                icon:     '$logo',
                control:  '$entry->control',
                position: '$entry->position',
                menu:     '$menu',
                display:  'fixed',
                abbr:     '$entry->abbr',
                order:    '$entry->order'
            });\n";
        }

        $blocks = $this->loadModel('block')->getBlockList();

        /* Init block when vist index first. */
        if(empty($blocks) and empty($this->config->blockInited))
        {
            if($this->loadModel('block')->initBlock('sys')) die(js::reload());
        }

        $this->view->allEntries = $allEntries;
        $this->view->blocks     = $blocks;
        $this->display();
    }
}
