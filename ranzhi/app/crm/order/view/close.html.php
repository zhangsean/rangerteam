<?php 
/**
 * The close view file of order module of Ranzhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     order 
 * @version     $Id $
 * @link        http://www.zentao.net
 */
?>
<?php include '../../../sys/common/view/header.modal.html.php';?>
<?php include '../../../sys/common/view/kindeditor.html.php';?>
<?php include '../../../sys/common/view/chosen.html.php';?>
<div class="modal-dialog" style="width:700px;">
  <div class="modal-content">
    <div class="modal-header">
      <?php echo html::closeButton();?>
      <h4 class="modal-title"><i class="icon-cog"></i> <?php echo $lang->order->close; ?></h4>
    </div>
    <div class="modal-body">
      <form method='post' id='ajaxModalForm' action='<?php echo $this->createLink('order', 'close', "orderID=$orderID")?>'>
        <table class='table table-form'>
          <tr>
            <th class='w-100px'><?php echo $lang->order->closedReason?></th>
            <td><?php echo html::select('closedReason', $lang->order->closedReasonList, '', "class='form-control'")?></td>
          </tr>
          <tr>
            <th><?php echo $lang->order->closedNote;?></th>
            <td><?php echo html::textarea('closedNote');?></td>
          </tr>
          <tr>
            <th></th>
            <td><?php echo html::submitButton();?></td>
          </tr>
        </table>
      </form>
    </div>
  </div>
</div>
