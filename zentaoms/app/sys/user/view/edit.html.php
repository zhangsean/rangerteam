<?php
/**
 * The edit view file of user module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     user 
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.lite.html.php';?>
<div class="page-user-control">
  <div class='panel'>
    <div class='panel-body'>
      <form method='post' id='ajaxForm' class='form-inline form-horizontal'>
        <table class='table table-form'>
          <tr>
            <th style='width:100px;'><?php echo $lang->user->realname;?></th>
            <td><?php echo html::input('realname', $user->realname, "class='form-control'");?></td>
          </tr>
          <tr>
            <th><?php echo $lang->user->email;?></th>
            <td><?php echo html::input('email', $user->email, "class='form-control'");?></td>
          </tr>
          <tr>
            <th><?php echo $lang->user->password;?></th>
            <td><?php echo html::password('password1', '', "class='form-control'");?></td>
          </tr>
          <tr>
            <th><?php echo $lang->user->password2;?></th>
            <td><?php echo html::password('password2', '', "class='form-control'");?></td>
          </tr>
          <tr>
            <th><?php echo $lang->user->address;?></th>
            <td><?php echo html::input('address', $user->address, "class='form-control'");?></td>
          </tr>
          <tr>
            <th><?php echo $lang->user->zipcode;?></th>
            <td><?php echo html::input('zipcode', $user->zipcode, "class='form-control'");?></td>
          </tr>
          <tr>
            <th><?php echo $lang->user->mobile;?></th>
            <td><?php echo html::input('mobile', $user->mobile, "class='form-control'");?></td>
          </tr>
          <tr>
            <th><?php echo $lang->user->phone;?></th>
            <td><?php echo html::input('phone', $user->phone, "class='form-control'");?></td>
          </tr>
          <tr>
            <th><?php echo $lang->user->qq;?></th>
            <td><?php echo html::input('qq', $user->qq, "class='form-control'");?></td>
          </tr>
          <tr>
            <th><?php echo $lang->user->gtalk;?></th>
            <td><?php echo html::input('gtalk', $user->gtalk, "class='form-control'");?></td>
          </tr>
          <tr>
            <th></th>
            <td><?php echo html::submitButton();?></td>
          </tr>
        </table>
      </form>
    </div>
  </div>
</div>
<?php include '../../common/view/footer.lite.html.php';?>
</body>
</html>
