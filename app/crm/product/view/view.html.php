<?php 
/**
 * The view file of product module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     product 
 * @version     $Id$
 * @link        http://www.ranzhico.com
 */
?>
<?php include '../../common/view/header.html.php'; ?>
<ul id='menuTitle'>
  <li><?php echo html::a($this->createLink('product', 'browse'), $lang->product->list);?></li>
  <li class='divider angle'></li>
  <li class='title'><?php echo $product->name;?></li>
</ul>
<div class='row-table'>
  <div class='col-main'>
    <?php echo $this->fetch('action', 'history', "objectType=product&objectID={$product->id}");?>
    <div class='page-actions'>
      <?php
      echo "<div class='btn-group'>";
      echo html::a(inlink('edit',   "productID=$product->id"), $this->lang->edit,   "class='btn btn-default' data-toggle='modal'");
      echo html::a(inlink('delete', "productID=$product->id"), $this->lang->delete, "class='deleter btn btn-default'");
      echo '</div>';

      $browseLink = $this->session->productList ? $app->session->productList : inlink('browse');
      echo html::a($browseLink, $lang->goback, "class='btn btn-default'");
      ?>
    </div>
  </div>
  <div class='col-side'>
    <div class='panel'>
      <div class='panel-heading'><strong><i class='icon-file-text-alt'></i> <?php echo $lang->product->basicInfo;?></strong></div>
      <div class='panel-body'>
        <table class='table table-info'>
          <tr>
            <th class='w-50px'><?php echo $lang->product->name;?></th>
            <td><?php echo $product->name;?></td>
          </tr>
          <tr>
            <th><?php echo $lang->product->type;?></th>
            <td><?php echo $lang->product->typeList[$product->type];?></td>
          </tr>
          <tr>
            <th><?php echo $lang->product->status;?></th>
            <td><?php echo $lang->product->statusList[$product->status];?></td>
          </tr>
        </table>
      </div>
    </div> 
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>
