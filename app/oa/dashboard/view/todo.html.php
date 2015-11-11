<?php
/**
 * The view file of todo module of RanZhi.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv12.html)
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     todo
 * @version     $Id$
 * @link        http://www.ranzhico.com
 */
?>
<?php include $app->getModuleRoot() . 'common/view/header.html.php';?>
<div class='row page-content'>
  <div class='panel'>
    <table class='table table-hover table-striped tablesorter table-data' id='todoList'>
      <thead>
        <tr class='text-center'>
          <?php $vars = "orderBy=%s&recTotal={$pager->recTotal}&recPerPage={$pager->recPerPage}&pageID={$pager->pageID}";?>
          <th class='w-60px'> <?php commonModel::printOrderLink('id',     $orderBy, $vars, $lang->todo->id);?></th>
          <th class='w-80px'> <?php commonModel::printOrderLink('date',   $orderBy, $vars, $lang->todo->date);?></th>
          <th class='w-100px'><?php commonModel::printOrderLink('type',   $orderBy, $vars, $lang->todo->type);?></th>
          <th class='w-80px'> <?php commonModel::printOrderLink('pri',    $orderBy, $vars, $lang->todo->pri);?></th>
          <th>                <?php commonModel::printOrderLink('name',   $orderBy, $vars, $lang->todo->name);?></th>
          <th class='w-100px'><?php commonModel::printOrderLink('begin',  $orderBy, $vars, $lang->todo->begin);?></th>
          <th class='w-100px'><?php commonModel::printOrderLink('end',    $orderBy, $vars, $lang->todo->end);?></th>
          <th class='w-100px'><?php commonModel::printOrderLink('status', $orderBy, $vars, $lang->todo->status);?></th>
          <th class='w-120px'><?php echo $lang->actions;?></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($todos as $todo):?>
        <tr class='text-center'>
          <td><?php echo $todo->id;?></td>
          <td><?php echo $todo->date;?></td>
          <td><?php echo zget($lang->todo->typeList, $todo->type);?></td>
          <td><?php echo $lang->todo->priList[$todo->pri];?></td>
          <td class='text-left'><?php echo $todo->name;?></td>
          <td><?php echo $todo->begin;?></td>
          <td><?php echo $todo->end;?></td>
          <td><?php echo zget($lang->todo->statusList, $todo->status);?></td>
          <td class='text-left'>
            <?php echo html::a($this->createLink('oa.todo', 'view', "todoID={$todo->id}"), $lang->view, "data-toggle='modal'")?>
            <?php echo html::a($this->createLink('oa.todo', 'finish', "todoID={$todo->id}"), $lang->todo->finish, "data-id='{$todo->id}' class='ajaxFinish'")?>
            <?php echo html::a($this->createLink('oa.todo', 'assignTo', "todoID={$todo->id}"), $lang->todo->assignTo, "data-toggle='modal'")?>
          </td>
        </tr>
        <?php endforeach;?>
      </tbody>
      <tfoot><tr><td colspan='10'><?php $pager->show();?></td></tr></tfoot>
    </table>
  </div>
</div>
<?php include $app->getModuleRoot() . 'common/view/footer.html.php';?>
