<?php 
/**
 * The receive payments file of contract module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     contract 
 * @version     $Id$
 * @link        http://www.ranzhico.com
 */
?>
<?php include '../../../sys/common/view/header.modal.html.php';?>
<?php include '../../../sys/common/view/kindeditor.html.php';?>
<?php include '../../../sys/common/view/chosen.html.php';?>
<?php include '../../common/view/datepicker.html.php';?>
<form method='post' id='ajaxForm' class='form-inline' action='<?php echo $this->createLink('contract', 'receive', "contractID=$contractID")?>'>
  <table class='table table-form'>
    <tr>
      <th class='w-80px'><?php echo $lang->contract->amount;?></th>
      <td class='w-p40'>
        <div class='input-group'>
          <?php echo html::input('amount', '', "class='form-control'");?>
          <div class='input-group-addon'>
            <label class='checkbox'><input type='checkbox' id='finish' name='finish' value='1'> <?php echo $lang->contract->completeReturn;?></label>
          </div>
        </div>
      </td><td></td>
    </tr>
    <tr>
      <th><?php echo $lang->trade->depositor;?></th>
      <td><?php echo html::select('depositor', $depositorList, '', "class='form-control'");?></td>
    </tr>
    <tr>
      <th><?php echo $lang->trade->category;?></th>
      <td><?php echo html::select('category', array('') + (array) $categories, '', "class='form-control'");?></td>
    </tr>
    <tr>
      <th><?php echo $lang->contract->returnedBy;?></th>
      <td><?php echo html::select('returnedBy', $users, $this->app->user->account, "class='form-control chosen'");?></td><td></td>
    </tr>
    <tr>
      <th><?php echo $lang->contract->returnedDate;?></th>
      <td><?php echo html::input('returnedDate', '', "class='form-control form-date'");?></td>
    </tr>
    <tr>
      <th><?php echo $lang->trade->dept;?></th>
      <td><?php echo html::select('dept', $deptList, '', "class='form-control chosen'");?></td>
    </tr>
    <tr>
      <th><?php echo $lang->contract->handlers;?></th>
      <td colspan='2'><?php echo html::select('handlers[]', $users, $this->app->user->account, "class='form-control chosen' multiple");?></td>
    </tr>
    <tr>
      <th><?php echo $lang->comment;?></th>
      <td colspan='2'><?php echo html::textarea('comment');?></td>
    </tr>
    <tr>
      <th></th>
      <td><?php echo html::submitButton();?></td>
    </tr>
  </table>
</form>
<?php include '../../../sys/common/view/footer.modal.html.php';?>
