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
          <div class='btn-group'>
            <?php echo html::a($this->inlink('browse', "projectID=$projectID"), "<i class='icon-list-ul icon'></i> " . $lang->task->list, "class='btn'"); ?>
            <?php echo html::a($this->inlink('kanban', "projectID=$projectID"), "<i class='icon-columns icon'></i> " . $lang->task->kanban, "class='btn'"); ?>
            <?php echo html::a($this->inlink('mind', "projectID=$projectID"), "<i class='icon-usecase icon'></i> " . $lang->task->mind, "class='btn'"); ?>
            <?php echo html::a($this->inlink('outline', "projectID=$projectID"), "<i class='icon-list-alt icon'></i> " . $lang->task->outline, "class='btn active'"); ?>
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
                <?php echo html::a($this->inlink('outline', "projectID=$projectID&groupBy=$key"), $value); ?>
              </li>
            <?php endforeach;?>
            </ul>
          </div>
        </div>
        <div class="panel-actions pull-right">
          <div class="btn-group">
            <button class="btn" type="button" id="expandAll"><i class="icon-align-left"></i></button>
            <button class="btn" type="button" id="collapseAll"><i class="icon-align-justify"></i></button>
          </div>
        </div>
      </div>
      <div class='panel-body outline-container'>
        <div id='taskList' class='outline'>
        <?php $i = 0; ?>
        <?php foreach($tasks as $groupKey => $groupTasks):?>
          <?php
            $groupWait     = 0;
            $groupDone     = 0;
            $groupDoing    = 0;
            $groupClosed   = 0;
          ?>
          <div class="item">
            <div class="heading collapsed" data-toggle="collapse" data-target='#taskList<?php echo ++$i;?>'><i class='text-muted icon-caret-down'></i> <strong><?php echo $groupKey;?></strong></div>
            <div class="content list task-list collapse" id='taskList<?php echo $i;?>'>
              <?php foreach($groupTasks as $task):?>
                <?php
                if($task->status == 'wait')
                {
                    $groupWait++;
                }
                elseif($task->status == 'doing')
                {
                    $groupDoing++;
                }
                elseif($task->status == 'done')
                {
                    $groupDone++;
                }
                elseif($task->status == 'closed')
                {
                    $groupClosed++;
                }
                $groupSum = count($groupTasks);
                ?>
                <div class='item task task-pri-<?php echo $task->pri; ?>' data-id='<?php echo $task->id;?>' data-status='<?php echo $task->status;?>'>
                  <div class="heading">
                    <?php if($groupBy != 'status'):?>
                    <div class="pull-right">
                      <span class="label label-circle label-badge task-status-<?php echo $task->status?>"><?php echo $lang->task->statusList[$task->status]?></span>
                    </div>
                    <?php endif;?>
                    <strong><?php echo $task->name?></strong>
                    <?php if(!empty($task->type)):?>
                    &nbsp; <span class='text-muted task-type'><?php echo $lang->task->typeList[$task->type];?></span>
                    <?php endif;?>
                  </div>
                  <div class="content">
                    <div class='task-infos'>
                    <?php if(!empty($task->assignedTo)):?>
                      <div class='task-assignedTo text-muted w-80px task-info'><i class='icon-user'></i> <small><?php echo $task->assignedTo;?></small></div>
                    <?php endif;?>
                    <?php if(!empty($task->deadline) and $task->deadline != '0000-00-00'):?>
                      <div class='task-deadline text-warning w-100px task-info'><i class='icon-time'></i> <small><?php echo $task->deadline;?></small></div>
                    <?php endif;?>
                    </div>
                  </div>
                  <div class='actions'>
                    <?php echo $this->task->buildOperateMenu($task);?>
                  </div>
                </div>
              <?php endforeach;?>
            </div>
            <div class="info">
              <?php printf($lang->task->groupinfo, $groupSum, $groupWait, $groupDoing, $groupDone, $groupClosed) ?>
            </div>
          </div>
        <?php endforeach;?>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
$(function()
{
    $('#expandAll').click(function()
    {
        $('.outline > .item > .heading.collapsed').click();
    });

    $('#collapseAll').click(function()
    {
        $('.outline > .item > .heading:not(.collapsed)').click();
    });
});
</script>
<?php include $app->getModuleRoot() . 'common/view/footer.html.php';?>
