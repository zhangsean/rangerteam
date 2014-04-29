<?php
/**
 * The view view file of contract module of RanZhi.
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
<div class='col-md-8'>
  <div class='panel'>
    <div class='panel-heading'>
      <strong><i class='icon-file-text-alt'></i> <?php echo $lang->contract->common . ': #' . $contract->id . $contract->name;?></strong>
    </div>
    <div class='panel-body'>
      <table class='table table-form table-data'>
        <tr>
          <th class='w-80px'><?php echo $lang->contract->name;?></th>
          <td><?php echo $contract->name;?></td>
        </tr>
        <tr>
          <th><?php echo $lang->contract->customer;?></th>
          <td><?php echo $customers[$contract->customer];?></td>
        </tr>
        <tr>
          <th><?php echo $lang->contract->order;?></th>
          <td>
            <ul>
              <?php foreach($orders as $order):?>
              <li><?php echo $products[$order->product] . $lang->minus .  $lang->order->real . " : " . $order->real; ?></li>
              <?php endforeach;?>
            </ul>
          </td>
        </tr>
        <tr>
          <th><?php echo $lang->contract->amount;?></th>
          <td><?php echo $contract->amount?></td>
        </tr>
        <tr>
          <th><?php echo $lang->contract->items;?></th>
          <td><?php echo $contract->items;?></td>
        </tr>
        <tr>
          <th><?php echo $lang->files?></th>
          <td><?php echo $this->fetch('file', 'printFiles', array('files' => $contract->files, 'fieldset' => 'false'))?></td>
        </tr>
      </table>
    </div>
    <div class='panel-footer'>
      <?php
      echo html::a(inlink('edit', "contractID=$contract->id"), "<i class='icon-pencil'></i> " . $lang->edit, "class='btn'");
      echo html::a(inlink('delete', "contractID=$contract->id"), "<i class='icon-remove'></i> " . $lang->delete, "class='deleter btn'");
      echo html::backButton();
      ?>
    </div>
  </div>
  <?php echo $this->fetch('action', 'history', "objectType=contract&objectID={$contract->id}&customer={$contract->customer}")?>
</div>
<div class='col-md-4'>
  <div class='panel'>
    <div class='panel-heading'>
      <strong><?php echo $lang->contract->info;?></strong>
    </div>
    <div class='panel-body'>
      <table class='table table-form table-data'>
          <th class='w-80px'><?php echo $lang->contract->code;?></th>
          <td><?php echo $contract->code;?></td>
        </tr>
        <tr>
          <th><?php echo $lang->contract->delivery;?></th>
          <td><?php echo $lang->contract->deliveryList[$contract->delivery];?></td>
        </tr>
        <tr>
          <th><?php echo $lang->contract->return;?></th>
          <td><?php echo $lang->contract->returnList[$contract->return];?></td>
        </tr>
        <tr>
          <th><?php echo $lang->contract->status;?></th>
          <td><?php echo $lang->contract->statusList[$contract->status];?></td>
        </tr>
        <tr>
          <th><?php echo $lang->contract->contact;?></th>
          <td><?php if(isset($contacts[$contract->contact])) echo $contacts[$contract->contact];?></td>
        </tr>
        <tr>
          <th><?php echo $lang->contract->signedBy;?></th>
          <td><?php echo $users[$contract->signedBy];?></td>
        </tr>
        <tr>
          <th><?php echo $lang->contract->signedDate;?></th>
          <td><?php echo $contract->signedDate;?></td>
        </tr>
        <tr>
          <th><?php echo $lang->contract->begin;?></th>
          <td><?php echo $contract->begin;?></td>
        </tr>
        <tr>
          <th><?php echo $lang->contract->end;?></th>
          <td><?php echo $contract->end;?></td>
        </tr>
        <tr>
          <th><?php echo $lang->contract->handlers;?></th>
          <td><?php echo $contract->handlers;?></td>
        </tr>
      </table>
    </div>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>
