<?php 
/**
 * The action conditions view file of product module of ZenTaoMS.
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
    <strong><i class="icon-plus"></i> <?php echo $lang->product->action->adminConditions;?></strong>
  </div>
  <div class='panel-body'>
    <form method='post' id='ajaxForm'>
      <table class='table table-form'>
        <thead>
          <tr class='text-center'>
            <td><?php echo $lang->product->field->field;?></td>
            <td><?php echo $lang->product->action->conditions;?></td>
            <td><?php echo $lang->product->action->param;?></td>
            <td></td>
          </tr>
        </thead>
        <?php
        $i = 0;
        foreach($action->conditions as $condition):
        ?>
        <tr>
          <th><?php echo html::select('field[]', $conditionFields, $condition->field, "class='form-control'");?></th>
          <td><?php echo html::select("operater[]", $lang->order->operaterList, $condition->operater, "class='form-control'"); ?></td>
          <td><?php echo html::input("param[]", $condition->param, "class='form-control'")?></td>
          <td>
            <?php echo html::a('javascript:;', $lang->add, "class='plus'")?>
            <?php echo html::a('javascript:;', $lang->delete, "class='condition-deleter'")?>
          </td>
        </tr>
        <?php $i++; endforeach;?>
        <?php js::set('key', $i);?>
        <tr><td colspan='4'><?php echo html::submitButton();?></td></tr>
      </table>
    </form>
    <table class='hide'>
        <tr id='originTR'>
          <th><?php echo html::select('field[]', $conditionFields, '', "class='form-control'");?></th>
          <td><?php echo html::select("operater[]", $lang->order->operaterList, '', "class='form-control'"); ?></td>
          <td><?php echo html::input("param[]", '', "class='form-control'")?></td>
          <td>
            <?php echo html::a('javascript:;', $lang->add, "class='plus'")?>
            <?php echo html::a('javascript:;', $lang->delete, "class='condition-deleter'")?>
          </td>
        </tr>
     </table>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>
