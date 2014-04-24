<?php
/**
 * The items view file of contract module of Ranzhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     contract
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
?>
<?php include '../../../sys/common/view/header.modal.html.php';?>
<?php include '../../../sys/common/view/kindeditor.html.php';?>
<div class='alert'>
  <table class='table table-form items'>
    <tr>
      <th class='w-80px'><?php echo $lang->contract->items;?></th>
      <td><?php echo strip_tags($contract->items) == $contract->items ? nl2br($contract->items) : $contract->items;?></td>
    </tr>
    <tr>
      <th><?php echo $lang->files;?></th>
      <td><?php echo $this->fetch('file', 'printFiles', array('files' => $files, 'fieldset' => 'false'));?></td>
    </tr>
    <tr>
      <th></th>
      <td class='items'><?php echo html::a('javascript:toggleComment()', '<i class="icon-pencil"></i> ' . $lang->edit, "class='btn'")?></td>
  </table>
  <div class='hide' id='itemGroup'>
    <form method='post' id='ajaxForm' action='<?php echo $this->createLink('contract', 'items', "contractID=$contract->id")?>'>
      <table align='center' class='table table-form'>
        <tr>
          <th><?php echo $lang->contract->items;?></th>
          <td><?php echo html::textarea('items', htmlspecialchars($contract->items),"rows='5' class='form-control'");?></td>
        </tr>
        <?php if($files):?>
        <tr>
          <th><?php echo $lang->files;?></th>
          <td><?php echo $this->fetch('file', 'printFiles', array('files' => $files, 'fieldset' => 'false'))?></td>
        </tr>
        <?php endif;?>
        <tr>
          <th><?php echo $lang->contract->uploadFile;?></th>
          <td><?php echo $this->fetch('file', 'buildForm');?></td>
        </tr>
        <tr>
          <th></th>
          <td><?php echo html::submitButton() . html::a("javascript:toggleComment()", $lang->goback, "class='btn'");?></td>
        </tr>
      </table>
    </form>
  </div>
</div>
<?php include '../../../sys/common/view/footer.modal.html.php';?>
