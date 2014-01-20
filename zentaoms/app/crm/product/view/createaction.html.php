<?php include '../../common/view/header.html.php';?>
<?php include $this->app->getBasePath() . 'app/sys/common/view/chosen.html.php';?>
<div class='panel'>
  <div class='panel-heading'>
    <strong><i class="icon-plus"></i> <?php echo $lang->product->action->create;?></strong>
  </div>
  <div class='panel-body'>
    <form method='post' id='ajaxForm'>
      <table class='table table-form'>
        <tr>
          <th class='w-100px'><?php echo $lang->product->action->name;?></th>
          <td colspan='2'><?php echo html::input('name', '', "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->product->action->action;?></th>
          <td colspan='2'><?php echo html::input('action', '', "class='form-control'");?></td>
        </tr>
        <tr>
          <th></th>
          <td colspan='2'><?php echo html::submitButton();?></td>
        </tr>
      </table>
    </form>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>
