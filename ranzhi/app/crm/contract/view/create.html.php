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
<?php include '../../../sys/common/view/header.modal.html.php';?>
<?php include '../../common/view/datepicker.html.php';?>
<?php include '../../../sys/common/view/chosen.html.php';?>
<form method='post' id='ajaxModalForm' action='<?php echo $this->createLink('contract', 'create')?>'>
  <table class='table table-striped table-form'>
    <tr>
      <th class='w-100px'><?php echo $lang->contract->customer;?></th>
      <td><?php echo html::select('customer', $customers, '', "class='form-control select-customer' onchange='getOrder(this.value)'");?></td><td></td>
    </tr>
    <tr id= 'orderTR' class='hide'>
      <th><?php echo $lang->contract->order;?></th>
      <td id='orderTD'></td>
    </tr>
    <tr>
      <th><?php echo $lang->contract->name;?></th>
      <td><?php echo html::input('name', '', "class='form-control'");?></td>
    </tr>
    <tr>
      <th><?php echo $lang->contract->amount;?></th>
      <td><?php echo html::input('amount', '', "class='form-control'");?></td>
    </tr>
    <tr>
      <th><?php echo $lang->contract->contact;?></th>
      <td><?php echo html::select('contact', $contacts, '', "class='form-control select-contact'");?></td>
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
<?php include '../../../sys/common/view/footer.modal.html.php';?>
