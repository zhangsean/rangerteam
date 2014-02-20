<?php include '../../common/view/header.html.php';?>
<div class='panel'>
  <div class='panel-heading'><strong><?php echo $lang->order->view;?></strong></div>
  <table class='table table-hover'>
    <thead>
      <tr class='text-center'>
        <th><?php echo $lang->order->plan;?></th>
        <?php if($order->status == 'payed'):?>
        <th><?php echo $lang->order->real;?></th>
        <?php endif;?>
        <th><?php echo $lang->order->status;?></th>
        <?php if($order->activatedBy):?>
        <th><?php echo $lang->order->activatedBy;?></th>
        <th><?php echo $lang->order->activatedDate;?></th>
        <?php endif;?>
        <?php if($order->status == 'closed'):?>
        <th><?php echo $lang->order->closedReason;?></th>
        <th><?php echo $lang->order->closedNote;?></th>
        <?php endif;?>
        <?php if(!empty($actions)):?>
        <th><?php echo $lang->actions;?></th>
        <?php endif;?>
      </tr>
    </thead>
    <tbody>
      <tr class='text-center'>
        <td><?php echo $order->plan;?></td>
        <?php if($order->status == 'payed'):?>
        <td><?php echo $lang->order->real;?></td>
        <?php endif;?>
        <td><?php echo $lang->order->statusList[$order->status];?></td>
        <?php if($order->activatedBy):?>
        <td><?php echo $order->activatedBy;?></td>
        <td><?php echo $order->activatedDate;?></td>
        <?php endif;?>
        <?php if($order->status == 'closed'):?>
        <td><?php echo $lang->order->closedReasonList[$order->closedReason];?></td>
        <td><?php echo $order->closedNote;?></td>
        <?php endif;?>
        <?php if(!empty($actions)):?>
        <td><?php foreach($actions as $action) echo html::a($this->inlink('operate', "orderID={$order->id}&action={$action->id}"), $action->name) . '&nbsp;';?></td>
        <?php endif;?>
      <tr>
      <tr>
        <?php ($order->status == 'payed' || $order->status == 'closed') ? $colspan = '4' : $colspan = '2';?>
        <td colspan="<?php echo $colspan;?>" class='text-left'>
          <?php printf($lang->order->created, $order->createdBy, $order->createdDate);?><br/>
          <?php if($order->status == 'assigned') printf($lang->order->assigned, $order->assignedBy, $order->assignedDate, $order->assignedTo);?>
          <?php if($order->status == 'signed') printf($lang->order->signed, $order->signedBy, $order->signedDate);?>
        </td>
      </tr>
    </tbody>
  </table>
</div>
<div class='panel'>
  <table class='table table-hover'>
    <thead>
      <tr class='text-center'>
        <th><?php echo $lang->order->product;?></th>
        <th><?php echo $lang->product->summary;?></th>
      </tr>
    </thead>
    <tbody>
      <tr class='text-center'>
        <td><?php echo $product->name;?></td>
        <td><?php echo $product->summary;?></td>
      <tr>
    </tbody>
  </table>
</div>
<div class='panel'>
  <table class='table table-hover'>
    <thead>
      <tr class='text-center'>
        <th><?php echo $lang->order->customer;?></th>
        <th><?php echo $lang->customer->contactBy;?></th>
        <th><?php echo $lang->customer->contactDate;?></th>
      </tr>
    </thead>
    <tbody>
      <tr class='text-center'>
        <td><?php echo $customer->name;?></td>
        <td><?php echo $customer->contactedBy;?></td>
        <td><?php echo $customer->contactedDate;?></td>
      <tr>
    </tbody>
  </table>
</div>
<div class='panel'>
  <div class='panel-heading'><strong><?php echo $lang->order->effort;?></strong></div>
  <table class='table table-hover'>
    <thead>
      <tr class='text-center'>
        <th class='w-id'><?php echo $lang->effort->id;?></th>
        <th class='w-100px'><?php echo $lang->effort->date;?></th>
        <th class='w-80px'><?php echo $lang->effort->consumed;?></th>
        <th><?php echo $lang->effort->work;?></th>
      </tr>
    </thead>
    <tbody>
      <?php unset($efforts['typeList']);?>
      <?php foreach($efforts as $effort):?>
      <tr class='text-center'>
        <td><?php echo $effort->id;?></td>
        <td><?php echo $effort->date;?></td>
        <td><?php echo $effort->consumed;?></td>
        <td class='text-left'><?php echo $effort->work;?></td>
      <tr>
      <?php endforeach;?>
    </tbody>
  </table>
</div>
<?php include '../../common/view/footer.html.php';?>
