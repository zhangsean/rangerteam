<?php
/**
 * The browse view file of contract module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     contract
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php';?>
<div class='panel'>
  <div class='panel-heading'>
  <strong><i class="icon-list-ul"></i> <?php echo $lang->contract->list;?></strong>
  <div class='panel-actions'><?php echo html::a($this->inlink('create'), '<i class="icon-plus"></i> ' . $lang->contract->create, 'class="btn btn-primary"');?></div>
  </div>
  <table class='table table-hover table-striped tablesorter'>
    <thead>
      <tr class='text-center'>
        <?php $vars = "orderBy=%s&recTotal={$pager->recTotal}&recPerPage={$pager->recPerPage}&pageID={$pager->pageID}";?>
        <th class='w-60px'> <?php commonModel::printOrderLink('id',          $orderBy, $vars, $lang->contract->id);?></th>
        <th>                <?php commonModel::printOrderLink('name',        $orderBy, $vars, $lang->contract->name);?></th>
        <th class='w-100px'><?php commonModel::printOrderLink('customer',    $orderBy, $vars, $lang->contract->customer);?></th>
        <th class='w-100px'><?php commonModel::printOrderLink('amount',      $orderBy, $vars, $lang->contract->amount);?></th>
        <th class='w-160px'><?php commonModel::printOrderLink('createdDate', $orderBy, $vars, $lang->contract->createdDate);?></th>
        <th class='w-100px'><?php commonModel::printOrderLink('delivery',    $orderBy, $vars, $lang->contract->delivery);?></th>
        <th class='w-100px'><?php commonModel::printOrderLink('return',      $orderBy, $vars, $lang->contract->return);?></th>
        <th class='w-60px'> <?php commonModel::printOrderLink('status',      $orderBy, $vars, $lang->contract->status);?></th>
        <th class='w-100px'><?php echo $lang->actions;?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($contracts as $contract):?>
      <tr class='text-center'>
        <td><?php echo $contract->id;?></td>
        <td class='text-left'><?php echo $contract->name;?></td>
        <td><?php echo $customers[$contract->customer];?></td>
        <td><?php echo $contract->amount;?></td>
        <td><?php echo $contract->createdDate;?></td>
        <td><?php echo $lang->contract->deliveryList[$contract->delivery];?></td>
        <td><?php echo $lang->contract->returnList[$contract->return];?></td>
        <td><?php echo $lang->contract->statusList[$contract->status];?></td>
        <td>
          <?php
          echo html::a($this->createLink('contract', 'edit', "contract=$contract->id"), $lang->edit);
          echo html::a($this->createLink('contract', 'delete', "contract=$contract->id"), $lang->delete, "class='deleter'");
          ?>
        </td>
      </tr>
      <?php endforeach;?>
    </tbody>
    <tfoot><tr><td colspan='9'><?php $pager->show();?></td></tr></tfoot>
  </table>
</div>
<?php include '../../common/view/footer.html.php';?>
