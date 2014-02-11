<?php
/**
 * The create view file of contract module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2010 QingDao Nature Easy Soft Network Technology Co,LTD (www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     contract
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../../sys/common/view/kindeditor.html.php';?>
<?php include '../../../sys/common/view/chosen.html.php';?>
<div class='panel'>
  <div class='panel-heading'>
    <strong><i class="icon-plus"></i> <?php echo $lang->contract->create;?></strong>
  </div>
  <div class='panel-body'>
    <form method='post' id='ajaxForm'>
      <table class='table table-form'>
        <tr>
          <th><?php echo $lang->contract->customer;?></th>
          <td><?php echo html::select('customer', $customers, $order ? $order->customer : '', "class='form-control'");?></td>
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
          <th><?php echo $lang->contract->code;?></th>
          <td><?php echo html::input('code', '', "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->contract->amount;?></th>
          <td><?php echo html::input('amount', $amount, "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->contract->items;?></th>
          <td><?php echo html::textarea('items', '', "class='form-control'");?></td>
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
          <td><?php echo html::input('signedDate', '', "class='form-control date w-200px'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->contract->begin;?></th>
          <td><?php echo html::input('begin', '', "class='form-control date w-200px'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->contract->end;?></th>
          <td><?php echo html::input('end', '', "class='form-control date w-200px'");?></td>
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

