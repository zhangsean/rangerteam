<?php
/**
 * The headernav view file of task module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Xiying Guan guanxiying@xirangit.com<>
 * @package     task
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
?>
<?php $lang->task->browse = $lang->task->list;?>
<div id='groupBar' class='panel-actions'>
  <div class="btn-group">
    <a href='javascript:;' class='w-100px dropdown-toggle' id='groupButton' data-toggle='dropdown'>
      <icon class='icon-folder-close'></icon>
      <?php echo $lang->task->{$methodName};?>
      <icon class='icon-caret-down'></icon>
    </a>
    <ul class="dropdown-menu w-100px">
      <li <?php if($methodName == 'browse') echo "class='active'";?>><?php echo html::a($this->inlink('browse', "projectID=$projectID"), "<i class='icon-list-ul icon'></i> " . $lang->task->list); ?></li>
      <li <?php if($methodName == 'kanban') echo "class='active'";?>><?php echo html::a($this->inlink('kanban', "projectID=$projectID"), "<i class='icon-columns icon'></i> " . $lang->task->kanban); ?></li>
      <li <?php if($methodName == 'outline') echo "class='active'";?>><?php echo html::a($this->inlink('outline', "projectID=$projectID"), "<i class='icon-list-alt icon'></i> " . $lang->task->outline); ?></li>
    </ul>
  </div>
  <?php if($methodName != 'browse'):?>
  <div class="btn-group">
    <a class="dropdown-toggle" data-toggle="dropdown">
    <i class='icon-flag'></i>
 <?php echo $lang->task->groups[$groupBy];?>
      <icon class="icon-caret-down"></icon>
    </a>
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
  <?php endif;?>
</div>
