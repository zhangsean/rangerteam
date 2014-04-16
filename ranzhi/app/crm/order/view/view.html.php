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
<?php include '../../common/view/header.html.php';?>
<div class='col-lg-6'>
  <div class='panel'>
    <div class='panel-heading'><strong><i class='icon-file-text-alt'></i> <?php echo $lang->order->view;?></strong></div>
    <div class='panel-body'>
      <div class='alert <?php echo $config->order->statusClassList[$order->status];?>'>
        <?php $payed = $order->status == 'payed';?>
        <table class="table table-borderless table-condensed">
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
          <tr>
            <th class='small text-muted' colspan='2'><?php echo $lang->order->history;?></th>
          </tr>
          <tr>
            <td class='small' colspan='2'>
              <ul>
                <?php foreach($actionList as $action):?>
                <li>
                  <?php
                  $actionType = strtolower($action->action);
                  $desc       = $lang->action->desc->common;

                  if(isset($lang->action->desc->$actionType))
                  {
                      $desc = $lang->action->desc->$actionType;
                  }
                  elseif(!empty($action->extra))
                  {
                      $desc = '$date,' . $lang->by . '<strong>$actor</strong> ' . $action->extra . '。' . "\n";
                  }

                  foreach($action as $key => $value)
                  {
                      if($key == 'history') continue;
                      $desc = str_replace('$' . $key, $value, $desc);          
                  }
                  echo $desc;
                  ?>
                </li>
                <?php endforeach;?>
              </ul>
            </td>
          </tr>
          <?php if(!empty($order->enabledActions)):?>
          <tr>
            <td><?php foreach($order->enabledActions as $action) echo html::a($this->inlink('operate', "orderID={$order->id}&action={$action->id}"), $action->name, "class='btn'") . '&nbsp;';?></td>
          </tr>
          <?php endif;?>
        </table>
      </div>
      <h6 class='header-dividing text-muted'><?php echo $lang->order->product;?></h6>
      <ul>
        <li>
          <strong><?php echo $product->name;?></strong>
          <div class='small text-muted'><?php echo $product->desc;?></div>
        </li>
      </ul>
      <h6 class='header-dividing text-muted'><?php echo $lang->order->customer;?></h6>
      <ul>
        <li>
          <strong><?php echo $customer->name;?></strong>
          <?php if($customer->contactedBy):?>
          <div class='small text-muted'><i class='icon-user'></i> <?php echo $lang->order->contact . ': ' . $customer->contactedBy;?></div>
          <?php endif;?>
          <div class='small text-muted'><i class='icon-time'></i> <?php echo $lang->customer->contactDate . ': ' . $customer->contactedDate;?></div>
        </li>
      </ul>
    </div>
  </div>
</div>
<div class='col-lg-6'>
  <div class='panel'>
    <div class='panel-heading'><strong><i class='icon-time'></i> <?php echo $lang->order->effort;?></strong></div>
    <table class='table table-hover table-data'>
      <thead>
        <tr class='text-center'>
          <th class='w-id'><?php echo $lang->effort->id;?></th>
          <th class='w-100px'><?php echo $lang->effort->date;?></th>
          <th class='w-80px'><?php echo $lang->effort->consumed;?></th>
          <th><?php echo $lang->effort->work;?></th>
        </tr>
      </thead>
      <tbody>
        <?php unset($efforts['typeList']);?>
        <?php foreach($efforts as $effort):?>
        <tr class='text-center'>
          <td><?php echo $effort->id;?></td>
          <td><?php echo $effort->date;?></td>
          <td><?php echo $effort->consumed;?></td>
          <td class='text-left'><?php echo $effort->work;?></td>
        <tr>
        <?php endforeach;?>
      </tbody>
    </table>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>
