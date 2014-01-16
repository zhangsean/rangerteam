<?php include '../../common/view/header.html.php';?>
<div class='panel'>
  <div class='panel-heading'><?php echo $lang->order->edit;?></div>
  <div class='panel-body'>
    <form method='post' id='ajaxForm'>
      <table class='table table-form'>
        <tr>
          <th><?php echo $lang->order->customer;?></th>
          <td colspan='2'><?php echo $lang->order->customers[$order->customer];?></td>
        </tr>
        <tr>
          <th><?php echo $lang->order->product;?></th>
          <td colspan='2'><?php echo html::select('product', $products, $order->product, "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->order->plannedAmounts;?></th>
          <td><?php echo html::input('plan', $order->plan, "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->order->assignedTo;?></th>
          <td><?php echo html::input('assignedTo', $order->assignedTo, "class='form-control'");?></td>
        </tr>
        <tr>
          <th></th>
          <td colspan='2'><?php echo html::submitButton();?></div>
        </div>
      </table>
    </form>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>
