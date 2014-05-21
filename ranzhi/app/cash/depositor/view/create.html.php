<?php 
/**
 * The create view file of Depositor module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     depositor 
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../../sys/common/view/chosen.html.php';?>
<div class='panel'>
  <div class='panel-heading'>
    <strong><i class="icon-plus"></i> <?php echo $lang->depositor->create;?></strong>
  </div>
  <div class='panel-body'>
    <form method='post' id='ajaxForm'>
      <table class='table table-form w-p60'>
        <tr>
          <th><?php echo $lang->depositor->type;?></th>
          <td><?php echo html::select('type', $lang->depositor->typeList, '', "class='form-control'");?></td>
        </tr>
        <tr>
          <th class='w-120px'><?php echo $lang->depositor->abbr;?></th>
          <td><?php echo html::input('abbr', '', "class='form-control'");?></td>
        </tr>
        <tbody id='depositor' class='hide'>
        <tr class='provider'>
        </tr>
        <tr>
          <th><?php echo $lang->depositor->title;?></th>
          <td><?php echo html::input('title', '', "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->depositor->account;?></th>
          <td><?php echo html::input('account', '', "class='form-control'");?></td>
        </tr>
        <tr class='bankcode'>
          <th><?php echo $lang->depositor->bankcode;?></th>
          <td><?php echo html::input('bankcode', '', "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->depositor->public;?></th>
          <td><?php echo html::radio('public', $lang->depositor->publicList, '');?></td>
        </tr>
        <tbody>
        <tr>
          <th><?php echo $lang->depositor->currency;?></th>
          <td><?php echo html::input('currency', '', "class='form-control'");?></td>
        </tr>
        <tr>
          <th></th>
          <td><?php echo html::submitButton();?></td>
        </tr>
      </table>
    </form>
    <table class='hide'>
      <tr class='branch'>
        <th><?php echo $lang->depositor->branchProvider;?></th>
        <td><?php echo html::input('provider', '', "class='form-control'");?></td>
      </tr>
      <tr class='service'>
        <th><?php echo $lang->depositor->serviceProvider;?></th>
        <td><?php echo html::select('provider', $lang->depositor->providerList, '', "class='form-control'");?></td>
      </tr>
    </table>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>
