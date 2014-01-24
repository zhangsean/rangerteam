<?php include '../../common/view/header.html.php';?>
<form id='ajaxForm' method='post'>
<div class='panel'>
  <div class='panel-heading'><strong><i class='icon-list-ul'></i> <?php echo $lang->product->roles;?></strong></div>
  <table class='table'>
    <tbody>
      <?php if($roles):?>
      <?php foreach($roles as $key => $role):?>
      <tr class='text-center text-middle'>
        <td><?php echo html::input("roles[$key]", $role, "class='form-control'");?></td>
      </tr>
      <?php endforeach;?>
      <?php endif;?>

      <?php for($i = 0; $i < PRODUCT::NEW_ROLE_COUNT ; $i ++):?>
      <tr>
        <td><?php echo html::input("roles[]", '', "class='form-control'");?></td>
      </tr>
      <?php endfor;?>
    </tbody>
    <tfoot>
      <tr>
        <td><?php echo html::submitButton();?></td>
      </tr>
    </tfoot>
  </table>
</div>
</form>
<?php include '../../common/view/footer.html.php';?>
