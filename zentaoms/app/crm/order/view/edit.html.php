<?php include '../../common/view/header.html.php';?>
<div class='panel'>
  <div class='panel-heading'><?php echo $lang->order->edit;?></div>
  <div class='panel-body'>
    <form method='post' id='ajaxForm'>
      <table class='table table-form'>
        <tr>
          <th><?php echo $lang->order->customer;?></th>
          <td><?php echo $lang->order->customers[$order->customer];?></td>
        </tr>
        <tr>
          <th><?php echo $lang->order->product;?></th>
          <td><?php echo html::select('product', $products, $order->product, "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->order->plan;?></th>
          <td><?php echo html::input('plan', $order->plan, "class='form-control'");?></td>
        </tr>
        <?php if($order->status != 'closed'):?>
        <tr>
          <th><?php echo $lang->order->assignedTo;?></th>
          <td><?php echo html::input('assignedTo', $order->assignedTo, "class='form-control'");?></td>
        </tr>
        <?php endif;?>
        <?php if($order->status == 'closed'):?>
        <tr>
          <th><?php echo $lang->order->closedReason;?></th>
          <td><?php echo html::select('closedReason', $lang->order->closedReasonList, $order->closedReason, "class='form-control'");?></td>
        </tr>
        <?php endif;?>
        <tr>
          <th></th>
          <td><?php echo html::submitButton();?></div>
        </div>
      </table>
    </form>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>
