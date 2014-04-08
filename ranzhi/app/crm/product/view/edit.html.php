<?php 
/**
 * The edit view file of product module of Ranzhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     product 
 * @version     $Id $
 * @link        http://www.ranzhi.org
 */
?>
<?php include '../../common/view/header.html.php';?>
<div class='panel'>
  <div class='panel-heading'><?php echo $lang->product->edit;?></div>
  <div class='panel-body'>
    <form method='post' id='ajaxForm'>
      <table class='table table-form'>
        <tr>
          <th class='w-100px'><?php echo $lang->product->name;?></th>
          <td class='w-p50'><?php echo html::input('name', $product->name, "class='form-control'");?></td><td></td>
        </tr>
        <tr>
          <th><?php echo $lang->product->code;?></th>
          <td><?php echo html::input('code', $product->code, "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->product->type;?></th>
          <td><?php echo html::select('type', $lang->product->typeList, $product->type, "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->product->status;?></th>
          <td><?php echo html::select('status', $lang->product->statusList, $product->status, "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->product->summary;?></th>
          <td colspan='2'><?php echo html::textarea('summary', $product->summary, "rows='2' class='form-control'");?></td>
        </tr>
        <tr>
          <th></th>
          <td><?php echo html::submitButton();?></td>
        </tr>
      </table>
    </form>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>
