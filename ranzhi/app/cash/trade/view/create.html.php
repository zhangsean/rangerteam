<?php 
/**
 * The create view file of trade module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     trade 
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../../sys/common/view/datepicker.html.php';?>
<?php include '../../../sys/common/view/chosen.html.php';?>
<div class='panel'>
  <div class='panel-heading'>
    <strong><i class="icon-plus"></i> <?php echo $lang->trade->{$type};?></strong>
  </div>
  <div class='panel-body'>
    <form method='post' id='ajaxForm'>
      <table class='table table-form w-p60'>
        <tr>
          <th class='w-100px'><?php echo $lang->trade->depositor;?></th>
          <td><?php echo html::select('depositor', $depositorList, '', "class='form-control'");?></td>
        </tr>
        <?php if($type == 'out'):?>
        <tr>
          <th><?php echo $lang->trade->trader;?></th>
          <td><?php echo html::input('trader', '', "class='form-control'");?></td>
        </tr>
        <?php endif;?>
        <?php if($type == 'in'):?>
        <tr>
          <th><?php echo $lang->trade->customer;?></th>
          <td><?php echo html::select('trader', $customerList, '', "class='form-control'");?></td>
        </tr>
        <?php endif;?>
        <tr>
          <th><?php echo $lang->trade->money;?></th>
          <td><?php echo html::input('money', '', "class='form-control'");?></td>
        </tr>
        <?php if($type == 'in'):?>
        <tr class='income'>
          <th><?php echo $lang->trade->category;?></th>
          <td><?php echo html::select('category', array('') + $incomeTypes, '', "class='form-control'");?></td>
        </tr>
        <?php endif;?>
        <?php if($type == 'out'):?>
        <tr class='expense'>
          <th><?php echo $lang->trade->category;?></th>
          <td><?php echo html::select('category', array('') + $expenseTypes, '', "class='form-control'");?></td>
        </tr>
        <?php endif;?>
        <tr>
          <th><?php echo $lang->trade->product;?></th>
          <td><?php echo html::select('product', array('') + $productList, '', "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->trade->order;?></th>
          <td><?php echo html::select('order', array('') + $orderList, '', "class='form-control chosen'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->trade->contract;?></th>
          <td><?php echo html::select('contract', array('') + $contractList, '', "class='form-control chosen'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->trade->handler;?></th>
          <td><?php echo html::select('handler', $users, '', "class='form-control chosen'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->trade->date;?></th>
          <td><?php echo html::input('date', date('Y-m-d'), "class='form-control form-date'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->trade->desc;?></th>
          <td><?php echo html::textarea('desc','', "class='form-control' rows='8'");?></td>
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
