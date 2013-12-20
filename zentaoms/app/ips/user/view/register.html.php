<?php include '../../common/view/header.html.php';?>
<section id="reg">
  <div class="box-radius">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h2><?php echo $lang->user->register->welcome;?></h2>
      </div>
      <div class="panel-body">
        <form method='post' id='ajaxForm' class='form-inline form-horizontal' role="form">
          <table> 
            <tr>
              <th class='w-100px'><?php echo $lang->user->account;?></th>
              <td><?php echo html::input('account', '', "class='text-box' autocomplete='off' placeholder='" . $lang->user->register->lblAccount . "'");?></td>
            </tr>  
            <tr>
              <th><?php echo $lang->user->realname;?></th>
              <td><?php echo html::input('realname', '', "class='text-box'");?></td>
            </tr>
            <tr>
              <th><?php echo $lang->user->email;?></th>
              <td><?php echo html::input('email', '', "class='text-box' autocomplete='off'") . '';?></td>
            </tr> 
            <tr>
              <th><?php echo $lang->user->password;?></th>
              <td><?php echo html::password('password1', '', "class='text-box' autocomplate='off' placeholder='" . $lang->user->register->lblPassword . "'");?></td>
            </tr>  
            <tr>
              <th><?php echo $lang->user->password2;?></th>
              <td><?php echo html::password('password2', '', "class='text-box'");?></td>
            </tr>  
            <tr>
              <th><?php echo $lang->user->company;?></th>
              <td><?php echo html::input('company', '', "class='text-box'");?></td>
            </tr>
            <tr>
              <th><?php echo $lang->user->phone;?></th>
              <td><?php echo html::input('phone', '', "class='text-box'");?></td>
            </tr>  
            <tr>
              <th></th>
              <td><?php echo html::submitButton($lang->register,'btn btn-primary btn-block') . html::hidden('referer', $referer);?></td>
            </tr>
          </table>
        </form>      
      </div>
    </div>  
  </div>
</section>
<?php include '../../common/view/footer.html.php'; ?>
