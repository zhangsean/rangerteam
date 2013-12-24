<?php
/**
 * The edit view of entry module of ZenTaoMS.
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
    <strong><i class='icon-building'></i> <?php echo $lang->entry->edit;?></strong>
  </div>
  <div class='panel-body'>
    <form method='post' class='form form-horizontal' id='ajaxForm'>
      <div class="form-group">
        <label for='name' class='col-md-2 col-sm-3 control-label'><?php echo $lang->entry->name;?></label>
        <div class='col-md-4 col-sm-6'>
          <?php 
          echo html::input('name', $entry->name, "class='form-control'");
          $checked = $entry->visible ? 'checked="checked"' : ''; 
          echo "<span><input type='checkbox' name='visible' value='1' $checked>{$lang->entry->note->visible}</span>";
          ?>
        </div>
      </div>
      <div class="form-group">
        <label for='name' class='col-md-2 col-sm-3 control-label'><?php echo $lang->entry->code;?></label>
        <div class='col-md-4 col-sm-6'><?php echo $entry->code;?></div>
      </div>
      <div class="form-group">
        <label for='name' class='col-md-2 col-sm-3 control-label'><?php echo $lang->entry->open;?></label>
        <div class='col-md-4 col-sm-6'><?php echo html::select('open', $lang->entry->openList, $entry->open,'class="form-control"');?></div>
      </div>
      <div class="form-group">
        <label for='name' class='col-md-2 col-sm-3 control-label'><?php echo $lang->entry->key;?></label>
        <div class='col-md-4 col-sm-6'>
          <?php echo html::input('key', $entry->key, "class='form-control' readonly='readonly'");?>
          <?php echo html::a('javascript:void(0)', $lang->entry->createKey, 'onclick="createKey()"')?>
        </div>
      </div>
      <div class="form-group">
        <label for='name' class='col-md-2 col-sm-3 control-label'><?php echo $lang->entry->login;?></label>
        <div class='col-md-4 col-sm-6'><?php echo html::input('login', $entry->login, "class='form-control' placeholder='{$lang->entry->note->login}'");?></div>
      </div>
      <div class="form-group">
        <label for='name' class='col-md-2 col-sm-3 control-label'><?php echo $lang->entry->logout;?></label>
        <div class='col-md-4 col-sm-6'><?php echo html::input('logout', $entry->logout, "class='form-control' placeholder='{$lang->entry->note->logout}'");?></div>
      </div>
      <div class="form-group">
        <label for='name' class='col-md-2 col-sm-3 control-label'><?php echo $lang->entry->ip;?></label>
        <div class='col-md-4 col-sm-6'><?php echo html::input('ip', $entry->ip, "class='form-control'");?></div>
      </div>
      <div class="form-group">
        <label for='name' class='col-md-2 col-sm-3 control-label'><?php echo $lang->entry->logo;?></label>
        <div class='col-md-4 col-sm-6'><input type='file' name='logo' /></div>
      </div>
      <div class="form-group">
        <div class='col-md-4 col-sm-6 col-md-offset-2 col-sm-offset-3'><?php echo html::submitButton() . html::backButton();?></div>
      </div>
    </form>
  </div>
</div>
<?php include '../../common/view/footer.admin.html.php';?>
