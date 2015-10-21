<?php
/**
 * The review view file of refund module of RanZhi.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv11.html)
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     refund 
 * @version     $Id$
 * @link        http://www.ranzhico.com
 */
?>
<?php include '../../../sys/common/view/header.modal.html.php';?>
<?php include '../../../sys/common/view/kindeditor.html.php';?>
<?php include '../../../sys/common/view/datepicker.html.php';?>
<?php include '../../../sys/common/view/chosen.html.php';?>
<form method='post' id='ajaxForm' action='<?php echo inlink('review', "refundID={$refund->id}&status=$status")?>'>
  <?php if($status == 'pass'):?>
  <?php if(!empty($refund->detail)):?>
  <table class='table table-form'>
    <tr class='text-center'>
      <th class='w-80px'><?php echo $lang->refund->date;?></th>
      <th class='w-80px'><?php echo $lang->refund->category;?></th>
      <th class='w-80px'><?php echo $lang->refund->money;?></th>
      <th class='w-100px'><?php echo $lang->refund->status;?></th>
      <th><?php echo $lang->refund->desc;?></th>
      <th class='w-150px'><?php echo $lang->actions;?></th>
    </tr>
    <?php foreach($refund->detail as $detail):?>
    <tr class='text-center'>
      <td><?php echo $detail->date;?></td>
      <td><?php echo $categories[$detail->category];?></td>
      <td><?php echo $detail->money;?></td>
      <td><?php echo $lang->refund->statusList[$detail->status];?></td>
      <td><?php echo $detail->desc?></td>
      <td><?php echo html::a($this->createLink('refund', 'review', "refundID={$detail->id}&status=reject"), $lang->refund->reviewStatusList['reject'], "class='loadInModal'")?></td>
    </tr>
    <?php endforeach;?>
  </table>
  <?php endif;?>
  <table class='table table-form'>
    <tr>
      <th class='w-80px'><?php echo $lang->refund->reviewMoney;?></th>
      <td>
        <div class='input-group'>
          <?php echo html::input('money', $refund->money, "class='form-control'");?>
          <span class='input-group-addon'><?php echo zget($lang->currencyList, $refund->currency, $refund->currency);?></span>
        </div>
      </td>
      <td><?php echo html::submitButton();?></td>
    </tr>
  </table>
  <?php else:?>
  <table class='table table-form'>
    <tr>
      <th class='w-80px'><?php echo $lang->refund->reason;?></th>
      <td><?php echo html::textarea('reason', '', "class='form-control' rows='3'");?></td>
    </tr>
    <tr><th></th><td><?php echo html::submitButton();?></td></tr>
  </table>
  <?php endif;?>
</form>
<?php include '../../../sys/common/view/footer.modal.html.php';?>
