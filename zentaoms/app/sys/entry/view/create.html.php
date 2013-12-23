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
<form method='post' class='form-inline' id='ajaxForm'>
  <table class='table table-form'> 
    <caption><?php echo $lang->entry->create;?></caption>
    <tr>
      <th class='rowhead'><?php echo $lang->entry->name;?></th>
      <td>
        <?php 
        echo html::input('name', '', "class='text-3' placeholder='{$lang->entry->note->name}'");
        echo "<span><input type='checkbox' name='visible' value='1'>{$lang->entry->note->visible}</span>";
        ?>
      </td>
    </tr>
    <tr>
      <th class='rowhead'><?php echo $lang->entry->code;?></th>
      <td><?php echo html::input('code', '', "class='text-3' placeholder='{$lang->entry->note->code}'");?></td>
    </tr>
    <tr>
      <th class='rowhead'><?php echo $lang->entry->open;?></th>
      <td><?php echo html::select('open', $lang->entry->openList, '','class="select-3 form-control"');?></td>
    </tr>
    <tr>
      <th class='rowhead'><?php echo $lang->entry->key;?></th>
      <td>
        <?php echo html::input('key', $key, "class='text-3' readonly='readonly'");?>
        <?php echo html::a('javascript:void(0)', $lang->entry->createKey, 'onclick="createKey()"')?>
      </td>
    </tr>
    <tr>
      <th class='rowhead'><?php echo $lang->entry->login;?></th>
      <td><?php echo html::input('login', '', "class='text-5' placeholder='{$lang->entry->note->login}'");?></td>
    </tr>
    <tr>
      <th class='rowhead'><?php echo $lang->entry->logout;?></th>
      <td><?php echo html::input('logout', '', "class='text-5' placeholder='{$lang->entry->note->logout}'");?></td>
    </tr>
    <tr>
      <th class='rowhead'><?php echo $lang->entry->ip;?></th>
      <td><?php echo html::input('ip', '', "class='text-5' placeholder='{$lang->entry->note->ip}'");?></td>
    </tr>
    <tr>
      <th class='rowhead'><?php echo $lang->entry->logo;?></th>
      <td><input type='file' name='logo' id='logo' /></td>
    </tr>
    <tr><td></td><td colspan='2' class='a-left'><?php echo html::submitButton() . html::backButton();?></td></tr>
  </table>
</form>
<div class="instruction"><?php echo $lang->entry->instruction;?></div>
<?php include '../../common/view/footer.admin.html.php';?>
