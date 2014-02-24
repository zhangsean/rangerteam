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
<table class='table table-data table-hover' id='crmBlockOrder'>
  <tr>
    <th class='w-id text-center'><?php echo $lang->order->id?></th>
    <th><?php echo $lang->order->customer?></th>
    <th><?php echo $lang->order->product?></th>
    <th><?php echo $lang->order->status?></th>
  </tr>
  <?php foreach($orders as $id => $order):?>
  <tr data-url='<?php echo $this->createLink('order', 'view', "orderID=$id"); ?>'>
    <td class='text-center'><?php echo $id?></td>
    <td><?php echo $customers[$order->customer]?></td>
    <td><?php echo $products[$order->product]?></td>
    <td><?php echo $lang->order->statusList[$order->status]?></td>
  </tr>
  <?php endforeach;?>
</table>
<script>$('#crmBlockOrder').dataTable();</script>
