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
<div class='panel'>
  <div class='panel-heading'>
    <strong><i class="icon-group"></i> <?php echo $lang->project->browse;?></strong>
    <div class='panel-actions pull-right'>
      <?php echo html::a(inlink('create'), "<i class='icon-plus'></i> {$lang->project->create}", "class='btn btn-primary' data-toggle='modal'")?>
    </div>
  </div>
  <div class='panel-body'>
    <div class="cards">
      <?php foreach($projects as $project):?>
      <div class='col-md-4 col-sm-6'>
        <div class='panel project-block'>
          <div class='panel-heading'>
            <strong><?php echo $project->name;?></strong>
            <div class='panel-action pull-right'>
              <?php echo html::a(helper::createLink('task', 'browse', "projectID=$project->id"), $lang->project->tasks);?>
              <?php echo html::a(inlink('edit', "projectID=$project->id"), $lang->edit, "data-toggle='modal'");?>
              <?php if($project->status == 'doing'):?>
              <?php echo html::a(inlink('finish', "projectID=$project->id"), $lang->finish, "data-toggle='modal'");?>
              <?php else:?>
              <?php echo html::a(inlink('activate', "projectID=$project->id"), $lang->activate, "class='activater'");?>
              <?php endif?>
            </div>
          </div>
          <div class='panel-body'>
            <div class='text-important'> <?php echo $project->begin . ' - ' . $project->end;?> </div>
            <div class='info'><?php echo $project->desc;?></div>
          </div>
        </div>
      </div>
      <?php endforeach;?>
    </div>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>
