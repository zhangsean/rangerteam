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
      <form method='post' id='ajaxForm' class='form form-horizontal'>
        <div class='form-group'>
          <label for='realname' class='col-md-2 col-sm-3 control-label'><?php echo $lang->user->realname;?></label>
          <div class='col-md-4 col-sm-6'>
            <?php echo html::input('realname', $user->realname, "class='form-control'");?>
          </div>
        </div>
        <div class='form-group'>
          <label for='email' class='col-md-2 col-sm-3 control-label'><?php echo $lang->user->email;?></label>
          <div class='col-md-4 col-sm-6'>
            <?php echo html::input('email', $user->email, "class='form-control'");?>
          </div>
        </div>
        <div class='form-group'>
          <label for='password' class='col-md-2 col-sm-3 control-label'><?php echo $lang->user->password;?></label>
          <div class='col-md-4 col-sm-6'>
            <?php echo html::password('password1', '', "class='form-control'");?>
          </div>
        </div>
        <div class='form-group'>
          <label for='password2' class='col-md-2 col-sm-3 control-label'><?php echo $lang->user->password2;?></label>
          <div class='col-md-4 col-sm-6'>
            <?php echo html::password('password2', '', "class='form-control'");?>
          </div>
        </div>
        <div class='form-group'>
          <label for='address' class='col-md-2 col-sm-3 control-label'><?php echo $lang->user->address;?></label>
          <div class='col-md-4 col-sm-6'>
            <?php echo html::input('address', $user->address, "class='form-control'");?>
          </div>
        </div>
        <div class='form-group'>
          <label for='zipcode' class='col-md-2 col-sm-3 control-label'><?php echo $lang->user->zipcode;?></label>
          <div class='col-md-4 col-sm-6'>
            <?php echo html::input('zipcode', $user->zipcode, "class='form-control'");?>
          </div>
        </div>
        <div class='form-group'>
          <label for='mobile' class='col-md-2 col-sm-3 control-label'><?php echo $lang->user->mobile;?></label>
          <div class='col-md-4 col-sm-6'>
            <?php echo html::input('mobile', $user->mobile, "class='form-control'");?>
          </div>
        </div>
        <div class='form-group'>
          <label for='phone' class='col-md-2 col-sm-3 control-label'><?php echo $lang->user->phone;?></label>
          <div class='col-md-4 col-sm-6'>
            <?php echo html::input('phone', $user->phone, "class='form-control'");?>
          </div>
        </div>
        <div class='form-group'>
          <label for='qq' class='col-md-2 col-sm-3 control-label'><?php echo $lang->user->qq;?></label>
          <div class='col-md-4 col-sm-6'>
            <?php echo html::input('qq', $user->qq, "class='form-control'");?>
          </div>
        </div>
        <div class='form-group'>
          <label for='gtalk' class='col-md-2 col-sm-3 control-label'><?php echo $lang->user->gtalk;?></label>
          <div class='col-md-4 col-sm-6'>
            <?php echo html::input('gtalk', $user->gtalk, "class='form-control'");?>
          </div>
        </div>
        <div class='form-group'>
          <div class='col-md-4 col-sm-6 col-md-offset-2 col-sm-offset-3'><?php echo html::submitButton();?></div>
        </div>
      </form>
    </div>
  </div>
</div>
<?php include '../../common/view/footer.lite.html.php';?>
</body>
</html>
