<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/datepicker.html.php';?>
<div class='panel'>
  <div class='panel-heading'><?php echo $action->name;?></div>
  <div class='panel-body'>
    <form method='post' id='ajaxForm'>
      <table class='table table-form'>
        <?php foreach($action->inputs as $field => $input):?>
        <tr>
          <th><?php echo isset($fields[$field]->name) ? $fields[$field]->name : $lang->order->{$field};?></th>
          <td><?php echo $this->product->buildControl($fields[$field], isset($order->$field) ? $order->$field : '' );?></td>
        </tr>
        <?php endforeach;?>
        <tr>
          <th></th>
          <td><?php echo html::submitButton();?></td>
        </tr>
      </table>
    </form>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>
