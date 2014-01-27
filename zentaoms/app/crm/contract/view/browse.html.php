<?php include '../../common/view/header.html.php';?>
<div class='panel'>
  <div class='panel-heading'>
  <strong><i class="icon-list-ul"></i> <?php echo $lang->contract->list;?></strong>
  <div class='panel-actions'><?php echo html::a($this->inlink('create'), '<i class="icon-plus"></i> ' . $lang->contract->create, 'class="btn btn-primary"');?></div>
  </div>
  <table class='table table-hover table-striped tablesorter'>
    <thead>
      <tr class='text-center'>
        <th style='width: 60px'><?php echo $lang->contract->id;?></th>
        <th><?php echo $lang->contract->name;?></th>
        <th style='width: 100px'><?php echo $lang->contract->customer;?></th>
        <th style='width: 100px'><?php echo $lang->contract->amount;?></th>
        <th style='width: 160px'><?php echo $lang->contract->createdDate;?></th>
        <th style='width: 100px'><?php echo $lang->contract->delivery;?></th>
        <th style='width: 100px'><?php echo $lang->contract->return;?></th>
        <th style='width: 60px'><?php echo $lang->contract->status;?></th>
        <th style='width: 90px'><?php echo $lang->actions;?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($contracts as $contract):?>
      <tr class='text-center'>
        <td><?php echo $contract->id;?></td>
        <td class='text-left'><?php echo $contract->name;?></td>
        <td><?php echo $customers[$contract->customer];?></td>
        <td><?php echo $contract->amount;?></td>
        <td><?php echo $contract->createdDate;?></td>
        <td><?php echo $lang->contract->deliveryList[$contract->delivery];?></td>
        <td><?php echo $lang->contract->returnList[$contract->return];?></td>
        <td><?php echo $lang->contract->statusList[$contract->status];?></td>
        <td>
          <?php
          echo html::a($this->createLink('contract', 'edit', "contract=$contract->id"), $lang->edit);
          echo html::a($this->createLink('contract', 'delete', "contract=$contract->id"), $lang->delete, "class='deleter'");
          ?>
        </td>
      </tr>
      <?php endforeach;?>
    </tbody>
    <tfoot><tr><td colspan='9'><?php $pager->show();?></td></tr></tfoot>
  </table>
</div>
<?php include '../../common/view/footer.html.php';?>
