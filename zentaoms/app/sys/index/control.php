<?php
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

        $this->view->title        = $this->lang->zentaoms;
        $this->view->allEntries   = $allEntries;
        $this->view->leftBarEntry = $leftBarEntry;
        $this->display();
    }
}
