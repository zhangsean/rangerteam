<?php
/**
 * The privilege view file of project module of RanZhi.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv11.html)
 * @author      chujilu<chujilu@cnezsoft.com>
 * @package     project 
 * @version     $Id$
 * @link        http://www.ranzhico.com
 */
?>
<?php include '../../../sys/common/view/header.modal.html.php';?>
<?php include '../../../sys/common/view/kindeditor.html.php';?>
<?php include '../../../sys/common/view/datepicker.html.php';?>
<?php include '../../../sys/common/view/chosen.html.php';?>
<form method='post' id='ajaxForm' action='<?php echo inlink('privilege', "projectID={$project->id}")?>' class='form-inline'>
  <fieldset>
    <legend><?php echo $lang->project->common?></legend>
    <table class='table-form w-p90'>
      <tr>
        <th class='w-100px'><?php echo $lang->project->acl;?></th>
        <td colspan='2'><?php echo nl2br(html::radio('acl', $lang->project->aclList, $project->acl, "onclick='whitelistBox(this);'", 'block'));?></td>
      </tr>  
      <tr id='whitelistBox' class='hidden'>
        <th><?php echo $lang->project->whitelist;?></th>
        <td colspan='2'><?php echo html::checkbox('whitelist', $groups, $project->whitelist);?></td>
      </tr>
    </table>
  </fieldset>
  <fieldset>
    <legend><?php echo $lang->project->task?></legend>
    <table class='table-form w-p90'>
      <tr id='editListBox'>
        <th class='w-100px'><?php echo $lang->project->editTask;?></th>
        <td colspan='2'>
          <?php foreach($project->members as $account):?>
          <label class='checkbox?>' id='edituser<?php echo $account?>'>
            <input type='checkbox' name='editList[]' value='<?php echo $account?>' <?php echo in_array($account, $project->editList) ? "checked='checked'" : ''?> onChange='updateChecked(this);' />
            <?php echo zget($users, $account);?>
          </label>
          <?php endforeach;?>
        </td>
      </tr>  
      <tr id='viewListBox'>
        <th><?php echo $lang->project->viewTask;?></th>
        <td colspan='2'>
          <?php foreach($project->members as $account):?>
          <label class='checkbox?>' id='viewuser<?php echo $account?>'>
            <input type='checkbox' name='viewList[]' value='<?php echo $account?>' <?php echo in_array($account, $project->viewList) ? "checked='checked'" : ''?> onChange='updateChecked(this);' />
            <?php echo zget($users, $account);?>
          </label>
          <?php endforeach;?>
        </td>
      </tr>  
    </table>
  </fieldset>
  <div class='text-center w-p100'><?php echo html::submitButton();?></div>
</form>
<?php include '../../../sys/common/view/footer.modal.html.php';?>
