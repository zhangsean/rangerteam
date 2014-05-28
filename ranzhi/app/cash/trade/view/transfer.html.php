<?php 
/**
 * The transfer view file of trade module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Tingting Dai <daitingting@xirangit.com>
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
    <strong><i class="icon-plus"></i> <?php echo $lang->trade->transfer;?></strong>
  </div>
  <div class='panel-body'>
    <form method='post' id='ajaxForm'>
      <table class='table table-form w-p60'>
       <tr>
          <th class='w-100px'><?php echo $lang->trade->payment;?></th>
          <td><?php echo html::select('payment', $depositorList, '', "class='form-control'");?></td>
        </tr>
       <tr>
          <th><?php echo $lang->trade->receipt;?></th>
          <td><?php echo html::select('receipt', $depositorList, '', "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->trade->money;?></th>
          <td>
            <div class='row'>
              <div class='col-sm-9'><?php echo html::input('money', '', "class='form-control'");?></div>
              <div class='col-sm-3'><?php echo html::select('currency', $lang->depositor->currencyList, '', "class='form-control'");?></div>
            </div>
          </td>
        </tr>
        <tr>
          <th><?php echo $lang->trade->fee;?></th>
          <td>
            <div class='row'>
              <div class='col-sm-9'><?php echo html::input('fee', '', "class='form-control'");?></div>
              <div class='col-sm-3'><?php echo html::select('feeCurrency', $lang->depositor->currencyList, '', "class='form-control'");?></div>
            </div>
          </td>
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
