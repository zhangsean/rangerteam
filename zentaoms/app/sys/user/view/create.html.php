<?php include '../../common/view/header.admin.html.php';?>
<div class="col-md-12">
  <div class='col-md-2'>
    <table class='table table-striped'>
      <caption><?php echo $lang->dept->common?></caption>
      <tr>
        <td>
        <?php
        echo $treeMenu;
        echo html::a($this->createLink('tree', 'browse', "type=dept"), $lang->dept->edit, "class='pull-right'");
        ?>
        </td>
      </tr>
    </table>
  </div>
  <div class='col-md-10'>
    <form method='post' id='ajaxForm' class='form-inline form-horizontal' role="form">
      <table class='table table-form table-bordered'>
        <caption><?php echo $lang->user->create?></caption>
        <tr>
          <th><?php echo $lang->user->dept;?></th>
          <td><?php echo html::select('dept', $depts, '', "class='select-3'");?></td>
        </tr>  
        <tr>
          <th class='w-100px'><?php echo $lang->user->account;?></th>
          <td><?php echo html::input('account', '', "class='text-3'");?></td>
        </tr>  
        <tr>
          <th class='w-100px'><?php echo $lang->user->realname;?></th>
          <td><?php echo html::input('realname', '', "class='text-3'");?></td>
        </tr>  
        <tr>
          <th><?php echo $lang->user->email;?></th>
          <td><?php echo html::input('email', '', "class='text-3'");?></td>
        </tr>  
        <tr>
          <th><?php echo $lang->user->password;?></th>
          <td><?php echo html::password('password1', '', "class='text-3' autocomplete='off'")?></td>
        </tr>  
        <tr>
          <th><?php echo $lang->user->password2;?></th>
          <td><?php echo html::password('password2', '', "class='text-3'");?></td>
        </tr>  
        <tr>
          <th><?php echo $lang->user->role;?></th>
          <td><?php echo html::select('role', $lang->user->roleList, '', "class='select-3'");?></td>
        </tr>  
        <tr>
          <th><?php echo $lang->user->gendar;?></th>
          <td><?php unset($lang->user->gendarList->u); echo html::radio('gendar', $lang->user->gendarList, '');?></td>
        </tr>  
        <tr>
          <th><?php echo $lang->user->company;?></th>
          <td><?php echo html::input('company', $config->company->name, "class='text-3'");?></td>
        </tr>  
        <tr>
          <th><?php echo $lang->user->address;?></th>
          <td><?php echo html::input('address', '', "class='text-3'");?></td>
        </tr>  
        <tr>
          <th><?php echo $lang->user->mobile;?></th>
          <td><?php echo html::input('mobile', '', "class='text-3'");?></td>
        </tr>  
        <tr>
          <th><?php echo $lang->user->phone;?></th>
          <td><?php echo html::input('phone', '', "class='text-3'");?></td>
        </tr>  
        <tr>
          <th><?php echo $lang->user->qq;?></th>
          <td><?php echo html::input('qq', '', "class='text-3'");?></td>
        </tr>  
        <tr>
          <th><?php echo $lang->user->gtalk;?></th>
          <td><?php echo html::input('gtalk', '', "class='text-3'");?></td>
        </tr>  
        <tr><th></th><td><?php echo html::submitButton();?></td></tr>
      </table>
    </form>      
  </div>
</div>
<?php include '../../common/view/footer.admin.html.php'; ?>
