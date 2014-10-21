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
<?php $this->loadModel('project')->setMenu($projects, $projectID);?>
<div class='with-menu page-content'>
  <div class='panel'>
    <div class='panel-heading'>
      <div class='panel-actions'>
        <div class="btn-group">
          <?php echo html::a($this->inlink('browse', "projectID=$projectID"), "<i class='icon-list-ul icon'></i> " . $lang->task->list, "class='btn'"); ?>
          <?php echo html::a($this->inlink('kanban', "projectID=$projectID"), "<i class='icon-columns icon'></i> " . $lang->task->kanban, "class='btn active'"); ?>
          <?php echo html::a($this->inlink('outline', "projectID=$projectID"), "<i class='icon-list-alt icon'></i> " . $lang->task->outline, "class='btn'"); ?>
        </div>
        <div class="btn-group">
          <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
          <i class='icon-cog'></i> <?php echo $lang->task->groups[$groupBy];?>
            <icon class="icon-caret-down"></icon>
          </button>
          <ul class="dropdown-menu">
          <?php foreach ($lang->task->groups as $key => $value):?>
          <?php if(empty($key)) continue;?>
            <?php $class = ($key == $groupBy) ? 'active' : '';?>
            <li class='<?php echo $class;?>'>
              <?php echo html::a($this->inlink('kanban', "projectID=$projectID&groupBy=$key"), $value); ?>
            </li>
          <?php endforeach;?>
          </ul>
        </div>
      </div>
      <div class='panel-actions pull-right'><?php echo html::a($this->inlink('batchCreate', "projectID=$projectID"), '<i class="icon-plus"></i> ' . $lang->task->create, 'class="btn btn-primary"');?></div>
    </div>
    <div class='panel-body boards-container'>
      <div class='boards task-boards clearfix'>
      <?php foreach($tasks as $groupKey => $groupTasks):?>
        <div class='board task-board'  data-id='<?php echo $key;?>' data-col='<?php echo $colCount ?>' style='width: <?php echo $colWidth?>%'>
          <div class='panel'>
            <div class='panel-heading'>
              <?php echo empty($groupKey) ? $lang->task->unkown : $groupKey?>
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
                    <span class='pri pri-<?php echo $task->pri; ?>'>P<?php echo $task->pri;?></span>
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
