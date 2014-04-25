<?php 
/**
 * The view file for the method of view of order module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     customer 
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
?>
<?php include '../../common/view/header.html.php'; ?>
<div class='col-lg-8'>
  <div class='panel'>
    <div class='panel-heading'><strong><?php echo $lang->order->view;?></strong></div>
    <div class='panel-body'>
      <div class='panel'>
        <table class='table table-data'>
          <thead>
            <tr>
              <th><?php echo $lang->order->customer;?></th>
              <th class='w-60px'><?php echo $lang->customer->level;?></th>
              <th><?php echo $lang->order->product;?></th>
              <th class='w-120px'><?php echo $lang->order->plan;?>
              <th class='w-120px'><?php echo $lang->order->real;?>
              <th class='w-80px'><?php echo $lang->order->assignedTo;?></th>
              <th class='w-80px'><?php echo $lang->order->contactedDate;?></th>
              <th class='w-80px'><?php echo $lang->order->nextDate;?></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><?php echo $customer->name;?></td>
              <td><?php echo $lang->customer->levelList[$customer->level];?></td>
              <td><?php echo $product->name;?></td>
              <td><?php echo $order->plan;?></td>
              <td><?php echo $order->real;?></td>
              <td><?php echo $users[$order->assignedTo];?></td>
              <td><?php echo substr($order->contactedDate, 0, 10);?></td>
              <td><?php echo $order->nextDate;?></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class='panel-footer'>
      <?php 
      echo html::a(inlink('edit', "orderID={$order->id}"), $lang->edit, "class='btn btn-default'");
      echo html::a(inlink('delete', "orderID={$order->id}"), $lang->delete, "class='btn btn-default deleter'");
      echo html::backButton();
      ?>
    </div>
  </div>
  <?php echo $this->fetch('action', 'history', "objectType=order&objectID={$order->id}&customer={$order->customer}");?>
</div>
<div class='col-lg-4'>
  <div class='panel'>
    <div class='panel-heading'><strong><i class='icon-file-text-alt'></i> <?php echo $lang->order->status;?></strong></div>
    <div class='panel-body'>
      <div>
        <?php $payed = $order->status == 'payed';?>
        <table class="table table-borderless table-condensed">
         <tr>
            <th class='small text-muted'><?php echo $lang->order->status;?></th>
            <th class='small text-muted w-p45'><?php echo $payed ? $lang->order->real : $lang->order->plan;?></th>
          </tr>
          <tr>
            <td><strong class='<?php echo $config->order->statusClassList[$order->status];?>'><?php echo $lang->order->statusList[$order->status];?></strong></td>
            <?php if($payed):?>
            <td><strong class="label lead text-latin"><?php echo $order->real;?></strong></td>
            <?php else:?>
            <td rowspan='3'><strong class="lead text-latin"><?php echo $order->plan;?></strong></td>
            <?php endif;?>
          </tr>
          <tr>
            <?php if($payed):?>
            <th class='small text-muted'><?php echo $lang->order->plan;?></th>
            <?php endif;?>
            <td class='small'>
              <?php if($order->status == 'closed'):?>
              <strong class='text-muted'><?php echo $lang->order->closedReason . $lang->colon;?></strong>
              <strong><?php echo $lang->order->closedReasonList[$order->closedReason];?></strong>
              <?php if($order->closedNote) echo "<p class='text-info'>{$order->closedNote}</p>";?>
              <?php endif;?>
            </td>
          </tr>
          <tr>
            <?php if($payed):?>
            <td><strong class="lead text-danger text-latin"><?php echo $order->plan;?></strong></td>
            <?php endif;?>
          </tr>
        </table>
      </div>
    </div>
  </div>
  <?php if($contract):?>
  <div class='panel'>
    <div class='panel-heading'><strong><?php echo $lang->contract->common;?></strong></div>
    <div class='panel-body'>
      <?php echo html::a($this->createLink('contract', 'view', "contractID={$contract->id}"), $contract->name);?>
    </div>
  </div>
  <?php endif;?>
  <div class='panel'>
    <div class='panel-heading'><h5><?php echo $lang->customer->contact;?></h5></div>
    <div class='panel-body'>
      <table class='table table-hover table-striped table-data table-contact'>
        <?php foreach($contacts as $contact):?>
        <tr>
          <td>
            <dl>
              <dt <?php if($contact->maker) echo "class='text-danger'";?>>
                <?php echo $contact->realname;?>
              </dt>
              <dd>
                <small class='w-70px'> <?php echo $lang->resume->dept . $lang->colon; ?></small>
                <strong><?php echo $contact->dept;?></strong>
                <small> <?php echo $lang->resume->title . $lang->colon; ?></small>
                <strong><?php echo $contact->title;?></strong>
              </dd>
              <?php foreach($config->contact->contactWayList as $item):?>
              <?php if(!empty($contact->{$item})):?>
              <dd>
                <small class='w-70px'><?php echo $lang->contact->{$item} . $lang->colon;?></small>
                <strong><?php echo $contact->{$item};?></strong>
              </dd>
              <?php endif;?>
              <?php endforeach;?>
            </dl>
          </td>
        </tr>
        <?php endforeach;?>
      </table>
    </div>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>
