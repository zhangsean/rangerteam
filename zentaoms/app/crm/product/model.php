<?php
/**
 * The model file of product category of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     product
 * @version     $Id$
 * @link        http://www.zentao.net
 */
class productModel extends model
{
    /**
     * Get produt by id.
     * 
     * @param  int    $id 
     * @access public
     * @return int|bool
     */
    public function getByID($id)
    {
       $product = $this->dao->select('*')->from(TABLE_PRODUCT)->where('id')->eq($id)->fetch();

       if(!$product) return false;

       return $product;
    }

    /** 
     * Get product list.
     * 
     * @param  string  $orderBy 
     * @param  object  $pager 
     * @access public
     * @return array
     */
    public function getList($orderBy = 'id_desc', $pager = null)
    {
        $products = $this->dao->select('*')->from(TABLE_PRODUCT)->where('deleted')->eq(0)->orderBy($orderBy)->page($pager)->fetchAll('id');

        if(!$products) return array();

        return $products;
    }

    /** 
     * Get product pairs.
     * 
     * @param  string  $orderBy 
     * @access public
     * @return array
     */
    public function getPairs($orderBy = 'id_desc')
    {
        return $this->dao->select('id, name')->from(TABLE_PRODUCT)->where('deleted')->eq(0)->orderBy($orderBy)->fetchPairs('id');
    }

    /**
     * Create a product.
     * 
     * @access public
     * @return int|bool
     */
    public function create()
    {
        $now = helper::now();
        $product = fixer::input('post')
            ->add('createdBy', $this->app->user->account)
            ->add('createdDate', $now)
            ->add('editedDate', $now)
            ->setDefault('deleted', 0)
            ->get();

        $this->dao->insert(TABLE_PRODUCT)
            ->data($product)
            ->autoCheck()
            ->batchCheck($this->config->product->require->create, 'notempty')
            ->check('code', 'unique')
            ->check('code', 'code')
            ->exec();

        $productID = $this->dao->lastInsertID();

        if(dao::isError()) return false;

        $sql = "CREATE TABLE IF NOT EXISTS `crm_order_{$product->code}` ( `order` mediumint(5) NOT NULL, PRIMARY KEY (`order`)) ENGINE=MyISAM DEFAULT CHARSET=utf8";
        if(!$this->dbh->query($sql)) return false;

        return $productID;
    }

    /**
     * Update a product.
     * 
     * @param  int $productID 
     * @access public
     * @return void
     */
    public function update($productID)
    {
        $product = $this->getByID($productID);
        $code    = $product->code;

        $product = fixer::input('post')
            ->add('editedBy', $this->app->user->account)
            ->add('editedDate', helper::now())
            ->setDefault('deleted', 0)
            ->get();

        $this->dao->update(TABLE_PRODUCT)
            ->data($product)
            ->autoCheck()
            ->batchCheck($this->config->product->require->edit, 'notempty')
            ->check('code', 'unique', "id<>{$productID}")
            ->check('code', 'code')
            ->where('id')->eq($productID)
            ->exec();

        if(dao::isError()) return false;

        if($code != $product->code)
        {
            $sql = "RENAME TABLE `crm_order_{$code}` TO `crm_order_{$product->code}`" ;
            if(!$this->dbh->query($sql)) return false;
        }

        return !dao::isError();
    }

    /**
     * Delete a product.
     * 
     * @param  int      $productID 
     * @access public
     * @return void
     */
    public function delete($productID)
    {
        $this->dao->update(TABLE_PRODUCT)->set('deleted')->eq(1)->where('id')->eq($productID)->exec();

        return !dao::isError();
    }
}
