<?php
/**
 * The resetpassword view file of user module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     user 
 * @version     $Id: resetpassword.html.php 2605 2013-12-23 09:12:58Z wwccss $
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php';?>
<section id="reset">
  <div class="box-radius">
    <div class="panel panel-default">
      <div class="panel-heading"><h4><strong><?php echo $lang->user->recoverPassword;?></strong></h4></div>
      <div class="panel-body">
        <form method='post' id='ajaxForm'>
          <table> 
            <tr>
              <td><?php echo html::input('account', '', "class='text-box' placeholder='{$lang->user->inputAccountOrEmail}'");?></td>
            </tr>
            <tr>
              <td><?php echo html::submitButton($lang->user->submit,'btn btn-primary btn-block');?></td>
            </tr>
          </table>
        </form>
      </div>
    </div>  
  </div>
</section>
<?php include '../../common/view/footer.html.php';?>
