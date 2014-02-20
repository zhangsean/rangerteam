<?php
/**
 * The create view file of task module of ZenTaoMS.
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
  <div class='panel-heading'><strong><?php echo $lang->task->create;?></strong></div>
  <div class='panel-body'>
    <form method='post' id='ajaxForm'>
      <table class='table table-form'>
        <tr>
          <th><?php echo $lang->task->name;?></th>
          <td><?php echo html::input('name', '', "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->task->customer;?></th>
          <td><?php echo html::select('customer', $customers, $order ? $order->customer : $customerID, "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->task->order;?></th>
          <td><?php echo html::select('order', $orders, $orderID, "class='form-control chosen'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->task->assignedTo;?></th>
          <td><?php echo html::select('assignedTo', $users, '', "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->task->type;?></th>
          <td><?php echo html::select('type', $lang->task->typeList, '', "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->task->pri;?></th>
          <td><?php echo html::select('pri', $lang->task->priList, '', "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->task->estStarted;?></th>
          <td><?php echo html::input('estStarted', '', "class='form-control form-date'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->task->deadline;?></th>
          <td><?php echo html::input('deadline', '', "class='form-control form-date'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->task->estimate;?></th>
          <td><?php echo html::input('estimate', '', "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->task->desc;?></th>
          <td><?php echo html::textarea('desc', '', "class='form-control'");?></td>
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
