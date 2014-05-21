<?php 
/**
 * The browse view file of depositor module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     depositor 
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
?>
<?php include '../../common/view/header.html.php';?>
<div class='panel'>
  <div class='panel-heading'>
    <strong><i class="icon-group"></i> <?php echo $lang->depositor->list;?></strong>
    <div class='panel-actions pull-right'>
      <?php echo html::a(inlink('create'), "<i class='icon-plus'>{$lang->depositor->create}</i>", "class='btn btn-primary'")?>
    </div>
  </div>
  <table class='table table-hover table-striped tablesorter table-data' id='depositorList'>
    <thead>
      <tr class='text-center'>
        <?php $vars = "orderBy=%s&recTotal={$pager->recTotal}&recPerPage={$pager->recPerPage}&pageID={$pager->pageID}";?>
        <th class='w-50px'> <?php commonModel::printOrderLink('id', $orderBy, $vars, $lang->depositor->id);?></th>
        <th class='w-100px'><?php commonModel::printOrderLink('abbr', $orderBy, $vars, $lang->depositor->abbr);?></th>
        <th class='w-100px'><?php commonModel::printOrderLink('provider', $orderBy, $vars, $lang->depositor->serviceProvider);?></th>
        <th class='w-100px'> <?php commonModel::printOrderLink('title', $orderBy, $vars, $lang->depositor->title);?></th>
        <th class='w-100px'><?php commonModel::printOrderLink('account', $orderBy, $vars, $lang->depositor->account);?></th>
        <th class='w-100px'><?php commonModel::printOrderLink('bankcode', $orderBy, $vars, $lang->depositor->bankcode);?></th>
        <th class='w-60px'><?php commonModel::printOrderLink('public', $orderBy, $vars, $lang->depositor->public);?></th>
        <th class='w-60px'><?php commonModel::printOrderLink('type', $orderBy, $vars, $lang->depositor->type);?></th>
        <th class='w-60px'><?php commonModel::printOrderLink('currency', $orderBy, $vars, $lang->depositor->currency);?></th>
        <th class='w-60px'><?php commonModel::printOrderLink('status', $orderBy, $vars, $lang->depositor->status);?></th>
        <th class='w-80px'><?php echo $lang->actions;?></th>
      </tr>
    </thead>
    <tbody>
    <?php foreach($depositors as $depositor):?>
    <tr class='text-center'>
      <td><?php echo $depositor->id;?></td>
      <td><?php echo $depositor->abbr;?></td>
      <td><?php echo $depositor->provider;?></td>
      <td><?php echo $depositor->title;?></td>
      <td><?php echo $depositor->account;?></td>
      <td><?php echo $depositor->bankcode;?></td>
      <td><?php echo $lang->depositor->publicList[$depositor->public];?></td>
      <td><?php echo $lang->depositor->typeList[$depositor->type];?></td>
      <td><?php echo $depositor->currency;?></td>
      <td><?php echo $lang->depositor->statusList[$depositor->status];?></td>
      <td class='operate'>
        <?php echo html::a($this->createLink('depositor', 'edit',     "depositorID=$depositor->id"), $lang->edit);?>
        <?php if($depositor->status == 'normal')  echo html::a($this->createLink('depositor', 'forbid',   "depositorID=$depositor->id"), $lang->forbid, "data-toggle='modal'");?>
        <?php if($depositor->status == 'disable') echo html::a($this->createLink('depositor', 'activate', "depositorID=$depositor->id"), $lang->activate, "data-toggle='modal'");?>
      </td>
    </tr>
    <?php endforeach;?>
    </tbody>
    <tfoot><tr><td colspan='11'><?php $pager->show();?></td></tr></tfoot>
  </table>
</div>
<?php include '../../common/view/footer.html.php';?>
