<?php 
/**
 * The create result view file of product module of ZenTaoMS.
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
    <strong><i class="icon-plus"></i> <?php echo $lang->product->action->createResult;?></strong>
  </div>
  <div class='panel-body'>
    <form method='post' id='ajaxForm'>
      <table class='table table-form'>
        <tr class='text-center'>
          <th class='w-100px'><?php echo $lang->product->field->field;?></th>
          <td><?php echo html::select("field", $inputFields, '', "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->product->action->conditions;?></th>
          <td>
            <div class='input-group'>
              <?php echo html::hidden("conditions[logicalOperater][]", '');?>
              <?php echo html::select("conditions[field][]", $conditionFields, '', "class='form-control'");?>
              <span class='input-group-addon'></span>
              <?php echo html::select("conditions[operater][]", $lang->order->operaterList, '', "class='form-control'");?>
              <span class='input-group-addon'></span>
              <?php echo html::input("conditions[param][]", '', "class='form-control'");?>
              <div class="input-group-btn">
                <i class="icon-plus-sign icon-large"></i>
                <i class="icon-minus-sign icon-large"></i>
              </div>
            </div>
          </td>
        </tr>
        <tr>
          <th><?php echo $lang->product->action->results;?></th>
          <td>
            <div class='input-group'> 
              <?php echo html::select("result", $lang->order->reaultsOptions, '', "class='form-control'");?>
              <span class='input-group-addon'></span>
              <?php echo html::input('resultValue', '', "class='form-control'");?>
            <div>
          </td>
        </tr>
        <tr>
          <td></td>
          <td><?php echo html::submitButton();?></td>
        </tr>
      </table>
    </form>
  </div>
</div>
<?php /* Hidden condation group. */ ?>
<div id='conditionGroup' class='hide'>
  <div class='input-group'>
    <?php echo html::select("conditions[logicalOperater][]", $lang->order->logicalOperators, '', "class='form-control'");?>
    <span class='input-group-addon'></span>
    <?php echo html::select("conditions[field][]", $conditionFields, '', "class='form-control'");?>
    <span class='input-group-addon'></span>
    <?php echo html::select("conditions[operater][]", $lang->order->operaterList, '', "class='form-control'");?>
    <span class='input-group-addon'></span>
    <?php echo html::input("conditions[param][]", '', "class='form-control'");?>
    <div class="input-group-btn">
      <i class="icon-plus-sign icon-large"></i>
      <i class="icon-minus-sign icon-large"></i>
    </div>
  </div>
</div>
<?php /* Hidden condation group. */ ?>
<?php include '../../common/view/footer.html.php';?>
