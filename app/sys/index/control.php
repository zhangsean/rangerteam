<?php
/**
 * The control file of index module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     index 
 * @version     $Id$
 * @link        http://www.ranzhico.com
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
            $logo = !empty($entry->logo) ? $entry->logo : '';
            $size = !empty($entry->size) ? ($entry->size != 'max' ? $entry->size : "'$entry->size'") : "'max'";
            $menu = $entry->visible ? 'all' : 'list';
            /* add web root if logo not start with /  */
            if($logo != '' && substr($logo, 0, 1) != '/') $logo = $this->config->webRoot . $logo;
            
            if(!isset($entry->control))  $entry->control = '';
            if(!isset($entry->position)) $entry->position = '';
            $allEntries .= "entries.push(
            {
                id:       '$entry->id',
                code:     '$entry->code',
                name:     '$entry->name',
                url:      '$sso',
                open:     '$entry->open', 
                desc:     '$entry->name',
                size:      $size,
                icon:     '$logo',
                control:  '$entry->control',
                position: '$entry->position',
                menu:     '$menu',
                display:  'fixed',
                abbr:     '$entry->abbr',
                order:    '$entry->order',
                sys:      '$entry->buildin'
            });\n";
        }

        $blocks = $this->loadModel('block')->getBlockList();

        /* Init block when vist index first. */
        if(empty($blocks) and empty($this->config->blockInited))
        {
            if($this->loadModel('block')->initBlock('sys')) die(js::reload());
        }

        /* Get custom setting about superadmin */
        $customApp = isset($this->config->personal->common->customApp) ? json_decode($this->config->personal->common->customApp->value) : new stdclass();
        if(isset($customApp->superadmin)) $this->view->superadmin = $customApp->superadmin;

        $this->view->allEntries = $allEntries;
        $this->view->blocks     = $blocks;
        $this->view->company    = $this->loadModel('setting')->getItem('owner=system&app=sys&module=common&section=company&key=name');
        $this->display();
    }
}
