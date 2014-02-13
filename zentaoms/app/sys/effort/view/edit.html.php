<?php
/**
 * The edit view file of effort module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     effort
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php';?>
<form method='post' id='ajaxForm'>
  <table class='table'> 
    <tr>
      <th class='w-100px'><?php echo $lang->effort->date;?></th>
      <td><?php echo html::input('date', $effort->date, "class='form-control select-3'");?></td>
    </tr>  
    <tr>
      <th><?php echo $lang->effort->consumed;?></th>
      <td><?php echo html::input('consumed', $effort->consumed, "class=' form-control select-3'");?></td>
    </tr>
    <?php if($effort->objectType == 'task'):?>
    <tr>
      <th><?php echo $lang->effort->left;?></th>
      <td><?php echo html::input('left', $effort->left, "class='form-control select-3'");?></td>
    </tr>
    <?php endif;?>
    <tr>
      <th><?php echo $lang->effort->objectType;?></th>
      <td><?php echo html::select('objectType', $lang->effort->objectTypeList, $effort->objectType, "class='form-control select-3'");?></td>
    </tr>  
    <tr>
      <th><?php echo $lang->effort->objectID;?></th>
      <td><?php echo html::input('objectID', $effort->objectID, "class='form-control select-3'");?></td>
    </tr>  
    <tr>
      <th><?php echo $lang->effort->work;?></th>
      <td><?php echo html::input('work', $effort->work, "class='form-control'");?></td>
    </tr>  
    <tr>
      <td colspan='2' class='text-center'>
        <?php echo html::submitButton() . html::backButton();?>
      </td>
    </tr>
  </table>
</form>
<?php include '../../common/view/footer.html.php'?>
