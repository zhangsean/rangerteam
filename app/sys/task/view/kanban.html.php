<?php
/**
 * The view view file of task module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     task
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
?>
<?php include $app->getModuleRoot() . 'common/view/header.html.php';?>
<div class='row'>
  <div class='col-md-2'>
    <?php $this->loadModel('project')->setMenu($projects, $projectID);?>
  </div>
  <div class='col-md-10'>
    <div class='panel'>
      <div class='panel-heading'>
        <div class='panel-actions'>
          <div class="btn-group">
            <?php echo html::a($this->inlink('browse', "projectID=$projectID"), "<i class='icon-list-ul icon'></i> " . $lang->task->list, "class='btn'"); ?>
            <?php echo html::a($this->inlink('kanban', "projectID=$projectID"), "<i class='icon-columns icon'></i> " . $lang->task->kanban, "class='btn active'"); ?>
            <?php echo html::a($this->inlink('mind', "projectID=$projectID"), "<i class='icon-usecase icon'></i> " . $lang->task->mind, "class='btn'"); ?>
            <?php echo html::a($this->inlink('outline', "projectID=$projectID"), "<i class='icon-list-alt icon'></i> " . $lang->task->outline, "class='btn'"); ?>
          </div>
        </div>
        <div class='panel-actions pull-right'><?php echo html::a($this->inlink('create', "projectID=$projectID"), '<i class="icon-plus"></i> ' . $lang->task->create, 'class="btn btn-primary"');?></div>
      </div>
      <div class='panel-body boards-container'>
        <div class='boards task-boards'>
        <?php $colsWidth = 100/(count($lang->task->statusList) - 1); ?>
        <?php foreach ($lang->task->statusList as $key => $value):?>
        <?php if(empty($key)) continue; ?>
          <div class='board panel task-board'  data-id='<?php echo $key;?>' style="width: <?php echo $colsWidth;?>%">
            <div class='panel-heading'>
              <strong><?php echo $value?></strong>
            </div>
            <div class='panel-body'>
              <div class='board-list'>
                <?php foreach($tasks as $task):?>
                <?php if($task->status != $key) continue;?>
                <div class='board-item task task-pri-<?php echo $task->pri; ?>' data-id='<?php echo $task->id;?>'>
                  <div class='task-heading'>
                    <strong class='task-name'><?php echo $task->name;?></strong>
                  </div>
                  <div class='task-info clearfix'>
                  <?php if(!empty($task->assignedTo)):?>
                    <div class='task-assignedTo text-muted pull-left'><i class='icon-user'></i> <small><?php echo $task->assignedTo;?></small></div>
                  <?php endif;?>
                  <?php if(!empty($task->deadline) and $task->deadline != '0000-00-00'):?>
                    <div class='task-deadline text-warning pull-right'><i class='icon-time'></i> <small><?php echo $task->deadline;?></small></div>
                  <?php endif;?>
                  </div>
                  <div class='task-actions'>
                    <?php echo $this->task->buildOperateMenu($task);?>
                  </div>
                </div>
                <?php endforeach;?>
              </div>
            </div>
          </div>
        <?php endforeach;?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include $app->getModuleRoot() . 'common/view/footer.html.php';?>
