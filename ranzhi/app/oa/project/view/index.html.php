<?php 
/**
 * The browse view file of project module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     project 
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php js::set('status', $status);?>
<?php foreach($projects as $project):?>
<div class='col-md-4 col-sm-6'>
  <div class='panel project-block'>
    <div class='panel-heading'>
      <strong><?php echo $project->name;?></strong>
      <div class='panel-action pull-right'>
      </div>
    </div>
    <div class='panel-body'>
      <div class='text-important'>
        <?php echo $lang->project->begin . $lang->colon . formatTime($project->begin);?> 
        <div class='pull-right'>
          <?php echo html::a(inlink('edit', "projectID=$project->id"), $lang->edit, "class='btn btn-xs' data-toggle='modal'");?>
          <?php if($project->status == 'doing'):?>
          <?php echo html::a(inlink('finish', "projectID=$project->id"), $lang->finish, "class='btn btn-xs' data-toggle='modal'");?>
          <?php else:?>
          <?php echo html::a(inlink('activate', "projectID=$project->id"), $lang->activate, "class='btn btn-xs' class='activater'");?>
          <?php endif?>
          <?php echo html::a(helper::createLink('task', 'browse', "projectID=$project->id"), $lang->project->enter, "class='btn btn-primary btn-xs'");?>
        </div>
      </div>
      <div class='text-important'><?php echo $lang->project->end   . $lang->colon . formatTime($project->end);?> </div>
      <div class='info'><?php echo $project->desc;?></div>
      <div class='text-important'>
        <?php if(!empty($project->members)):?>
        <?php echo $lang->project->member . $lang->colon;?>
        <?php foreach($project->members as $member):?>
          <?php echo "<span class='{$member->role}'>{$users[$member->account]}</span>";?>
        <?php endforeach;?>
        <?php endif;?>
      </div>
    </div>
  </div>
</div>
<?php endforeach;?>
<?php include '../../common/view/footer.html.php';?>
