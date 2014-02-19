<?php 
/**
 * The edit view file of order module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     order 
 * @version     $Id $
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php'; ?>
<div class='panel'>
  <div class='panel-heading'><?php echo $lang->order->edit;?></div>
  <div class='panel-body'>
    <form method='post' id='ajaxForm'>
      <table class='table table-form w-p60'>
        <tr>
          <th class='w-120px'><?php echo $lang->order->customer;?></th>
          <td><?php echo html::select('customer', $customers, $order->customer, "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->order->product;?></th>
          <td><?php echo html::select('product', $products, $order->product, "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->order->plan;?></th>
          <td><?php echo html::input('plan', $order->plan, "class='form-control'");?></td>
        </tr>
        <?php if($order->status == 'closed'):?>
        <tr>
          <th><?php echo $lang->order->closedReason;?></th>
          <td><?php echo html::select('closedReason', $lang->order->closedReasonList, $order->closedReason, "class='form-control'");?></td>
        </tr>
        <?php endif;?>
        <tr>
          <th></th>
          <td><?php echo html::submitButton();?></div>
        </div>
      </table>
    </form>
  </div>
</div>
<?php include '../../../sys/common/view/action.html.php';?>
<?php include '../../common/view/footer.html.php';?>
