<?php
/**
 * The view view file of task module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     task
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php';?>
<div class='panel'>
  <div class='panel-heading'><strong><i class='icon-file-alt'></i> <?php echo $lang->task->view; ?>: <?php echo $lang->task->name;?></strong></div>
  <div class='panel-body'>
    <table class='table table-borderless table-condensed table-form'>
      <tr>
        <th class='w-120px'><?php echo $lang->task->name;?></th>
        <td><?php echo $task->name;?></td>
      </tr>
      <tr>
        <th><?php echo $lang->task->customer;?></th>
        <td><?php echo $customers[$task->customer];?></td>
      </tr>
      <tr>
        <th><?php echo $lang->task->order;?></th>
        <td><?php echo html::a($this->createLink('order', 'view', "orderID=$task->order"), $orders[$task->order]);?></td>
      </tr>
      <tr>
        <th><?php echo $lang->task->assignedTo;?></th>
        <td><?php echo $users[$task->assignedTo];?></td>
      </tr>
      <tr>
        <th><?php echo $lang->task->type;?></th>
        <td><?php $lang->task->typeList[$task->type];?></td>
      </tr>
      <tr>
        <th><?php echo $lang->task->pri;?></th>
        <td><?php $lang->task->priList[$task->pri];?></td>
      </tr>
      <tr>
        <th><?php echo $lang->task->estStarted;?></th>
        <td><?php echo $task->estStarted;?></td>
      </tr>
      <tr>
        <th><?php echo $lang->task->realStarted;?></th>
        <td><?php echo $task->realStarted;?></td>
      </tr>
      <tr>
        <th><?php echo $lang->task->deadline;?></th>
        <td><?php echo $task->deadline;?></td>
      </tr>
      <tr>
        <th><?php echo $lang->task->estimate;?></th>
        <td><?php echo $task->estimate;?></td>
      </tr>
      <tr>
        <th><?php echo $lang->task->consumed;?></th>
        <td><?php echo $task->consumed;?></td>
      </tr>
      <tr>
        <th><?php echo $lang->task->left;?></th>
        <td><?php echo $task->left;?></td>
      </tr>
      <tr>
        <th><?php echo $lang->task->createdBy;?></th>
        <td><?php echo $task->createdBy;?></td>
      </tr>
      <tr>
        <th><?php echo $lang->task->finishedBy;?></th>
        <td><?php echo $task->finishedBy;?></td>
      </tr>
      <tr>
        <th><?php echo $lang->task->canceledBy;?></th>
        <td><?php echo $task->canceledBy;?></td>
      </tr>
      <tr>
        <th><?php echo $lang->task->closedBy;?></th>
        <td><?php echo $task->closedBy;?></td>
      </tr>
      <tr>
        <th><?php echo $lang->task->closedReason;?></th>
        <td><?php echo $task->closedReason;?></td>
      </tr>
      <tr>
        <th><?php echo $lang->task->lastEditedBy;?></th>
        <td><?php echo $task->editedBy;?></td>
      </tr>
      <tr>
        <th><?php echo $lang->task->desc;?></th>
        <td><?php echo $task->desc;?></td>
      </tr>
      <tr>
        <th><?php echo $lang->files;?></th>
        <td><?php echo $this->fetch('file', 'printFiles', array('files' =>$task->files, 'fieldset' => 'false'))?></td>
      </tr>
    </table>
  </div>
  <div class='panel-footer'>
    <?php
    if($task->status != 'done') echo html::a($this->createLink('task', 'finish', "taskID=$task->id"), "<i class='icon-ok'></i> " . $lang->finish, "class='btn btn-primary'");
    echo html::a($this->createLink('task', 'edit', "taskID=$task->id"), "<i class='icon-pencil'></i> " . $lang->edit, "class='btn'");
    echo html::a($this->createLink('task', 'assignto', "taskID=$task->id"), "<i class='icon-hand-right'></i> " . $lang->assign, "class='btn'");
    ?>
  </div>
</div>
<?php include '../../common/view/action.html.php';?>
<?php include '../../../crm/common/view/footer.html.php';?>
