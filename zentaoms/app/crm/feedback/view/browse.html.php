<?php
/**
 * The browse view file of feedback module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     feedback
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php';?>
<div class='panel'>
  <div class='panel-heading'>
    <strong><i class="icon-list-ul"></i> <?php echo $lang->feedback->list;?></strong>
  <div class='panel-actions pull-right'><?php echo html::a($this->inlink('create'), '<i class="icon-plus"></i> ' . $lang->feedback->create, 'class="btn btn-primary"');?></div>
  </div>
  <table class='table table-hover table-striped tablesorter'>
    <thead>
      <tr class='text-center'>
        <?php $vars = "orderBy=%s&recTotal={$pager->recTotal}&recPerPage={$pager->recPerPage}&pageID={$pager->pageID}";?>
        <th class='w-60px'> <?php commonModel::printOrderLink('id',         $orderBy, $vars, $lang->feedback->id);?></th>
        <th class='w-40px'> <?php commonModel::printOrderLink('pri',        $orderBy, $vars, $lang->feedback->lblPri);?></th>
        <th>                <?php commonModel::printOrderLink('title',      $orderBy, $vars, $lang->feedback->title);?></th>
        <th class='w-100px'><?php commonModel::printOrderLink('product',    $orderBy, $vars, $lang->feedback->product);?></th>
        <th class='w-100px'><?php commonModel::printOrderLink('customer',   $orderBy, $vars, $lang->feedback->customer);?></th>
        <th class='w-120px'><?php commonModel::printOrderLink('contact',    $orderBy, $vars, $lang->feedback->contact);?></th>
        <th class='w-150px'><?php commonModel::printOrderLink('addedDate',  $orderBy, $vars, $lang->feedback->addedDate);?></th>
        <th class='w-100px'><?php commonModel::printOrderLink('assignedTo', $orderBy, $vars, $lang->feedback->assignedTo);?></th>
        <th class='w-80px'> <?php commonModel::printOrderLink('status',     $orderBy, $vars, $lang->feedback->status);?></th>
        <th class='w-100px'><?php echo $lang->actions;?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($issues as $issue):?>
      <tr class='text-center'>
        <td><?php echo $issue->id;?></td>
        <td><?php echo $lang->feedback->priList[$issue->pri];?></td>
        <td class='text-left'><?php echo html::a(inlink('view', "issueID=$issue->id"), $issue->title);?></td>
        <td><?php echo $products[$issue->product];?></td>
        <td><?php echo $customers[$issue->customer];?></td>
        <td><?php echo $contacts[$issue->contact];?></td>
        <td><?php echo $issue->addedDate;?></td>
        <td><?php echo $users[$issue->assignedTo];?></td>
        <td><?php echo $lang->feedback->statusList[$issue->status];?></td>
        <td>
          <?php
          echo html::a($this->createLink('feedback', 'edit', "issueID=$issue->id"), $lang->edit);
          echo html::a($this->createLink('feedback', 'delete', "issueID=$issue->id"), $lang->delete, "class='deleter'");
          ?>
        </td>
      </tr>
      <?php endforeach;?>
    </tbody>
    <tfoot><tr><td colspan='10'><?php $pager->show();?></td></tr></tfoot>
  </table>
</div>
<?php include '../../common/view/footer.html.php';?>
