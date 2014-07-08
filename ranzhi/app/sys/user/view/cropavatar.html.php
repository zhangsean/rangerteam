<?php
/**
 * The crop avatar view file of user module of RanZhi.
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
<form method='post' id='editForm' action="<?php echo inlink('cropAvatar', "account={$user->account}");?>" class='form-condensed'>
  <table class='table table-form'>
    <tr>
      <td>
        <div class="img-cutter fixed-ratio" id="imgCutter">
          <div class="canvas">
          <?php
          if(empty($user->avatar))
          {
              echo html::image($themeRoot . 'default/images/ips/avatar.png', "class='avatar-img'");
          }
          else
          {
              echo html::image($user->avatar, "class='avatar-img'");
          }
          ?>
          </div>
          <div class="actions">
            <h5><?php echo $lang->user->cropAvatarTip;?></h5>
            <div class="img-cutter-preview"></div>
            <?php echo html::submitButton('', 'btn btn-primary img-cutter-submit');?> <?php echo html::a(inlink('profile'), $lang->goback, "class='btn loadInModal'");?>
          </div>
        </div>
      </td>
    </tr>
  </table>
</form>
<script>
$("#imgCutter").imgCutter({fixedRatio: true});
</script>
<?php include '../../common/view/footer.modal.html.php';?>
