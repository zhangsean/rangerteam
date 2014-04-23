<?php
/**
 * The order list file of customer module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     customer
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
?>
<?php include '../../../sys/common/view/header.modal.html.php';?>
<table class='table table-bordered table-hover table-striped table-data'>
  <thead>
    <tr class='text-center'>
      <th class='w-60px'><?php echo $lang->customer->id;?></th>
      <th><?php echo $lang->customer->name;?></th>
      <th><?php echo $lang->actions;?></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($orders as $id => $order):?>
    <tr class='text-center'>
      <td><?php echo $id;?></td>
      <td><?php echo $order;?></td>
      <td><?php echo html::a($this->createLink('order', 'edit', "orderID={$id}"), $lang->edit);?></td>
    </tr>
    <?php endforeach;?>
  </tbody>
</table>
<?php include '../../../sys/common/view/footer.modal.html.php';?>
