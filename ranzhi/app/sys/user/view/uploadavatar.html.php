<?php
/**
 * The upload avatar view file of user module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     user 
 * @version     $Id: profile.html.php 8669 2014-05-02 07:58:48Z guanxiying $
 * @link        http://www.ranzhi.org
 */
?>
<?php include '../../common/view/header.modal.html.php';?>
<form method='post' action="<?php echo inlink('uploadAvatar', "account={$user->account}");?>" class='form-condensed' id='avatarForm' enctype='multipart/form-data'>
  <table class='table table-form'>
    <tr>
      <td><?php echo html::file('files', "class='form-control'");?></td>
    </tr>
    <tr>
      <td><?php echo html::submitButton();?> <?php echo html::a(inlink('profile'), $lang->goback, "class='btn loadInModal'");?> <?php echo html::a(inlink('cropAvatar'), '→', "class='btn loadInModal'");?></td>
    </tr>
  </table>
</form>
<?php include '../../common/view/footer.modal.html.php';?>
