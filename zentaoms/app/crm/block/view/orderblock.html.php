<?php
/**
 * The order block view file of block module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<table class='table'>
  <tr>
    <th class='w-id'><?php echo $lang->order->id?></th>
    <th><?php echo $lang->order->customer?></th>
    <th><?php echo $lang->order->product?></th>
    <th><?php echo $lang->order->status?></th>
    <th><?php echo $lang->block->actions?></th>
  </tr>
  <?php foreach($orders as $id => $order):?>
  <tr>
    <td><?php echo $id?></td>
    <td><?php echo $customers[$order->customer]?></td>
    <td><?php echo $products[$order->product]?></td>
    <td><?php echo $lang->order->statusList[$order->status]?></td>
    <td><?php echo html::a($this->createLink('order', 'view', "orderID=$id"), $this->lang->order->view)?></td>
  </tr>
  <?php endforeach;?>
</table>
