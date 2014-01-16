<?php
/**
 * The model file of field module of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     field
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
class fieldModel extends model
{
    /**
     * Create a field.
     * 
     * @access public
     * @return int|bool
     */
    public function create($productID)
    {
        $field = fixer::input('post')->add('product', $productID)->get();
        $product = $this->loadModel('product')->getByID($productID);
        if(empty($product)) return false;

        $this->dao->insert(TABLE_ORDERFIELD)
            ->data($field)
            ->autoCheck()
            ->check('field', 'unique', "product={$productID}")
            ->batchCheck($this->config->field->require->create, 'notempty')
            ->exec();

        if(dao::isError()) return false;
        $alterQuery = "ALTER TABLE crm_order_{$product->code} ADD `{$field->field}` {$this->config->field->controlTypeList[$field->control]} NOT NULL";
        if($field->default) $alterQuery .= " default {$field->default}";
        if(!$this->dbh->query($alterQuery)) return false;

        return true;
    }


}

