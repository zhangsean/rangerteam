<?php 
/**
 * The browse view file of product module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     product 
 * @version     $Id$
 * @link        http://www.ranzhico.com
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php js::set('mode', $mode);?>
<div id='menuActions'>
  <?php echo html::a($this->inlink('create'), '<i class="icon-plus"></i> ' . $lang->product->create, "class='btn btn-primary' data-toggle='modal'");?>
</div>
<div class='panel'>
  <table class='table table-hover table-striped tablesorter table-data' id='productList'>
    <thead>
      <tr class='text-center'>
        <?php $vars = "mode={$mode}&orderBy=%s&recTotal={$pager->recTotal}&recPerPage={$pager->recPerPage}&pageID={$pager->pageID}";?>
        <th class='w-60px'> <?php commonModel::printOrderLink('id',          $orderBy, $vars, $lang->product->id);?></th>
        <th>                <?php commonModel::printOrderLink('name',        $orderBy, $vars, $lang->product->name);?></th>
        <th class='w-160px visible-lg'><?php commonModel::printOrderLink('createdDate', $orderBy, $vars, $lang->product->createdDate);?></th>
        <th class='w-60px'> <?php commonModel::printOrderLink('type',        $orderBy, $vars, $lang->product->type);?></th>
        <th class='w-60px'> <?php commonModel::printOrderLink('status',      $orderBy, $vars, $lang->product->status);?></th>
        <th class='w-100px'><?php echo $lang->actions;?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($products as $product):?>
      <tr class='text-center' data-url="<?php echo $this->createLink('product', 'view', "productID={$product->id}");?>">
        <td><?php echo $product->id;?></td>
        <td class='text-left'><?php echo $product->name;?></td>
        <td class='visible-lg'><?php echo $product->createdDate;?></td>
        <td><?php echo $lang->product->typeList[$product->type];?></td>
        <td><?php echo $lang->product->statusList[$product->status];?></td>
        <td>
          <?php
          echo html::a($this->createLink('product', 'edit', "productID=$product->id"), $lang->edit, "data-toggle='modal'");
          echo html::a($this->createLink('product', 'delete', "productID=$product->id"), $lang->delete, "class='reloadDeleter'");
          ?>
        </td>
      </tr>
      <?php endforeach;?>
    </tbody>
  </table>
  <div class='table-footer'><?php $pager->show();?></div>
</div>
<?php include '../../common/view/footer.html.php';?>
