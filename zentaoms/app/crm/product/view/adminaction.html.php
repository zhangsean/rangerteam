<?php 
/**
 * The admin action view file of product module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     product 
 * @version     $Id $
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php';?>
<div class='panel'>
  <div class='panel-heading'>
    <strong><i class="icon-list-ul"></i> <?php echo $lang->product->action->admin;?></strong>
    <div class='panel-actions pull-right'><?php echo html::a($this->inlink('createAction', "productID={$productID}"), '<i class="icon-plus"></i> ' . $lang->product->action->create, 'class="btn btn-primary"');?></div>
  </div>
  <table class='table table-hover table-striped tablesorter'>
    <thead>
      <tr class='text-center'>
        <th class='w-100px'><?php echo $lang->product->action->action;?></th>
        <th><?php echo $lang->product->action->name;?></th>
        <th width='w-200px'><?php echo $lang->actions;?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($actions as $action):?>
      <tr>
        <td><?php echo $action->action;?></td>
        <td><?php echo $action->name;?></td>
        <td>
          <?php
          echo html::a($this->createLink('product', 'editAction', "actionID=$action->id"), $lang->edit, "class='editr'");
          echo html::a($this->createLink('product', 'actionConditions', "actionID=$action->id"), $lang->product->action->conditions);
          echo html::a($this->createLink('product', 'actionInputs', "actionID=$action->id"), $lang->product->action->inputs);
          echo html::a($this->createLink('product', 'actionResults', "actionID=$action->id"), $lang->product->action->results);
          echo html::a($this->createLink('product', 'actionTasks', "actionID=$action->id"), $lang->product->action->tasks);
          echo html::a($this->createLink('product', 'deleteAction', "actionID=$action->id"), $lang->delete, "class='deleter'");
          ?>
        </td>
      </tr>
      <?php endforeach;?>
    </tbody>
  </table>
</div>
<?php include '../../common/view/footer.html.php';?>
