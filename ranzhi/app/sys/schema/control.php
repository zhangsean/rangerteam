<?php
/**
 * The control file of schema module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     schema
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
class schema extends control
{
    public function __construct()
    {
        parent::__construct();

        $this->lang->schema->menu = $this->lang->setting->menu;
        $this->lang->menuGroups->schema = 'setting';
    }

    /** 
     * The index page, locate to the browse page.
     * 
     * @access public
     * @return void
     */
    public function index()
    {
        $this->locate(inlink('browse'));
    }

    /**
     * Browse schema. 
     * 
     * @access public
     * @return void
     */
    public function browse()
    {
        $this->app->loadLang('trade', 'cash');
        $this->view->schemas = $this->schema->getList();
        $this->display();
    }

    /**
     * create a schema. 
     * 
     * @access public
     * @return void
     */
    public function create()
    {
        if($_POST)
        {
            $schemaID = $this->schema->create();
            if(dao::isError())$this->send(array('result' => 'fail', 'message' => dao::getError()));

            $this->loadModel('action')->create('schema', $schemaID, 'Created');

            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('browse')));

        }

        $this->app->loadLang('trade', 'cash');
        $this->display();
    }

    /**
     * Edit schema. 
     * 
     * @param  int    $schemaID 
     * @access public
     * @return void
     */
    public function edit($schemaID)
    {
        if($_POST)
        {
            $changes = $this->schema->update($schemaID);
            if(dao::isError())$this->send(array('result' => 'fail', 'message' => dao::getError()));

            if($changes)
            {
                $actionID = $this->loadModel('action')->create('schema', $schemaID, 'Edited');
                $this->action->logHistory($actionID, $changes);
            }

            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('browse')));

        }

        $this->app->loadLang('trade', 'cash');

        $schema = $this->schema->getByID($schemaID);
        if(!$schema) $this->locate(inlink('browse'));

        $this->view->schema = $schema;
        $this->display();
    }

    /**
     * Delete schema. 
     * 
     * @param  int    $schemaID 
     * @access public
     * @return void
     */
    public function delete($schemaID)
    {
        if($this->schema->delete($schemaID)) $this->send(array('result' => 'success', 'locate' => inlink('schema')));
        $this->send(array('result' => 'fail', 'message' => dao::getError()));
    }
}
