<?php
/**
 * The edit view file of effort module of Ranzhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     effort
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.modal.html.php';?>
<div class="modal-dialog" style="width:700px;">
  <div class="modal-content">
    <div class="modal-header">
      <?php echo html::closeButton();?>
      <h4 class="modal-title"><i class="icon-cog"></i> <?php echo $lang->effort->edit; ?></h4>
    </div>
    <div class="modal-body">
      <form method='post' id='ajaxModalForm' action='<?php echo $this->createLink('effort', 'edit', "effortID=$effort->id")?>'>
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
    </div>
  </div>
</div>
<?php include '../../common/view/footer.lite.html.php'?>
