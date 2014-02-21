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
    <form method='post' id='ajaxForm' class='form-condensed col-md-10 col-lg-8'>
      <fieldset class='fieldset-primary'>
        <table class='table table-form'>
          <tr class='text-left'>
            <th><?php echo $lang->task->name;?></th>
          </tr>
          <tr>
            <td><?php echo html::input('name', '', "class='form-control'");?></td>
          </tr>
        </table>
      </fieldset>
      <fieldset>
        <legend><?php echo $lang->task->basicInfo; ?></legend>
        <table class='table table-form'>
          <tr>
            <th class='w-80px'><?php echo $lang->task->customer;?></th>
            <td class='w-p40'><?php echo html::select('customer', $customers, $order ? $order->customer : $customerID, "class='form-control'");?></td>
            <th class='w-80px'><?php echo $lang->task->order;?></th>
            <td><?php echo html::select('order', $orders, $orderID, "class='form-control chosen'");?></td>
          </tr>
          <tr>
            <th><?php echo $lang->task->assignedTo;?></th>
            <td><?php echo html::select('assignedTo', $users, '', "class='form-control'");?></td>
            <th><?php echo $lang->task->type;?></th>
            <td><?php echo html::select('type', $lang->task->typeList, '', "class='form-control'");?></td>
          </tr>
          <tr>
            <th><?php echo $lang->task->pri;?></th>
            <td colspan='3'>
              <?php 
              foreach ($lang->task->priList as $key => $value)
              {
                echo "<span data-value='" . $value . "' class='pri pri-" . $key . "'>" . ($value ? $value : '&nbsp;') . "</span>";
              }
              echo html::hidden('pri', '');
              ?>
            </td>
          </tr>
          <tr>
            <th><?php echo $lang->task->estStarted;?></th>
            <td><?php echo html::input('estStarted', '', "class='form-control form-date'");?></td>
            <th><?php echo $lang->task->deadline;?></th>
            <td><?php echo html::input('deadline', '', "class='form-control form-date'");?></td>
          </tr>
          <tr>
            <th><?php echo $lang->task->estimate;?></th>
            <td>
              <div class="input-group">
                <?php echo html::input('estimate', '', "class='form-control'");?>
                <span class="input-group-addon"><?php echo $lang->task->hour ?></span>
              </div>
            </td>
          </tr>
        </table>
      </fieldset>
      <fieldset class='collapsed'>
        <legend><?php echo $lang->task->moreInfo; ?></legend>
        <table class='table table-form'>
          <tr>
            <th class='w-80px'><?php echo $lang->task->desc;?></th>
            <td><?php echo html::textarea('desc', '', "class='form-control'");?></td>
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
<?php include '../../common/view/footer.lite.html.php';?>
</body>
</html>
