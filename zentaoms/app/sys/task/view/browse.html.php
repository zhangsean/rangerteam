<?php
/**
 * The view file of task module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     task
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php';?>
<div class='panel'>
  <div class='panel-heading'>
  <strong><i class="icon-list-ul"></i> <?php echo $lang->task->list;?></strong>
  <div class='panel-actions'><?php echo html::a($this->inlink('create'), '<i class="icon-plus"></i> ' . $lang->task->create, 'class="btn btn-primary"');?></div>
  </div>
  <table class='table table-hover table-striped tablesorter'>
    <thead>
      <tr class='text-center'>
        <th class='w-50px'><?php echo $lang->task->id;?></th>
        <th class='w-30px'><?php echo $lang->task->lblPri;?></th>
        <th><?php echo $lang->task->name;?></th>
        <th class='w-150px'><?php echo $lang->task->deadline;?></th>
        <th class='w-80px'><?php echo $lang->task->assignedTo;?></th>
        <th class='w-150px'><?php echo $lang->task->openedDate;?></th>
        <th class='w-80px'><?php echo $lang->task->type;?></th>
        <th class='w-80px'><?php echo $lang->task->status;?></th>
        <th class='w-80px'><?php echo $lang->task->order;?></th>
        <th class='w-80px'><?php echo $lang->actions;?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($tasks as $task):?>
      <tr class='text-center'>
        <td><?php echo $task->id;?></td>
        <td><?php echo $lang->task->priList[$task->pri];?></td>
        <td class='text-left'><?php echo $task->name;?></td>
        <td><?php echo $task->deadline;?></td>
        <td><?php echo $task->assignedTo;?></td>
        <td><?php echo $task->openedDate;?></td>
        <td><?php echo $lang->task->typeList[$task->type];?></td>
        <td><?php echo $lang->task->statusList[$task->status];?></td>
        <td><?php echo $task->order;?></td>
        <td>
          <?php
          ?>
        </td>
      </tr>
      <?php endforeach;?>
    </tbody>
    <tfoot><tr><td colspan='10'><?php $pager->show();?></td></tr></tfoot>
  </table>
</div>
<?php include '../../common/view/footer.lite.html.php';?>
</body>
</html>

