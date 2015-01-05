<?php
/**
 * The view file of task module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     task
 * @version     $Id$
 * @link        http://www.ranzhico.com
 */
?>
<?php include $app->getModuleRoot() . 'common/view/header.html.php';?>
<?php if($mode) js::set('mode', $mode);?>
<?php $this->loadModel('project')->setMenu($projects, $projectID);?>
<li id='bysearchTab'><?php echo html::a('#', "<i class='icon-search icon'></i>" . $lang->search->common)?></li>
<div class='row with-menu page-content'>
  <div class='panel'>
    <table class='table table-hover table-striped tablesorter table-data' id='taskList'>
      <thead>
        <tr class='text-center'>
          <?php $vars = "projectID=$projectID&mode={$mode}&orderBy=%s&recTotal={$pager->recTotal}&recPerPage={$pager->recPerPage}&pageID={$pager->pageID}";?>
          <th class='w-60px'> <?php commonModel::printOrderLink('id',          $orderBy, $vars, $lang->task->id);?></th>
          <th class='w-40px'> <?php commonModel::printOrderLink('pri',         $orderBy, $vars, $lang->task->lblPri);?></th>
          <th>                <?php commonModel::printOrderLink('name',        $orderBy, $vars, $lang->task->name);?></th>
          <th class='w-100px'><?php commonModel::printOrderLink('deadline',    $orderBy, $vars, $lang->task->deadline);?></th>
          <th class='w-80px'> <?php commonModel::printOrderLink('assignedTo',  $orderBy, $vars, $lang->task->assignedTo);?></th>
          <th class='w-90px'> <?php commonModel::printOrderLink('status',      $orderBy, $vars, $lang->task->status);?></th>
          <th class='w-100px visible-lg'><?php commonModel::printOrderLink('createdDate', $orderBy, $vars, $lang->task->createdDate);?></th>
          <th class='w-90px visible-lg'> <?php commonModel::printOrderLink('consumed',    $orderBy, $vars, $lang->task->consumedAB . $lang->task->lblHour);?></th>
          <th class='w-110px visible-lg'> <?php commonModel::printOrderLink('left',        $orderBy, $vars, $lang->task->left . $lang->task->lblHour);?></th>
          <th class='w-200px'><?php echo $lang->actions;?></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($tasks as $task):?>
        <tr class='text-center' data-url='<?php echo $this->createLink('task', 'view', "taskID=$task->id"); ?>'>
          <td><?php echo $task->id;?></td>
          <td><span class='active pri pri-<?php echo $task->pri; ?>'><?php echo $lang->task->priList[$task->pri];?></span></td>
          <td class='text-left'><?php echo $task->name;?></td>
          <td><?php echo $task->deadline;?></td>
          <td><?php if(isset($users[$task->assignedTo])) echo $users[$task->assignedTo];?></td>
          <td><?php echo zget($lang->task->statusList, $task->status);?></td>
          <td class='visible-lg'><?php echo substr($task->createdDate, 0, 10);?></td>
          <td class='visible-lg'><?php echo $task->consumed;?></td>
          <td class='visible-lg'><?php echo $task->left;?></td>
          <td><?php echo $this->task->buildOperateMenu($task);?></td>
        </tr>
        <?php endforeach;?>
      </tbody>
      <tfoot><tr><td colspan='10'><?php $pager->show();?></td></tr></tfoot>
    </table>
  </div>
</div>
<?php include $app->getModuleRoot() . 'common/view/footer.html.php';?>
