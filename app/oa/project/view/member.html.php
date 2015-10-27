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
      <td><?php echo html::select("member[$key]", $users, $member->account, "class='form-control chosen' onchange='updateMember()'")?></td>
      <td class='w-180px text-center'><?php echo html::radio("role[$key]", $lang->project->roleList, $member->role)?></td>
      <td class='w-100px'></td>
    </tr>
    <?php $key++;?>
    <?php endforeach;?>
    <?php for($i = 0; $i < 3; $i++):?>
    <tr>
      <td><?php echo html::select("member[$key]", $users, '', "class='form-control chosen' onchange='updateMember()'")?></td>
      <td class='w-180px text-center'><?php echo html::radio("role[$key]", $lang->project->roleList, 'member')?></td>
      <td class='w-100px'><i class='btn btn-mini icon-plus'></i> <i class='btn btn-mini icon-minus'></i></td>
    </tr>
    <?php $key++;?>
    <?php endfor;?>
  </table>
<div class='alert alert-info'>
  <?php foreach($lang->project->roleTips as $roleTip):?>
  <p><?php echo $roleTip;?></p>
  <?php endforeach;?>
</div>
<div class='text-center'><?php echo html::submitButton();?></div>
</form>
<table class='hidden'>
  <tbody id='hiddenMember'>
    <tr>
      <td><?php echo html::select("member[key]", $users, '', "class='form-control' onchange='updateMember()'")?></td>
      <td class='w-180px text-center'><?php echo html::radio("role[key]", $lang->project->roleList, 'member')?></td>
      <td class='w-100px'><i class='btn btn-mini icon-plus'></i> <i class='btn btn-mini icon-minus'></i></td>
    </tr>
  </tbody>
</table>
<?php js::set('key', $key);?>
<?php js::set('manager', $project->PM);?>
<?php js::set('roleTips', $lang->project->roleTips);?>
<?php include '../../../sys/common/view/footer.modal.html.php';?>
