<?php
/**
 * The edit view file of contract module of Ranzhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     contract
 * @version     $Id$
 * @link        http://www.ranzhi.co
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/datepicker.html.php';?>
<?php include '../../../sys/common/view/kindeditor.html.php';?>
<?php include '../../../sys/common/view/chosen.html.php';?>
<div class='panel'>
  <div class='panel-heading'>
    <strong><i class="icon-edit"></i> <?php echo $lang->contract->edit;?></strong>
  </div>
  <div class='panel-body'>
    <form method='post' id='ajaxForm' class='form-condensed'>
      <fieldset class='fieldset-primary'>
        <table class='table table-form'>
          <tr class='text-left'>
            <th class='w-p50'><?php echo $lang->contract->customer;?></th>
            <th><?php echo $lang->contract->order;?></th>
          </tr>
          <tr>
            <td><?php echo html::select('customer', $customers, $contract->customer, "class='form-control'");?></td>
            <td><?php echo html::select('order[]', $orders, $contract->order, "class='form-control chosen' multiple");?></td>
          </tr>
          <tr class='text-left'>
            <th><?php echo $lang->contract->name;?></th>
          </tr>
          <tr>
            <td colspan='2'><?php echo html::input('name', $contract->name, "class='form-control'");?></td>
          </tr>
        </table>
      </fieldset>
      <fieldset>
        <legend><?php echo $lang->contract->info; ?></legend>
        <table class='table table-form'>
          <tr>
            <th class='w-80px'><?php echo $lang->contract->code;?></th>
            <td class='w-p40'><?php echo html::input('code', $contract->code, "class='form-control'");?></td>
            <th class='w-80px'><?php echo $lang->contract->amount;?></th>
            <td><?php echo html::input('amount', $contract->amount, "class='form-control'");?></td>
          </tr>
          <tr>
            <th><?php echo $lang->contract->items;?></th>
            <td colspan='3'><?php echo html::textarea('items', $contract->items, "class='form-control'");?></td>
          </tr>
          <tr>
            <th><?php echo $lang->contract->delivery;?></th>
            <td><?php echo html::select('delivery', $lang->contract->deliveryList, $contract->delivery, "class='form-control'");?></td>
            <th><?php echo $lang->contract->return;?></th>
            <td><?php echo html::select('return', $lang->contract->returnList, $contract->return, "class='form-control'");?></td>
          </tr>
          <tr>
            <th><?php echo $lang->contract->status;?></th>
            <td><?php echo html::select('status', $lang->contract->statusList, $contract->status, "class='form-control'");?></td>
            <th><?php echo $lang->contract->contact;?></th>
            <td><?php echo html::select('contact', $contacts, $contract->contact, "class='form-control'");?></td>
          </tr>
          <tr>
            <th><?php echo $lang->contract->signedBy;?></th>
            <td><?php echo html::select('signedBy', $users, $contract->signedBy, "class='form-control'");?></td>
            <th><?php echo $lang->contract->signedDate;?></th>
            <td><?php echo html::input('signedDate', $contract->signedDate, "class='form-control form-date'");?></td>
          </tr>
          <tr>
            <th><?php echo $lang->contract->begin;?></th>
            <td><?php echo html::input('begin', $contract->begin, "class='form-control form-date'");?></td>
            <th><?php echo $lang->contract->end;?></th>
            <td><?php echo html::input('end', $contract->end, "class='form-control form-date'");?></td>
          </tr>
          <tr>
            <th><?php echo $lang->files;?></th>
            <td colspan='3'><?php echo $this->fetch('file', 'buildForm');?></td>
          </tr>
        </table>
      </fieldset>
      <?php echo html::submitButton();?>
    </form>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>
