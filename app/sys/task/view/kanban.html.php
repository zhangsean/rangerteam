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
<?php js::set('notAllowed', $lang->task->notAllowed);?>
<div class='page-content'>
  <div class='panel'>
    <div class='panel-heading'>
      <strong><?php echo $project->name;?></strong>
      <?php include 'headernav.html.php';?>
      <div class='panel-actions pull-right'><?php echo html::a($this->inlink('batchCreate', "projectID=$projectID"), '<i class="icon-plus"></i> ' . $lang->task->create, 'class="btn btn-primary"');?></div>
    </div>
    <div class='panel-body boards-container'>
      <div class='boards task-boards clearfix' id='taskKanban'>
      <?php foreach($tasks as $groupKey => $groupTasks):?>
        <?php if(empty($groupKey) and $groupBy == 'status') continue;?>
        <div class='board task-board' data-group='<?php echo $groupBy?>' data-key='<?php echo $groupKey;?>' style='width: <?php echo $colWidth?>%'>
          <div class='panel'>
            <div class='panel-heading'>
              <?php if(empty($groupKey)):?>
              <?php echo $lang->task->unkown;?>
              <?php elseif($groupBy == 'status'):?>
              <?php echo $lang->task->statusList[$groupKey];?>
              <?php else:?>
              <?php echo zget($users, $groupKey);?>
              <?php endif;?>
            </div>
            <div class='panel-body'>
              <div class='board-list'>
                <?php foreach($groupTasks as $task):?>
                <div class='board-item task' data-id='<?php echo $task->id;?>'>
                  <div class='task-heading'>
                    <a class='task-name' href='<?php echo $this->createLink('task', 'view', "taskID=$task->id"); ?>'><strong><?php echo $task->name;?></strong></a>
                  </div>
                  <div class='task-info clearfix'>
                    <div class='pull-left'>
                    <span class='pri pri-<?php echo $task->pri; ?>'>P<?php echo ($task->pri == 0 ? '?' : $task->pri);?></span>
                    <?php if(!empty($task->desc)): ?>
                      <button type='button' class='btn btn-link btn-mini' data-toggle='popover' data-original-title='<?php echo $lang->task->desc?>' data-trigger='hover' data-html='true' data-placement='bottom' data-content='<?php echo $task->desc?>'><i class='icon-file-alt'></i></button>&nbsp;&nbsp;
                    <?php endif; ?>
                    <?php if(!empty($task->assignedTo)):?>
                      <span class='task-assignedTo text-muted'><i class='icon-hand-right'></i> <small><?php echo $task->assignedTo;?></small></span>
                    <?php endif;?>
                    </div>
                    <?php if(!empty($task->deadline) and $task->deadline != '0000-00-00'):?>
                    <div class='task-deadline text-warning pull-right'><i class='icon-time'></i> <small><?php echo $task->deadline;?></small></div>
                    <?php endif;?>
                  </div>
                  <div class='task-actions'>
                    <div class='dropdown'>
                      <button type='button' class='btn btn-mini btn-link dropdown-toggle' type='button' data-toggle='dropdown'>
                        <span class='caret'></span>
                      </button>
                      <div class='dropdown-menu pull-right'>
                        <?php echo $this->task->buildOperateMenu($task);?>
                      </div>
                    </div>
                  </div>
                </div>
                <?php endforeach;?>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach;?>
      </div>
    </div>
  </div>
</div>
<?php include $app->getModuleRoot() . 'common/view/footer.html.php';?>
