<?php
/**
 * The edit view file of task module of ZenTaoMS.
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
<?php include '../../common/view/kindeditor.html.php';?>
<?php include '../../common/view/datepicker.html.php';?>
<div class='panel'>
  <div class='panel-heading'><strong><?php echo $lang->task->edit;?></strong></div>
  <div class='panel-body'>
    <form method='post' id='ajaxForm'>
      <table class='table table-form'>
        <tr>
          <th><?php echo $lang->task->name;?></th>
          <td><?php echo html::input('name', $task->name, "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->task->customer;?></th>
          <td><?php echo html::select('customer', $customers, $task->customer, "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->task->order;?></th>
          <td><?php echo html::select('order', $orders, $task->order, "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->task->assignedTo;?></th>
          <td><?php echo html::select('assignedTo', $users, $task->assignedTo, "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->task->type;?></th>
          <td><?php echo html::select('type', $lang->task->typeList, $task->type, "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->task->status;?></th>
          <td><?php echo html::select('status', $lang->task->statusList, $task->status, "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->task->pri;?></th>
          <td><?php echo html::select('pri', $lang->task->priList, $task->pri, "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->task->estStarted;?></th>
          <td><?php echo html::input('estStarted', $task->estStarted, "class='form-control form-date'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->task->realStarted;?></th>
          <td><?php echo html::input('realStarted', $task->realStarted, "class='form-control form-date'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->task->deadline;?></th>
          <td><?php echo html::input('deadline', $task->deadline, "class='form-control form-date'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->task->estimate;?></th>
          <td><?php echo html::input('estimate', $task->estimate, "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->task->consumed;?></th>
          <td><?php echo html::input('consumed', $task->consumed, "class='form-control' autocomplete='off'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->task->left;?></th>
          <td><?php echo html::input('left', $task->left, "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->task->createdBy;?></th>
          <td><?php echo $users[$task->createdBy];?></td>
        </tr>
        <tr>
          <th><?php echo $lang->task->finishedBy;?></th>
          <td><?php echo html::select('finishedBy', $users, $task->finishedBy, "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->task->finishedDate;?></th>
          <td><?php echo html::input('finishedDate', $task->finishedDate, "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->task->canceledBy;?></th>
          <td><?php echo html::select('canceledBy', $users, $task->canceledBy, "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->task->canceledDate;?></th>
          <td><?php echo html::input('canceledDate', $task->canceledDate, "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->task->closedBy;?></th>
          <td><?php echo html::select('closedBy', $users, $task->closedBy, "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->task->closedReason;?></th>
          <td><?php echo html::select('closedReason', $lang->task->reasonList, $task->closedReason, "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->task->closedDate;?></th>
          <td><?php echo html::input('closedDate', $task->closedDate, "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->task->desc;?></th>
          <td><?php echo html::textarea('desc', $task->desc, "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->files;?></th>
          <td><?php echo $this->fetch('file', 'buildForm');?></td>
        </tr>
        <tr>
          <th></th>
          <td><?php echo html::submitButton();?></div>
        </div>
      </table>
    </form>
  </div>
</div>
<?php include '../../common/view/footer.lite.html.php';?>
</body>
</html>
