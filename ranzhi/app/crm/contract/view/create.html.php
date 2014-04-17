<?php
/**
 * The create view file of contract module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     contract
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/datepicker.html.php';?>
<?php include '../../../sys/common/view/chosen.html.php';?>
<div class='panel'>
  <div class='panel-heading'>
    <strong><i class='icon-plus'></i> <?php echo $lang->contract->create;?></strong>
  </div>
  <div class='panel-body'>
    <form method='post' id='ajaxForm'>
      <table class='table table-form'>
        <tr>
          <th class='w-100px'><?php echo $lang->contract->customer;?></th>
          <td class='w-p45'><?php echo html::select('customer', $customers, $order ? $order->customer : $customerID, "class='form-control'");?></td><td></td>
        </tr>
        <tr>
          <th><?php echo $lang->contract->order;?></th>
          <td><?php echo html::select('order[]', $orders, $orderID, "class='form-control chosen' multiple");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->contract->name;?></th>
          <td><?php echo html::input('name', '', "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->contract->amount;?></th>
          <td><?php echo html::input('amount', $amount, "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->contract->contact;?></th>
          <td><?php echo html::select('contact', $contacts, '', "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->contract->signedBy;?></th>
          <td><?php echo html::select('signedBy', $users, '', "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->contract->signedDate;?></th>
          <td><?php echo html::input('signedDate', '', "class='form-control form-date'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->contract->begin;?></th>
          <td><?php echo html::input('begin', '', "class='form-control form-date'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->contract->end;?></th>
          <td><?php echo html::input('end', '', "class='form-control form-date'");?></td>
        </tr>
        <tr>
          <th></th>
          <td><?php echo html::submitButton();?></td>
        </tr>
      </table>
    </form>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>
