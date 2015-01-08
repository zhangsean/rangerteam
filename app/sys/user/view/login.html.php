<?php
/**
 * The login view file of user module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     user 
 * @version     $Id$
 * @link        http://www.ranzhico.com
 */
?>
<?php
include '../../common/view/header.lite.html.php';
js::import($jsRoot . 'md5.js');
js::set('scriptName', $_SERVER['SCRIPT_NAME']);
js::set('random', $this->session->random);
css::internal('body{background-color:#f6f5f5}');
?> 
<div class='container'>
  <div id='login'>
    <div class='panel-head'>
      <h4><?php printf($lang->welcome, $config->company->name);?></h4>
      <div class='panel-actions'>
        <div class='dropdown' id='langs'>
          <button class='btn' data-toggle='dropdown' title='Change Language/更换语言/更換語言'><?php echo $config->langs[$this->app->getClientLang()]; ?> <span class="caret"></span></button>
          <ul class='dropdown-menu'>
            <?php foreach($config->langs as $key => $value):?>
            <li class="<?php echo $key==$this->app->getClientLang()?'active':''; ?>"><a href="###" data-value="<?php echo $key; ?>"><?php echo $value; ?></a></li>
            <?php endforeach;?>
          </ul>
        </div>
      </div>
    </div>
    <div class="panel-body" id="loginForm">
      <form method='post' target='hiddenwin' class='form-condensed'>
        <div id='responser' class='text-center'></div>
        <div class='row'>
          <div class='col-xs-4 text-center'>
          <?php echo html::image($this->config->webRoot . 'theme/default/images/main/logo.png'); ?>
          </div>
          <div class='col-xs-8'>
            <table class='table table-form'>
              <tr>
                <th><?php echo $lang->user->account;?></th>
                <td><?php echo html::input('account','',"class='form-control' placeholder='{$lang->user->inputAccountOrEmail}'");?></td>
              </tr>
              <tr>
                <th><?php echo $lang->user->password;?></th>
                <td><?php echo html::password('password','',"class='form-control' placeholder='{$lang->user->inputPassword}'");?></td>
              </tr>
              <tr>
                <th></th>
                <td><?php echo html::submitButton($lang->login) . html::hidden('referer', $referer);?></td>
              </tr>
            </table>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<?php
if($config->debug) js::import($jsRoot . 'jquery/form/min.js');
if(isset($pageJS)) js::execute($pageJS);
?>
</body>
</html>
