<?php
/**
 * The contract list file of customer module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
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
      <th class='w-60px'><?php echo $lang->contract->id;?></th>
      <th><?php echo $lang->contract->name;?></th>
      <th><?php echo $lang->contract->status;?></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($contracts as $contract):?>
    <tr class='text-center'>
      <td><?php echo $contract->id;?></td>
      <td><?php echo $contract->name;?></td>
      <td><?php echo $lang->contract->statusList[$contract->status];?></td>
    </tr>
    <?php endforeach;?>
  </tbody>
</table>
<?php include '../../../sys/common/view/footer.modal.html.php';?>
