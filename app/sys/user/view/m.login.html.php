<?php
/**
 * The login mobile view file of user module of RanZhi.
 *
 * @copyright   Copyright 2009-2016 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv12.html)
 * @author      Hao Sun <sunhao@cnezsoft.com>
 * @package     user 
 * @version     $Id: login.html.php 3633 2016-02-23 09:21:34Z daitingting $
 * @link        http://www.ranzhico.com
 */
?>

<?php
include '../../common/view/m.header.lite.html.php';
js::import($webRoot . 'js/md5.js');
js::set('scriptName', $_SERVER['SCRIPT_NAME']);
js::set('random', $this->session->random);
?>

<nav class='appnav affix dock-top nav justify-center' id='langs'>
  <?php foreach($config->langs as $key => $value):?>
    <a href='###' data-value='<?php echo $key; ?>'<?php if($key === $this->app->getClientLang()) echo ' class="active"' ?>><?php echo $value; ?></a>
  <?php endforeach;?>
</nav>

<div class='page with-appbar-top'>
  <div id='login' class='column fluid-v no-margin'>
    <div class='cell gray'>
      <div class='tile flex-center flex flex-column article'>
        <img src='<?php echo $webRoot . 'mobile/img/logo.png' ?>' alt='<?php echo $lang->ranzhi ?>'>
        <h4 class='lead'><?php printf($lang->welcome, isset($config->company->name) ? $config->company->name : '');?></h4>
      </div>
    </div>
    <div class='cell box'>
      <div class='tile flex-center flex flex-column'>
        <form method='post' id='loginForm'>
          <div class='control box danger form-message hide-empty'></div>
          <div class='control has-label-left fluid'>
            <input autofocus id='account' name='account' type='text' class='input' placeholder='<?php echo $lang->user->inputAccountOrEmail ?>'>
            <label for='account' title='<?php echo $lang->user->account;?>'><i class='icon-user'></i></label>
            <p class='help-text'></p>
          </div>
          <div class='control has-label-left fluid'>
            <input id='password' name='password' type='password' class='input' placeholder='<?php echo $lang->user->password ?>'>
            <label for='password' title='<?php echo $lang->user->password;?>'><i class='icon-lock'></i></label>
            <p class='help-text'></p>
          </div>
          <div class='flex flex-row space-between fluid'>
            <div class='control'>
              <button type='submit' class='btn primary'><?php echo $lang->login ?></button>
            </div>
            <div class='control'>
              <div class='checkbox'>
                <input type='checkbox' name='keepLogin' value='on'>
                <label for='keepLogin'><?php echo $lang->user->keepLogin ?></label>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include '../../common/view/m.footer.html.php';?>
