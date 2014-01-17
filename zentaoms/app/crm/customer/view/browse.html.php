<?php include '../../common/view/header.html.php';?>
<div class='panel'>
  <div class='panel-heading'>
  <strong><i class="icon-list-ul"></i> <?php echo $lang->customer->list;?></strong>
  <div class='panel-actions'><?php echo html::a($this->inlink('create'), '<i class="icon-plus"></i> ' . $lang->customer->create, 'class="btn btn-primary"');?></div>
  </div>
  <table class='table table-hover table-striped tablesorter'>
    <thead>
      <tr class='text-center'>
        <th style='width: 60px'><?php echo $lang->customer->id;?></th>
        <th><?php echo $lang->customer->name;?></th>
        <th style='width: 160px'><?php echo $lang->customer->createdDate;?></th>
        <th style='width: 100px'><?php echo $lang->customer->type;?></th>
        <th style='width: 60px'><?php echo $lang->customer->status;?></th>
        <th style='width: 60px'><?php echo $lang->customer->size;?></th>
        <th style='width: 60px'><?php echo $lang->customer->level;?></th>
        <th style='width: 100px'><?php echo $lang->actions;?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($customers as $customer):?>
      <tr class='text-center'>
        <td><?php echo $customer->id;?></td>
        <td class='text-left'><?php echo $customer->name;?></td>
        <td><?php echo $customer->createdDate;?></td>
        <td><?php echo $lang->customer->typeList[$customer->type];?></td>
        <td><?php echo $lang->customer->sizeList[$customer->size];?></td>
        <td><?php echo $customer->level;?></td>
        <td><?php echo $lang->customer->statusList[$customer->status];?></td>
        <td>
          <?php
          echo html::a($this->createLink('customer', 'edit', "customerID=$customer->id"), $lang->edit);
          echo html::a($this->createLink('customer', 'delete', "customerID=$customer->id"), $lang->delete, "class='deleter'");
          ?>
        </td>
      </tr>
      <?php endforeach;?>
    </tbody>
    <tfoot><tr><td colspan='8'><?php $pager->show();?></td></tr></tfoot>
  </table>
</div>
<?php include '../../common/view/footer.html.php';?>
