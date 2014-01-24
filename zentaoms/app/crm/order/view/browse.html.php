<?php include '../../common/view/header.html.php';?>
<div class='panel'>
  <div class='panel-heading'>
  <strong><i class="icon-list-ul"></i> <?php echo $lang->order->list;?></strong>
  <div class='panel-actions'><?php echo html::a($this->inlink('create'), '<i class="icon-plus"></i> ' . $lang->order->create, 'class="btn btn-primary"');?></div>
  </div>
  <table class='table table-hover table-striped tablesorter'>
    <thead>
      <tr class='text-center'>
        <th style='width: 60px'><?php echo $lang->order->id;?></th>
        <th style='width: 100px'><?php echo $lang->order->customer;?></th>
        <th><?php echo $lang->order->product;?></th>
        <th style='width: 160px'><?php echo $lang->order->createdBy;?></th>
        <th style='width: 160px'><?php echo $lang->order->assignedBy;?></th>
        <th style='width: 160px'><?php echo $lang->order->assignedTo;?></th>
        <th style='width: 60px'><?php echo $lang->order->status;?></th>
        <th><?php echo $lang->actions;?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($orders as $order):?>
      <tr class='text-center'>
        <td><?php echo $order->id;?></td>
        <td><?php echo $lang->order->customers[$order->customer];?></td>
        <td><?php echo $products[$order->product];?></td>
        <td><?php echo $order->createdBy;?></td>
        <td><?php echo $order->assignedBy;?></td>
        <td><?php echo $order->assignedTo;?></td>
        <td><?php echo $lang->order->statusList[$order->status];?></td>
        <td>
          <?php
          echo html::a($this->createLink('order', 'edit',   "orderID=$order->id"), $lang->edit);
          echo html::a($this->createLink('order', 'assign', "orderID=$order->id"), $lang->assign);
          if($order->status != 'closed') echo html::a($this->createLink('order', 'close', "orderID=$order->id"), $lang->close);
          if($order->status == 'closed' && $order->closedReason != 'payed') echo html::a($this->createLink('order', 'activate', "orderID=$order->id"), $lang->activate, "class='reload'");
          echo html::a($this->createLink('order', 'view', "orderID=$order->id"), $lang->view);
          echo html::a($this->createLink('order', 'team', "orderID=$order->id"), $lang->order->team);
          ?>
          <?php 
          $actions = $this->order->getEnabledActions($order);
          foreach($actions as $action)
          {
              echo html::a($this->inlink('option', "orderID={$orderID}&action={$action->action}"), $action->name);
          }
          ?>
        </td>
      </tr>
      <?php endforeach;?>
    </tbody>
    <tfoot><tr><td colspan='8'><?php $pager->show();?></td></tr></tfoot>
  </table>
</div>
<?php include '../../common/view/footer.html.php';?>
