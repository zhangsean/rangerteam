<?php 
/**
 * The action results view of product module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     product 
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php';?>
<div class='panel'>
  <div class='panel-heading'>
  <strong><i class="icon-list-ul"></i> <?php echo $lang->product->action->results;?></strong>
  <div class='panel-actions pull-right'><?php echo html::a($this->inlink('create'), '<i class="icon-plus"></i> ' . $lang->product->action->createResult, 'class="btn btn-primary"');?></div>
  </div>
  <table class='table table-hover table-striped tablesorter table-data'>
    <thead>
      <tr class='text-center'>
        <th>                <?php echo $lang->product->field->field;?></th>
        <th class='w-160px'><?php echo $lang->product->action->conditions;?></th>
        <th class='w-60px'> <?php echo $lang->product->action->results;?></th>
        <th class='w-200px'><?php echo $lang->actions;?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($action->results as $key => $result):?>
      <tr class='text-center'>
        <td class='text-left'><?php echo $result->field;?></td>
        <td>
          <?php foreach($result->conditions as $condition):?>
          <?php echo $lang->order->logicalOperators[$condition->logicalOperater];?>
          <?php echo $fields[$condition->field];?>
          <?php echo $lang->order->operaterList[$condition->operater];?>
          <?php echo $condition->param;?>
          <?php endforeach;?>
        </td>
        <td><?php echo $result->result;?></td>
        <td>
          <?php
          echo html::a($this->createLink('result', 'edit', "resultID=$key"), $lang->edit);
          echo html::a($this->createLink('result', 'delete', "resultID=$key"), $lang->delete, "class='deleter'");
          ?>
        </td>
      </tr>
      <?php endforeach;?>
    </tbody>
  </table>
</div>
<?php include '../../common/view/footer.html.php';?>
