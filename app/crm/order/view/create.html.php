<?php 
/**
 * The view file for create function of order module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     order 
 * @version     $Id$
 * @link        http://www.ranzhico.com
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../../sys/common/view/chosen.html.php';?>
<div class='panel'>
  <div class='panel-heading'>
    <strong><i class="icon-plus"></i> <?php echo $lang->order->create;?></strong>
  </div>
  <div class='panel-body'>
    <form method='post' id='orderForm'>
      <table class='table table-form w-p60'>
        <tr>
          <th class='w-120px'><?php echo $lang->order->customer;?></th>
          <td>
            <div class='input-group'>
              <?php echo html::select('customer', $customers, '', "class='form-control chosen'");?>
              <?php echo html::input('name', '', "class='form-control' style='display:none'");?>
              <span class='input-group-addon'>
                <label class='checkbox'>
                  <input type='checkbox' name='createCustomer' id='createCustomer' value='1' /><?php echo $lang->order->createCustomer?>
                </label>
              </span>
            </div>
          </td>
        </tr>
        <tr class='customerInfo hide'>
          <th><?php echo $lang->customer->contact;?></th>
          <td>
            <div class='required required-wrapper'></div>
            <?php echo html::input('contact', '', "class='form-control'");?>
          </td>
        </tr>
        <tr class='customerInfo hide'>
          <th><?php echo $lang->customer->phone;?></th>
          <td><?php echo html::input('phone', '', "class='form-control'");?></td>
        </tr>
        <tr class='customerInfo hide'>
          <th><?php echo $lang->customer->email;?></th>
          <td><?php echo html::input('email', '', "class='form-control'");?></td>
        </tr>
        <tr class='customerInfo hide'>
          <th><?php echo $lang->customer->qq;?></th>
          <td><?php echo html::input('qq', '', "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->order->product;?></th>
          <td><?php echo html::select('product', $products, '', "class='form-control chosen'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->order->plan;?></th>
          <td>
            <div class='row'>
              <div class='col-sm-3'><?php echo html::select('currency', $currencyList, '', "class='form-control'");?></div>
              <div class='col-sm-9'><?php echo html::input('plan', '', "class='form-control'");?></div>
            </div>
          </td>
        </tr>
        <tr>
          <th></th>
          <td>
            <?php echo html::submitButton() . '&nbsp;&nbsp;' . html::backButton();?>
            <div class='popover'></div> 
          </td>
        </tr>
      </table>
    </form>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>
