<?php
/**
 * The edit view file of task module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     task
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/kindeditor.html.php';?>
<?php include '../../common/view/datepicker.html.php';?>
<div class='panel'>
  <div class='panel-heading'><strong><?php echo $lang->task->edit;?></strong></div>
  <div class='panel-body'>
    <form method='post' id='ajaxForm' class='form-condensed col-md-10 col-lg-8'>
      <fieldset class='fieldset-primary'>
        <table class='table table-form'>
          <tr class='text-left'>
            <th><?php echo $lang->task->name;?></th>
            <th><?php echo $lang->task->status;?></th>
          </tr>
          <tr>
            <td class='w-p50'><?php echo html::input('name', $task->name, "class='form-control'");?></td>
            <td><?php echo html::select('status', $lang->task->statusList, $task->status, "class='form-control'");?></td>
          </tr>
        </table>
      </fieldset>
      <fieldset>
        <legend><?php echo $lang->task->basicInfo; ?></legend>
        <table class='table table-form'>
          <tr>
            <th class='w-80px'><?php echo $lang->task->customer;?></th>
            <td class='w-p40'><?php echo html::select('customer', $customers, $task->customer, "class='form-control'");?></td>
            <th class='w-80px'><?php echo $lang->task->order;?></th>
            <td><?php echo html::select('order', $orders, $task->order, "class='form-control'");?></td>
          </tr>
          <tr>
            <th><?php echo $lang->task->assignedTo;?></th>
            <td><?php echo html::select('assignedTo', $users, $task->assignedTo, "class='form-control'");?></td>
            <th><?php echo $lang->task->type;?></th>
            <td><?php echo html::select('type', $lang->task->typeList, $task->type, "class='form-control'");?></td>
          </tr>
          <tr>
            <th><?php echo $lang->task->pri;?></th>
            <td colspan='3'>
              <?php 
              foreach ($lang->task->priList as $key => $value)
              {
                echo "<span data-value='" . $value . "' class='pri pri-" . $key . "'>" . ($value ? $value : '&nbsp;') . "</span>";
              }
              echo html::hidden('pri', $task->pri);
              ?>
            </td>
          </tr>
          <tr>
            <th><?php echo $lang->task->estStarted;?></th>
            <td><?php echo html::input('estStarted', $task->estStarted, "class='form-control form-date'");?></td>
            <th><?php echo $lang->task->deadline;?></th>
            <td><?php echo html::input('deadline', $task->deadline, "class='form-control form-date'");?></td>
          </tr>
          <tr>
            <th><?php echo $lang->task->realStarted;?></th>
            <td><?php echo html::input('realStarted', $task->realStarted, "class='form-control form-date'");?></td>
            <th><?php echo $lang->task->estimate;?></th>
            <td>
              <div class="input-group">
                <?php echo html::input('estimate', $task->estimate, "class='form-control'");?>
                <span class="input-group-addon"><?php echo $lang->task->hour;?></span>
              </div>
            </td>
          </tr>
          <tr>
            <th><?php echo $lang->task->consumed;?></th>
            <td><?php echo html::input('consumed', $task->consumed, "class='form-control' autocomplete='off'");?></td>
            <th><?php echo $lang->task->left;?></th>
            <td><?php echo html::input('left', $task->left, "class='form-control'");?></td>
          </tr>
          <tr>
            <th><?php echo $lang->task->createdBy;?></th>
            <td><?php echo $users[$task->createdBy];?></td>
            <th><?php echo $lang->task->finishedBy;?></th>
            <td><?php echo html::select('finishedBy', $users, $task->finishedBy, "class='form-control'");?></td>
          </tr>
          <tr>
            <th><?php echo $lang->task->finishedDate;?></th>
            <td><?php echo html::input('finishedDate', $task->finishedDate, "class='form-control form-datetime'");?></td>
            <th><?php echo $lang->task->canceledBy;?></th>
            <td><?php echo html::select('canceledBy', $users, $task->canceledBy, "class='form-control'");?></td>
          </tr>
          <tr>
            <th><?php echo $lang->task->canceledDate;?></th>
            <td><?php echo html::input('canceledDate', $task->canceledDate, "class='form-control form-datetime'");?></td>
            <th><?php echo $lang->task->closedBy;?></th>
            <td><?php echo html::select('closedBy', $users, $task->closedBy, "class='form-control'");?></td>
          </tr>
          <tr>
            <th><?php echo $lang->task->closedReason;?></th>
            <td><?php echo html::select('closedReason', $lang->task->reasonList, $task->closedReason, "class='form-control'");?></td>
            <th><?php echo $lang->task->closedDate;?></th>
            <td><?php echo html::input('closedDate', $task->closedDate, "class='form-control'");?></td>
          </tr>
        </table>
      </fieldset>
      <fieldset class='collapsed'>
        <legend><?php echo $lang->task->moreInfo;?></legend>
        <table class='table table-form'>
          <tr>
            <th class='w-80px'><?php echo $lang->task->desc;?></th>
            <td><?php echo html::textarea('desc', $task->desc, "class='form-control'");?></td>
          </tr>
          <tr>
            <th><?php echo $lang->files;?></th>
            <td><?php echo $this->fetch('file', 'buildForm');?></td>
          </tr>
        </table>
      </fieldset>
      <?php echo html::submitButton();?>
    </form>
  </div>
</div>
<?php include $app->getModuleRoot() . 'common/view/footer.html.php';?>
