<?php
/**
 * The model file of schema module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     schema
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
class schemaModel extends model
{
    /**
     * Get schema by ID.
     * 
     * @param  int    $schemaID 
     * @access public
     * @return object
     */
    public function getByID($schemaID)
    {
        return $this->dao->select('*')->from(TABLE_SCHEMA)->where('id')->eq($schemaID)->fetch();
    }

    /**
     * Get schema list.
     * 
     * @access public
     * @return array
     */
    public function getList()
    {
        return $this->dao->select('*')->from(TABLE_SCHEMA)->orderBy('id desc')->fetchAll('id');
    }

    /**
     * Create a schema 
     * 
     * @access public
     * @return int|bool
     */
    public function create()
    {
        $schema = fixer::input('post')
            ->setIF($this->post->feeRow, 'fee', '')
            ->remove('feeRow')
            ->get();

        $this->dao->insert(TABLE_SCHEMA)->data($schema)
            ->autoCheck()
            ->batchCheck($this->config->schema->require->create, 'notempty')
            ->exec();

        if(dao::isError()) return false;
        return $this->dao->lastInsertID();
    }

    /**
     * Update schema.
     * 
     * @param  int    $schemaID 
     * @access public
     * @return array
     */
    public function update($schemaID)
    {
        $oldSchema = $this->getByID($schemaID);
        $schema    = fixer::input('post')
            ->setIF($this->post->feeRow, 'fee', '')
            ->remove('feeRow')
            ->get();

        $this->dao->update(TABLE_SCHEMA)->data($schema)
            ->autoCheck()
            ->batchCheck($this->config->schema->require->edit, 'notempty')
            ->where('id')->eq($schemaID)
            ->exec();

        if(!dao::isError()) return commonModel::createChanges($oldSchema, $schema);
        return false;
    }

    /**
     * Delete a schema.
     * 
     * @param  int      $schemaID 
     * @access public
     * @return bool
     */
    public function delete($schemaID, $null = null)
    {
        $schema = $this->getByID($schemaID);
        if(!$schema) return false;

        $this->dao->delete()->from(TABLE_SCHEMA)->where('id')->eq($schemaID)->exec();

        return !dao::isError();
    }
}
