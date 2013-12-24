<?php
/**
 * The create view of entry module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     entry 
 * @version     $Id$
 * @link        http://www.zentao.net
 */
include '../../common/view/header.admin.html.php';
?>
<div class='panel'>
  <div class='panel-heading'>
    <strong><i class='icon-building'></i> <?php echo $lang->entry->create;?></strong>
  </div>
  <div class='panel-body'>
    <form method='post' class='form form-horizontal' id='ajaxForm'>
      <div class="form-group">
        <label for='name' class='col-md-2 col-sm-3 control-label'><?php echo $lang->entry->name;?></label>
        <div class='col-md-4 col-sm-6'>
          <?php 
          echo html::input('name', '', "class='form-control' placeholder='{$lang->entry->note->name}'");
          echo "<span><input type='checkbox' name='visible' value='1'>{$lang->entry->note->visible}</span>";
          ?>
        </div>
      </div>
      <div class="form-group">
        <label for='code' class='col-md-2 col-sm-3 control-label'><?php echo $lang->entry->code;?></label>
        <div class='col-md-4 col-sm-6'>
          <?php echo html::input('code', '', "class='form-control' placeholder='{$lang->entry->note->code}'");?>
        </div>
      </div>
      <div class="form-group">
        <label for='open' class='col-md-2 col-sm-3 control-label'><?php echo $lang->entry->open;?></label>
        <div class='col-md-4 col-sm-6'><?php echo html::select('open', $lang->entry->openList, '', 'class="form-control"');?></div>
      </div>
      <div class="form-group">
        <label for='key' class='col-md-2 col-sm-3 control-label'><?php echo $lang->entry->key;?></label>
        <div class='col-md-4 col-sm-6'>
          <?php echo html::input('key', $key, "class='form-control' readonly='readonly'");?>
          <?php echo html::a('javascript:void(0)', $lang->entry->createKey, 'onclick="createKey()"')?>
        </div>
      </div>
      <div class="form-group">
        <label for='login' class='col-md-2 col-sm-3 control-label'><?php echo $lang->entry->login;?></label>
        <div class='col-md-4 col-sm-6'><?php echo html::input('login', '', "class='form-control' placeholder='{$lang->entry->note->login}'");?></div>
      </div>
      <div class="form-group">
        <label for='login' class='col-md-2 col-sm-3 control-label'><?php echo $lang->entry->logout;?></label>
        <div class='col-md-4 col-sm-6'><?php echo html::input('logout', '', "class='form-control' placeholder='{$lang->entry->note->logout}'");?></div>
      </div>
      <div class="form-group">
        <label for='ip' class='col-md-2 col-sm-3 control-label'><?php echo $lang->entry->ip;?></label>
        <div class='col-md-4 col-sm-6'><?php echo html::input('ip', '', "class='form-control' placeholder='{$lang->entry->note->ip}'");?></div>
      </div>
      <div class="form-group">
        <label for='ip' class='col-md-2 col-sm-3 control-label'><?php echo $lang->entry->logo;?></label>
        <div class='col-md-4 col-sm-6'><input type='file' name='logo' id='logo' /></div>
      </div>
      <div class="form-group">
        <div class='col-md-4 col-sm-6 col-md-offset-2 col-sm-offset-3'><?php echo html::submitButton() . html::backButton();?></div>
      </div>
    </form>
  </div>
</div>
<div class="instruction"><?php echo $lang->entry->instruction;?></div>
<?php include '../../common/view/footer.admin.html.php';?>
