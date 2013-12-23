<?php
/**
 * The html template file of step4 method of install module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     install 
 * @version     $Id: step4.html.php 2605 2013-12-23 09:12:58Z wwccss $
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.lite.html.php';?>
<div class='container'>
  <?php if(isset($error)):?>
  <table class='table table-bordered shadow'>
	<caption><?php echo $lang->install->error;?></caption>
    <tr><td class='red'><?php echo $error;?></td></tr>
    <tr><td class='a-center'><?php echo html::backButton($lang->install->pre, 'btn btn-primary');?></td></tr>
  </table>
  <?php else:?>
  <form method='post'>
  <table class='table table-bordered shadow'>
	<caption><?php echo $lang->install->setAdmin;?></caption>
    <tr valign='middle'>
      <th class='a-right w-100px'><?php echo $lang->install->account;?></th>
      <td><?php echo html::input('account', '', 'class="text-2"');?></td>
	</tr>
    <tr>
      <th class='a-right'><?php echo $lang->install->password;?></th>
      <td><?php echo html::input('password', '', 'class="text-2"');?></td>
	</tr>
    <tr><td colspan='2' class='a-center'><?php echo html::submitButton();?></td></tr>
  </table>
  </form>
  <?php endif;?>
</div>
<?php include './footer.html.php';?>
