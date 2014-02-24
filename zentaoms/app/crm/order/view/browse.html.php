<?php 
/**
 * The browse view file of order module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     order 
 * @version     $Id $
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php';?>
<div class='panel'>
  <div class='panel-heading'>
  <strong><i class="icon-list-ul"></i> <?php echo $lang->order->list;?></strong>
  <div class='panel-actions pull-right'><?php echo html::a($this->inlink('create'), '<i class="icon-plus"></i> ' . $lang->order->create, 'class="btn btn-primary"');?></div>
  </div>
  <table class='table table-hover table-striped tablesorter table-data'>
    <thead>
      <tr>
        <?php $vars = "orderBy=%s&recTotal={$pager->recTotal}&recPerPage={$pager->recPerPage}&pageID={$pager->pageID}";?>
        <th class='w-60px text-center' ><?php commonModel::printOrderLink('id', $orderBy, $vars, $lang->order->id);?></th>
        <th><?php commonModel::printOrderLink('customer', $orderBy, $vars, $lang->order->customer);?></th>
        <th><?php commonModel::printOrderLink('product', $orderBy, $vars, $lang->order->product);?></th>
        <th class='w-120px'><?php commonModel::printOrderLink('createdBy', $orderBy, $vars, $lang->order->createdBy);?></th>
        <th class='w-120px'><?php commonModel::printOrderLink('assignedBy', $orderBy, $vars, $lang->order->assignedBy);?></th>
        <th class='w-120px'><?php commonModel::printOrderLink('assignedTo', $orderBy, $vars, $lang->order->assignedTo);?></th>
        <th class='w-60px' ><?php commonModel::printOrderLink('status', $orderBy, $vars, $lang->order->status);?></th>
        <th class='w-150px'><?php echo $lang->actions;?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($orders as $order):?>
      <tr data-url='<?php echo $this->createLink('order', 'view', "orderID=$order->id"); ?>'>
        <td class='text-center'><?php echo $order->id;?></td>
        <td><?php echo $customers[$order->customer];?></td>
        <td><?php echo $products[$order->product];?></td>
        <td><?php echo $order->createdBy;?></td>
        <td><?php echo $order->assignedBy;?></td>
        <td><?php echo $order->assignedTo;?></td>
        <td><?php echo isset($lang->order->statusList[$order->status]) ? $lang->order->statusList[$order->status] : $order->status;?></td>
        <td class='actions'>
          <?php
          echo html::a($this->createLink('order', 'edit',   "orderID=$order->id"), $lang->edit);
          echo html::a($this->createLink('order', 'assign', "orderID=$order->id"), $lang->assign);
          if(empty($order->contract)) echo html::a($this->createLink('contract', 'create', "orderID=$order->id"), $lang->order->sign);
          else echo "<a href='###' disabled='disabled' class='disabled'>" . $lang->order->sign . '</a> ';
          echo "<div class='dropdown'><a data-toggle='dropdown' href='javascript:;'>" . $lang->more . "<span class='caret'></span> </a><ul class='dropdown-menu pull-right'>";
          if($order->status != 'closed') echo '<li>' . html::a($this->createLink('order', 'close', "orderID=$order->id"), $lang->close) . '</li>';
          if($order->status == 'closed' && $order->closedReason != 'payed') echo '<li>' . html::a($this->createLink('order', 'activate', "orderID=$order->id"), $lang->activate, "class='reload'") . '</li>';
          echo '<li>' . html::a($this->createLink('order', 'team', "orderID=$order->id"), $lang->order->team) . '</li>';
          if(!empty($order->contact))
          {
              echo '<li>' . html::a($this->createLink('order', 'contact', "orderID=$order->id"), $lang->order->contact) . '</li>';
          }
          else
          {
              echo '<li>' . html::a($this->createLink('contact', 'create', "customerID=$order->customer"), $lang->order->contact) . '</li>';
          }
          echo '<li>' . html::a($this->createLink('effort', 'createForObject', "objectType=order&objectID=$order->id"), $lang->order->effort) . '</li>';
          ?>
          <?php 
          $actions = $this->order->getEnabledActions($order);
          foreach($actions as $action)
          {
              echo '<li>' . html::a($this->inlink('operate', "orderID={$order->id}&action={$action->id}"), $action->name) . '</li>';
          }
          ?>
          <?php echo '</ul></div>'; ?>
        </td>
      </tr>
      <?php endforeach;?>
    </tbody>
    <tfoot><tr><td colspan='8'><?php $pager->show();?></td></tr></tfoot>
  </table>
</div>
<?php include '../../common/view/footer.html.php';?>
