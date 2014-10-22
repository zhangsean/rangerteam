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
<div class='page-content'>
  <div class='panel'>
    <div class='panel-heading'>
      <strong><?php echo $project->name; ?></strong>
      <div class='panel-actions'>
        <div class='btn-group'>
          <?php echo html::a($this->inlink('browse', "projectID=$projectID"), "<i class='icon-list-ul icon'></i> " . $lang->task->list, "class='btn'"); ?>
          <?php echo html::a($this->inlink('kanban', "projectID=$projectID"), "<i class='icon-columns icon'></i> " . $lang->task->kanban, "class='btn'"); ?>
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
        <?php echo html::a($this->inlink('batchCreate', "projectID=$projectID"), '<i class="icon-plus"></i> ' . $lang->task->create, 'class="btn btn-primary"');?>
      </div>
    </div>
    <table class='table table-hover table-striped tablesorter table-data' id='taskList'>
      <thead>
        <tr class='text-center'>
          <?php $vars = "projectID=$projectID&groupBy={$groupBy}&orderBy=%s";?>
          <th class='w-60px'> <?php commonModel::printOrderLink('id',          $orderBy, $vars, $lang->task->id);?></th>
          <th class='w-40px'> <?php commonModel::printOrderLink('pri',         $orderBy, $vars, $lang->task->lblPri);?></th>
          <th>                <?php commonModel::printOrderLink('name',        $orderBy, $vars, $lang->task->name);?></th>
          <th class='w-100px'><?php commonModel::printOrderLink('deadline',    $orderBy, $vars, $lang->task->deadline);?></th>
          <th class='w-80px'> <?php commonModel::printOrderLink('assignedTo',  $orderBy, $vars, $lang->task->assignedTo);?></th>
          <th class='w-100px'><?php commonModel::printOrderLink('createdDate', $orderBy, $vars, $lang->task->createdDate);?></th>
          <th class='w-90px'> <?php commonModel::printOrderLink('consumed',    $orderBy, $vars, $lang->task->consumedAB . $lang->task->lblHour);?></th>
          <th class='w-90px'> <?php commonModel::printOrderLink('left',        $orderBy, $vars, $lang->task->left . $lang->task->lblHour);?></th>
          <th class='w-180px'><?php echo $lang->actions;?></th>
        </tr>
      </thead>
      <?php $i = 0; ?>
      <?php foreach($tasks as $groupKey => $groupTasks):?>
      <?php
        $groupWait     = 0;
        $groupDone     = 0;
        $groupDoing    = 0;
        $groupClosed   = 0;
        $groupSum      = count($groupTasks);
      ?>
        <tr class="heading toggle-handle" data-target='#taskList<?php echo ++$i;?>'>
          <td colspan='4'>&nbsp;<i class='text-muted icon-caret-down toggle-icon'></i> &nbsp;<?php echo $groupKey;?> <?php echo ($groupSum > 0 ? ('(' . $groupSum . ')') : ''); ?></td>
          <td colspan='5' class='text-right'></td>
        </tr>
        <tbody id='taskList<?php echo $i;?>'>
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
            ?>
            <tr class='text-center' data-url='<?php echo $this->createLink('task', 'view', "taskID=$task->id"); ?>'>
              <td><?php echo $task->id;?></td>
              <td><span class='active pri pri-<?php echo $task->pri; ?>'><?php echo $lang->task->priList[$task->pri];?></span></td>
              <td class='text-left'><?php echo $task->name;?></td>
              <td><?php echo $task->deadline;?></td>
              <td><?php if(isset($users[$task->assignedTo])) echo $users[$task->assignedTo];?></td>
              <td><?php echo substr($task->createdDate, 0, 10);?></td>
              <td><?php echo formatHours($task->consumed);?></td>
              <td><?php echo formatHours($task->left);?></td>
              <td><?php echo $this->task->buildOperateMenu($task);?></td>
            </tr>
          <?php endforeach;?>
          <td></td><td colspan='8'><?php printf($lang->task->groupinfo, $groupSum, $groupWait, $groupDoing, $groupDone, $groupClosed) ?></td>
        </tbody>
      <?php endforeach;?>
    </table>
  </div>
</div>
<script>
$(function()
{
    $(document).on('click', '.toggle-handle', function()
    {
        var $this = $(this);
        $this.toggleClass('collapsed');
        var collapsed = $this.hasClass('collapsed');
        $this.find('.toggle-icon').toggleClass('icon-caret-down', !collapsed).toggleClass('icon-caret-right', collapsed);;
        $($this.data('target')).toggleClass('collapse', collapsed).toggleClass('in', !collapsed);
    });

    $('#expandAll').click(function()
    {
        $('#taskList .toggle-handle.collapsed').click();
    });

    $('#collapseAll').click(function()
    {
        $('#taskList .toggle-handle:not(.collapsed)').click();
    });
});
</script>
<?php include $app->getModuleRoot() . 'common/view/footer.html.php';?>
