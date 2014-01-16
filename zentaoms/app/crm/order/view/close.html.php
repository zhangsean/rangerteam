<?php include '../../common/view/header.html.php';?>
<?php include '../../../sys/common/view/kindeditor.html.php';?>
<div class='panel'>
  <div class='panel-heading'>
    <strong><?php echo $lang->order->close;?></strong>
  </div>
  <div class='panel-body'>
    <form method='post' id='ajaxForm'>
      <table class='table table-form'>
        <tr>
          <th><?php echo $lang->order->closedReason;?></th>
          <td><?php echo html::select('closedReason', $lang->order->closedReasonList, '', "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->order->closedNote;?></th>
          <td><?php echo html::textarea('closedNote', '', "rows='6' class='form-control'");?></td>
        </tr>
        <tr>
          <th></th>
          <td><?php echo html::submitButton();?></td>
        </tr>
      </table>
    </form>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>
