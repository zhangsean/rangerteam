<?php 
/**
 * The browse view file of customer module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     customer 
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php js::set('mode', $mode);?>
<li id='bysearchTab'><a href='#'><i class='icon-search icon'></i>&nbsp;<?php echo $lang->search->common;?></a></li>
<div id='menuActions'>
  <?php echo html::a($this->inlink('create'), '<i class="icon-plus"></i> ' . $lang->customer->create, 'class="btn btn-primary"');?>
</div>
<div class='panel'>
  <div class='panel-heading'><strong><i class="icon-list-ul"></i> <?php echo $lang->customer->list;?></strong></div>
  <table class='table table-hover table-striped tablesorter table-data'>
    <thead>
      <tr class='text-center'>
        <?php $vars = "mode={$mode}&param=&orderBy=%s&recTotal={$pager->recTotal}&recPerPage={$pager->recPerPage}&pageID={$pager->pageID}";?>
        <th class='w-60px'> <?php commonModel::printOrderLink('id',          $orderBy, $vars, $lang->customer->id);?></th>
        <th>                <?php commonModel::printOrderLink('name',        $orderBy, $vars, $lang->customer->name);?></th>
        <th class='w-60px'> <?php commonModel::printOrderLink('level',       $orderBy, $vars, $lang->customer->level);?></th>
        <th class='w-60px'> <?php commonModel::printOrderLink('status',      $orderBy, $vars, $lang->customer->status);?></th>
        <th class='w-60px'><?php commonModel::printOrderLink('size',         $orderBy, $vars, $lang->customer->size);?></th>
        <th class='w-60px'> <?php commonModel::printOrderLink('type',        $orderBy, $vars, $lang->customer->type);?></th>
        <th class='w-100px'><?php commonModel::printOrderLink('contactDate', $orderBy, $vars, $lang->customer->contactDate);?></th>
        <th class='w-100px'><?php commonModel::printOrderLink('nextDate',    $orderBy, $vars, $lang->customer->nextDate);?></th>
        <th class='w-100px'><?php commonModel::printOrderLink('createdDate', $orderBy, $vars, $lang->customer->createdDate);?></th>
        <th class='w-200px'><?php echo $lang->actions;?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($customers as $customer):?>
      <tr class='text-center' data-url='<?php echo $this->createLink('customer', 'view', "customerID=$customer->id"); ?>'>
        <td><?php echo $customer->id;?></td>
        <td class='text-left'><?php echo $customer->name;?></td>
        <td><?php echo isset($lang->customer->levelNameList[$customer->level]) ? $lang->customer->levelNameList[$customer->level] : '';?></td>
        <td class='<?php echo "customer-{$customer->status}";?>'><?php if($customer->status) echo $lang->customer->statusList[$customer->status];?></td>
        <td><?php echo $lang->customer->sizeNameList[$customer->size];?></td>
        <td><?php echo $lang->customer->typeList[$customer->type];?></td>
        <td><?php echo formatTime($customer->contactedDate, DT_DATE1);?></td>
        <td><?php echo $customer->nextDate;?></td>
        <td><?php echo substr($customer->createdDate, 0, 10);?></td>
        <td class='actions'>
          <?php
          echo html::a($this->createLink('action', 'createRecord', "objectType=customer&objectID=$customer->id&customer=$customer->id"), $lang->customer->record, "data-toggle='modal' data-type='iframe' data-icon='comment-alt'");
          echo html::a(inlink('assign', "customerID=$customer->id"), $lang->customer->assign, "data-toggle='modal'");
          echo html::a(inlink('contact', "customerID=$customer->id"), $lang->customer->contact,  "data-toggle='modal'");
          echo html::a(inlink('edit', "customerID=$customer->id"), $lang->edit);
          echo "<div class='dropdown'><a data-toggle='dropdown' href='javascript:;'>" . $this->lang->more . "<span class='caret'></span> </a><ul class='dropdown-menu pull-right'>";
          echo "<li>" . html::a(inlink('order', "customerID=$customer->id"), $lang->customer->order,    "data-toggle='modal'") . "</li>";
          echo "<li>" . html::a(inlink('contract', "customerID=$customer->id"), $lang->customer->contract, "data-toggle='modal'") . "</li>";
          echo "<li>" . html::a($this->createLink('address', 'browse', "objectType=customer&objectID=$customer->id"), $lang->customer->address, "data-toggle='modal'") . "</li>";
          echo "</ul></div>";
          ?>
        </td>
      </tr>
      <?php endforeach;?>
    </tbody>
    <tfoot><tr><td colspan='10'><?php $pager->show();?></td></tr></tfoot>
  </table>
</div>
<?php include '../../common/view/footer.html.php';?>
