<?php
/**
 * The login admin view file of user module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     user 
 * @version     $Id: login.admin.html.php 2605 2013-12-23 09:12:58Z wwccss $
 * @link        http://www.zentao.net
 */
include '../../common/view/header.lite.html.php';
js::import($jsRoot . 'md5.js');
js::set('scriptName', $_SERVER['SCRIPT_NAME']);
js::set('random', $this->session->random);
css::internal('body{background-color:#f6f5f5}');
?> 
<div class='container'>
  <div id='adminLogin'>
    <form method='post' id='ajaxForm'>
      <div id='logo' class='text-center'><?php echo html::image("$themeRoot/default/images/main/logo.login.png");?></div>
      <div id='responser' class='text-center'></div>
      <?php echo html::input('account','',"class='form-control' placeholder='{$lang->user->inputAccountOrEmail}'");?>
      <?php echo html::password('password','',"class='form-control' placeholder='{$lang->user->inputPassword}'");?>
      <?php echo html::hidden('referer', $referer);?>
      <?php echo html::submitButton($lang->user->login->common, 'btn btn-primary btn-block');?>
    </form>
  </div>
</div>
<?php
if($config->debug) js::import($jsRoot . 'jquery/form/min.js');
if(isset($pageJS)) js::execute($pageJS);
?>
</body>
</html>
