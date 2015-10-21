<?php 
/**
 * The browse view file of order module of RanZhi.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv11.html)
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     order 
 * @version     $Id$
 * @link        http://www.ranzhico.com
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php js::set('mode', $mode);?>
<div id='menuActions'>
  <?php commonModel::printLink('refund', 'create', '', '<i class="icon-plus"></i> ' . $lang->refund->create, 'class="btn btn-primary"');?>
</div>
<div class='panel'>
  <table class='table table-hover table-striped table-sorter table-data table-fixed text-center'>
    <thead>
      <tr class='text-center'>
        <th class='w-50px'><?php echo $lang->refund->id;?></th>
        <th class='w-100px visible-lg'><?php echo $lang->user->dept;?></th>
        <th class='w-100px'><?php echo $lang->user->realname;?></th>
        <th class='w-100px'><?php echo $lang->refund->date;?></th>
        <th class='w-100px'><?php echo $lang->refund->money;?></th>
        <th class='w-100px'><?php echo $lang->refund->status;?></th>
        <th class='w-100px'><?php echo $lang->refund->firstReviewer;?></th>
        <th class='w-100px'><?php echo $lang->refund->secondReviewer;?></th>
        <th class='w-100px'><?php echo $lang->refund->refundBy;?></th>
        <th><?php echo $lang->refund->name;?></th>
        <th class='w-150px'><?php echo $lang->actions;?></th>
      </tr>
    </thead>
    <?php foreach($refunds as $refund):?>
    <tr data-url='<?php echo $this->createLink('refund', 'view', "refundID=$refund->id");?>'>
      <td><?php echo $refund->id;?></td>
      <td class='visible-lg'><?php echo zget($userDept, $refund->createdBy);?></td>
      <td><?php echo zget($userPairs, $refund->createdBy);?></td>
      <td><?php echo $refund->date?></td>
      <td><?php echo zget($currencySign, $refund->currency) . $refund->money?></td>
      <td><?php echo zget($lang->refund->statusList, $refund->status)?></td>
      <td><?php echo zget($userPairs, $refund->firstReviewer);?></td>
      <td><?php echo zget($userPairs, $refund->secondReviewer);?></td>
      <td><?php echo zget($userPairs, $refund->refundBy);?></td>
      <td><?php echo $refund->name?></td>
      <td>
        <?php echo html::a($this->createLink('refund', 'edit',   "refundID={$refund->id}"), $lang->edit, "")?>
        <?php echo html::a($this->createLink('refund', 'delete', "refundID={$refund->id}"), $lang->delete, "class='deleter'")?>
      </td>
    </tr>
    <?php endforeach;?>
  </table>
  <div class='table-footer'>
    <?php $pager->show();?>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>
