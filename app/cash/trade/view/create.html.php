<?php 
/**
 * The create view file of trade module of RanZhi.
 *
 * @copyright   Copyright 2009-2016 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv12.html)
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     trade 
 * @version     $Id$
 * @link        http://www.ranzhico.com
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../../sys/common/view/datepicker.html.php';?>
<?php include '../../../sys/common/view/chosen.html.php';?>
<?php js::set('mode', $type);?>
<div class='panel'>
  <div class='panel-heading'>
    <strong><i class="icon-plus"></i> <?php echo $lang->trade->{$type};?></strong>
  </div>
  <div class='panel-body'>
    <form method='post' id='ajaxForm' class='form-inline'>
      <table class='table table-form w-p60'>
        <tr>
          <th class='w-100px'><?php echo $lang->trade->depositor;?></th>
          <td><?php echo html::select('depositor', $depositorList, '', "class='form-control'");?></td>
        </tr>
        <?php if($type == 'in'):?>
        <tr class='income'>
          <th><?php echo $lang->trade->category;?></th>
          <td><?php echo html::select('category', array('') + (array) $categories, '', "class='form-control'");?></td>
        </tr>
        <?php endif;?>
        <?php if($type == 'out'):?>
        <tr class='expense'>
          <th><?php echo $lang->trade->category;?></th>
          <td>
            <div class='input-group'>
              <?php echo html::select('category', array('') + (array) $categories, '', "class='form-control'");?>
              <div class='input-group-addon'><?php echo html::checkbox('objectType', $lang->trade->objectTypeList);?></div>
            </div>
          </td>
        </tr>
        <tr class='hide'>
          <th><?php echo $lang->trade->order;?></th>
          <td>
            <select class='form-control chosen' id='order' name='order'>
              <option value=''></option>
              <?php foreach($orderList as $id => $order):?>
              <option value="<?php echo $id?>" data-customer="<?php echo $order->customer?>" data-amount="<?php echo $order->real;?>"><?php echo $order->name;?></option>
              <?php endforeach;?>
            </select>
          </td>
        </tr>
        <tr class='hide'>
          <th><?php echo $lang->trade->contract;?></th>
          <td>
            <select class='form-control chosen' id='contract' name='contract'>
              <option value=''></option>
              <?php foreach($contractList as $id => $contract):?>
              <option value="<?php echo $id?>" data-customer="<?php echo $contract->customer?>" data-amount="<?php echo $contract->amount;?>"><?php echo $contract->name;?></option>
              <?php endforeach;?>
            </select>
          </td>
        </tr>
        <tr class='hide'>
          <th><?php echo $lang->trade->customer;?></th>
          <td><?php echo html::select('customer', $customerList, '', "class='form-control chosen' onchange='getContract(this.value)'");?></td>
        </tr>
        <tr class='traderTR'>
          <th><?php echo $lang->trade->trader;?></th>
          <td>
            <?php if(count($traderList) > 1):?>
            <div class='input-group'>
              <?php  echo html::select('trader', $traderList, '', "class='form-control chosen'");?>
              <?php  echo html::input('traderName', '', "class='form-control' style='display:none'");?>
              <div class='input-group-addon'><?php echo html::checkbox('createTrader', array( 1 => $lang->trade->newTrader));?></div>
            </div>
            <?php else:?>
            <?php echo html::input('traderName', '', "class='form-control'") . html::hidden('createTrader', '');?>
            <?php endif;?>
          </td>
        </tr>
        <tr class='customer-depositor hide'>
          <th><?php echo $lang->customer->depositor;?></th>
          <td><?php echo html::input('customerDepositor', '', "class='form-control' disabled='disabled'");?></td>
        </tr>
        <?php endif;?>
        <?php if($type == 'in'):?>
        <tr>
          <th><?php echo $lang->trade->customer;?></th>
          <td><?php echo html::select('trader', $customerList, '', "class='form-control chosen' onchange='getContract(this.value)'");?></td>
        </tr>
        <tr class='customer-depositor hide'>
          <th><?php echo $lang->customer->depositor;?></th>
          <td><?php echo html::input('customerDepositor', '', "class='form-control' disabled='disabled'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->trade->contract;?></th>
          <td class='contractTD'><select name='contract' id='contract' class='form-control'></select></td>
        </tr>
        <?php endif;?>
        <tr>
          <th><?php echo $lang->trade->money;?></th>
          <td><?php echo html::input('money', '', "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->trade->dept;?></th>
          <td><?php echo html::select('dept', $deptList, '', "class='form-control chosen'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->trade->handlers;?></th>
          <td><?php echo html::select('handlers[]', $users, '', "class='form-control chosen' multiple");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->trade->product;?></th>
          <td><?php echo html::select('product', array('') + $productList, '', "class='form-control chosen'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->trade->date;?></th>
          <td><?php echo html::input('date', date('Y-m-d'), "class='form-control form-date'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->trade->desc;?></th>
          <td><?php echo html::textarea('desc','', "class='form-control' rows='3'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->trade->uploadFile;?></th>
          <td><?php echo $this->fetch('file', 'buildForm');?></td>
        </tr>
        <tr>
          <th></th>
          <td><?php echo html::submitButton() . '&nbsp;&nbsp;' . html::backButton();?></td>
        </tr>
      </table>
    </form>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>
