<?php
/**
 * The save order record view file of order module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     order
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
?>
<?php include '../../../sys/common/view/header.modal.html.php';?>
<?php include '../../../sys/common/view/kindeditor.html.php';?>
<?php include '../../../sys/common/view/datepicker.html.php';?>
<?php js::set('customer', $order->customer);?>
<form method='post' id='ajaxModalForm' action='<?php echo inlink('createrecord', "orderID=$order->id")?>'>
  <table class='table table-form'>
    <tr>
      <th class='w-100px'><?php echo $lang->order->record->contact;?></th>
      <td><?php echo html::select('contact', $contacts, '', "class='form-control select-contact'");?></td>
    </tr>
    <tr>
      <th><?php echo $lang->order->record->comment;?></th>
      <td><?php echo html::textarea('comment', '', "class='form-control'");?></td>
    </tr>
    <tr>
      <th><?php echo $lang->order->record->date;?></th>
      <td><?php echo html::input('date', date('Y-m-d H:i:s'), "class='form-control form-datetime'");?></td>
    </tr>
    <tr>
      <th></th>
      <td><?php echo html::submitButton();?></td>
    </tr>
  </table>
</form>
<?php include '../../../sys/common/view/footer.modal.html.php';?>
