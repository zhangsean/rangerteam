<?php
/**
 * The save order record view file of order module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     order
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
?>
<?php include '../../../sys/common/view/header.modal.html.php';?>
<?php include '../../../sys/common/view/kindeditor.html.php';?>
<?php include '../../../sys/common/view/datepicker.html.php';?>
<?php js::set('customer', $customer);?>
<form method='post' id='ajaxForm' action='<?php echo inlink('createrecord', "objectType={$objectType}&objectID={$objectID}&customer={$customer}")?>'>
  <table class='table table-form'>
    <?php if($objectType != 'contact'):?>
    <tr>
      <th><?php echo $lang->action->record->contact;?></th>
      <td>
        <div class='col-sm-5'><?php echo html::select('contact', $contacts, '', "class='form-control'");?></div>
        <div class='col-sm-4'><?php echo html::a('javascrit:;', $lang->contact->create, "class='btn-xs contact-creater'");?></div>
      </td>
    </tr>
    <?php endif;?>
    <tr>
      <th class='w-100px'><?php echo $lang->action->record->date;?></th>
      <td><div class='col-sm-5'><?php echo html::input('date', date('Y-m-d H:i:s'), "class='form-control form-datetime'");?></div></td>
    </tr> 
    <tr>
      <th><?php echo $lang->action->record->comment;?></th>
      <td><div class='col-sm-12'><?php echo html::textarea('comment', '', "class='form-control' rows='5'");?></div></td>
    </tr>
    <tr>
      <th></th>
      <td>
        <?php if($objectType == 'contact') echo html::hidden('contact', $objectID);?>
        <?php echo html::submitButton();?>
      </td>
    </tr>
  </table>
</form>
<?php include '../../../sys/common/view/footer.modal.html.php';?>
