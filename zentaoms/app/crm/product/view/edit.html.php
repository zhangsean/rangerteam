<?php include '../../common/view/header.html.php';?>
<div class='panel'>
  <div class='panel-heading'><?php echo $lang->product->edit;?></div>
  <div class='panel-body'>
    <form method='post' id='ajaxForm'>
      <table class='table table-form'>
        <tr>
          <th><?php echo $lang->product->name;?></th>
          <td colspan='2'><?php echo html::input('name', $product->name, "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->product->code;?></th>
          <td colspan='2'><?php echo html::input('code', $product->code, "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->product->type;?></th>
          <td><?php echo html::select('type', $lang->product->typeList, $product->type, "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->product->status;?></th>
          <td><?php echo html::select('status', $lang->product->statusList, $product->status, "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->product->summary;?></th>
          <td colspan='2'><?php echo html::textarea('summary', $product->summary, "rows='2' class='form-control'");?></td>
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
