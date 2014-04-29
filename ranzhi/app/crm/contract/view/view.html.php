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
  </div>
  <?php echo $this->fetch('action', 'history', "objectType=contract&objectID={$contract->id}")?>
  <div class='text-center'>
    <?php
    echo $this->contract->buildOperateMenu($contract, 'btn', 'view');
    echo html::backButton();
    ?>
  </div>
</div>
<div class='col-md-4'>
  <div class='panel'>
    <div class='panel-heading'>
      <strong><?php echo $lang->contract->info;?></strong>
    </div>
    <div class='panel-body'>
      <table class='table table-info'>
        <tr>
          <th class='w-70px'><?php echo $lang->contract->customer;?></th>
          <td><?php echo $customers[$contract->customer];?></td>
        </tr>
        <tr>
          <th><?php echo $lang->contract->code;?></th>
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
          <th><?php echo $lang->contract->begin;?></th>
          <td><?php echo formatTime($contract->begin);?></td>
        </tr>
        <tr>
          <th><?php echo $lang->contract->end;?></th>
          <td><?php echo formatTime($contract->end);?></td>
        </tr>
        <tr>
          <th><?php echo $lang->contract->handlers;?></th>
          <td>
            <?php
            foreach(explode(',', $contract->handlers) as $handler)
            {
                if($handler and isset($users[$handler])) echo $users[$handler] . ' ';
            }
            ?>
          </td>
        </tr>
      </table>
    </div>
  </div>
  <div class='panel'>
    <div class='panel-heading'>
      <strong><?php echo $lang->contract->life;?></strong>
    </div>
    <div class='panel-body'>
      <table class='table table-info' id='contractLife'>
        <tr>
          <th class='w-70px'><?php echo $lang->contract->createdBy;?></th>
          <td><?php echo zget($users, $contract->createdBy, $contract->createdBy) . $lang->at . $contract->createdDate;?></td>
        </tr>
        <tr>
          <th><?php echo $lang->contract->signedBy;?></th>
          <td><?php if($contract->signedBy) echo zget($users, $contract->signedBy, $contract->signedBy) . $lang->at . $contract->signedDate;?></td>
        </tr>
        <tr>
          <th><?php echo $lang->contract->finishedBy;?></th>
          <td><?php if($contract->finishedBy) echo zget($users, $contract->finishedBy, $contract->finishedBy) . $lang->at . $contract->finishedDate;?></td>
        </tr>
        <tr>
          <th><?php echo $lang->contract->canceledBy;?></th>
          <td><?php if($contract->canceledBy) echo zget($users, $contract->canceledBy, $contract->canceledBy) . $lang->at . $contract->canceledDate;?></td>
        </tr>
        <tr>
          <th><?php echo $lang->contract->editedBy;?></th>
          <td><?php if($contract->editedBy) echo zget($users, $contract->editedBy, $contract->editedBy) . $lang->at . $contract->editedDate;?></td>
        </tr>
      </table>
    </div>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>
