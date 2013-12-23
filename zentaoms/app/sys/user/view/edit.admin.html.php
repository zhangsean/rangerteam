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
    <form method='post' id='ajaxForm' class='form form-inline'>
      <table class='table table-form table-bordered'>
        <caption><?php echo $lang->user->editProfile;?></caption>
        <tr>
          <th><?php echo $lang->user->dept;?></th>
          <td><?php echo html::select('dept', $depts, $user->dept, "class='select-3'");?></td>
        </tr>  
        <tr>
          <th class='w-100px'><?php echo $lang->user->realname;?></th>
          <td><?php echo html::input('realname', $user->realname, "class='text-3'");?></td>
        </tr>  
        <tr>
          <th class='w-100px'><?php echo $lang->user->admin;?></th>
          <td><input name='admin' type='checkbox' value='super' <?php if($user->admin == 'super') echo 'checked';?>></td>
        </tr>  
        <tr>
          <th><?php echo $lang->user->email;?></th>
          <td><?php echo html::input('email', $user->email, "class='text-3'");?></td>
        </tr>  
        <tr>
          <th><?php echo $lang->user->password;?></th>
          <td><?php echo html::password('password1', '', "class='text-3' autocomplete='off'") . $lang->user->control->lblPassword;?></td>
        </tr>  
        <tr>
          <th><?php echo $lang->user->password2;?></th>
          <td><?php echo html::password('password2', '', "class='text-3'");?></td>
        </tr>  
        <tr>
          <th><?php echo $lang->user->role;?></th>
          <td><?php echo html::select('role', $lang->user->roleList, $user->role, "class='select-3'");?></td>
        </tr>  
        <tr>
          <th><?php echo $lang->user->company;?></th>
          <td><?php echo html::input('company', $user->company, "class='text-3'");?></td>
        </tr>  
        <tr>
          <th><?php echo $lang->user->address;?></th>
          <td><?php echo html::input('address', $user->address, "class='text-3'");?></td>
        </tr>  
        <tr>
          <th><?php echo $lang->user->zipcode;?></th>
          <td><?php echo html::input('zipcode', $user->zipcode, "class='text-3'");?></td>
        </tr>  
        <tr>
          <th><?php echo $lang->user->mobile;?></th>
          <td><?php echo html::input('mobile', $user->mobile, "class='text-3'");?></td>
        </tr>  
        <tr>
          <th><?php echo $lang->user->phone;?></th>
          <td><?php echo html::input('phone', $user->phone, "class='text-3'");?></td>
        </tr>  
        <tr>
          <th><?php echo $lang->user->qq;?></th>
          <td><?php echo html::input('qq', $user->qq, "class='text-3'");?></td>
        </tr>  
        <tr>
          <th><?php echo $lang->user->gtalk;?></th>
          <td><?php echo html::input('gtalk', $user->gtalk, "class='text-3'");?></td>
        </tr>  
        <tr><th></th><td><?php echo html::submitButton();?></td></tr>
      </table>
    </form>
  </div>
</div>
<?php include '../../common/view/footer.admin.html.php';?>
