<?php 
/**
 * The browse view file of trade module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     trade 
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php $vars = "orderBy=%s&recTotal={$pager->recTotal}&recPerPage={$pager->recPerPage}&pageID={$pager->pageID}";?>
<div class='panel'>
  <div class='panel-heading'>
    <strong><i class="icon-group"></i> <?php echo $lang->trade->browse;?></strong>
    <div class='panel-actions pull-right'>
      <?php echo html::a(inlink('create'), "<i class='icon-plus'>{$lang->trade->create}</i>", "class='btn btn-primary'")?>
    </div>
  </div>
  <table class='table table-hover table-striped tablesorter table-data' id='tradeList'>
    <thead>
      <tr>
        <th class='w-100px'><?php commonModel::printOrderLink('depositor', $orderBy, $vars, $lang->trade->depositor);?></th>
        <th class='w-100px'><?php commonModel::printOrderLink('type', $orderBy, $vars, $lang->trade->type);?></th>
        <th class='w-100px'><?php commonModel::printOrderLink('trader', $orderBy, $vars, $lang->trade->trader);?></th>
        <th class='w-120px'><?php commonModel::printOrderLink('money', $orderBy, $vars, $lang->trade->money);?></th>
        <th class='w-100px'><?php commonModel::printOrderLink('category', $orderBy, $vars, $lang->trade->category);?></th>
        <th class='w-100px'><?php commonModel::printOrderLink('dept', $orderBy, $vars, $lang->trade->dept);?></th>
        <th class='w-100px'><?php commonModel::printOrderLink('handler', $orderBy, $vars, $lang->trade->handler);?></th>
        <th class='w-100px'><?php commonModel::printOrderLink('date', $orderBy, $vars, $lang->trade->date);?></th>
        <th class='w-100px'><?php commonModel::printOrderLink('order', $orderBy, $vars, $lang->trade->order);?></th>
        <th class='w-100px'><?php commonModel::printOrderLink('contract', $orderBy, $vars, $lang->trade->contract);?></th>
        <th><?php echo $lang->actions;?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($trades as $trade):?>
      <tr>
        <td><?php echo $depositorList[$trade->depositor];?></td>
        <td><?php echo $lang->trade->typeList[$trade->type];?></td>
        <td><?php echo $trade->trader?></td>
        <td><?php echo zget($lang->depositor->currencyList, $trade->currency) . $lang->colon . $trade->money;?></td>
        <td><?php echo zget($categories, $trade->category);?></td>
        <td><?php echo zget($deptList, $trade->dept);?></td>
        <td><?php echo zget($users, $trade->handler);?></td>
        <td><?php echo formatTime($trade->date, 'Y-m-d');?></td>
        <td><?php echo zget($orderList, $trade->order);?></td>
        <td><?php echo zget($contractList, $trade->contract);?></td>
        <td>
          <?php echo html::a(inlink('edit', "tradeID={$trade->id}"), $lang->edit);?>
          <?php echo html::a(inlink('delete', "tradeID={$trade->id}"), $lang->delete, "class='deleter'");?>
        </td>
      </tr>
      <?php endforeach;?>
    </tbody>
  </table>
</div>
<?php include '../../common/view/footer.html.php';?>
