<?php include '../../common/view/header.html.php';?>
<div class='panel'>
  <div class='panel-heading'>
    <strong><i class="icon-plus"></i> <?php echo $lang->order->create;?></strong>
  </div>
  <div class='panel-body'>
    <form method='post' id='ajaxForm'>
      <table class='table table-form'>
        <tr>
          <th><?php echo $lang->order->customer;?></th>
          <td><?php echo html::select('customer', $customers, '', "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->order->product;?></th>
          <td><?php echo html::select('product', $products, $productID, "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->order->plan;?></th>
          <td><?php echo html::input('plan', '', "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->order->assignedTo;?></th>
          <td><?php echo html::input('assignedTo', '', "class='form-control'");?></td>
        </tr>
        <?php echo $productForm;?>
        <tr>
          <th></th>
          <td><?php echo html::submitButton();?></td>
        </tr>
      </table>
    </form>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>
