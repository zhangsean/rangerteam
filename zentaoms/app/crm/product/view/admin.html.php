<?php include '../../common/view/header.html.php';?>
<div class='panel'>
  <div class='panel-heading'>
  <strong><i class="icon-list-ul"></i> <?php echo $lang->product->list;?></strong>
  <div class='panel-actions'><?php echo html::a($this->inlink('create'), '<i class="icon-plus"></i> ' . $lang->product->create, 'class="btn btn-primary"');?></div>
  </div>
  <table class='table table-hover table-striped tablesorter'>
    <thead>
      <tr class='text-center'>
        <th style='width: 60px'><?php echo $lang->product->id;?></th>
        <th><?php echo $lang->product->name;?></th>
        <th style='width: 160px'><?php echo $lang->product->createDate;?></th>
        <th style='width: 60px'><?php echo $lang->product->type;?></th>
        <th style='width: 60px'><?php echo $lang->product->status;?></th>
        <th style='width: 200px'><?php echo $lang->actions;?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($products as $product):?>
      <tr class='text-center'>
        <td><?php echo $product->id;?></td>
        <td class='text-left'><?php echo $product->name;?></td>
        <td><?php echo $product->createDate;?></td>
        <td><?php echo $lang->product->typeList[$product->type];?></td>
        <td><?php echo $lang->product->statusList[$product->status];?></td>
        <td>
          <?php
          echo html::a($this->createLink('product', 'edit', "productID=$product->id"), $lang->edit);
          echo html::a($this->createLink('product', 'delete', "productID=$product->id"), $lang->delete, "class='deleter'");
          ?>
        </td>
      </tr>
      <?php endforeach;?>
    </tbody>
    <tfoot><tr><td colspan='6'><?php $pager->show();?></td></tr></tfoot>
  </table>
</div>
<?php include '../../common/view/footer.html.php';?>
