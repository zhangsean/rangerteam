<?php
/**
 * The edit admin view file of user module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     user 
 * @version     $Id: edit.admin.html.php 2605 2013-12-23 09:12:58Z wwccss $
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.admin.html.php';?>
<div class='clearfix'>
  <div class='col-md-2'>
    <div class='panel'>
      <div class="panel-heading"><strong> <?php echo $lang->dept->common;?></strong></div>
      <table class='table table-striped'>
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
  </div>
  <div class='col-md-10'>
    <div class="panel">
      <div class="panel-heading"><strong><i class="icon-edit"></i> <?php echo $lang->user->editProfile;?></strong></div>
      <form method='post' id='ajaxForm' class='form form-inline'>
        <table class='table table-form table-bordered'>
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
            <td><?php echo html::select('role', $lang->user->roleList, '', "class='select-3'");?></td>
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
</div>
<?php include '../../common/view/footer.admin.html.php';?>
