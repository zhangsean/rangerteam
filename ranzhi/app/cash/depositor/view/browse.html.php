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
    <?php
    echo '&nbsp; &nbsp; &nbsp;';
    echo html::a(inlink('browse', "type=cash"),   $lang->depositor->typeList['cash'],   $type == 'cash' ? "class='active'" : '');
    echo html::a(inlink('browse', "type=bank"),   $lang->depositor->typeList['bank'],   $type == 'bank' ? "class='active'" : '');
    echo html::a(inlink('browse', "type=online"), $lang->depositor->typeList['online'], $type == 'online' ? "class='active'" : '');
    ?>
    <div class='panel-actions pull-right'>
      <?php echo html::a(inlink('create'), "<i class='icon-plus'>{$lang->depositor->create}</i>", "class='btn btn-primary'")?>
    </div>
  </div>
  <table class='table table-hover table-striped tablesorter table-data' id='depositorList'>
    <thead>
      <tr class='text-center'>
        <?php $vars = "type={$type}&orderBy=%s&recTotal={$pager->recTotal}&recPerPage={$pager->recPerPage}&pageID={$pager->pageID}";?>
        <th class='w-50px'><?php commonModel::printOrderLink('id', $orderBy, $vars, $lang->depositor->id);?></th>
        <th><?php commonModel::printOrderLink('abbr', $orderBy, $vars, $lang->depositor->abbr);?></th>
        <?php if($type != 'cash'):?>
        <th class='w-100px'><?php commonModel::printOrderLink('provider', $orderBy, $vars, $lang->depositor->serviceProvider);?></th>
        <th class='w-160px'> <?php commonModel::printOrderLink('title', $orderBy, $vars, $lang->depositor->title);?></th>
        <th class='w-100px'><?php commonModel::printOrderLink('account', $orderBy, $vars, $lang->depositor->account);?></th>
        <?php if($type == 'bank'):?>
        <th class='w-100px'><?php commonModel::printOrderLink('bankcode', $orderBy, $vars, $lang->depositor->bankcode);?></th>
        <?php endif;?>
        <th class='w-80px'><?php commonModel::printOrderLink('public', $orderBy, $vars, $lang->depositor->public);?></th>
        <?php endif;?>
        <th class='w-80px'><?php commonModel::printOrderLink('currency', $orderBy, $vars, $lang->depositor->currency);?></th>
        <th class='w-60px'><?php commonModel::printOrderLink('status', $orderBy, $vars, $lang->depositor->status);?></th>
        <th class='w-80px'><?php echo $lang->actions;?></th>
      </tr>
    </thead>
    <tbody>
    <?php foreach($depositors as $depositor):?>
    <tr class='text-center'>
      <td><?php echo $depositor->id;?></td>
      <td><?php echo $depositor->abbr;?></td>
      <?php if($type != 'cash'):?>
      <td>
        <?php if($depositor->type == 'online') echo $lang->depositor->providerList[$depositor->provider];?>
        <?php if($depositor->type == 'bank')   echo $depositor->provider;?>
      </td>
      <td><?php echo $depositor->title;?></td>
      <td><?php echo $depositor->account;?></td>
      <?php if($type == 'bank'):?>
      <td><?php echo $depositor->bankcode;?></td>
      <?php endif;?>
      <td><?php echo $lang->depositor->publicList[$depositor->public];?></td>
      <?php endif;?>
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
