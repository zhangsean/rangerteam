<?php
/**
 * The member view file of project module of Ranzhi.
 *
 * @copyright   Copyright 2009-2015 QingDao Nature Easy Soft Network Technology Co,LTD (www.cnezsoft.com)
 * @license     ZPL
 * @author      chujilu <chujilu@cnezsoft.com>
 * @package     project
 * @version     $Id$
 * @link        http://www.ranzhico.com
 */
?>
<?php include '../../../sys/common/view/header.modal.html.php';?>
<?php include '../../../sys/common/view/chosen.html.php';?>
<?php $key = 0;?>
<form id='ajaxForm' method='post' action='<?php echo $this->createLink('oa.project', 'member', "projectID={$project->id}")?>'>
  <table class='table table-form table-hover no-td-padding'>
    <?php foreach($project->members as $member):?>
    <?php if($member->role == 'manager') continue;?>
    <tr>
      <td class='w-120px'><?php echo html::select("member[$key]", $users, $member->account, "class='form-control chosen' onchange='updateMember()'")?></td>
      <td class='w-160px'><?php echo html::radio("role[$key]", $lang->project->roleList, $member->role, "onchange='updateRole()'")?></td>
      <td class='text-info'></td>
      <td class='w-60px'></td>
    </tr>
    <?php $key++;?>
    <?php endforeach;?>
    <?php for($i = 0; $i < 3; $i++):?>
    <tr>
      <td class='w-120px'><?php echo html::select("member[$key]", $users, '', "class='form-control chosen' onchange='updateMember()'")?></td>
      <td class='w-160px'><?php echo html::radio("role[$key]", $lang->project->roleList, 'member', "onchange='updateRole()'")?></td>
      <td class='text-info'></td>
      <td class='w-60px'><i class='btn btn-mini icon-plus'></i> <i class='btn btn-mini icon-minus'></i></td>
    </tr>
    <?php $key++;?>
    <?php endfor;?>
    <tr><td colspan='4' class='text-center'><?php echo html::submitButton()?></td></tr>
  </table>
</form>
<table class='hidden'>
  <tbody id='hiddenMember'>
    <tr>
      <td><?php echo html::select("member[key]", $users, '', "class='form-control' onchange='updateMember()'")?></td>
      <td><?php echo html::radio("role[key]", $lang->project->roleList, 'member', "onchange='updateRole()'")?></td>
      <td class='text-info'></td>
      <td class='w-60px'><i class='btn btn-mini icon-plus'></i> <i class='btn btn-mini icon-minus'></i></td>
    </tr>
  </tbody>
</table>
<?php js::set('key', $key);?>
<?php js::set('manager', $project->PM);?>
<?php js::set('roleTips', $lang->project->roleTips);?>
<?php include '../../../sys/common/view/footer.modal.html.php';?>
