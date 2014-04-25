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
    <div class='panel-heading'><strong><i class='icon-file-text-alt'></i> <?php echo $lang->order->view;?></strong></div>
    <div class='panel-body'>
      <div class='alert <?php echo $config->order->statusClassList[$order->status];?>'>
        <?php $payed = $order->status == 'payed';?>
        <table class="table table-borderless table-condensed">
          <tr>
            <th class='small text-muted w-p45'><?php echo $lang->order->customer;?></th>
            <th colspan='2'></th>
          </tr>
          <tr>
            <th><?php echo $customer->name;?></th>
            <th>
              <span class='small text-muted'><?php echo $lang->customer->level?></span>
              <span class="label label-badge pull-ledt label-info"><?php echo $lang->customer->levelList[$customer->level]?></span>
            </th>
          <tr>
            <?php if($payed):?>
            <th class='small text-muted w-p45'><?php echo $lang->order->real;?></th>
            <?php else:?>
            <th class='small text-muted w-p45'><?php echo $lang->order->plan;?></th>
            <?php endif;?>
            <th class='small text-muted'><?php echo $lang->order->status;?></th>
          </tr>
          <tr>
            <?php if($payed):?>
            <td><strong class="label label-success lead text-latin"><?php echo $order->real;?></strong></td>
            <?php else:?>
            <td rowspan='3'><strong class="lead text-danger text-latin"><?php echo $order->plan;?></strong></td>
            <?php endif;?>
            <td>
              <strong class="lead"><?php echo $lang->order->statusList[$order->status];?></strong>
            </td>
          </tr>
          <tr>
            <?php if($payed):?>
            <th class='small text-muted'><?php echo $lang->order->plan;?></th>
            <?php endif;?>
            <td class='small'>
              <?php if($order->status == 'closed'):?>
              <strong><?php echo $lang->order->closedReason . ': ' . $lang->order->closedReasonList[$order->closedReason];?></strong>
              <div class='text-muted'><?php if($order->closedNote) echo $order->closedNote;?></div>
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
  <?php echo $this->fetch('action', 'history', "objectType=order&objectID={$order->id}&customer={$order->customer}");?>
</div>
<div class='col-lg-4'>
      <h6 class='header-dividing text-muted'><?php echo $lang->customer->contact;?></h6
      <ul>
        <?php foreach($contacts as $contact):?>
        <li>
          <strong><?php echo $contact->realname;?></strong>
          <i><?php echo $contact->dept . ' - ' . $contact->title;?></i>
          <?php if($contact->maker):?>
          <span class="label label-badge label-sm label-info"><?php echo $lang->contact->maker;?></span>
          <?php endif;?>
          <div class='small'><?php echo $lang->customer->contactDate . ': ' . $customer->contactedDate;?></div>
        </li>
        <?php endforeach;?>
      </ul>
      <h6 class='header-dividing text-muted'><?php echo $lang->order->product;?></h6>
      <ul>
        <li>
          <strong><?php echo $product->name;?></strong>
          <div class='small text-muted'>
            <?php echo $product->desc;?>
          </div>
        </li>
      </ul>
    </div>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>
