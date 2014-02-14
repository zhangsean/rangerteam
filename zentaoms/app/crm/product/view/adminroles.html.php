<?php include '../../common/view/header.html.php';?>
<form id='ajaxForm' method='post'>
<div class='panel'>
  <div class='panel-heading'><strong><i class='icon-list-ul'></i> <?php echo $lang->product->roles;?></strong></div>
  <table class='table table-form'>
    <tbody>
      <?php foreach($roles as $value => $text):?>
      <tr>
        <td>
          <div class="input-group w-700px">
            <?php echo html::input('code[]', $value, "class='form-control' placeholder={$lang->product->roleCode}");?>
            <span class='input-group-addon'>:</span>
            <?php echo html::input('name[]', $text, "class='form-control' placeholder={$lang->product->roleName}");?>
            <div class='input-group-btn'>
              <i class='icon-plus-sign icon-large'></i>
              <i class='icon-minus-sign icon-large'></i>
            </div>
          </div> 
        </td>
      </tr>
      <?php endforeach;?>
    </tbody>
    <tfoot><tr><td><?php echo html::submitButton();?></td></tr></tfoot>
  </table>
</div>
</form>

<?php /* Hidden role form tr for js. */ ?>
<table id='roleGroup' class='hide'>
  <tr>
    <td>
      <div class="input-group w-700px">
        <?php echo html::input('code[]', '', "class='form-control' placeholder={$lang->product->roleCode}");?>
        <span class='input-group-addon'>:</span>
        <?php echo html::input('name[]', '', "class='form-control' placeholder={$lang->product->roleName}");?>
        <div class='input-group-btn'>
          <i class='icon-plus-sign icon-large'></i>
          <i class='icon-minus-sign icon-large'></i>
        </div>
      </div> 
    </td>
  </tr>
</table>

<?php include '../../common/view/footer.html.php';?>
